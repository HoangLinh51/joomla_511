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
          </td>
          <td class="input-thongtin">
            <strong>Phường xã <span class="text-danger">*</span></strong>
            <select id="phuongxa_id" name="phuongxa_id" class="custom-select select2" data-placeholder="Chọn phường/xã">
              <option value=""></option>
              <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
              <?php } elseif (is_array($this->phuongxa)) { ?>
                <?php foreach ($this->phuongxa as $px) { ?>
                  <option value="<?php echo $px['id']; ?>" <?php echo ($detaiCoSo->phuongxa_id == $px['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td class="input-thongtin">
            <strong>Thôn tổ <span class="text-danger">*</span></strong>
            <select id="thonto_id" name="thonto_id" class="custom-select select2" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
              <option value=""></option>
            </select>
          </td>
        </tr>
        <tr class="mb-3">
          <td class="input-thongtin">
            <strong>Địa chỉ <span class="text-danger">*</span></strong>
            <input type="text" name="diachi" value="<?php echo htmlspecialchars($detaiCoSo->coso_diachi); ?>" class="form-control" placeholder="Nhập địa chỉ cơ sở">
          </td>
          <td class="input-thongtin">
            <strong>Ngày khảo sát <span class="text-danger">*</span></strong>
            <div class="input-group">
              <input type="text" id="ngaykhaosat" name="ngaykhaosat" class="form-control date-picker" value="<?php echo htmlspecialchars($detaiCoSo->ngaykhaosat); ?>" placeholder="dd/mm/yyyy">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
          </td>
          <td class="input-thongtin">
            <strong>Trạng thái <span class="text-danger">*</span></strong>
            <select id="trangthai_id" name="trangthai_id" class="custom-select select2" data-placeholder="Chọn trạng thái">
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
            <th class="align-middle text-center" style="min-width: 230px;">Họ tên</th>
            <th class="align-middle text-center" style="min-width: 115px;">Giới tính</th>
            <th class="align-middle text-center" style="min-width: 170px;">CMND/CCCD</th>
            <th class="align-middle text-center" style="min-width: 150px;">Điện thoại</th>
            <th class="align-middle text-center" style="min-width: 250px;">Địa chỉ</th>
            <th class="align-middle text-center" style="min-width: 150px;">Tình trạng</th>
            <th class="align-middle text-center" style="min-width: 175px;">Trạng thái</th>
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

<div class="modal modal-right fade" id="modalThemNhanVien" tabindex="-1" aria-labelledby="modalThemNhanVienLabel">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalThemNhanVienLabel">Tìm nhân khẩu</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= Route::_('index.php?option=com_dichvunhaycam&task=dichvunhaycam.timkiem_nhankhau') ?>" id="frmmodalThemNhanVien" name="frmmodalThemNhanVien" method="post">
          <div class="d-flex flex-column">
            <div class="d-flex justify-content-between mb-3" style="gap:20px">
              <div class="input-thongtin" style="width: 100%">
                <strong>Họ và tên nhân khẩu</strong>
                <input type="text" name="modal_tennhankhau" class="form-control" placeholder="Nhập họ và tên nhân khẩu">
              </div>
              <div class="input-thongtin" style="width: 100%">
                <strong>CMND/CCCD</strong>
                <input type="text" name="modal_cccd" class="form-control" placeholder="Nhập số CMND/CCCD">
              </div>
            </div>
            <div class="d-flex justify-content-between mb-3" style="gap:20px">
              <div class="input-thongtin" style="width: 100%">
                <strong>Phường xã</strong>
                <select id="modal_phuongxaid" name="modal_phuongxaid" class="custom-select" data-placeholder="Chọn xã/phường" style="width: 67%;">
                  <option value=""></option>
                  <?php foreach ($this->phuongxa as $px) { ?>
                    <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="input-thongtin" style="width: 100%">
                <strong>Thôn tổ</strong>
                <select id="modal_thontoid" name="modal_thontoid" class="custom-select" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="d-flex align-item-center justify-content-center ">
              <button type="submit" class="btn btn-primary btn_timkiemnhankhau">Tìm kiếm</button>
            </div>
          </div>
        </form>
        <h5 class="modal-title">Danh sách nhân khẩu</h5>
        <div style="overflow-x: auto; width: 100%;">
          <table class="table table-striped table-bordered table-hover" id="tblDanhSachNhanKhau" style="min-width: 900px;">
            <thead>
              <tr class="bg-primary text-white">
                <th class="align-middle text-center" style="min-width: 45px;"></th>
                <th class="align-middle text-center" style="min-width: 165px;">Họ tên</th>
                <th class="align-middle text-center" style="min-width: 100px;">Giới tính</th>
                <th class="align-middle text-center" style="min-width: 135px;">CMND/CCCD</th>
                <th class="align-middle text-center" style="min-width: 130px;">Điện thoại</th>
                <th class="align-middle text-center" style="min-width: 200px;">Địa chỉ</th>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
  const nhanviens = <?= json_encode($detaiCoSo->nhanvien ?? []) ?>;
  const phuongxa_id = <?= json_encode($detaiCoSo->phuongxa_id ?? 0) ?>;
  const thonto_id = <?= json_encode($detaiCoSo->thonto_id ?? 0) ?>;

  let $activeNhanVienRow = null;
  $(document).ready(function() {
    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi'
    });

    //khởi tạo select 2 của phường/xã, thôn/tổ, trạng thái, phường/xã và thôn/tổ bên trong modal
    $('#phuongxa_id, #thonto_id, #trangthai_id, #modal_phuongxaid, #modal_thontoid').select2({
      placeholder() {
        return $(this).data('placeholder');
      },
      allowClear: true,
      width: '100%'
    });

    $.validator.addMethod('select2', value => value !== '', 'Vui lòng chọn một giá trị');

    $('#phuongxa_id, #thonto_id, #ngaykhaosat, #trangthai_id').on('change', function() {
      $(this).valid(); // Gọi validate lại field này
    });

    $('#btn_quaylai').click(() =>
      window.location.href = '<?php echo Route::_('/index.php/component/dichvunhaycam/?view=dichvunhaycam&task=default'); ?>'
    );

    $('#btn_themnhanvien').click(() => {
      const $newRow = $(renderNhanVien());
      $('#tblDanhsach tbody').append($newRow);

      // Nếu checkbox trong dòng mới đang được check thì disable input tương ứng
      const $checkbox = $newRow.find('.lock-user');
      const isLocked = $checkbox.is(':checked');

      applyLockState($newRow, isLocked);
    });
    $('#tblDanhsach').on('click', '.btn-huy', function() {
      $(this).closest('tr').remove();
    });

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

    $(document).on('click', '[id^="btn_timnhankhau-"]', function() {
      // Ghi nhớ dòng đang click để sau này dùng lại
      $activeNhanVienRow = $(this).closest('tr');
    });

    //hành động chuyển trang khi đang tìm nhân khẩu
    $('#modalThemNhanVien').on('click', '#paginationContainer .page-link', function(e) {
      e.preventDefault();
      if ($(this).parent().hasClass('disabled')) return;
      const page = parseInt($(this).data('page'), 10);
      if (!page || isNaN(page)) return;

      timKiemNhanKhau(page);
    });

    //sự kiện khi chọn phường xã sẽ render thôn tổ theo phường xã
    $('#phuongxa_id').on('change', function() {
      const val = $(this).val();
      $('#thonto_id').html('<option value=""></option>').trigger('change');
      if (val) fetchKhuVuc(val);
    });

    $('#frmmodalThemNhanVien').submit(function(e) {
      e.preventDefault();
      timKiemNhanKhau(1);
    });

    // in nhân viên đã chọn ra bên ngoài modal
    $(document).on('click', '#btn_luu_nhankhau', function() {
      const $row = $(this).closest('tr'); // Dòng trong modal

      let tinhtrangcutru = '';
      if ($row.find('td:eq(6)').text().trim() === 'Thường trú') {
        tinhtrangcutru = '0';
      } else if ($row.find('td:eq(6)').text().trim() === 'Tạm trú') {
        tinhtrangcutru = '1';
      }

      const nhankhau = {
        id: $(this).val(),
        hoten: $row.find('td:eq(1)').text().trim(),
        gioitinh: $row.find('td:eq(2)').text().trim(),
        cccd: $row.find('td:eq(3)').text().trim(),
        dienthoai: $row.find('td:eq(4)').text().trim(),
        diachi: $row.find('td:eq(5)').text().trim(),
        tinhtrang: tinhtrangcutru
      };

      const $tbody = $('#tblDanhsach tbody');

      // Kiểm tra trùng ID (trừ dòng đang chọn)
      if ($tbody.find(`tr.input-row[data-id="${nhankhau.id}"]`).not($activeNhanVienRow).length > 0) {
        alert('Nhân khẩu này đã được thêm.');
        return;
      }

      let $targetRow;

      if ($activeNhanVienRow && $activeNhanVienRow.find('input[name="id_nhanvien[]"]').val()) {
        // Nếu dòng đã có ID → cập nhật dữ liệu
        $targetRow = $activeNhanVienRow;
      } else {
        // Nếu dòng chưa có ID → tìm dòng trống đầu tiên
        $targetRow = $('#tblDanhsach tbody tr.input-row').filter(function() {
          return $(this).find('input[name="id_nhanvien[]"]').val() === "";
        }).first();

        if ($targetRow.length === 0) {
          // Nếu không có dòng trống → tạo dòng mới
          $('#tblDanhsach tbody').append(renderNhanVien());
          $targetRow = $('#tblDanhsach tbody tr.input-row').last();
        }
      }

      // Gán dữ liệu mới vào dòng đích
      const newRow = $(renderNhanVien(nhankhau));
      $targetRow.replaceWith(newRow);

      // Khóa dòng sau khi thêm
      const $checkbox = newRow.find('input[type="checkbox"][class="lock-user"]');
      $checkbox.prop('checked', true).trigger('change');

      // Reset dòng đang thao tác
      $activeNhanVienRow = null;

      // Ẩn modal
      $('#modalThemNhanVien').modal('hide');
    });

    //xóa 1 hàng nhân viên
    $(document).on('click', '.btn-xoa-nv', function() {
      if (confirm('Bạn có chắc muốn xoá nhân khẩu này không?')) {
        $(this).closest('tr').remove();
      }
    });

    // khóa nhân viên(để không thể hiệu chỉnh được)
    $(document).on('change', 'input[type="checkbox"].lock-user', function() {
      const $row = $(this).closest('tr.input-row');
      const isLocked = $(this).is(':checked');
      applyLockState($row, isLocked);
    });

    //danh sách nhân viên được lấy từ detail
    nhanviens.forEach(nv => {
      const data = formatNhanVien(nv);
      const row = $(renderNhanVien(data));
      $('#tblDanhsach tbody').append(row);

      // ✅ Tự tích và gọi trigger khóa dòng
      const $checkbox = row.find('input[class="lock-user"]');
      $checkbox.prop('checked', true).trigger('change');
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
        trangthai_id: {
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
        trangthai_id: 'Vui lòng chọn trạng thái'
      },
      errorPlacement(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('.select2-container'));
        } else if (element.closest('.input-group').length) {
          error.insertAfter(element.closest('.input-group'));
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

  function applyLockState($row, isLocked) {
    $row.find('input[type="text"], textarea').prop('readonly', isLocked);

    $row.find('select[name="gioitinh_nhanvien[]"], select[name="tinhtrang_cutru_nhanvien[]"]').each(function() {
      if (isLocked) {
        $(this).attr('data-readonly', 'true').css({
          'pointer-events': 'none',
          'background-color': '#e9ecef'
        });
      } else {
        $(this).removeAttr('data-readonly').css({
          'pointer-events': '',
          'background-color': ''
        });
      }
    });

    $row.find('.btn_timnhankhau').prop('disabled', !isLocked);
    $row.find('.btn-xoa-nv').prop('disabled', false); // vẫn cho phép xóa
  }

  //lấy thôn tổ theo cha_id(phường/xã) và gán váo element
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

  //tìm kiếm nhân viên
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
              <td class="text-center">
                <button type="button" class="btn btn_luu_nhankhau" id="btn_luu_nhankhau" value="${item.id}" data-title="Thêm nhân viên">
                  <i class="fas fa-plus"></i>
                </button>
              </td>
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

  // format data phù hợp để render nhân viên khi đang trong hiệu chỉnh
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

  function renderNhanVien(data = {}) {
    return `
    <tr class="input-row" data-id="${data.id || ''}">
      <td class="text-center align-middle" >
        <input type="checkbox"  class="lock-user"style="width: 20px;height: 20px" >
      </td>
      <td class="input-name">
        <div class="input-group">
          <button type="button" id="btn_timnhankhau-${data.id}" data-bs-toggle="modal" data-bs-target="#modalThemNhanVien" data-iduser="${data.id}" class="btn btn-primary btn_timnhankhau">
            <i class="fas fa-search"></i>
          </button>
          <input type="text" class="form-control" name="hoten_nhanvien[]" value="${data.hoten || ''}">  
          <input type="hidden" name="id_nhanvien[]" value="${data.id || ''}">
        </div>
      </td>
      <td>
        <select class="form-control" name="gioitinh_nhanvien[]">
          <option value="">Chọn</option>
          <option value="1" ${data.gioitinh === 'Nam' ? 'selected' : ''}>Nam</option>
          <option value="2" ${data.gioitinh === 'Nữ' ? 'selected' : ''}>Nữ</option>
          <option value="3" ${data.gioitinh === 'Khác' ? 'selected' : ''}>Khác</option>
        </select>
      </td>
      <td><input type="text" class="form-control" name="cccd_nhanvien[]" value="${data.cccd || ''}"></td>
      <td><input type="text" class="form-control" name="dienthoai_nhanvien[]" value="${data.dienthoai || ''}"></td>
      <td><textarea class="form-control" rows="1" name="diachi_nhanvien[]">${data.diachi || ''}</textarea></td>
      <td>
        <select class="form-control" name="tinhtrang_cutru_nhanvien[]">
          <option value="">Chọn</option>
          <option value="0" ${data.tinhtrang === '0' ? 'selected' : ''}>Thường trú</option>
          <option value="1" ${data.tinhtrang === '1' ? 'selected' : ''}>Tạm trú</option>
        </select>
      </td>
      <td>
        <select class="form-control" name="trangthai_nhanvien[]">
          <option value="1" ${data.trangthai === '1' ? 'selected' : ''}>Đang làm việc</option>
          <option value="0" ${data.trangthai === '0' ? 'selected' : ''}>Nghỉ việc</option>
        </select>
      </td>
      <td class="text-center align-middle">
        <button type="button" class="btn btn-danger btn-sm btn-xoa-nv"><i class="fas fa-times"></i></button>
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
    border-radius: 0px 4px 4px 0px;
  }

  .input-name button {
    border-radius: 4px 0px 0px 4px;
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
    width: 357px;
  }

  .button {
    padding-bottom: 20px;
  }

  .input-group-text {
    border-radius: 0px 4px 4px 0px;
  }

  .modal.modal-right .modal-dialog {
    position: fixed;
    right: 0;
    top: 0;
    height: 100%;
  }

  .modal.modal-right .modal-content {
    height: 100%;
    border-radius: 5px 0px 0px 5px;
  }

  .table-bordered td,
  .table-bordered th {
    border-color: #c9c9c9;
  }

  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 1000px;
    }
  }

  #tblDanhSachNhanKhau.table td,
  #tblDanhSachNhanKhau.table th {
    padding: 8px;
  }

  .btn_luu_nhankhau {
    position: relative;
    cursor: pointer;
  }

  .btn_luu_nhankhau:hover {
    color: #007bff;
  }

  .btn_luu_nhankhau::after {
    content: attr(data-title);
    position: absolute;
    top: 33px;
    left: 10%;
    transform: translateX(-10%);
    background-color: #999;
    color: #000;
    padding: 6px 10px;
    font-size: 14px;
    white-space: nowrap;
    border-radius: 6px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    /* border: 1px solid #ccc; */
    z-index: 999;
  }

  .btn_luu_nhankhau::before {
    content: "";
    position: absolute;
    top: 18px;
    left: 50%;
    transform: translateX(-50%);
    border-width: 8px;
    border-style: solid;
    border-color: transparent transparent #999 transparent;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease;
    z-index: 998;
  }

  .btn_luu_nhankhau:hover::after,
  .btn_luu_nhankhau:hover::before {
    opacity: 1;
    visibility: visible;
  }


  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>