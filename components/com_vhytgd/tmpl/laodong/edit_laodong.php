<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detailLaoDong = $this->detailLaoDong;
?>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formLaoDong" name="formLaoDong" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=laodong&task=save_laodong'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
      <h2 class="text-primary mb-3">
        <?php echo ((int)$detailLaoDong->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin lao động
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </span>
    </div>

    <input type="hidden" name="id" value="<?php echo htmlspecialchars($detailLaoDong->id); ?>">
    <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($detailLaoDong->nhankhau_id); ?>">

    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
      <h5 style="margin: 0">Thông tin cá nhân</h5>
      <div class="d-flex align-items-center" style="gap:5px">
        <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo htmlspecialchars($detailLaoDong->nhankhau_id) ? 'checked' : ''; ?>>
        <small>Chọn người lao động từ danh sách nhân khẩu</small>
      </div>
    </div>
    <div id="select-container" style="display: <?php echo htmlspecialchars($detailLaoDong->nhankhau_id) ? 'block' : 'none'; ?>;" class="mb-3">
      <label for="select_top" class="form-label fw-bold">Tìm nhân khẩu</label>
      <select id="select_top" name="select_top" class="select2">
        <option value="">-- Chọn --</option>
        <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
          <option value="<?php echo $tv['id']; ?>" <?php echo htmlspecialchars($detailLaoDong->nhankhau_id) == $tv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tv['hoten']); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="row g-3 mb-4">
      <div class="col-md-4 mb-2">
        <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
        <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($detailLaoDong->n_hoten); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_gioitinh_id" class="form-label fw-bold">Giới tính</label>
        <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="<?php echo htmlspecialchars($detailLaoDong->n_gioitinh_id); ?>">
        <select id="select_gioitinh_id" name="select_gioitinh_id" class="select2" data-placeholder="Chọn giới tính">
          <option value=""></option>
          <?php foreach ($this->gioitinh as $gt) { ?>
            <option value="<?php echo $gt['id']; ?>" <?php echo $detailLaoDong->n_gioitinh_id == $gt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($gt['tengioitinh']); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
        <input id="cccd" type="text" name="cccd" class="form-control" value="<?php echo htmlspecialchars($detailLaoDong->n_cccd); ?>" placeholder="Nhập CCCD/CMND">
      </div>
      <div class="col-md-4 mb-2">
        <label for="namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
        <input type="hidden" id="input_namsinh" name="input_namsinh" value="<?php echo htmlspecialchars($detailLaoDong->n_namsinh); ?>">
        <div class="input-group">
          <input type="text" id="select_namsinh" name="select_namsinh" class="form-control date-picker" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailLaoDong->n_namsinh); ?>">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <label for="dienthoai" class="form-label fw-bold">Điện thoại</label>
        <input id="dienthoai" type="text" name="dienthoai" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($detailLaoDong->n_dienthoai); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_dantoc_id" class="form-label fw-bold">Dân tộc</label>
        <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="<?php echo htmlspecialchars($detailLaoDong->n_dantoc_id); ?>">
        <select id="select_dantoc_id" name="select_dantoc_id" class="select2" data-placeholder="Chọn dân tộc">
          <option value=""></option>
          <?php foreach ($this->dantoc as $dt) { ?>
            <option value="<?php echo $dt['id']; ?>" <?php echo $detailLaoDong->n_dantoc_id == $dt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dt['tendantoc']); ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="select_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
        <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="<?php echo htmlspecialchars($detailLaoDong->n_phuongxa_id); ?>">
        <select id="select_phuongxa_id" name="select_phuongxa_id" class="select2" data-placeholder="Chọn phường/xã">
          <option value=""></option>
          <?php if (is_array($this->phuongxa)) { ?>
            <?php foreach ($this->phuongxa as $px) { ?>
              <option value="<?php echo $px['id']; ?>" <?php echo $detailLaoDong->n_phuongxa_id == $px['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="select_thonto_id" class="form-label fw-bold">Thôn tổ</label>
        <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="<?php echo htmlspecialchars($detailLaoDong->n_thonto_id); ?>">
        <select id="select_thonto_id" name="select_thonto_id" class="select2" data-placeholder="Chọn thôn/tổ">
          <option value=""></option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
        <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailLaoDong->n_diachi); ?>">
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin chung</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="doituonguutien_id" class="form-label fw-bold">Đối tượng ưu tiên</label>
        <select id="doituonguutien_id" name="doituonguutien_id" class="select2" data-placeholder="Chọn đối tượng">
          <option value=""></option>
          <?php foreach ($this->doituonguutien as $dtut) { ?>
            <option value="<?php echo $dtut['id']; ?>" <?php echo $detailLaoDong->doituonguutien == $dtut['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dtut['tendoituong']); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-bold">BHXH </label>
        <input id="bhxh" type="text" name="bhxh" class="form-control" placeholder="Nhập số thẻ BHXH" value="<?php echo htmlspecialchars($detailLaoDong->bhxh || ''); ?>">
      </div>
      <div class="col-md-4">
        <label for="doituong_id" class="form-label fw-bold">Đối tượng <span class="text-danger">*</span></label>
        <select id="doituong_id" name="doituong_id" class="select2" data-placeholder="Chọn đối tượng">
          <option value=""></option>
          <?php foreach ($this->doituong as $dt):
            $selected = '';
            if (!empty($detailLaoDong->doituonglaodong_id)) {
              $selected = ($detailLaoDong->doituonglaodong_id == $dt['id']) ? 'selected' : '';
            } elseif ((int)$dt['id'] === 8) {
              $selected = 'selected';
            }
          ?>
            <option value="<?php echo $dt['id']; ?>" <?php echo $selected; ?>>
              <?php echo htmlspecialchars($dt['tendoituong']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="doituongdacovieclam">
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label for="vithe_id" class="form-label fw-bold">Vị thế làm việc</label>
          <select id="vithe_id" name="vithe_id" class="select2" data-placeholder="Chọn vị thế">
            <option value=""></option>
            <?php foreach ($this->vithelamviec as $vt) { ?>
              <option value="<?php echo $vt['id']; ?>" <?php echo $detailLaoDong->vithe == $vt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($vt['tenvithe']); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label for="nghenghiep_id" class="form-label fw-bold">Công việc đang làm</label>
          <select id="nghenghiep_id" name="nghenghiep_id" class="select2" data-placeholder="Chọn công việc">
            <option value=""></option>
            <?php foreach ($this->nghenghiep as $nn) { ?>
              <option value="<?php echo $nn['id']; ?>" <?php echo $detailLaoDong->nghenghiep_id == $nn['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nn['tennghenghiep']); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-bold">Địa chỉ nơi làm việc </label>
          <input id="diachilamviec" type="text" name="diachilamviec" class="form-control" value="<?php echo htmlspecialchars($detailLaoDong->diachinoilamviec); ?>" placeholder="Nhập địa chỉ làm việc">
        </div>
      </div>
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label for="phuongxagioithieu_id" class="form-label fw-bold">Phường/Xã giới thiệu: </label>
          <select id="phuongxagioithieu_id" name="phuongxagioithieu_id" class="select2" data-placeholder="Chọn công việc">
            <option value=""></option>
            <?php foreach ($this->phuongxa as $pxgt) { ?>
              <option value="<?php echo $pxgt['id']; ?>" <?php echo $detailLaoDong->gioithieuvieclam_id == $pxgt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($pxgt['tenkhuvuc']); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4 d-flex justify-content-between">
          <div class="d-flex flex-column ">
            <label class="form-label fw-bold">Hợp đồng lao động </label>
            <input id="check_hopdonglaodong" type="checkbox" name="check_hopdonglaodong" style="width: 38px; height : 38px" <?php echo $detailLaoDong->is_hopdonglaodong == '1' ? 'checked' : ''; ?>>
          </div>
          <div class="d-flex flex-column">
            <label class="form-label fw-bold">Hộ kinh doanh cá thể</label>
            <input id="check_kinhdoanhcathe" type="checkbox" name="check_kinhdoanhcathe" style="width: 38px; height : 38px" <?php echo $detailLaoDong->is_hokinhdoanh == '1' ? 'checked' : ''; ?>>
          </div>
        </div>
      </div>
    </div>

    <div class="doituongthatnghiep">
      <div class="row g-3 mb-4">
        <div class="col-md-4 d-flex flex-column">
          <label for="datunglamviec" class="form-label fw-bold">Đã từng làm việc <span class="text-danger">*</span></label>
          <select id="datunglamviec" name="datunglamviec" data-placeholder="Chọn vị thế" class="custom-select">
            <option value="0" <?php echo $detailLaoDong->is_dalamviec == '0' ? 'selected' : ''; ?>>Chưa bao giờ đi làm</option>
            <option value="1" <?php echo $detailLaoDong->is_dalamviec == '1' ? 'selected' : ''; ?>>Đã từng đi làm</option>
          </select>
        </div>
        <div class="col-md-4 thoigianlamviec_container" style="display: <?php echo $detailLaoDong->datunglamviec == '1' ? 'block' : 'none'; ?>;">
          <label for="thoigianlamviec" class="form-label fw-bold">Thời gian làm việc <span class="text-danger">*</span></label>
          <select id="thoigianlamviec" name="thoigianlamviec" data-placeholder="Chọn thời gian làm việc" class="custom-select">
            <option value=""></option>
            <option value="1" <?php echo $detailLaoDong->thoigian_lamviec == '1' ? 'selected' : ''; ?>>Dưới 3 tháng</option>
            <option value="2" <?php echo $detailLaoDong->thoigian_lamviec == '2' ? 'selected' : ''; ?>>Từ 3 tháng đến 1 năm</option>
            <option value="3" <?php echo $detailLaoDong->thoigian_lamviec == '3' ? 'selected' : ''; ?>>Trên 1 năm</option>
          </select>
        </div>
      </div>
    </div>

    <div class="doituongkhonglaodong">
      <div class="row g-3 mb-4">
        <div class="col-md-12">
          <label for="lydokhonglam" class="form-label fw-bold">Lý do không tham gia hoạt động kinh tế:<span class="text-danger">*</span></label>
          <textarea id="lydokhonglam" name="lydokhonglam" class="form-control" rows="4"><?php echo htmlspecialchars($detailLaoDong->lydokhonglaodong ?? ''); ?></textarea>
        </div>
      </div>
    </div>

    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>

<script>
  const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
  const detailLaoDong = <?php echo json_encode($detailLaoDong); ?>;
  const detailphuongxa_id = <?= json_encode($detailLaoDong->n_phuongxa_id ?? 0) ?>;
  const detailthonto_id = <?= json_encode($detailLaoDong->n_thonto_id ?? 0) ?>;
  const detaildoituong_id = <?= json_encode($detailLaoDong->doituonglaodong_id ?? 8) ?>;
  let isEditMode = <?php echo ((int)$detailLaoDong->id > 0) ? 'true' : 'false'; ?>;
  let isFetchingFromSelect = false;

  $(document).ready(function() {
    $('#btn_quaylai').click(() => {
      window.location.href = '<?php echo Route::_('/index.php/component/vhytgd/?view=laodong&task=default'); ?>';
    });

    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });

    function formatDateToDMY(dateStr) {
      if (!dateStr) return '';
      const date = new Date(dateStr);
      if (isNaN(date)) return '';
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }

    // gán giá trị n_namsinh vào input
    if (detailLaoDong && detailLaoDong.n_namsinh) {
      const formattedDate = formatDateToDMY(detailLaoDong.n_namsinh);
      $('#select_namsinh').val(formattedDate);
      $('#input_namsinh').val(formattedDate);
    }

    // khởi tạo select 2 
    const initSelect2 = (selector, width = '100%') => {
      $(selector).select2({
        placeholder: $(selector).data('placeholder') || 'Chọn',
        allowClear: true,
        width,
      });
    };
    ['#select_dantoc_id', '#select_gioitinh_id', '#select_tongiao_id', '#select_phuongxa_id',
      '#select_thonto_id', '#doituonguutien_id', '#doituong_id', '#vithe_id', '#nghenghiep_id', '#phuongxagioithieu_id',
    ].forEach(selector => {
      initSelect2(selector);
    });

    toggleDivs(detaildoituong_id);

    // hàm check div 
    function toggleDivs(selectedValue) {
      const sections = {
        8: '.doituongdacovieclam',
        9: '.doituongthatnghiep',
        10: '.doituongkhonglaodong'
      };

      // Ẩn tất cả các section trước
      Object.values(sections).forEach(selector => {
        $(selector).hide();
      });

      // Hiển thị section tương ứng với selectedValue
      if (sections[selectedValue]) {
        $(sections[selectedValue]).show();
      }

      // Xử lý hiển thị/ẩn container thoigianlamviec khi chọn đối tượng thất nghiệp (id = 9)
      if (selectedValue === 9) {
        const datunglamviecValue = detailLaoDong.datunglamviec ?? $('#datunglamviec').val();
        console.log(datunglamviecValue)
        $('#datunglamviec').val(datunglamviecValue).trigger('change');
        $('.thoigianlamviec_container').toggle(datunglamviecValue === '1' || datunglamviecValue === 1);
      } else {
        $('.thoigianlamviec_container').hide();
      }
    }

    // khởi tạo select 2 cho chọn người lao động
    function initializeSelect2() {
      $('#select_top').select2({
        placeholder: 'Chọn nhân khẩu',
        allowClear: true,
        width: '100%',
        ajax: {
          url: 'index.php?option=com_vhytgd&task=laodong.timkiem_nhankhau&format=json',
          dataType: 'json',
          delay: 150,
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
              results: data.items ? data.items.map(item => ({
                id: item.id,
                text: `${item.hoten} - CCCD: ${item.cccd_so || ''} - Ngày sinh: ${item.ngaysinh || ''} - Địa chỉ: ${item.diachi || ''}`,
                ...item
              })) : [],
              pagination: {
                more: data.has_more || false
              }
            };
          },
          error: function(xhr, status, error) {
            showToast('Lỗi khi tải danh sách nhân khẩu', false);
          },
          cache: true
        },
        minimumInputLength: 0,
        templateResult: data => data.loading ? data.text : $('<div>' + data.text + '</div>'),
        templateSelection: data => data.text || 'Chọn thành viên'
      });
    }

    // hàm để đặt disabled cho các field 
    function toggleFormFields(isChecked) {
      const textFields = ['#hoten', '#cccd', '#dienthoai', '#diachi'];
      const selectFields = ['#select_gioitinh_id', '#select_namsinh', '#select_dantoc_id', '#select_tongiao_id', '#select_phuongxa_id', '#select_thonto_id'];

      $('#select-container').toggle(isChecked);
      textFields.forEach(selector => $(selector).prop('readonly', isChecked));
      selectFields.forEach(selector => $(selector).prop('disabled', isChecked));
      // $("#formLaoDong").datepicker("option", "disabled", true)/
      if (isChecked) {
        initializeSelect2();
      } else {
        $('#nhankhau_id').val('');
        if ($.fn.select2 && $('#select_top').data('select2')) {
          $('#select_top').val('').select2('destroy');
        } else {
          $('#select_top').val('');
        }
      }
    }

    // lấy thôn tổ theo phường xã cung cấp
    async function fetchThonTo(phuongxa_id, element = '#select_thonto_id', thontoSelect = null) {
      if (!phuongxa_id) {
        $(element).html('<option value=""></option>').trigger('change');
        return;
      }
      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'laodong',
          task: 'getThonTobyPhuongxa',
          phuongxa_id: phuongxa_id
        }, null, 'json');
        let options = '<option value=""></option>';
        response.forEach(thonto => {
          const selected = thonto.id == thontoSelect ? ' selected' : '';
          options += `<option value="${thonto.id}"${selected}>${thonto.tenkhuvuc}</option>`;
        });
        $(element).html(options).trigger('change');
      } catch (error) {
        showToast('Lỗi khi tải danh sách thôn/tổ', false);
        $(element).html('<option value=""></option>').trigger('change');
      }
    }

    async function initializePhuongXaAndThonTo() {
      if (phuongxa_id.length === 1 && !isEditMode) {
        const singlePhuongXaId = phuongxa_id[0].id;
        $('#select_phuongxa_id').val(singlePhuongXaId).trigger('change');
        await fetchThonTo(singlePhuongXaId, '#select_thonto_id');
      } else if (isEditMode && detailphuongxa_id) {
        $('#select_phuongxa_id').val(detailphuongxa_id).trigger('change');
        await fetchThonTo(detailphuongxa_id, '#select_thonto_id', detailthonto_id);
      }
    }

    // select nhân khẩu theo laodongdetail (nếu có)
    async function fetchNhanKhauTheoLaoDongDetail() {
      const detailLaoDong = <?php echo json_encode($detailLaoDong); ?>;
      if (detailLaoDong && detailLaoDong.nhankhau_id) {
        try {
          const nhankhauResponse = await $.post('index.php', {
            option: 'com_vhytgd',
            task: 'laodong.timkiem_nhankhau',
            format: 'json',
            nhankhau_id: detailLaoDong.nhankhau_id,
          }, null, 'json');

          if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
            const nhankhau = nhankhauResponse.items.find(item => item.id === detailLaoDong.nhankhau_id) || nhankhauResponse.items[0];
            if (nhankhau) {
              const optionText = `${nhankhau.hoten} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${nhankhau.ngaysinh || ''} - Địa chỉ: ${nhankhau.diachi || ''}`;
              const newOption = new Option(optionText, nhankhau.id, true, true);
              $('#select_top').append(newOption).trigger('change');

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
        } catch (error) {
          console.error('Fetch nhankhau error:', error);
          showToast('Lỗi khi tải thông tin nhân khẩu', false);
        }
      }
    }

    // Initialize form state
    toggleFormFields($('#checkbox_toggle').is(':checked'));
    initializePhuongXaAndThonTo();
    fetchNhanKhauTheoLaoDongDetail();

    // kiểm tra checkbox toggle
    $('#checkbox_toggle').change(function() {
      toggleFormFields($(this).is(':checked'));
    });

    // thay đổi tối tượng -> thay đổi form theo đối tượng
    $('#doituong_id').on('change', function() {
      toggleDivs($(this).val());
    });

    // check datunglamviec 
    $('#datunglamviec').on('change', function() {
      const is_lamviec = $(this).val();
      $('.thoigianlamviec_container').toggle(is_lamviec === '1').toggleClass('d-flex flex-column', is_lamviec === '1');
      if (is_lamviec !== '1') {
        $('#thoigianlamviec').val('').trigger('change');
      }
    });

    // thay đổi phường xã -> gọi hàm fetchthonto để lấy thôn tổ theo phường xã mới
    $('#select_phuongxa_id').on('change', function() {
      if (!isFetchingFromSelect) {
        fetchThonTo($(this).val(), '#select_thonto_id');
      }
    });

    // chọn select từ danh sách nhân khẩu
    $('#select_top').on('select2:select', async function(e) {
      const data = e.params.data;

      if (!isEditMode) {
        try {
          const response = await $.post('index.php', {
            option: 'com_vhytgd',
            controller: 'laodong',
            task: 'checkNhankhauInDsLaoDong',
            nhankhau_id: data.id,
          }, null, 'json');

          if (response.exists) {
            showToast('Nhân khẩu này đã có trong danh sách lao động', false);
            $('#select_top').val('').trigger('change');
            return;
          }
        } catch (error) {
          console.error('Check nhankhau error:', error);
          showToast('Lỗi khi kiểm tra trạng thái nhân khẩu', false);
          return;
        }
      }

      // convert ngày thành dd/mm/yyyy
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

      // gán dữ liệu đã chọn từ danh sách nhân khẩu vào trong form
      $('#nhankhau_id').val(data.id || '');
      $('#hoten').val(data.hoten || '');
      $('#input_gioitinh_id').val(data.gioitinh_id || '');
      $('#select_gioitinh_id').val(data.gioitinh_id || '').trigger('change');
      $('#cccd').val(data.cccd_so || '');
      const formattedDate = formatDate(data.ngaysinh);
      if (!formattedDate && data.ngaysinh) {
        showToast('Ngày sinh không hợp lệ', false);
      }
      $('#input_namsinh').val(formattedDate).datepicker('update');
      $('#select_namsinh').val(formattedDate).datepicker('update');
      $('#dienthoai').val(data.dienthoai || '');
      $('#input_dantoc_id').val(data.dantoc_id || '');
      $('#select_dantoc_id').val(data.dantoc_id || '').trigger('change');
      $('#input_tongiao_id').val(data.tongiao_id || '');
      $('#select_tongiao_id').val(data.tongiao_id || '').trigger('change');
      isFetchingFromSelect = true;
      $('#input_phuongxa_id').val(data.phuongxa_id || '');
      $('#select_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      await fetchThonTo(data.phuongxa_id, '#select_thonto_id', data.thonto_id);
      isFetchingFromSelect = false;
      $('#diachi').val(data.diachi || '');
      $('#input_thonto_id').val(data.thonto_id || '');
      $('#select_thonto_id').val(data.thonto_id || '').trigger('change');
    });

    // validate forrm
    $('#formLaoDong').validate({
      ignore: [],
      rules: {
        select_top: {
          required: function() {
            return $('#checkbox_toggle').is(':checked');
          }
        },
        hoten: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        cccd: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        namsinh: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          },
        },
        select_phuongxa_id: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        doituong_id: {
          required: true
        },
        datunglamviec: {
          required: function() {
            return $('#doituong_id').val() === '9' && $('.doituongthatnghiep').is(':visible');
          }
        },
        thoigianlamviec: {
          required: function() {
            return $('#datunglamviec').val() === '1' && $('.thoigianlamviec_container').is(':visible');
          }
        },
        lydokhonglam: {
          required: function() {
            return $('#doituong_id').val() === '10' && $('.doituongkhonglaodong').is(':visible');
          }
        }
      },
      messages: {
        select_top: 'Vui lòng chọn nhân khẩu',
        hoten: 'Vui lòng nhập họ và tên',
        cccd: 'Vui lòng nhập CCCD/CMND',
        namsinh: 'Vui lòng chọn năm sinh',
        select_phuongxa_id: 'Vui lòng chọn phường/xã',
        doituong_id: 'Vui lòng chọn đối tượng',
        datunglamviec: 'Vui lòng chọn trạng thái đã từng làm việc',
        thoigianlamviec: 'Vui lòng chọn thời gian làm việc',
        lydokhonglam: 'Vui lòng nhập lý do không tham gia hoạt động kinh tế'
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

    // submit form chính
    $('#formLaoDong').on('submit', function(e) {
      e.preventDefault();
      if (!$(this).valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }

      const formData = new FormData(this);
      const namsinh = $('#namsinh').val();

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
            setTimeout(() => location.href = "/index.php/component/vhytgd/?view=laodong&task=default", 500);
          }
        },
        error: function(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });

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
      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 3000);
    };
  });
</script>

<style>
  .doituongdacovieclam,
  .doituongthatnghiep,
  .doituongkhonglaodong {
    display: none;
  }

  .custom-select {
    height: 38px;
    padding: 7px 12px;
    border-color: #aaa;
    border-radius: 4px;
  }

  .input-group-text {
    border-radius: 0px 4px 4px 0px;
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>