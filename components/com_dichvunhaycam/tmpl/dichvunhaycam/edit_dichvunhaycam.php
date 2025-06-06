<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detaiCoSo = $this->detailCoSo;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<form id="formCoSoNhayCam" name="formCoSoNhayCam" method="post" action="index.php?option=com_dichvunhaycam&controller=dichvunhaycam&task=save_dichvunhaycam">
  <div class="container-fluid px-3">
    <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
      <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin cơ sở dịch vụ nhạy cảm
      <span class="float-right">
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>

      </span>
    </h2>
    <table class="table w-100" style="margin-bottom: 15px;" id="tblThongtin">
      <tbody>
        <!-- Thông tin cơ sở -->
        <tr>
          <td colspan="6">
            <h3 class="mb-0 fw-bold">Thông tin cơ sở</h3>
          </td>
        </tr>
        <tr class="mb-3">
          <td class="input-thongtin">
            <strong>Tên cơ sở <span class="text-danger">*</span></strong>
            <input type="text" name="tencoso" value="<?php echo htmlspecialchars($detaiCoSo->coso_ten); ?>" class="form-control" placeholder="Nhập tên cơ sở">
            <label for="tencoso" class="error"></label>
          </td>
          <td class="input-thongtin">
            <strong>Phường xã <span class="text-danger">*</span></strong>
            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
              <option value=""></option>
              <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
              <?php } elseif (is_array($this->phuongxa)) { ?>
                <?php foreach ($this->phuongxa as $px) { ?>
                  <option value="<?php echo $px['id']; ?>" <?php echo ($detaiCoSo->phuongxa_id == $px['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <label for="phuongxa_id" class="error"></label>
          </td>
          <td class="input-thongtin">
            <strong>Thôn tổ <span class="text-danger">*</span></strong>
            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
              <option value=""></option>
            </select>
            <label for="thonto_id" class="error"></label>
          </td>
        </tr>
        <tr class="mb-3">
          <td class="input-thongtin">
            <strong>Địa chỉ <span class="text-danger">*</span></strong>
            <input type="text" name="diachi" value="<?php echo htmlspecialchars($detaiCoSo->coso_diachi); ?>" class="form-control" placeholder="Nhập địa chỉ cơ sở">
            <label for="diachi" class="error"></label>
          </td>
          <td class="input-thongtin">
            <strong>Ngày khảo sát <span class="text-danger">*</span></strong>
            <div class="input-group">
              <input type="text" id="ngaykhaosat" name="ngaykhaosat" class="form-control date-picker" value="<?php echo htmlspecialchars($detaiCoSo->ngaykhaosat); ?>" placeholder="dd/mm/yyyy">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <label for="ngaykhaosat" class="error"></label>
          </td>
          <td class="input-thongtin">
            <strong>Trạng thái <span class="text-danger">*</span></strong>
            <select id="idTrangthai" name="idTrangthai" class="custom-select" data-placeholder="Chọn phường/xã">
              <option value=""></option>
              <?php if (is_array($this->trangthaihoatdong) && count($this->trangthaihoatdong) == 1) { ?>
                <option value="<?php echo $this->trangthaihoatdong[0]['id']; ?>" selected>
                  <?php echo htmlspecialchars($this->trangthaihoatdong[0]['tentrangthaihoatdong']); ?>
                </option>
              <?php } elseif (is_array($this->trangthaihoatdong)) { ?>
                <?php foreach ($this->trangthaihoatdong as $tt) { ?>
                  <option value="<?php echo $tt['id']; ?>" <?php echo ($detaiCoSo->trangthaihoatdong_id == $tt['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($tt['tentrangthaihoatdong']); ?>
                  </option>
                <?php } ?>
              <?php } ?>
            </select>
            <label for="idTrangthai" class="error"></label>
          </td>
        </tr>

        <!-- Thông tin chủ cơ sở -->
        <tr>
          <td colspan="6">
            <h3 class="mb-0 fw-bold">Thông tin chủ cơ sở</h3>
          </td>
        </tr>
        <tr class="mb-3">
          <td class="input-thongtin">
            <strong>Họ tên <span class="text-danger">*</span></strong>
            <input type="text" id="hoten_chucoso" name="hoten_chucoso" class="form-control" value="<?php echo htmlspecialchars($detaiCoSo->chucoso_ten); ?>" placeholder="Nhập họ tên chủ cơ sở">
            <label for="hoten_chucoso" class="error"></label>
          </td>
          <td class="input-thongtin">
            <strong>CMND/CCCD</strong>
            <input type="text" name="cccd_chucoso" class="form-control" value="<?php echo htmlspecialchars($detaiCoSo->chucoso_cccd); ?>" placeholder="Nhập số CMND/CCCD">
          </td>
          <td class="input-thongtin">
            <strong>Số điện thoại</strong>
            <input type="text" name="sodienthoai_chucoso" class="form-control" value="<?php echo htmlspecialchars($detaiCoSo->chucoso_dienthoai); ?>" placeholder="Nhập số điện thoại">
          </td>
        </tr>
      </tbody>
    </table>

    <h3 style="padding-left:15px ;" class="mb-0 fw-bold">Thông tin nhân viên
      <span class="float-right">
        <button type="button" class="btn btn-primary" id="btn_themnhanvien"><i class="fas fa-plus"></i> Thêm nhân viên</button>
      </span>
    </h3>
    <div style="padding-left: 10px; overflow-x: auto;" class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="tblDanhsach" style="min-width: 1200px;">
        <thead>
          <tr class="bg-primary text-white">
            <th class="align-middle text-center" style="width: 80px;"></th>
            <th class="align-middle text-center" style="min-width: 170px;">Họ tên</th>
            <th class="align-middle text-center" style="min-width: 115px;">Giới tính</th>
            <th class="align-middle text-center" style="min-width: 150px;">CMND/CCCD</th>
            <th class="align-middle text-center" style="min-width: 150px;">Điện thoại</th>
            <th class="align-middle text-center" style="min-width: 200px;">Địa chỉ</th>
            <th class="align-middle text-center" style="min-width: 150px;">Tình trạng</th>
            <th class="align-middle text-center" style="min-width: 145px;">Trạng thái</th>
            <th class="align-middle text-center" style="min-width: 115px;">Chức năng</th>
          </tr>
        </thead>
        <tbody>


        </tbody>
      </table>
    </div>
    <table class="w-100">
      <tr>
        <td class="text-center">
        </td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="id" value="<?php echo (int)$detaiCoSo->id; ?>">
  <?php echo HTMLHelper::_('form.token'); ?>
</form>

<div class="modal fade" id="modalThemNhanVien" tabindex="-1" role="dialog" aria-labelledby="modalThemNhanVienLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalThemNhanVienLabel">Tìm nhân khẩu</h5>
      </div>
      <div class="modal-body">
        <form action="<?= Route::_('index.php?option=com_dichvunhaycam&task=dichvunhaycam.timkiem_nhankhau') ?>" id="frmmodalThemNhanVien" name="frmmodalThemNhanVien" method="post">
          <div class="d-flex align-items-center flex-column">
            <div class="d-flex justify-content-between mb-3" style="gap:20px">
              <div class="input-thongtin">
                <strong>Họ và tên nhân khẩu</strong>
                <input type="text" name="modal_tennhankhau" class="form-control" placeholder="Nhập họ và tên nhân khẩu">
              </div>
              <div class="input-thongtin">
                <strong>CMND/CCCD</strong>
                <input type="text" name="modal_cccd" class="form-control" placeholder="Nhập số CMND/CCCD">
              </div>
            </div>
            <div class="d-flex justify-content-between mb-3" style="gap:20px">
              <div class="input-thongtin">
                <strong>Phường xã</strong>
                <select id="modal_phuongxaid" name="modal_phuongxaid" class="custom-select" data-placeholder="Chọn xã/phường" style="width: 67%;">
                  <option value=""></option>
                  <?php foreach ($this->phuongxa as $px) { ?>
                    <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="input-thongtin">
                <strong>Thôn tổ</strong>
                <select id="modal_thontoid" name="modal_thontoid" class="custom-select" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn_timkiemnhankhau">Tìm kiếm</button>
          </div>
        </form>
        <h5 class="modal-title">Danh sách nhân khẩu</h5>
        <div style="overflow-x: auto; width: 100%;">
          <table class="table table-striped table-bordered table-hover" id="tblDanhSachNhanKhau" style="min-width: 900px;">
            <thead>
              <tr class="bg-primary text-white">
                <th class="align-middle text-center" style="min-width: 45px;"></th>
                <th class="align-middle text-center" style="min-width: 170px;">Họ tên</th>
                <th class="align-middle text-center" style="min-width: 110px;">Giới tính</th>
                <th class="align-middle text-center" style="min-width: 140px;">CMND/CCCD</th>
                <th class="align-middle text-center" style="min-width: 140px;">Điện thoại</th>
                <th class="align-middle text-center" style="min-width: 220px;">Địa chỉ</th>
                <th class="align-middle text-center" style="min-width: 162px;">Tình trạng cư trú</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <nav id="paginationContainer"></nav>
          <div id="paginationInfo" class="text-muted"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="btn_luu_nhankhau"><i class="fas fa-save"></i> Thêm nhân viên</button>
      </div>
    </div>
  </div>
</div>

<script>
  const nhanviens = <?= json_encode($detaiCoSo->nhanvien ?? []) ?>;
  const phuongxa_id = <?= json_encode($detaiCoSo->phuongxa_id ?? 0) ?>;
  const thonto_id = <?= json_encode($detaiCoSo->thonto_id ?? 0) ?>;

  $(document).ready(function() {
    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi'
    });

    $.validator.addMethod('select2', value => value !== '', 'Vui lòng chọn một giá trị');

    $('#btn_quaylai').click(() =>
      window.location.href = '<?php echo Route::_('/index.php/component/dichvunhaycam/?view=dichvunhaycam&task=default'); ?>'
    );

    $('#btn_themnhanvien').click(() => $('#tblDanhsach tbody').append(renderEmployee()));
    $('#tblDanhsach').on('click', '.btn-huy', function() {
      $(this).closest('tr').remove();
    });

    // Render danh sách nhân viên
    nhanviens.forEach(nv => $('#tblDanhsach tbody').append(renderEmployee(formatNhanVien(nv))));
    // Gán phường/xã nếu có
    if (phuongxa_id) {
      $('#phuongxa_id').val(phuongxa_id);
      fetchKhuVuc(phuongxa_id, '#thonto_id', thonto_id, );
    }

    $('#modal_phuongxaid').on('change', function() {
      if ($(this).val() == '') {
        $('#modal_thontoid').html('<option value=""></option>').trigger('change');
      } else {
        fetchKhuVuc($(this).val(), '#modal_thontoid');
      }
    });
    // Sự kiện

    $('#modalThemNhanVien').on('click', '#paginationContainer .page-link', function(e) {
      e.preventDefault();
      if ($(this).parent().hasClass('disabled')) return;
      const page = parseInt($(this).data('page'), 10);
      if (!page || isNaN(page)) return;

      timKiemNhanKhau(page); // Gọi lại ajax với trang mới
    });

    $('#phuongxa_id, #thonto_id, #idTrangthai, #modal_phuongxaid, #modal_thontoid').select2({
      placeholder() {
        return $(this).data('placeholder');
      },
      allowClear: true,
      width: '100%'
    });

    $('#phuongxa_id').on('change', function() {
      const val = $(this).val();
      $('#thonto_id').html('<option value=""></option>').trigger('change');
      if (val) fetchKhuVuc(val);
    });

    $('#frmmodalThemNhanVien').submit(function(e) {
      e.preventDefault();
      timKiemNhanKhau(1); // Luôn tìm từ trang 1
    });

    // Lưu nhân viên đã chọn
    $('#btn_luu_nhankhau').click(() => {
      $('#tblDanhSachNhanKhau tbody input.checkNhanVien:checked').each(function() {
        const $row = $(this).closest('tr');
        const rowData = {
          id: $(this).val(),
          hoten: $row.find('td').eq(1).text().trim(),
          gioitinh: $row.find('td').eq(2).text().trim(),
          cccd: $row.find('td').eq(3).text().trim(),
          dienthoai: $row.find('td').eq(4).text().trim(),
          diachi: $row.find('td').eq(5).text().trim(),
          tinhtrang: $row.find('td').eq(6).text().trim() === 'Thường trú' ? '0' : '1',
          trangthai: '1'
        };

        let $targetRow = $('#tblDanhsach tbody tr.input-row').filter(function() {
          return $(this).find('input[name="id_nhanvien[]"]').val() === "";
        }).first();

        if ($targetRow.length === 0) {
          $('#tblDanhsach tbody').append(renderEmployee());
          $targetRow = $('#tblDanhsach tbody tr.input-row').last();
        }

        $targetRow.replaceWith(renderEmployee(rowData));
      });

      $('#modalThemNhanVien').modal('hide');
    });

    // Validate form chính
    $('#formCoSoNhayCam').validate({
      ignore: [],
      rules: {
        tencoso: {
          required: true
        },
        diachi: {
          required: true
        },
        ngaykhaosat: {
          required: true
        },
        phuongxa_id: {
          required: true,
        },
        thonto_id: {
          required: true,
        },
        idTrangthai: {
          required: true,
        },
        hoten_chucoso: {
          required: true
        },
      },
      messages: {
        tencoso: 'Vui lòng nhập tên cơ sở',
        diachi: 'Vui lòng nhập địa chỉ cơ sở',
        ngaykhaosat: 'Vui lòng chọn ngày khảo sát',
        hoten_chucoso: 'Vui lòng nhập họ tên chủ cơ sở',
        phuongxa_id: 'Vui lòng chọn phường xã',
        thonto_id: 'Vui lòng chọn thôn tổ',
        idTrangthai: 'Vui lòng chọn trạng thái'
      },
      errorPlacement(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('.select2-container'));
        } else {
          error.insertAfter(element);
        }
      }
    });

    // Submit form chính
    $('#formCoSoNhayCam').on('submit', function(e) {
      e.preventDefault();

      if (!$(this).valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }

      const formData = new FormData(this);
      const $form = $(this);

      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success(response) {
          const isSuccess = response.success ?? true;
          showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
          if (isSuccess) {
            setTimeout(() => {
              window.location.href = '/index.php/component/dichvunhaycam/?view=dichvunhaycam&task=default';
            }, 500);
          }
        },
        error(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });
  });

  function fetchKhuVuc(cha_id, element = '#thonto_id', selectedId = null) {
    $.post('index.php', {
      option: 'com_vptk',
      controller: 'vptk',
      task: 'getKhuvucByIdCha',
      cha_id
    }, function(data) {
      let options = '<option value=""></option>';
      data.forEach(v => {
        const selected = v.id == selectedId ? ' selected' : '';
        options += `<option value="${v.id}"${selected}>${v.tenkhuvuc}</option>`;
      });
      $(element).html(options).trigger('change');
    });
  }

  function timKiemNhanKhau(page = 1) {
    const $form = $('#frmmodalThemNhanVien');
    const formData = new FormData($form[0]);
    formData.append('page', page); // Gửi thêm page

    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success({
        data = [],
        page = 1,
        take = 10,
        totalrecord = 0
      }) {
        const $tbody = $('#tblDanhSachNhanKhau tbody').empty();

        if (data.length === 0) {
          $tbody.append(`<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>`);
        } else {
          data.forEach(item => {
            $tbody.append(`
            <tr>
              <td class="text-center"><input type="checkbox" class="checkNhanVien" value="${item.id}"></td>
              <td>${item.hoten || ''}</td>
              <td class="text-center">${item.tengioitinh || ''}</td>
              <td class="text-center">${item.cccd_so || ''}</td>
              <td class="text-center">${item.dienthoai || ''}</td>
              <td>${item.diachi || ''}</td>
              <td class="text-center">${item.is_tamtru == 1 ? 'Tạm trú' : 'Thường trú'}</td>
            </tr>
          `);
          });
        }

        const {
          pagination,
          info
        } = renderPagination(page, Math.ceil(totalrecord / take), totalrecord, take);
        $('#paginationContainer').html(pagination);
        $('#paginationInfo').text(info);
      },
      error(xhr) {
        console.error('Lỗi khi tìm kiếm:', xhr.responseText);
      }
    });
  }

  function formatNhanVien(nv) {
    return {
      id: nv.nhankhau_id,
      hoten: nv.tennhanvien,
      gioitinh: nv.tengioitinh,
      cccd: nv.cccd,
      dienthoai: nv.dienthoai,
      diachi: nv.diachi,
      tinhtrang: nv.is_thuongtru.toString(),
      trangthai: nv.trangthai.toString()
    };
  }

  function renderEmployee(data = {}) {
    return `
    <tr class="input-row">
      <td class="text-center">
        <input type="checkbox" id="lock-user-${data.id || ''}" name="lock-user" >
      </td>
      <td class= "d-flex align-item-center input-name" >
        <button type="button" id="btn_timnhankhau" data-toggle="modal" data-target="#modalThemNhanVien" class="btn btn-primary">
          <i class="fas fa-search"></i>
        </button>
        <input type="text" class="form-control" name="hoten_nhanvien[]" value="${data.hoten || ''}">  
        <input type="hidden" name="id_nhanvien[]" value="${data.id || ''}">
      </td>
      <td>
        <select class="form-control" name="gioitinh_nhanvien[]">
          <option value="">Chọn</option>
          <option value="Nam" ${data.gioitinh === 'Nam' ? 'selected' : ''}>Nam</option>
          <option value="Nữ" ${data.gioitinh === 'Nữ' ? 'selected' : ''}>Nữ</option>
          <option value="Khác" ${data.gioitinh === 'Khác' ? 'selected' : ''}>Khác</option>
        </select>
      </td>
      <td><input type="text" class="form-control" name="cccd_nhanvien[]" value="${data.cccd || ''}"></td>
      <td><input type="text" class="form-control" name="dienthoai_nhanvien[]" value="${data.dienthoai || ''}"></td>
      <td><textarea class="form-control" name="diachi_nhanvien[]" value="${data.diachi || ''}"></textarea></td>
      <td>
        <select class="form-control" name="tinhtrang_cutru_nhanvien[]">
          <option value="">Chọn</option>
          <option value="0" ${data.tinhtrang === '0' ? 'selected' : ''}>Thường trú</option>
          <option value="1" ${data.tinhtrang === '1' ? 'selected' : ''}>Tạm trú</option>
        </select>
      </td>
      <td>
        <select class="form-control" name="trangthai[]">
          <option value="">Chọn</option>
          <option value="1" ${data.trangthai === '1' ? 'selected' : ''}>Đang làm việc</option>
          <option value="0" ${data.trangthai === '0' ? 'selected' : ''}>Nghỉ việc</option>
        </select>
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm btn-huy"><i class="fas fa-times"></i></button>
      </td>
    </tr>
    `;
  }

  function renderPagination(currentPage, totalPages, totalRecord, take) {
    let html = '<ul class="pagination">';

    // First and Previous buttons
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="1">&lt;&lt;</a>
    </li>`;
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">&lt;</a>
    </li>`;

    // Page numbers
    const range = 2;
    const startPage = Math.max(1, currentPage - range);
    const endPage = Math.min(totalPages, currentPage + range);

    for (let i = startPage; i <= endPage; i++) {
      html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>`;
    }

    // Next and Last buttons
    html += `<li class="page-item ${currentPage === totalPages || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">&gt;</a>
    </li>`;
    html += `<li class="page-item ${currentPage === totalPages || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${totalPages}">&gt;&gt;</a>
    </li>`;
    html += '</ul>';

    // Pagination info
    const startRecord = (currentPage - 1) * take + 1;
    const endRecord = Math.min(startRecord + take - 1, totalRecord);
    const info = totalRecord > 0 ?
      `Hiển thị ${startRecord} - ${endRecord} của ${totalRecord} mục (${totalPages} trang)` :
      'Không có dữ liệu trang';

    return {
      pagination: html,
      info
    };
  }

  function showToast(message, isSuccess = true) {
    const toast = $('<div></div>').text(message).css({
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
    }).appendTo('body');

    setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
  }
</script>

<style>
  .input-name input {
    border-radius: 4px 0px 0px 4px;
  }

  .input-name input {
    border-radius: 0px 4px 4px 0px;
  }

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

  .input-thongtin {
    min-width: 353px;
  }

  .button {
    padding-bottom: 20px;
  }

  .bottom-page {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
  }

  .upload-image img {
    width: 500px;
    max-height: 270px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .upload-image img:hover {
    transform: scale(1.03);
  }

  .infor-more {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    min-width: 250px;
    flex: 1;
  }

  #lightboxOverlay {
    position: fixed;
    z-index: 1050;
    width: 100%;
    height: 100%;
    display: none;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.8);
  }

  .lightbox-content {
    max-width: 90%;
    max-height: 90%;
    border-radius: 8px;
  }

  .lightbox-close {
    position: absolute;
    top: 15px;
    right: 25px;
    color: white;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
  }

  @media (max-width: 768px) {
    .bottom-page {
      flex-direction: column;
      align-items: stretch;
    }

    .infor-more {
      align-items: flex-start;
      text-align: left;
    }
  }

  .input-group-text {
    border-radius: 0px 4px 4px 0px;
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>