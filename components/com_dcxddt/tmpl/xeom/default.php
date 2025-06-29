<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

?>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<div class="danhsach" style="background-color:#fff">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý xe ôm</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <button type="button" data-bs-toggle="modal" data-bs-target="#modalThemXeOm" class="btn btn-primary btn-themmoi">
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
    <?php require_once 'ds_xeom.php'; ?>
  </div>
</div>

<div class="modal modal-right fade" id="modalThemXeOm" tabindex="-1" aria-labelledby="modalThemXeOmLabel">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mb-0 text-primary">
          <span class="title-edit"></span> thông tin xe ôm
        </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formXeOm" name="formXeOm" method="post" action="index.php?option=com_dcxddt&controller=xeom&task=save_xeom">
          <div class="card-body">
            <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
              <h5 style="margin: 0">Thông tin cá nhân</h5>
              <div class="d-flex align-items-center" style="gap:5px">
                <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;">
                <small>Chọn tài xế từ danh sách nhân khẩu</small>
              </div>
            </div>
            <div id="select-container" style="display: none;" class="mb-3">
              <label for="select_top" class="form-label fw-bold">Tìm tài xế</label>
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
                <label for="modal_dienthoai" class="form-label fw-bold">Điện thoại</label>
                <input id="modal_dienthoai" type="text" name="modal_dienthoai" class="form-control" placeholder="Nhập số điện thoại">
              </div>
              <div class="col-md-4 mb-2">
                <label for="modal_dantoc_id" class="form-label fw-bold">Dân tộc</label>
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
                <label for="modal_tongiao_id" class="form-label fw-bold">Tôn giáo</label>
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
                <label for="modal_thonto_id" class="form-label fw-bold">Thôn tổ</label>
                <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="">
                <select id="modal_thonto_id" name="modal_thonto_id" class="select2" data-placeholder="Chọn thôn/tổ">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="modal_diachi" class="form-label fw-bold">Địa chỉ</label>
                <input id="modal_diachi" type="text" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ">
              </div>
            </div>

            <h5 class="border-bottom pb-2 mb-4">Thông tin phương tiện</h5>
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label for="modal_biensoxe" class="form-label fw-bold">Biển số xe <span class="text-danger">*</span></label>
                <input id="modal_biensoxe" type="text" name="modal_biensoxe" class="form-control" placeholder="Nhập biển số xe">
              </div>
              <div class="col-md-4">
                <label for="modal_loaixe_id" class="form-label fw-bold">Loại xe</label>
                <select id="modal_loaixe_id" name="loaixe_id" class="select2" data-placeholder="Chọn loại xe">
                  <option value=""></option>
                  <?php foreach ($this->dmLoaixe as $lx) { ?>
                    <option value="<?php echo $lx['id']; ?>"><?php echo htmlspecialchars($lx['tenloaixe']); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">Thẻ hành nghề </label>
                <input id="modal_thehanhnghe" type="text" name="modal_sothehanhnghe" class="form-control" placeholder="Nhập số thẻ hành nghề  ">
              </div>
            </div>
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label for="modal_giayphep" class="form-label fw-bold">Giấy phép </label>
                <input id="modal_giayphep" name="giayphep" class="form-control" rows="3" placeholder="Nhập số giấy phép lái xe">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">Ngày hết hạn thẻ hành nghề </label>
                <input id="modal_ngayhethan_thehanhnghe" type="date" name="modal_ngayhethan_thehanhnghe" class="form-control">
              </div>
              <div class="col-md-4 ">
                <label for="modal_tinhtrang" class="form-label fw-bold">Tình trạng thẻ hành nghề</label>
                <select id="modal_tinhtrang" name="tinhtrang_id" class="select2" data-placeholder="Chọn tình trạng thẻ hành nghề">
                  <option value=""></option>
                  <?php foreach ($this->dmtinhtrangthe as $tt) { ?>
                    <option value="<?php echo $tt['id']; ?>"><?php echo htmlspecialchars($tt['tentinhtrang']); ?></option>
                  <?php } ?>
                </select>
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
  let isEditMode = false;
  $(document).ready(function() {
    // Initialize Select2 for modal and filter dropdowns
    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi'
    });
    const initSelect2 = (selector, width = '100%') => {
      $(selector).select2({
        placeholder: $(selector).data('placeholder') || 'Chọn',
        allowClear: true,
        width,
      });
    };

    ['#modal_dantoc_id', '#modal_tongiao_id', '#modal_phuongxa_id', '#modal_thonto_id', '#modal_loaixe_id', '#modal_tinhtrang'].forEach(selector => {
      initSelect2(selector);
    });
    ['#phuongxa_id', '#thonto_id', '#gioitinh_id'].forEach(selector => {
      initSelect2(selector, '67%');
    });

    // Fetch village data based on ward selection
    const fetchThonTo = (phuongxa_id, element = '#thonto_id', thontoSelect = null) => {
      if (!phuongxa_id) {
        $(element).html('<option value=""></option>').trigger('change');
        return Promise.resolve();
      }
      return $.post('index.php', {
        option: 'com_dcxddt',
        controller: 'xeom',
        task: 'getThonTobyPhuongxa',
        phuongxa_id: phuongxa_id
      }, function(response) {
        let options = '<option value=""></option>';
        response.forEach(village => {
          const selected = village.id == thontoSelect ? ' selected' : '';
          options += `<option value="${village.id}"${selected}>${village.tenkhuvuc}</option>`;
        });
        $(element).html(options).trigger('change');
      }, 'json').fail(() => {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
      });
    };

    $('#btn_luu').on('click', function() {
      $('#formXeOm').submit();
    });

    // Handle ward change for filter and modal
    $('#phuongxa_id').on('change', function() {
      fetchThonTo($(this).val(), '#thonto_id');
    });
    $('#modal_phuongxa_id').on('change', function() {
      fetchThonTo($(this).val(), '#modal_thonto_id');
    });

    // Toggle input fields based on checkbox
    $('#checkbox_toggle').change(function() {
      const isChecked = $(this).is(':checked');
      const textFields = ['#modal_hoten', '#modal_cccd', '#modal_namsinh', '#modal_dienthoai', '#modal_diachi'];
      const selectFields = ['#modal_dantoc_id', '#modal_tongiao_id', '#modal_phuongxa_id', '#modal_thonto_id'];

      $('#select-container').toggle(isChecked);
      textFields.forEach(selector => $(selector).prop('readonly', isChecked));
      selectFields.forEach(selector => $(selector).prop('disabled', isChecked));
      // Khi ấn vào checkbox, reset nhankhau_id và modal_gioitinh_id về rỗng
      $('#nhankhau_id').val('');
      $('#modal_gioitinh_id').val('');

      if (isChecked) {
        $('#select_top').select2({
          placeholder: 'Chọn thành viên',
          allowClear: true,
          width: '100%',
          ajax: {
            url: 'index.php?option=com_dcxddt&task=xeom.timkiem_nhankhau&format=json',
            dataType: 'json',
            delay: 250,
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
          minimumInputLength: 0,
          templateResult: data => data.loading ? data.text : $('<div>' + data.text + '</div>'),
          templateSelection: data => data.text || 'Chọn thành viên',
          dropdownParent: $('#modalThemXeOm')
        });
      } else {
        $('#select_top').val('').trigger('change');
        if ($.fn.select2 && $('#select_top').data('select2')) {
          $('#select_top').select2('destroy');
        }
        $('#select_top').html('<option value="">-- Chọn --</option>');
      }
    });
    $('.btn-themmoi').on('click', function() {
      isEditMode = false;
      $('.title-edit').text('Thêm mới');
      $('#formXeOm')[0].reset();
      $('.select2').val('').trigger('change');
      $('#checkbox_toggle').prop('checked', false).trigger('change');
    });

    $('#modalThemXeOm').on('hidden.bs.modal', function() {
      isEditMode = false;
      $('.title-edit').text('');
      $('#formXeOm')[0].reset();
      $('#select_top').val('').trigger('change');
      $('.select2').val('').trigger('change');
    });

    // Populate form with selected member data
    $('#select_top').on('select2:select', async function(e) {
      const data = e.params.data;

      // Check if nhankhau_id already exists in xeom
      if (!isEditMode) {
        try {
          const response = await $.post('index.php', {
            option: 'com_dcxddt',
            controller: 'xeom',
            task: 'checkNhankhauInXeOm',
            nhankhau_id: data.id,
          }, null, 'json');

          if (response.exists) {
            showToast('Nhân khẩu này đã có trong danh sách tài xế', false);
            $('#select_top').val('').trigger('change');
            return;
          }
        } catch (error) {
          console.error('Check nhankhau error:', error);
          showToast('Lỗi khi kiểm tra trạng thái nhân khẩu', false);
          return;
        }
      }

      $('#nhankhau_id').val(data.id || '');
      $('#modal_gioitinh_id').val(data.gioitinh_id || '');
      $('#modal_hoten').val(data.hoten || '');
      $('#modal_cccd').val(data.cccd_so || '');
      $('#modal_namsinh').val(data.ngaysinh || '');
      $('#modal_dienthoai').val(data.dienthoai || '');
      $('#input_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#modal_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#input_tongiao_id').val(data.tongiao_id || '').trigger('change');
      $('#modal_tongiao_id').val(data.tongiao_id || '').trigger('change');
      $('#input_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      $('#modal_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      $('#modal_diachi').val(data.diachi || '');
      await fetchThonTo(data.phuongxa_id, '#modal_thonto_id', data.thonto_id);
      $('#input_thonto_id').val(data.thonto_id || '').trigger('change');
      $('#modal_thonto_id').val(data.thonto_id || '').trigger('change');
    });

    // Handle edit action
    $('body').on('click', '.btn_hieuchinh', async function() {
      $('.title-edit').text('Hiệu chỉnh');
      const memberId = $(this).data('xeom');
      if (!memberId) {
        showToast('ID tài xế xe không hợp lệ', false);
        return;
      }

      isEditMode = true; // Đặt trạng thái là chỉnh sửa
      const $modal = $('#modalThemXeOm');
      const $modalContent = $modal.find('.modal-content');
      showLoadingOverlay($modalContent);

      try {
        const response = await $.post('index.php', {
          option: 'com_dcxddt',
          controller: 'xeom',
          task: 'getDetailXeOm',
          xeom_id: memberId
        }, null, 'json');

        if (response && response.id) {
          $('input[name="id"]').val(response.id || '');
          $('input[name="nhankhau_id"]').val(response.nhankhau_id || '');
          $('#modal_biensoxe').val(response.biensoxe || '');
          $('#modal_loaixe_id').val(response.loaixe_id || '').trigger('change');
          $('#modal_thehanhnghe').val(response.thehanhnghe_so || '');
          $('#modal_giayphep').val(response.sogiaypheplaixe || '');
          $('#tinhtrangthe_id').val(response.tinhtrangthe_id || '');
          $('#modal_ngayhethan_thehanhnghe').val(response.thehanhnghe_ngayhethan || '');

          const hasNhankhauId = !!response.nhankhau_id;
          $('#checkbox_toggle').prop('checked', hasNhankhauId).trigger('change');

          if (hasNhankhauId) {
            const nhankhauResponse = await $.post('index.php', {
              option: 'com_dcxddt',
              task: 'xeom.timkiem_nhankhau',
              format: 'json',
              keyword: response.n_cccd,
              phuongxa_id: response.n_phuongxa_id ? [response.n_phuongxa_id] : phuongxa_id.map(item => item.id)
            }, null, 'json');

            if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
              const nhankhau = nhankhauResponse.items.find(item => item.id === response.nhankhau_id) || nhankhauResponse.items[0];
              if (nhankhau) {
                const optionText = `${nhankhau.hoten || ''} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${nhankhau.ngaysinh || ''} - Địa chỉ: ${nhankhau.diachi || ''}`;
                const newOption = new Option(optionText, nhankhau.id, true, true);
                $('#select_top').append(newOption).trigger('change');

                // Trigger select2:select to populate form
                $('#select_top').trigger({
                  type: 'select2:select',
                  params: {
                    data: {
                      id: nhankhau.id,
                      hoten: nhankhau.hoten,
                      cccd_so: nhankhau.cccd_so,
                      ngaysinh: nhankhau.ngaysinh,
                      dienthoai: nhankhau.dienthoai,
                      dantoc_id: nhankhau.dantoc_id,
                      tongiao_id: nhankhau.tongiao_id,
                      phuongxa_id: nhankhau.phuongxa_id,
                      thonto_id: nhankhau.thonto_id,
                      diachi: nhankhau.diachi
                    }
                  }
                });
              } else {
                showToast('Không tìm thấy nhân khẩu phù hợp', false);
                $('#checkbox_toggle').prop('checked', false).trigger('change');
              }
            }
          } else {
            $('#nhankhau_id').val('');
            $('#modal_gioitinh_id').val(response.n_gioitinh_id || '');
            $('#modal_hoten').val(response.n_hoten || '');
            $('#modal_cccd').val(response.n_cccd || '');
            $('#modal_namsinh').val(response.n_namsinh || '');
            $('#modal_dienthoai').val(response.n_dienthoai || '');
            $('#input_dantoc_id').val(response.n_dantoc_id || '').trigger('change');
            $('#modal_dantoc_id').val(response.n_dantoc_id || '').trigger('change');
            $('#input_tongiao_id').val(response.n_tongiao_id || '').trigger('change');
            $('#modal_tongiao_id').val(response.n_tongiao_id || '').trigger('change');
            $('#input_phuongxa_id').val(response.n_phuongxa_id || '').trigger('change');
            $('#modal_phuongxa_id').val(response.n_phuongxa_id || '').trigger('change');
            $('#modal_diachi').val(response.n_diachi || '');
            await fetchThonTo(response.n_phuongxa_id, '#modal_thonto_id', response.n_thonto_id);
            $('#input_thonto_id').val(response.n_thonto_id || '').trigger('change');
            $('#modal_thonto_id').val(response.n_thonto_id || '').trigger('change');
          }

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
        } else {
          showToast(response.message || 'Không thể lấy dữ liệu', false);
        }
      } catch (error) {
        showToast('Lỗi khi gửi yêu cầu AJAX', false);
      } finally {
        hideLoadingOverlay($modalContent);
        isEditMode = false; // Reset trạng thái sau khi đóng modal
      }
    });
    $('#formXeOm').validate({
      ignore: [],
      rules: {
        modal_hoten: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        modal_cccd: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        modal_namsinh: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        modal_phuongxa_id: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
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
    $('#formXeOm').on('submit', function(e) {
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
  const showLoadingOverlay = ($container) => {
    if ($container.find('.loading-overlay').length === 0) {
      $container.css('position', 'relative').append(`
        <div class="loading-overlay">
          <div class="loading-spinner"></div>
        </div>
      `);
    }
  };
  const hideLoadingOverlay = ($container) => {
    $container.find('.loading-overlay').remove();
  };
  const showToast = (message, isSuccess = true) => {
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
  };
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