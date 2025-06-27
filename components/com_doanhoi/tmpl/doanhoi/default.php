<?php
defined('_JEXEC') or die('Restricted access');
?>

<div class="danhsach" style="background-color:#fff">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý đoàn viên hội viên</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <button type="button" data-bs-toggle="modal" data-bs-target="#modalThemDoanHoi" class="btn btn-primary">
          <i class="fas fa-plus"></i> Thêm mới
        </button>
      </div>
    </div>
  </div>

  <div class="card card-primary collapsed-card">
    <div class="card-header" data-card-widget="collapse">
      <h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="none" data-action="reload"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex align-items-center py-2" style="gap: 10px;">
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Họ tên </b>
          <input type="text" name="hoten" id="hoten" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập họ tên chủ cơ sở" />
        </div>
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">CCCD/CMND</b>
          <input type="text" name="cccd" id="cccd" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập tên cơ sở" />
        </div>
      </div>
      <div class="d-flex align-items-center py-2" style="gap: 10px;">
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Phường xã</b>
          <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường" style="width: 67%;">
            <option value=""></option>
            <?php foreach ($this->phuongxa as $px) { ?>
              <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Thôn tổ dân phố</b>
          <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
            <option value=""></option>
          </select>
        </div>
      </div>
      <div class="d-flex align-items-center py-2" style="gap: 10px;">
        <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 16%">Giới tính</b>
        <select id="gioitinh_id" name="gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính" style="width: 84%;">
          <option value=""></option>
        </select>
      </div>
      <div class="text-center" style="padding-top:10px;">
        <button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i> Tìm kiếm</button>
      </div>
    </div>
  </div>

  <div id="div_danhsach">
    <?php require_once 'ds_doanhoi.php'; ?>
  </div>
</div>

<div class="modal modal-right fade" id="modalThemDoanHoi" tabindex="-1" aria-labelledby="modalThemDoanHoiLabel">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <?php require_once 'edit_doanhoi.php'; ?>
    </div>
  </div>
</div>

<script>
  // Wait for the document to be fully loaded before running scripts
  $(document).ready(function() {
    // Initialize Select2 for dropdowns to make them searchable and user-friendly
    $('#phuongxa_id, #thonto_id, #gioitinh_id').select2({
      width: '67%',
      allowClear: true,
      placeholder: function() {
        return $(this).data('placeholder'); // Get placeholder from data attribute
      }
    });

    // Function to show toast notifications (success or error messages)
    function showToast(message, isSuccess = true) {
      const toast = $('<div></div>')
        .text(message)
        .css({
          position: 'fixed',
          top: '20px',
          right: '20px',
          background: isSuccess ? '#28a745' : '#dc3545',
          color: 'white',
          padding: '10px 20px',
          borderRadius: '5px',
          boxShadow: '0 0 10px rgba(0,0,0,0.3)',
          zIndex: 9999
        })
        .appendTo('body');
      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
    }

    // Function to fetch and populate village/ward dropdown based on selected commune
    function fetchVillages(communeId, selectedVillageId = '') {
      if (!communeId) {
        $('#thonto_id').html('<option value=""></option>').trigger('change');
        return;
      }
      $.post('index.php', {
        option: 'com_vptk',
        controller: 'vptk',
        task: 'getKhuvucByIdCha',
        cha_id: communeId
      }, function(response) {
        let options = '<option value=""></option>';
        response.forEach(village => {
          const selected = village.id == selectedVillageId ? ' selected' : '';
          options += `<option value="${village.id}"${selected}>${village.tenkhuvuc}</option>`;
        });
        $('#thonto_id').html(options).trigger('change');
      }, 'json').fail(function() {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
      });
    }

    // Event handler for commune selection change
    $('#phuongxa_id').on('change', function() {
      fetchVillages($(this).val());
    });

    // Event handler for clicking the "Edit" button
    $('body').on('click', '.btn_hieuchinh', function() {
      const memberId = $(this).data('doanhoi');
      const modalTitle = $(this).data('title') || 'Hiệu chỉnh đoàn hội';

      if (!memberId) {
        showToast('ID đoàn hội không hợp lệ', false);
        return;
      }

      // Update modal title
      $('#modalThemDoanHoiLabel').text(modalTitle);

      // Fetch member details via AJAX
      $.post('index.php', {
        option: 'com_doanhoi',
        controller: 'doanhoi',
        task: 'getDetailDoanHoi',
        doanhoi_id: memberId
      }, function(result) {
        if (result && result.id) {
          // Populate form fields with member data
          const modal = $('#modalThemDoanHoi');
          modal.find('#modal_hoten').val(result.n_hoten || '');
          modal.find('#modal_cccd').val(result.n_cccd || '');
          modal.find('#modal_namsinh').val(result.n_namsinh || '');
          modal.find('#modal_dienthoai').val(result.n_dienthoai || '');
          modal.find('#modal_diachi').val(result.n_diachi || '');
          modal.find('#modal_gioitinh_id').val(result.n_gioitinh_id || '').trigger('change');
          modal.find('#modal_dantoc_id').val(result.n_dantoc_id || '').trigger('change');
          modal.find('#modal_tongiao_id').val(result.n_tongiao_id || '').trigger('change');
          modal.find('#modal_phuongxa_id').val(result.n_phuongxa_id || '').trigger('change');
          modal.find('#modal_chucdanh_id').val(result.chucvu_id || '').trigger('change');
          modal.find('input[name="thoidiem_batdau"]').val(result.thoidiem_batdau || '');
          modal.find('input[name="thoidiem_ketthuc"]').val(result.thoidiem_ketthuc || '');
          modal.find('#lydo_biendong').val(result.lydobiendong || '');
          modal.find('#ghichu').val(result.ghichu || '');
          modal.find('input[name="id"]').val(result.id || '');

          // Fetch villages for the selected commune
          if (result.n_phuongxa_id) {
            fetchVillages(result.n_phuongxa_id, result.n_thonto_id);
          }

          // Show the modal
          modal.modal('show');
        } else {
          showToast(result.message || 'Không thể lấy dữ liệu', false);
        }
      }, 'json').fail(function() {
        showToast('Lỗi khi gửi yêu cầu AJAX', false);
      });
    });

    // Reset form when opening modal for adding new member
    $('#modalThemDoanHoi').on('show.bs.modal', function(e) {
      if (!$(e.relatedTarget).hasClass('btn_hieuchinh')) {
        const form = $(this).find('form')[0];
        form.reset();
        $('#modalThemDoanHoiLabel').text('Thêm mới đoàn hội');
        $(this).find('input[name="id"]').val('');
        $('#modal_gioitinh_id, #modal_dantoc_id, #modal_tongiao_id, #modal_phuongxa_id, #modal_thonto_id, #modal_chucdanh_id').val('').trigger('change');
      }
    });
  });
</script>

<style>
  .modal-right .modal-dialog {
    height: 100%;
  }

  .modal-right .modal-content {
    height: 100%;
  }

  .modal-body {
    max-height: calc(100vh - 150px);
    padding: 0px 10px;
    overflow-y: auto;
  }

  .danhsach {
    padding: 0px 20px;
  }

  .content-header {
    padding: 20px 8px 15px 8px;
  }

  .calendar .form-control {
    padding: 6px 10px;
  }

  .select2-container .select2-choice {
    height: 34px !important;
  }

  .select2-container .select2-choice .select2-chosen {
    height: 34px !important;
    padding: 5px 0 0 5px !important;
  }

  .text-primary {
    color: #478fca !important;
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }

  .input-group-text {
    border-radius: 0px 4px 4px 0px;
  }
</style>