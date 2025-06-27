<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
?>

<div class="modal-header">
  <h4 class="mb-0 text-primary">
    <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin đoàn viên, hội viên
  </h4>
  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<div class="modal-body">
  <form id="formDoanvienHoiVien" name="formDoanvienHoiVien" method="post" action="index.php?option=com_doanhoi&controller=doanhoi&task=save_doanhoi">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-4">
        <h5>Thông tin cá nhân</h5>
        <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;">
      </div>
      <div id="select-container" style="display: none;" class="mb-3">
        <label for="select_top" class="form-label fw-bold">Chọn thành viên từ danh sách nhân khẩu</label>
        <select id="select_top" name="select_top" class="custom-select select2">
          <option value="">-- Chọn --</option>
          <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
            <option value="<?php echo $tv['id']; ?>"><?php echo htmlspecialchars($tv['hoten']); ?></option>
          <?php } ?>
        </select>
      </div>

      <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="">
      <div class="row g-3 mb-4">
        <div class="col-md-4 mb-2">
          <label for="modal_hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
          <input id="modal_hoten" type="text" name="n_hoten" class="form-control" placeholder="Nhập họ và tên công dân">
        </div>
        <div class="col-md-4 mb-2">
          <label for="modal_cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
          <input id="modal_cccd" type="text" name="n_cccd" class="form-control" placeholder="Nhập CCCD/CMND">
        </div>
        <div class="col-md-4 mb-2">
          <label for="modal_namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
          <input id="modal_namsinh" type="date" name="n_namsinh" class="form-control">
        </div>
        <div class="col-md-4 mb-2">
          <label for="modal_dienthoai" class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
          <input id="modal_dienthoai" type="text" name="n_dienthoai" class="form-control" placeholder="Nhập số điện thoại">
        </div>
        <div class="col-md-4 mb-2">
          <label for="modal_dantoc_id" class="form-label fw-bold">Dân tộc <span class="text-danger">*</span></label>
          <select id="modal_dantoc_id" name="n_dantoc_id" class="custom-select select2" data-placeholder="Chọn dân tộc">
            <option value=""></option>
            <?php if (is_array($this->dantoc)) { ?>
              <?php foreach ($this->dantoc as $dt) { ?>
                <option value="<?php echo $dt['id']; ?>"><?php echo htmlspecialchars($dt['tendantoc']); ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4 mb-2">
          <label for="modal_tongiao_id" class="form-label fw-bold">Tôn giáo <span class="text-danger">*</span></label>
          <select id="modal_tongiao_id" name="n_tongiao_id" class="custom-select select2" data-placeholder="Chọn tôn giáo">
            <option value=""></option>
            <?php if (is_array($this->tongiao)) { ?>
              <?php foreach ($this->tongiao as $tg) { ?>
                <option value="<?php echo $tg['id']; ?>"><?php echo htmlspecialchars($tg['tentongiao']); ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>

      <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label for="modal_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
          <select id="modal_phuongxa_id" name="n_phuongxa_id" class="custom-select select2" data-placeholder="Chọn phường/xã">
            <option value=""></option>
            <?php if (is_array($this->phuongxa)) { ?>
              <?php foreach ($this->phuongxa as $px) { ?>
                <option value="<?php echo $px['id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label for="modal_thonto_id" class="form-label fw-bold">Thôn tổ <span class="text-danger">*</span></label>
          <select id="modal_thonto_id" name="n_thonto_id" class="custom-select select2" data-placeholder="Chọn thôn/tổ">
            <option value=""></option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="modal_diachi" class="form-label fw-bold">Địa chỉ <span class="text-danger">*</span></label>
          <input id="modal_diachi" type="text" name="n_diachi" class="form-control" placeholder="Nhập địa chỉ">
        </div>
      </div>

      <h5 class="border-bottom pb-2 mb-4">Thông tin đoàn hội</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label for="doanhoi_id" class="form-label fw-bold">Đoàn hội <span class="text-danger">*</span></label>
          <select id="doanhoi_id" name="doanhoi_id" class="custom-select select2" data-placeholder="Chọn đoàn hội" disabled>
            <?php foreach ($this->doanhoi as $dh) { ?>
              <option value="<?php echo $dh['id']; ?>" <?php echo ($this->doanhoiPhanQuyen[0]['is_doanvien'] == $dh['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dh['tendoanhoi']); ?></option>
            <?php } ?>
          </select>
          <input type="hidden" id="doanhoi_id" name="doanhoi_id" value="<?php echo $this->doanhoiPhanQuyen[0]['is_doanvien']; ?>">
        </div>
        <div class="col-md-4">
          <label for="modal_chucdanh_id" class="form-label fw-bold">Chức vụ đoàn/hội <span class="text-danger">*</span></label>
          <select id="modal_chucdanh_id" name="chucvu_id" class="custom-select select2" data-placeholder="Chọn chức vụ">
            <option value=""></option>
            <?php foreach ($this->chucdanh as $cd) { ?>
              <option value="<?php echo $cd['id']; ?>"><?php echo htmlspecialchars($cd['tenchucdanh']); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-bold">Thời gian tham gia <span class="text-danger">*</span></label>
          <div class="d-flex" style="gap: 8px;">
            <input type="date" name="thoidiem_batdau" class="form-control" placeholder="Ngày bắt đầu" style="width: 145px;">
            <input type="date" name="thoidiem_ketthuc" class="form-control" placeholder="Ngày kết thúc" style="width: 145px;">
          </div>
        </div>
      </div>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label for="lydo_biendong" class="form-label fw-bold">Lý do biến động</label>
          <textarea id="lydo_biendong" name="lydobiendong" class="form-control" rows="3" placeholder="Nhập lý do biến động"></textarea>
        </div>
        <div class="col-md-6">
          <label for="ghichu" class="form-label fw-bold">Ghi chú</label>
          <textarea id="ghichu" name="ghichu" class="form-control" rows="3" placeholder="Nhập ghi chú nếu có"></textarea>
        </div>
      </div>
      <input type="hidden" name="id" value="">
      <?php echo HTMLHelper::_('form.token'); ?>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">X Đóng</button>
  <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
</div>

<script>
  // Initialize when document is ready
  $(document).ready(function() {
    const phuongxa_id = <?= json_encode($this->phuongxa ?? []) ?>;
    const thonto_id = <?= json_encode($this->thonto_id ?? 0) ?>;

    // Function to show toast notifications
    function showToast(message, isSuccess = true) {
      const toast = $('<div></div>')
        .text(message)
        .css({
          position: 'fixed',
          top: '20px',
          right: '20px',
          background: isSuccess ? '#28a745' : '#dc3545',
          color: '#fff',
          padding: '10px 20px',
          borderRadius: '5px',
          boxShadow: '0 0 10px rgba(0,0,0,0.3)',
          zIndex: 9999,
          transition: 'opacity 0.5s'
        })
        .appendTo('body');
      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
    }

    // Function to initialize Select2 for dropdowns
    function initSelect2($element, options = {}) {
      $element.select2({
        placeholder: $element.data('placeholder') || 'Chọn',
        allowClear: true,
        width: '100%',
        ...options
      });
    }

    // Initialize Select2 for all dropdowns
    initSelect2($('#modal_dantoc_id, #modal_tongiao_id, #modal_phuongxa_id, #modal_thonto_id, #modal_chucdanh_id'));

    // Function to fetch villages based on selected commune
    function fetchVillages(communeId, selectedVillageId = 0) {
      if (!communeId) {
        $('#modal_thonto_id').html('<option value=""></option>').trigger('change');
        return;
      }
      $.post('index.php', {
        option: 'com_vptk',
        controller: 'vptk',
        task: 'getKhuvucByIdCha',
        cha_id: communeId
      }, function(data) {
        let options = '<option value=""></option>';
        data.forEach(village => {
          const selected = village.id == selectedVillageId ? ' selected' : '';
          options += `<option value="${village.id}"${selected}>${village.tenkhuvuc}</option>`;
        });
        $('#modal_thonto_id').html(options).trigger('change');
      }).fail(function() {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
      });
    }

    // Handle commune selection change
    $('#modal_phuongxa_id').on('change', function() {
      fetchVillages($(this).val());
    });

    // Handle checkbox toggle for enabling/disabling fields
    $('#checkbox_toggle').change(function() {
      const isChecked = $(this).is(':checked');
      const textFields = ['#modal_hoten', '#modal_cccd', '#modal_namsinh', '#modal_dienthoai', '#modal_diachi'];
      const selectFields = ['#modal_dantoc_id', '#modal_tongiao_id', '#modal_phuongxa_id', '#modal_thonto_id'];

      $('#select-container').toggle(isChecked);

      // Toggle readonly for text inputs
      textFields.forEach(selector => {
        $(selector).attr('readonly', isChecked);
      });

      // Toggle pointer-events for select fields
      selectFields.forEach(selector => {
        $(selector).next('.select2-container').css({
          'pointer-events': isChecked ? 'none' : '',
          'background-color': isChecked ? '#e9ecef' : '',
          'cursor': isChecked ? 'not-allowed' : ''
        });
      });

      if (isChecked) {
        // Clear form fields
        textFields.concat(['#lydo_biendong', '#ghichu']).forEach(selector => $(selector).val(''));
        selectFields.concat(['#modal_chucdanh_id']).forEach(selector => $(selector).val('').trigger('change'));
        $('input[name="thoidiem_batdau"], input[name="thoidiem_ketthuc"]').val('');

        // Initialize Select2 for member search with AJAX
        initSelect2($('#select_top'), {
          ajax: {
            url: 'index.php?option=com_doanhoi&task=doanhoi.timkiem_nhankhau&format=json',
            dataType: 'json',
            delay: 200,
            data: function(params) {
              return {
                keyword: params.term || '',
                page: params.page || 1,
                phuongxa_id: phuongxa_id.map(item => item.id)
              };
            },
            processResults: function(data, params) {
              params.page = params.page || 1;
              return {
                results: data.items.map(item => ({
                  id: item.id,
                  text: `${item.hoten} - CCCD: ${item.cccd_so || ''} - Ngày sinh: ${item.ngaysinh || ''} - Địa chỉ: ${item.diachi || ''}`,
                  ...item
                })),
                pagination: {
                  more: data.has_more
                }
              };
            },
            cache: true
          },
          templateResult: data => data.loading ? data.text : $('<div>' + data.text + '</div>'),
          templateSelection: data => data.text || '',
          dropdownParent: $('#formDoanvienHoiVien')
        });
      }
    });

    // Handle member selection from search dropdown
    $('#select_top').on('select2:select', function(e) {
      const data = e.params.data;
      $('#nhankhau_id').val(data.id || '');
      $('#modal_hoten').val(data.hoten || '');
      $('#modal_cccd').val(data.cccd_so || '');
      $('#modal_namsinh').val(data.ngaysinh || '');
      $('#modal_dienthoai').val(data.dienthoai || '');
      $('#modal_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#modal_tongiao_id').val(data.tongiao_id || '').trigger('change');
      $('#modal_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      fetchVillages(data.phuongxa_id, data.thonto_id);
      $('#modal_diachi').val(data.diachi || '');
    });

    // Validate form before submission
    $('#formDoanvienHoiVien').validate({
      ignore: [],
      rules: {
        n_hoten: {
          required: true
        },
        n_cccd: {
          required: true
        },
        n_namsinh: {
          required: true
        },
        n_phuongxa_id: {
          required: true
        },

      },
      messages: {
        n_hoten: 'Vui lòng nhập họ tên',
        n_cccd: 'Vui lòng nhập CCCD/CMND',
        n_namsinh: 'Vui lòng chọn năm sinh',
        n_phuongxa_id: 'Vui lòng chọn phường/xã',
      },
      errorPlacement: function(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('.select2-container'));
        } else if (element.closest('.input-group').length) {
          error.insertAfter(element.closest('.input-group'));
        } else {
          error.insertAfter(element);
        }
      }
    });

    // Handle form submission
    $('#formDoanvienHoiVien').on('submit', function(e) {
      e.preventDefault();
      if (!$(this).valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }

      const formData = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          const isSuccess = response.success ?? true;
          showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
          // if (isSuccess) {
          //   setTimeout(() => window.location.href = '/index.php/component/doanhoi/?view=doanhoi&task=default', 500);
          // }
        },
        error: function(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });

    // Bind save button to form submission
    $('#btn_luu').on('click', function() {
      $('#formDoanvienHoiVien').submit();
    });
  });
</script>

<style>
  .select2-container .select2-choice {
    height: 34px !important;
  }

  .select2-container .select2-choice .select2-chosen {
    height: 34px !important;
    padding: 5px 0 0 5px !important;
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }

  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 1000px;
    }
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>