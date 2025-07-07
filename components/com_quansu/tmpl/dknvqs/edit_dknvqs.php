<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detailDknvqs = $this->detailDknvqs;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formDknvqs" name="formDknvqs" method="post" action="<?php echo Route::_('index.php?option=com_quansu&controller=dknvqs&task=save_dknvqs'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
      <h2 class="text-primary mb-3">
        <?php echo ((int)$detailDknvqs->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> công dân đến tuổi thực hiện nghĩa vụ quân sự
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </span>
    </div>

    <input type="hidden" name="id" value="<?php echo htmlspecialchars($detailDknvqs->id); ?>">
    <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($detailDknvqs->nhankhau_id); ?>">

    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
      <h5 style="margin: 0">Thông tin cá nhân</h5>
      <div class="d-flex align-items-center" style="gap:5px">
        <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo htmlspecialchars($detailDknvqs->nhankhau_id) ? 'checked' : ''; ?>>
        <small>Chọn người đăng ký từ danh sách nhân khẩu</small>
      </div>
    </div>
    <div id="select-container" style="display: <?php echo htmlspecialchars($detailDknvqs->nhankhau_id) ? 'block' : 'none'; ?>;" class="mb-3">
      <label for="select_top" class="form-label fw-bold">Tìm nhân khẩu</label>
      <select id="select_top" name="select_top" class="form-control">
        <option value="">-- Chọn --</option>
        <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
          <option value="<?php echo $tv['id']; ?>" <?php echo htmlspecialchars($detailDknvqs->nhankhau_id) == $tv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tv['hoten']); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="row g-3 mb-4">
      <div class="col-md-4 mb-2">
        <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
        <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($detailDknvqs->n_hoten); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_gioitinh_id" class="form-label fw-bold">Giới tính</label>
        <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="<?php echo htmlspecialchars($detailDknvqs->n_gioitinh_id); ?>">
        <select id="select_gioitinh_id" name="select_gioitinh_id" class="form-control" data-placeholder="Chọn giới tính">
          <option value=""></option>
          <?php foreach ($this->gioitinh as $gt) { ?>
            <option value="<?php echo $gt['id']; ?>" <?php echo $detailDknvqs->n_gioitinh_id == $gt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($gt['tengioitinh']); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
        <input id="cccd" type="text" name="cccd" class="form-control" value="<?php echo htmlspecialchars($detailDknvqs->n_cccd); ?>" placeholder="Nhập CCCD/CMND">
      </div>
      <div class="col-md-4 mb-2">
        <label for="namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
        <input type="hidden" id="input_namsinh" name="input_namsinh" value="<?php echo htmlspecialchars($detailDknvqs->n_namsinh); ?>">
        <div class="input-group">
          <input type="text" id="select_namsinh" name="select_namsinh" class="form-control namsinh" placeholder="dd/mm/yyyy" value="">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <label for="dienthoai" class="form-label fw-bold">Điện thoại</label>
        <input id="dienthoai" type="text" name="dienthoai" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($detailDknvqs->n_dienthoai); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_dantoc_id" class="form-label fw-bold">Dân tộc</label>
        <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="<?php echo htmlspecialchars($detailDknvqs->n_dantoc_id); ?>">
        <select id="select_dantoc_id" name="select_dantoc_id" class="form-control" data-placeholder="Chọn dân tộc">
          <option value=""></option>
          <?php foreach ($this->dantoc as $dt) { ?>
            <option value="<?php echo $dt['id']; ?>" <?php echo $detailDknvqs->n_dantoc_id == $dt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dt['tendantoc']); ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="select_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
        <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="<?php echo htmlspecialchars($detailDknvqs->n_phuongxa_id); ?>">
        <div class="input-group">
          <select id="select_phuongxa_id" name="select_phuongxa_id" class="form-control" data-placeholder="Chọn phường/xã">
            <option value=""></option>
            <?php if (is_array($this->phuongxa)) { ?>
              <?php foreach ($this->phuongxa as $px) { ?>
                <option value="<?php echo $px['id']; ?>" <?php echo $detailDknvqs->n_phuongxa_id == $px['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <label for="select_thonto_id" class="form-label fw-bold">Thôn tổ</label>
        <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="<?php echo htmlspecialchars($detailDknvqs->n_thonto_id); ?>">
        <select id="select_thonto_id" name="select_thonto_id" class="form-control" data-placeholder="Chọn thôn/tổ">
          <option value=""></option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
        <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailDknvqs->n_diachi); ?>">
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin học vấn</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="trinhdohocvan_id" class="form-label fw-bold">Trình độ học vấn</label>
        <select id="trinhdohocvan_id" name="trinhdohocvan_id" class="form-control" data-placeholder="Chọn trình độ học vấn">
          <option value=""></option>
          <?php if (is_array($this->trinhdohocvan)) { ?>
            <?php foreach ($this->trinhdohocvan as $tdhv) { ?>
              <option value="<?php echo $tdhv['id']; ?>" <?php echo $detailDknvqs->trinhdohocvan_id == $tdhv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tdhv['tentrinhdohocvan']); ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="nghenghiep_id" class="form-label fw-bold">Nghề nghiệp</label>
        <select id="nghenghiep_id" name="nghenghiep_id" class="form-control" data-placeholder="Chọn nghề nghiệp">
          <option value=""></option>
          <?php foreach ($this->nghenghiep as $nn) { ?>
            <option value="<?php echo $nn['id']; ?>" <?php echo $detailDknvqs->nghenghiep_id == $nn['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nn['tennghenghiep']); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="noilamviec" class="form-label fw-bold">Nơi làm việc (học tập, công tác)</label>
        <input id="noilamviec" type="text" name="noilamviec" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailDknvqs->noilamviec); ?>">
      </div>
    </div>

    <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
      <h5 class="">Thông tin nhân thân</h5>
      <button type="button" class="btn btn-success btn-themnhanthan">Thêm nhân thân</button>
    </div>
    <div class="row g-3 mb-4" style="height: 200px; overflow-y: auto; border: 1px solid #d9d9d9; border-radius: 4px;">
      <table id="table-thannhan" class="table table-striped table-bordered" style="table-layout: fixed; width: 100%; margin: 0px">
        <thead class="table-primary">
          <tr>
            <th style="width: 50px; text-align: center;">STT</th>
            <th style="width: 175px; text-align: center;">Quan hệ</th>
            <th style="width: 200px; text-align: center;">Họ và tên</th>
            <th style="width: 150px; text-align: center;">Năm sinh</th>
            <th style="width: 300px; text-align: center;">Ngành nghề</th>
            <th style="width: 55px; text-align: center;"></th>
          </tr>
        </thead>
        <tbody class="dsThanNhan">
        </tbody>
      </table>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin phân loại đối tượng</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="thongtinsuckhoebanthan" class="form-label fw-bold">Phân loại đối tượng <span class="text-danger">*</span></label>
        <div class="input-group">
          <select id="doituong_id" name="doituong_id" class="form-control" data-placeholder="Chọn đối tượng" style="width: 67%;">
            <option value=""></option>
            <?php foreach ($this->doituong as $dt) { ?>
              <option value="<?php echo $dt['id']; ?>" <?php echo $detailDknvqs->trangthaiquansu_id == $dt['id'] ? 'selected' : ''; ?>><?php echo $dt['tentrangthai']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <label for="form_ngaydangky" class="form-label fw-bold">Ngày đăng ký</label>
        <div class="input-group">
          <input type="text" id="form_ngaydangky" name="form_ngaydangky" class="form-control ngaydangky" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailDknvqs->ngaydangky); ?>">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4">
        <label for="ghichu" class="form-label fw-bold">Ghi chú</label>
        <input id="ghichu" type="text" name="ghichu" class="form-control" value="<?php echo htmlspecialchars($detailDknvqs->ghichu); ?>">
      </div>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>

<script>
  const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
  const detailDknvqs = <?php echo json_encode($detailDknvqs); ?>;
  const detailphuongxa_id = <?= json_encode($detailDknvqs->n_phuongxa_id ?? 0) ?>;
  const detailthonto_id = <?= json_encode($detailDknvqs->n_thonto_id ?? 0) ?>;
  const nghenghiep = <?= json_encode($this->nghenghiep ?? []) ?>;
  const quanhethannhan = <?= json_encode($this->quanhethannhan ?? []) ?>;
  let isEditMode = <?php echo ((int)$detailDknvqs->id > 0) ? 'true' : 'false'; ?>;
  let isFetchingFromSelect = false;

  $(document).ready(function() {
    $('#btn_quaylai').click(() => {
      window.location.href = '<?php echo Route::_('/index.php/component/quansu/?view=dknvqs&task=default'); ?>';
    });

    $('.namsinh').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });
    $('.ngaydangky').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy',
    });

    const formatDate = dateStr => {
      if (!dateStr || !/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) return '';
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return '';
      return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
    };


    // gán giá trị n_namsinh vào input
    if (detailDknvqs && detailDknvqs.n_namsinh) {
      const formattedDate = formatDate(detailDknvqs.n_namsinh);
      $('#select_namsinh').val(formattedDate);
      $('#input_namsinh').val(formattedDate);
    }
    if (detailDknvqs && detailDknvqs.ngaydangky) {
      const formattedDate = formatDate(detailDknvqs.ngaydangky);
      $('#form_ngaydangky').val(formattedDate);
    }

    // khởi tạo select 2 
    const initSelect2 = (selector, width = '100%') => {
      $(selector).select2({
        placeholder: $(selector).data('placeholder') || 'Chọn',
        allowClear: true,
        width,
      });
    };
    ['#select_dantoc_id', '#select_gioitinh_id', '#select_phuongxa_id', '#select_thonto_id',
      '#trinhdohocvan_id', '#tinhtrangdangky', '#nghenghiep_id', '#doituong_id'
    ].forEach(selector => {
      initSelect2(selector);
    });

    function initializeSelect2() {
      $('#select_top').select2({
        placeholder: 'Chọn nhân khẩu',
        allowClear: true,
        width: '100%',
        ajax: {
          url: 'index.php?option=com_quansu&task=dknvqs.timkiem_nhankhau&format=json',
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
      $('#table-thannhan tbody').empty();
      $('#select-container').toggle(isChecked);
      textFields.forEach(selector => $(selector).prop('readonly', isChecked));
      selectFields.forEach(selector => $(selector).prop('disabled', isChecked));

      $('.btn-xoathannhan').prop('disabled', isChecked);
      $('.btn-themnhanthan').toggle(!isChecked);
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
          option: 'com_quansu',
          controller: 'dknvqs',
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
      const detailDknvqs = <?php echo json_encode($detailDknvqs); ?>;
      if (detailDknvqs && detailDknvqs.nhankhau_id) {
        try {
          const nhankhauResponse = await $.post('index.php', {
            option: 'com_quansu',
            task: 'dknvqs.timkiem_nhankhau',
            format: 'json',
            nhankhau_id: detailDknvqs.nhankhau_id,
          }, null, 'json');

          if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
            const nhankhau = nhankhauResponse.items.find(item => item.id === detailDknvqs.nhankhau_id) || nhankhauResponse.items[0];
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
    $('.btn-themnhanthan').click(function() {
      const stt = $('.dsThanNhan tr').length;

      // Tạo options cho quan hệ thân nhân
      let quanheOptions = '<option value="">Chọn quan hệ</option>';
      for (const item of quanhethannhan) {
        quanheOptions += `<option value="${item.id}">${item.tenquanhenhanthan}</option>`;
      }

      // Tạo options cho nghề nghiệp
      let nghenghiepOptions = '<option value="">Chọn nghề nghiệp</option>';
      for (const item of nghenghiep) {
        nghenghiepOptions += `<option value="${item.id}">${item.tennghenghiep}</option>`;
      }
      // Set range for year selection in JavaScript
      const currentYear = new Date().getFullYear();
      const startYear = 1900;
      const endYear = currentYear;
      let namsinhOption = '<option value="">Chọn năm sinh</option>';
      for (let y = endYear; y >= startYear; y--) {
        namsinhOption += `<option value="${y}" >${y}</option>`;
      }
      let isdisabled = ''
      if ($('#checkbox_toggle').is(':checked')) {
        isdisabled = 'disabled'
      }

      // Thêm dòng mới vào bảng
      const newRow = `
      <tr>
        <td class="text-center" style="max-width: 50px;">${stt + 1}</td>
        <td style="max-width: 175px;">
          <select name="thannhan_quanhe_id[]" class="form-control select-quanhe">
            ${quanheOptions}
          </select>
        </td>
        <td style="max-width: 200px;">
          <input type="text" name="thannhan_hoten[]" placeholder="Nhập họ tên"  class="form-control">
        </td>
        <td style="max-width: 150px;">
          <select name="thannhan_namsinh[]" class="form-control select-namsinh">
            ${namsinhOption}
          </select>
        </td>
        <td style="max-width: 300px">
          <select name="thannhan_nghenghiep[]" class="form-control select-nghenghiep">
            ${nghenghiepOptions}
          </select>
        </td>     
        <td class="text-center" >
          <button type="button" class="btn btn-danger btn-xoathannhan" ${isdisabled} ><i class="fa fa-trash"></i></button>
        </td>
      </tr>
      `;

      $('.dsThanNhan').append(newRow);

      // Init Select2 cho các select mới thêm
      $('.select-quanhe').last().select2({
        placeholder: 'Chọn quan hệ',
        width: '100%',
        allowClear: true
      });

      $('.select-namsinh').last().select2({
        placeholder: 'Chọn năm sinh',
        width: '100%',
        allowClear: true
      });
      $('.select-nghenghiep').last().select2({
        placeholder: 'Chọn nghề nghiệp',
        width: '100%',
        allowClear: true
      });
    });

    // Xóa dòng thân nhân khi click vào nút xóa
    $(document).on('click', '.btn-xoathannhan', function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
      // Cập nhật lại số thứ tự (STT)
      $('.dsThanNhan tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
      });
    });

    if (detailDknvqs && detailDknvqs.thannhan) {
      if (Array.isArray(detailDknvqs.thannhan)) {
        $('.dsThanNhan').empty(); // Xóa dữ liệu cũ nếu có
        detailDknvqs.thannhan.forEach((item, index) => {
          const stt = index + 1;
          // Tạo options cho quan hệ
          let quanheOptions = '<option value="">Chọn quan hệ</option>';
          for (const q of quanhethannhan) {
            const selected = (parseInt(item.quanhenhanthan_id) === q.id) ? 'selected' : '';
            quanheOptions += `<option value="${q.id}" ${selected}>${q.tenquanhenhanthan}</option>`;
          }

          // Tạo options cho nghề nghiệp
          let nghenghiepOptions = '<option value="">Chọn nghề nghiệp</option>';
          for (const n of nghenghiep) {
            const selected = (parseInt(item.nghenghiep_id) === n.id) ? 'selected' : '';
            nghenghiepOptions += `<option value="${n.id}" ${selected}>${n.tennghenghiep}</option>`;
          }
          const currentYear = new Date().getFullYear();
          const startYear = 1900;
          const endYear = currentYear;
          let namsinhOption = '<option value="">Chọn năm sinh</option>';
          for (let y = endYear; y >= startYear; y--) {
            const selected = (parseInt(item.namsinh) === y) ? 'selected' : '';
            namsinhOption += `<option value="${y}" ${selected} >${y}</option>`;
          }

          let isdisabled = ''
          if ($('#checkbox_toggle').is(':checked')) {
            isdisabled = 'disabled'
          }
          const newRow = `
            <tr>
              <td class="text-center" style="max-width: 50px;">${stt}</td>
              <td style="max-width: 175px;">
                <select name="thannhan_quanhe_id[]" class="form-control select-quanhe">
                  ${quanheOptions}
                </select>
              </td>
              <td style="max-width: 200px;">
                <input type="text" name="thannhan_hoten[]" placeholder="Nhập họ tên" value="${item.hoten || ''}" class="form-control">
              </td>
              <td style="max-width: 150px;"> 
                <select name="thannhan_namsinh[]" class="form-control select-namsinh">
                  ${namsinhOption}
                </select>
              </td>
              <td style="max-width: 300px">
                <select name="thannhan_nghenghiep[]" class="form-control select-nghenghiep">
                  ${nghenghiepOptions}
                </select>
              </td>
              <td class="text-center" >
                <button type"button" class="btn btn-danger btn-xoathannhan" ${isdisabled}><i class="fa fa-trash"></i></button>
              </td>
            </tr>
          `;

          $('.dsThanNhan').append(newRow);
        });

        // Khởi tạo lại Select2 sau khi append
        $('.select-quanhe').select2({
          placeholder: 'Chọn quan hệ',
          width: '100%',
          allowClear: true
        });

        $('.select-namsinh').select2({
          placeholder: 'Chọn năm sinh',
          width: '100%',
          allowClear: true
        });

        $('.select-nghenghiep').select2({
          placeholder: 'Chọn nghề nghiệp',
          width: '100%',
          allowClear: true
        });
      }
    }

    // kiểm tra checkbox toggle
    $('#checkbox_toggle').change(function() {
      toggleFormFields($(this).is(':checked'));
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
            option: 'com_quansu',
            controller: 'dknvqs',
            task: 'checkNhankhauInDSDknvqs',
            nhankhau_id: data.id,
          }, null, 'json');

          if (response.exists) {
            showToast('Nhân khẩu này đã có trong danh sách đăng ký', false);
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
      isFetchingFromSelect = true;
      $('#input_phuongxa_id').val(data.phuongxa_id || '');
      $('#select_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
      await fetchThonTo(data.phuongxa_id, '#select_thonto_id', data.thonto_id);
      isFetchingFromSelect = false;
      $('#diachi').val(data.diachi || '');
      $('#input_thonto_id').val(data.thonto_id || '');
      $('#select_thonto_id').val(data.thonto_id || '').trigger('change');

      isEditMode = false
      try {
        const response = await $.post('index.php', {
          option: 'com_quansu',
          controller: 'dknvqs',
          task: 'getThanNhan',
          nhankhau_id: data.id,
        }, 'json');
        const responses = JSON.parse(response)

        // Xóa các hàng hiện có trong bảng .dsThanNhan
        $('.dsThanNhan').empty();

        // Thêm từng thân nhân vào bảng
        if (responses && Array.isArray(responses) && responses.length > 0) {
          responses.forEach((item, index) => {
            if (item.id !== data.id) {
              if (!item.ngaysinh || !/^\d{4}-\d{2}-\d{2}$/.test(item.ngaysinh)) {
                return '';
              }
              const date = new Date(item.ngaysinh);
              const getYear = date.getFullYear();

              let isdisabled = ''
              if ($('#checkbox_toggle').is(':checked')) {
                isdisabled = 'disabled'
              }

              const boldStyle = item.is_chuho == 1 ? 'font-weight:bold' : '';
              const newRow = `
                <tr>
                  <td class="text-center" style="max-width: 50px;">${index + 1}</td>
                  <td style="max-width: 175px;">
                    <input type="text" name="thannhan_quanhe_id[]" class="form-control" value="${item.tenquanhenhanthan || ''}" ${boldStyle} readonly>
                  </td>
                  <td style="max-width: 200px;">
                    <input type="text" name="thannhan_hoten[]" class="form-control" value="${item.hoten || ''}" style="${boldStyle}" readonly>
                  </td>
                  <td class="text-center" style="max-width: 150px;">
                    <input type="text" name="thannhan_namsinh[]" class="form-control" value="${getYear}" style="${boldStyle}" readonly>
                  </td>
                  <td style = "max-width: 300px" >
                    <input type="text" name="thannhan_nganhnghe[]" class="form-control" value="${item.tennghenghiep || ''}" style="${boldStyle}" readonly>
                  </td>
                  <td class="text-center" >
                    <button type="button" class="btn btn-danger btn-xoathannhan"${isdisabled} ><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
              `;
              $('.dsThanNhan').append(newRow);
            }
          });

        } else {
          showToast('Không có dữ liệu thân nhân', false);
        }
      } catch (error) {
        console.error('GetThanNhan error:', error);
        showToast('Lỗi khi tải danh sách thân nhân', false);
      }
    });

    jQuery.validator.addMethod("checkTuoi18den27", function(value, element) {
      if (!value) return true; // Để rule "required" xử lý

      // Tách chuỗi "dd/mm/yyyy"
      const parts = value.split('/');
      if (parts.length !== 3) return false;

      const day = parseInt(parts[0], 10);
      const month = parseInt(parts[1], 10) - 1; // JavaScript đếm tháng từ 0
      const year = parseInt(parts[2], 10);

      const birthDate = new Date(year, month, day);
      if (isNaN(birthDate.getTime())) return false;

      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();

      // Kiểm tra nếu chưa đến ngày sinh nhật trong năm
      const m = today.getMonth() - birthDate.getMonth();
      const d = today.getDate() - birthDate.getDate();
      if (m < 0 || (m === 0 && d < 0)) {
        age--;
      }

      return age >= 18 && age <= 27;
    }, "Người đăng ký phải trong độ tuổi từ 18 đến 27.");

    // validate forrm
    $('#formDknvqs').validate({
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
        select_namsinh: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          },
          checkTuoi18den27: true
        },
        select_phuongxa_id: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        doituong_id: {
          required: true
        }
      },
      messages: {
        select_top: 'Vui lòng chọn nhân khẩu',
        hoten: 'Vui lòng nhập họ và tên',
        cccd: 'Vui lòng nhập CCCD/CMND',
        select_namsinh: {
          required: 'Vui lòng chọn ngày, tháng, năm sinh',
          checkTuoi18den27: 'Người đăng ký phải trong độ tuổi từ 18 đến 27'
        },
        select_phuongxa_id: 'Vui lòng chọn phường/xã',
        doituong_id: 'Vui lòng phân loại đối tượng',
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
    $('#formDknvqs').on('submit', function(e) {
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
            setTimeout(() => location.href = "/index.php/component/quansu/?view=dknvqs&task=default", 500);
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
  .card-body {
    padding: 2.5rem;
    font-size: 15px;
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