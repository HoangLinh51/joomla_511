<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
?>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>


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
        <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 19.5%;">Họ tên </b>
        <input type="text" name="hoten" id="hoten" class="form-control" style="width: 100%; font-size:16px;" placeholder="Nhập họ tên chủ cơ sở" />
      </div>
      <div class="d-flex align-items-center py-2" style="gap: 10px;">
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">CCCD/CMND</b>
          <input type="text" name="cccd" id="cccd" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập tên cơ sở" />
        </div>
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Giới tính</b>
          <select id="gioitinh_id" name="gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính" style="width: 84%;">
            <option value=""></option>
            <?php foreach ($this->gioitinh as $gt) { ?>
              <option value="<?php echo $gt['id']; ?>"><?php echo $gt['tengioitinh']; ?></option>
            <?php } ?>
          </select>
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
      <div class="modal-header">
        <h4 class="mb-0 text-primary" data-editTitle="Thêm mới thông tin đoàn viên, hội viên">
          <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin đoàn viên, hội viên
        </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formDoanvienHoiVien" name="formDoanvienHoiVien" method="post" action="index.php?option=com_doanhoi&controller=doanhoi&task=save_doanhoi">
          <div class="card-body">
            <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:10px">
              <h5 style="margin: 0">Thông tin cá nhân</h5>
              <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Chọn thành viên từ danh sách nhân khẩu">
            </div>
            <div id="select-container" style="display: none;" class="mb-3">
              <label for="select_top" class="form-label fw-bold">Chọn thành viên từ danh sách nhân khẩu</label>
              <select id="select_top" name="select_top" class="select2">
                <option value="">-- Chọn --</option>
                <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
                  <option value="<?php echo $tv['id']; ?>"><?php echo htmlspecialchars($tv['hoten']); ?></option>
                <?php } ?>
              </select>
            </div>

            <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="">
            <input type="hidden" name="modal_gioitinh_id" id="modal_gioitinh_id" value="">
            <div class="row g-3 mb-4">
              <div class="col-md-4 mb-2">
                <label for="modal_hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                <input id="modal_hoten" type="text" name="modal_hoten" class="form-control" placeholder="Nhập họ và tên công dân">
              </div>
              <div class="col-md-4 mb-2">
                <label for="modal_cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
                <input id="modal_cccd" type="text" name="modal_cccd" class="form-control" placeholder="Nhập CCCD/CMND">
              </div>
              <div class="col-md-4 mb-2">
                <label for="modal_namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
                <input id="modal_namsinh" type="date" name="modal_namsinh" class="form-control">
              </div>
              <div class="col-md-4 mb-2">
                <label for="modal_dienthoai" class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
                <input id="modal_dienthoai" type="text" name="modal_dienthoai" class="form-control" placeholder="Nhập số điện thoại">
              </div>
              <div class="col-md-4 mb-2">
                <label for="modal_dantoc_id" class="form-label fw-bold">Dân tộc <span class="text-danger">*</span></label>
                <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="">
                <select id="modal_dantoc_id" name="modal_dantoc_id" class="select2" data-placeholder="Chọn dân tộc">
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
                <input type="hidden" id="input_tongiao_id" name="input_tongiao_id" value="">
                <select id="modal_tongiao_id" name="modal_tongiao_id" class="select2" data-placeholder="Chọn tôn giáo">
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
                <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="">
                <select id="modal_phuongxa_id" name="modal_phuongxa_id" class="select2" data-placeholder="Chọn phường/xã">
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
                <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="">
                <select id="modal_thonto_id" name="modal_thonto_id" class="select2" data-placeholder="Chọn thôn/tổ">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="modal_diachi" class="form-label fw-bold">Địa chỉ <span class="text-danger">*</span></label>
                <input id="modal_diachi" type="text" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ">
              </div>
            </div>

            <h5 class="border-bottom pb-2 mb-4">Thông tin đoàn hội</h5>
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label for="doanhoi_id" class="form-label fw-bold">Đoàn hội <span class="text-danger">*</span></label>
                <select id="doanhoi_id" class="select2" data-placeholder="Chọn đoàn hội" disabled>
                  <?php foreach ($this->doanhoi as $dh) { ?>
                    <option value="<?php echo $dh['id']; ?>" <?php echo ($this->doanhoiPhanQuyen[0]['is_doanvien'] == $dh['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dh['tendoanhoi']); ?></option>
                  <?php } ?>
                </select>
                <input type="hidden" name="doanhoi_id" value="<?php echo $this->doanhoiPhanQuyen[0]['is_doanvien']; ?>">
              </div>
              <div class="col-md-4">
                <label for="modal_chucdanh_id" class="form-label fw-bold">Chức vụ đoàn/hội <span class="text-danger">*</span></label>
                <select id="modal_chucdanh_id" name="chucvu_id" class="select2" data-placeholder="Chọn chức vụ">
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
    </div>
  </div>
</div>


<script>
  const phuongxa_id = <?= json_encode($this->phuongxa ?? []) ?>;
  const thonto_id = <?= json_encode($this->thonto_id ?? 0) ?>;

  $(document).ready(function() {
    //khởi tạo select 2 
    function initSelect2Modal($element, options = {}) {
      $element.select2({
        placeholder: $element.data('placeholder') || 'Chọn',
        allowClear: true,
        width: '100%',
        ...options
      });
    }

    function initSelect2($element, options = {}) {
      $element.select2({
        placeholder: $element.data('placeholder') || 'Chọn',
        allowClear: true,
        width: '67%',
        ...options
      });
    }

    ['#modal_dantoc_id', '#modal_tongiao_id', '#modal_phuongxa_id', '#modal_thonto_id', '#modal_chucdanh_id', '#doanhoi_id'].forEach(selector => {
      initSelect2Modal($(selector));
    });
    ['#phuongxa_id', '#thonto_id', '#gioitinh_id'].forEach(selector => {
      initSelect2($(selector));
    });

    // hàm lấy dữ liệu thôn tổ cùng với đó select nếu có truyền thôn tổ 
    function fetchThonTo(phuongxa_id, element = '#thonto_id', thontoSelect = 0) {
      console.log('thontoSelect: ', thontoSelect)
      if (!phuongxa_id) {
        $(element).html('<option value=""></option>').trigger('change');
        return;
      }
      $.post('index.php', {
        option: 'com_doanhoi',
        controller: 'doanhoi',
        task: 'getThonTobyPhuongxa',
        phuongxa_id: phuongxa_id
      }, function(response) {
        let options = '<option value=""></option>';
        response.forEach(village => {
          const selected = village.id == thontoSelect ? ' selected' : '';
          options += `<option value="${village.id}"${selected}>${village.tenkhuvuc}</option>`;
        });
        $(element).html(options).trigger('change');
      }, 'json').fail(function() {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
      });
    }

    // hành động gọi lại hàm fechthonto nếu phường xã thay đổi
    $('#modal_phuongxa_id').on('change', function() {
      fetchThonTo($(this).val(), '#modal_thonto_id');
    });
    $('#phuongxa_id').on('change', function() {
      fetchThonTo($(this).val(), '#thonto_id');
    });

    // checkbox disable các field
    $('#checkbox_toggle').change(function() {
      const isChecked = $(this).is(':checked');
      const textFields = ['#modal_hoten', '#modal_cccd', '#modal_namsinh', '#modal_dienthoai', '#modal_diachi'];
      const selectFields = ['#modal_dantoc_id', '#modal_tongiao_id', '#modal_phuongxa_id', '#modal_thonto_id'];

      $('#select-container').toggle(isChecked);

      textFields.forEach(selector => {
        $(selector).attr('readonly', isChecked);
      });

      selectFields.forEach(selector => {
        $(selector).attr('disabled', isChecked);
      });

      if (isChecked) {
        // khởi tạo select 2 cho phần search nhân khẩu (kèm theo phân trang và search keyword )
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

    // gán dữ liệu đã chọn vào các input 
    $('#select_top').on('select2:select', function(e) {
      const data = e.params.data;
      $('#nhankhau_id').val(data.id || '');
      $('#modal_gioitinh_id').val(data.gioitinh_id || '');
      $('#modal_hoten').val(data.hoten || '');
      $('#modal_cccd').val(data.cccd_so || '');
      $('#modal_namsinh').val(data.ngaysinh || '');
      $('#modal_dienthoai').val(data.dienthoai || '');
      $('#input_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#input_tongiao_id').val(data.tongiao_id || '').trigger('change');
      $('#input_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      $('#input_thonto_id').val(data.thonto_id || '').trigger('change');
      $('#modal_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#modal_tongiao_id').val(data.tongiao_id || '').trigger('change');
      $('#modal_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      $('#modal_diachi').val(data.diachi || '');
      console.log(data.thonto_id)
      fetchThonTo(data.phuongxa_id, '#modal_thonto_id', data.thonto_id);
    });

    // gọi hành động submit
    $('#btn_luu').on('click', function() {
      $('#formDoanvienHoiVien').submit();
    });

    // hành động hiệu chỉnh
    $('body').on('click', '.btn_hieuchinh', function() {
      const memberId = $(this).data('doanhoi');
      const modalTitle = $(this).data('title') || 'Hiệu chỉnh thông tin đoàn viên hội viên';
      if (!memberId) {
        showToast('ID đoàn hội không hợp lệ', false);
        return;
      }

      const $modal = $('#modalThemDoanHoi');
      const $modalContent = $modal.find('.modal-content');

      // hiện phần loadding 
      showLoadingOverlay($modalContent);

      // cập nhật tiêu đề
      $('#modalThemDoanHoiLabel').text(modalTitle);

      // gọi AJAX lấy detail 
      $.post('index.php', {
        option: 'com_doanhoi',
        controller: 'doanhoi',
        task: 'getDetailDoanHoi',
        doanhoi_id: memberId
      }, function(result) {
        if (result && result.id) {
          // gán dữ liệu vào input 
          new Promise((resolve) => {
            $('#nhankhau_id').val(result.nhankhau_id);
            $('#modal_gioitinh_id').val(result.n_gioitinh_id);
            $('#modal_hoten').val(result.n_hoten);
            $('#modal_cccd').val(result.n_cccd);
            $('#modal_namsinh').val(result.n_namsinh);
            $('#modal_dienthoai').val(result.n_dienthoai);
            $('#input_dantoc_id').val(result.n_dantoc_id);
            $('#modal_dantoc_id').val(result.n_dantoc_id).trigger('change');
            $('#input_tongiao_id').val(result.n_tongiao_id);
            $('#modal_tongiao_id').val(result.n_tongiao_id).trigger('change');
            $('#input_phuongxa_id').val(result.n_phuongxa_id);
            $('#modal_phuongxa_id').val(result.n_phuongxa_id).trigger('change');
            $('#modal_diachi').val(result.n_diachi);
            $('#doanhoi_id').val(result.doanhoi_id).trigger('change');
            $('input[name="doanhoi_id"]').val(result.doanhoi_id);
            $('#modal_chucdanh_id').val(result.chucvu_id).trigger('change');
            $('input[name="thoidiem_batdau"]').val(result.thoidiem_batdau);
            $('input[name="thoidiem_ketthuc"]').val(result.thoidiem_ketthuc);
            $('#lydo_biendong').val(result.lydobiendong);
            $('#ghichu').val(result.ghichu);
            $('input[name="id"]').val(result.id);

            // tích vào check box
            if (parseInt(result.is_ngoai) === 0) {
              $('#checkbox_toggle').prop('checked', true);
            } else {
              $('#checkbox_toggle').prop('checked', false);
            }
            $('#checkbox_toggle').trigger('change');

            fetchThonTo(result.n_phuongxa_id, '#modal_thonto_id', result.n_thonto_id);
            resolve();
          }).then(() => {
            // ẩn loadding
            hideLoadingOverlay($modalContent);

            $modal.modal({
              show: true,
              backdrop: 'static',
              keyboard: false
            }).css({
              'opacity': 0,
              'transition': 'opacity 0.3s ease-in-out'
            }).animate({
              opacity: 1
            }, 300);
          });
        } else {
          hideLoadingOverlay($modalContent);
          showToast(result.message || 'Không thể lấy dữ liệu', false);
        }
      }, 'json').fail(function() {
        hideLoadingOverlay($modalContent);
        showToast('Lỗi khi gửi yêu cầu AJAX', false);
      });
    });

    // validate form
    $('#formDoanvienHoiVien').validate({
      ignore: [],
      rules: {
        modal_hoten: {
          required: true
        },
        modal_cccd: {
          required: true
        },
        modal_namsinh: {
          required: true
        },
        modal_phuongxa_id: {
          required: true
        },
      },
      messages: {
        modal_hoten: 'Vui lòng nhập họ tên',
        modal_cccd: 'Vui lòng nhập CCCD/CMND',
        modal_namsinh: 'Vui lòng chọn năm sinh',
        modal_phuongxa_id: 'Vui lòng chọn phường/xã',
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

    // submit form 
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
          if (isSuccess) {
            $('.modal').modal('hide');
            setTimeout(() => location.reload(), 500);
          }
        },
        error: function(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });
  });

  // hàm để show loadding 
  function showLoadingOverlay($container) {
    if ($container.find('.loading-overlay').length === 0) {
      const $overlay = $(`
      <div class="loading-overlay">
        <div class="loading-spinner"></div>
      </div>
    `);
      $container.css('position', 'relative');
      $container.append($overlay);
    }
  }
  
  // hàm để hide loadding 
  function hideLoadingOverlay($container) {
    $container.find('.loading-overlay').remove();
  }

  // hàm thông báo 
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
</script>

<style>
  .modal.modal-right .modal-dialog {
    position: fixed;
    right: -100%;
    top: 0;
    height: 100%;
    transition: right 0.6s ease-in-out;
  }

  .modal.modal-right.show .modal-dialog {
    right: 0;
  }

  .modal-right .modal-content {
    height: 100%;
    border-radius: 5px 0px 0px 5px;
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

  .select2-container.select2-container-disabled .select2-choice {
    background-color: #ddd;
    border-color: #a8a8a8;
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

  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 1000px;
    }
  }

  .loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    /* Màu nền xám mờ */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
  }

  .loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #007bff;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>