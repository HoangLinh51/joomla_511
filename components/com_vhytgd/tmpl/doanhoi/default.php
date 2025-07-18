<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
?>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<div class="danhsach" style="background-color:#fff">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý đoàn viên hội viên</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <button type="button" data-bs-toggle="modal" data-bs-target="#modalThemDoanHoi" class="btn btn-primary btn-themmoi">
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
        <input type="text" name="hoten" id="hoten" class="form-control" style="width: 100%; font-size:16px;" placeholder="Nhập họ tên" />
      </div>
      <div class="d-flex align-items-center py-2" style="gap: 10px;">
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">CCCD/CMND</b>
          <input type="text" name="cccd" id="cccd" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập CCCD/CMND" />
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
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Phường/xã</b>
          <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường" style="width: 67%;">
            <option value=""></option>
            <?php foreach ($this->phuongxa as $px) { ?>
              <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="d-flex align-items-center w-50" style="gap: 10px;">
          <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Thôn/tổ</b>
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
          <span class="title-edit"></span> thông tin đoàn viên, hội viên
        </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formDoanvienHoiVien" name="formDoanvienHoiVien" method="post" action="index.php?option=com_vhytgd&controller=doanhoi&task=save_doanhoi">
          <div class="card-body">
            <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
              <h5 style="margin: 0">Thông tin cá nhân</h5>
              <div class="d-flex align-items-center" style="gap:5px">
                <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;">
                <small>Chọn thành viên từ danh sách nhân khẩu</small>
              </div>
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
            <!-- <input type="hidden" name="modal_gioitinh_id" id="modal_gioitinh_id" value=""> -->
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
                <div class="input-group">
                  <input type="text" id="modal_namsinh" name="modal_namsinh" class="form-control" placeholder="dd/mm/yyyy">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
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
                <label for="modal_gioitinh_id" class="form-label fw-bold">Giới tính</label>
                <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="">
                <select id="modal_gioitinh_id" name="modal_gioitinh_id" class="select2" data-placeholder="Chọn giới tính ">
                  <option value=""></option>
                  <?php if (is_array($this->gioitinh)) { ?>
                    <?php foreach ($this->gioitinh as $gt) { ?>
                      <option value="<?php echo $gt['id']; ?>"><?php echo htmlspecialchars($gt['tengioitinh']); ?></option>
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
                <label for="modal_chucdanh_id" class="form-label fw-bold">Chức vụ đoàn/hội</label>
                <select id="modal_chucdanh_id" name="chucvu_id" class="select2" data-placeholder="Chọn chức vụ">
                  <option value=""></option>
                  <?php foreach ($this->chucdanh as $cd) { ?>
                    <option value="<?php echo $cd['id']; ?>"><?php echo htmlspecialchars($cd['tenchucdanh']); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">Thời gian tham gia </label>
                <div class="d-flex" style="gap: 5px;">
                  <div class="input-group">
                    <input type="text" id="thoidiem_batdau" name="form_thoidiem_batdau" class="form-control" placeholder="dd/mm/yyyy">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  </div>
                  <div class="input-group">
                    <input type="text" id="thoidiem_ketthuc" name="form_thoidiem_ketthuc" class="form-control" placeholder="dd/mm/yyyy">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  </div>
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
  let isEditMode = false
  let isFetchingFromSelect = false;


  function resetFormManually() {
    // Các trường cần reset
    const fieldsToReset = [
      '#modal_hoten',
      '#modal_cccd',
      '#modal_namsinh',
      '#modal_dienthoai',
      '#modal_dantoc_id',
      '#modal_gioitinh_id',
      '#modal_phuongxa_id',
      '#modal_thonto_id',
      '#modal_diachi',
      '#modal_chucdanh_id',
      'input[name="thoidiem_batdau"]',
      'input[name="thoidiem_ketthuc"]',
      '#lydo_biendong',
      '#ghichu',
      '#nhankhau_id',
      '#input_dantoc_id',
      '#input_gioitinh_id',
      '#input_phuongxa_id',
      '#input_thonto_id',
      '#select_top'
    ];

    // Reset từng trường
    fieldsToReset.forEach(selector => {
      const $element = $(selector);
      if ($element.is('input:text, input:hidden')) {
        $element.val('');
      } else if ($element.is('select')) {
        $element.val('').trigger('change'); // Trigger change để cập nhật Select2
      } else if ($element.is('textarea')) {
        $element.val('');
      }
    });

    // Reset validation
    const validator = $('#formDoanvienHoiVien').validate();
    validator.resetForm();
    $('.select2').each(function() {
      $(this).next('.select2-container').find('.select2-selection').removeClass('error');
    });
    $('.error').remove();
  }

  function formatDate(dateString) {
    if (!dateString || !/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
      return '';
    }
    const date = new Date(dateString);
    if (isNaN(date.getTime())) {
      return '';
    }
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  }

  $(document).ready(function() {

    $('.modal_namsinh').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });
    $('#thoidiem_batdau').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });
    $('#thoidiem_ketthuc').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });

    // Initialize Select2 for modal and filter dropdowns
    const initSelect2 = (selector, width = '100%') => {
      $(selector).select2({
        placeholder: $(selector).data('placeholder') || 'Chọn',
        allowClear: true,
        width,
      });
    };

    ['#modal_dantoc_id', '#modal_gioitinh_id', '#modal_phuongxa_id', '#modal_thonto_id', '#modal_chucdanh_id', '#doanhoi_id'].forEach(selector => {
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
        option: 'com_vhytgd',
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
      }, 'json').fail(() => {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
      });
    };

    $('#btn_luu').on('click', function() {
      $('#formDoanvienHoiVien').submit();
    });

    // Handle ward change for filter and modal
    $('#phuongxa_id').on('change', function() {
      fetchThonTo($(this).val(), '#thonto_id');
    });
    $('#modal_phuongxa_id').on('change', function() {
      if (!isFetchingFromSelect) {
        fetchThonTo($(this).val(), '#modal_thonto_id');
      }
    });

    // Toggle input fields based on checkbox
    $('#checkbox_toggle').change(function() {
      const isChecked = $(this).is(':checked');
      const textFields = ['#modal_hoten', '#modal_cccd', '#modal_namsinh', '#modal_dienthoai', '#modal_diachi'];
      const selectFields = ['#modal_dantoc_id', '#modal_gioitinh_id', '#modal_phuongxa_id', '#modal_thonto_id'];

      $('#select-container').toggle(isChecked);
      textFields.forEach(selector => $(selector).prop('readonly', isChecked));
      selectFields.forEach(selector => $(selector).prop('disabled', isChecked));

      $('#nhankhau_id').val('');


      if (isChecked) {
        $('#select_top').select2({
          placeholder: 'Chọn thành viên',
          allowClear: true,
          width: '100%',
          ajax: {
            url: 'index.php?option=com_vhytgd&task=doanhoi.timkiem_nhankhau&format=json',
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
                  text: `${item.hoten} - CCCD: ${item.cccd_so || ''} - Ngày sinh: ${formatDate(item.ngaysinh)} - Địa chỉ: ${item.diachi || ''}`,
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
          dropdownParent: $('#modalThemDoanHoi')
        });
      }
    });

    $('.btn-themmoi').on('click', function() {
      isEditMode = false;
      $('.title-edit').text('Thêm mới');
      resetFormManually()
      $('#checkbox_toggle').prop('checked', false).trigger('change');
    });

    $('#modalThemDoanHoi').on('hidden.bs.modal', function() {
      isEditMode = false;
      $('.title-edit').text('');
      resetFormManually()
    });

    // Populate form with selected member data
    $('#select_top').on('select2:select', async function(e) {
      const data = e.params.data;
      const doanhoiPhanQuyen = <?= json_encode($this->doanhoiPhanQuyen[0]['is_doanvien'] ?? 0) ?>;

      // Check if nhankhau_id already exists in doanhoi      
      if (!isEditMode) {
        try {
          const response = await $.post('index.php', {
            option: 'com_vhytgd',
            controller: 'doanhoi',
            task: 'checkNhankhauInDoanhoi',
            nhankhau_id: data.id,
            doanhoi_id: doanhoiPhanQuyen
          }, null, 'json');

          if (response.exists) {
            showToast('Nhân khẩu này đã là thành viên của đoàn hội', false);
            // Optionally, you can clear the selection and reset the form
            $('#select_top').val('').trigger('change');
            return;
          }
        } catch (error) {
          showToast('Lỗi khi kiểm tra trạng thái nhân khẩu trong đoàn hội', false);
          return;
        }
      }
      $('#nhankhau_id').val(data.id || '');
      $('#modal_gioitinh_id').val(data.gioitinh_id || '');
      $('#modal_hoten').val(data.hoten || '');
      $('#modal_cccd').val(data.cccd_so || '');
      $('#modal_namsinh').val(data.ngaysinh);
      $('#modal_dienthoai').val(data.dienthoai || '');
      $('#input_dantoc_id').val(data.dantoc_id || '');
      $('#modal_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#input_gioitinh_id').val(data.gioitinh_id || '');
      $('#modal_gioitinh_id').val(data.gioitinh_id || '').trigger('change');

      isFetchingFromSelect = true;
      $('#input_phuongxa_id').val(data.phuongxa_id || '');
      $('#modal_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      await fetchThonTo(data.phuongxa_id, '#modal_thonto_id', data.thonto_id);
      isFetchingFromSelect = false;

      $('#input_thonto_id').val(data.thonto_id || '');
      $('#modal_thonto_id').val(data.thonto_id || '').trigger('change');
      $('#modal_diachi').val(data.diachi || '');
    });

    // Handle edit action
    $('body').on('click', '.btn_hieuchinh', async function() {
      $('.title-edit').text('Hiệu chỉnh');
      const memberId = $(this).data('doanhoi');
      if (!memberId) {
        showToast('ID đoàn hội không hợp lệ', false);
        return;
      }

      isEditMode = true;
      const $modal = $('#modalThemDoanHoi');
      const $modalContent = $modal.find('.modal-content');
      showLoadingOverlay($modalContent);

      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'doanhoi',
          task: 'getDetailDoanHoi',
          doanhoi_id: memberId
        }, null, 'json');

        if (response && response.id) {
          $('input[name="id"]').val(response.id || '');
          $('#modal_chucdanh_id').val(response.chucvu_id || '').trigger('change');
          $('input[name="form_thoidiem_batdau"]').val(formatDate(response.thoidiem_batdau));
          $('input[name="form_thoidiem_ketthuc"]').val(formatDate(response.thoidiem_ketthuc));
          $('#lydo_biendong').val(response.lydobiendong || '');
          $('#ghichu').val(response.ghichu || '');

          const hasNhankhauId = !!response.nhankhau_id;
          $('#checkbox_toggle').prop('checked', hasNhankhauId).trigger('change');

          if (hasNhankhauId) {
            // Use cccd_so as keyword to fetch nhankhau details
            const nhankhauResponse = await $.post('index.php', {
              option: 'com_vhytgd',
              task: 'doanhoi.timkiem_nhankhau',
              format: 'json',
              keyword: response.n_cccd || '', // Use cccd_so as keyword
              phuongxa_id: response.n_phuongxa_id ? [response.n_phuongxa_id] : phuongxa_id.map(item => item.id)
            }, null, 'json');

            if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
              const nhankhau = nhankhauResponse.items.find(item => item.id === response.nhankhau_id) || nhankhauResponse.items[0];
              if (nhankhau) {
                // Add the fetched nhankhau as a selected option
                const optionText = `${nhankhau.hoten} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${formatDate(nhankhau.ngaysinh)} - Địa chỉ: ${nhankhau.diachi || ''}`;
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
                      ngaysinh: formatDate(nhankhau.ngaysinh),
                      dienthoai: nhankhau.dienthoai,
                      dantoc_id: nhankhau.dantoc_id,
                      gioitinh_id: nhankhau.gioitinh_id,
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
            } else {
              showToast('Không tìm thấy thông tin nhân khẩu', false);
              $('#checkbox_toggle').prop('checked', false).trigger('change');
            }
          } else {
            // Populate manual input fields for non-nhankhau data
            $('#nhankhau_id').val(response.nhankhau_id);
            $('#modal_gioitinh_id').val(response.n_gioitinh_id || '');
            $('#modal_hoten').val(response.n_hoten || '');
            $('#modal_cccd').val(response.n_cccd || '');
            $('#modal_namsinh').val(formatDate(response.n_namsinh) || '');
            $('#modal_dienthoai').val(response.n_dienthoai || '');
            $('#input_dantoc_id').val(response.n_dantoc_id || '');
            $('#modal_dantoc_id').val(response.n_dantoc_id || '').trigger('change');
            $('#input_gioitinh_id').val(response.n_gioitinh_id || '');
            $('#modal_gioitinh_id').val(response.n_gioitinh_id || '').trigger('change');
            $('#input_phuongxa_id').val(response.n_phuongxa_id || '');
            $('#modal_phuongxa_id').val(response.n_phuongxa_id || '').trigger('change');
            $('#input_thonto_id').val(response.n_thonto_id || '');
            $('#modal_thonto_id').val(response.n_thonto_id || '').trigger('change');
            await fetchThonTo(response.n_phuongxa_id, '#modal_thonto_id', response.n_thonto_id);
            $('#modal_diachi').val(response.n_diachi || '');
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
    $('#formDoanvienHoiVien').validate({
      ignore: [],
      rules: {
        select_top: {
          required: function() {
            return $('#checkbox_toggle').is(':checked');
          }
        },
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
        select_top: 'Vui lòng chọn công dân',
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
            // setTimeout(() => location.reload(), 500);
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

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
    color: #fff
  }

  .select2-container.select2-container-disabled .select2-choice {
    background-color: #ddd;
    border-color: #a8a8a8;
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