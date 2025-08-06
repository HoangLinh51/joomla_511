<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detailViaHe = $this->item;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formViaHe" name="formViaHe" method="post" action="<?php echo Route::_('index.php?option=com_dcxddt&controller=viahe&task=save_viahe'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
      <h2 class="text-primary mb-3">
        <?php echo ((int)$detailViaHe['thongtin']['thongtinviahe_id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin cấp phép sử dụng tạm thời một phần vỉa hè
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </span>
    </div>

    <input type="hidden" name="id" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['thongtinviahe_id']); ?>">
    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
      <h5 style="margin: 0">Thông tin khách hàng</h5>
    </div>
    <div class="row g-3 mb-4">
      <div class="col-md-8 mb-2">
        <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
        <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['hoten']); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="sodienthoai" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
        <input id="sodienthoai" type="text" name="sodienthoai" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['dienthoai']); ?>" placeholder="Nhập số điện thoại">
      </div>
      <div class="col-md-8 mb-2">
        <label for="diachi" class="form-label fw-bold">Địa chỉ thường trú</label>
        <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ thường trú" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['diachithuongtru']); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="namsinh" class="form-label fw-bold">Năm sinh</label>
        <div class="input-group">
          <input type="text" id="select_namsinh" name="select_namsinh" class="form-control namsinh" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['ngaysinh']); ?>">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd" class="form-label fw-bold">CCCD/CMND</label>
        <input id="cccd" type="text" name="cccd" class="form-control" placeholder="Nhập CCCD/CMND" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['cccd']); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd_ngaycap" class="form-label fw-bold">Ngày cấp</label>
        <div class="input-group">
          <input type="text" id="cccd_ngaycap" name="cccd_ngaycap" class="form-control namsinh" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['ngaycap_cccd']); ?>">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd_noicap" class="form-label fw-bold">Nơi cấp</label>
        <input id="cccd_noicap" type="text" name="cccd_noicap" class="form-control" placeholder="Nhập nơi cấp" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['noicap_cccd']); ?>">
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin cấp phép</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-12 mb-2">
        <label for="diachiviahe" class="form-label fw-bold">Địa chỉ vỉa hè <span class="text-danger">*</span></label>
        <input id="diachiviahe" type="text" name="diachiviahe" class="form-control" placeholder="Nhập địa chỉ vỉa hè" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['diachi']); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="dientichtamthoi" class="form-label fw-bold">Diện tích sử dụng tạm thời</label>
        <input id="dientichtamthoi" type="text" name="dientichtamthoi" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['dientichtamthoi']); ?>" placeholder="Nhập diện tích">
      </div>
      <div class="col-md-4 mb-2">
        <label for="chieudai" class="form-label fw-bold">Chiều dài dọc vỉa hè</label>
        <input id="chieudai" type="text" name="chieudai" class="form-control" placeholder="Nhập chiều dài dọc vỉa hè" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['chieudai']); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="chieurong" class="form-label fw-bold">Chiều rộng</label>
        <input id="chieurong" type="text" name="chieurong" class="form-control" placeholder="Nhập chiều rộng" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['chieurong']); ?>">
      </div>
      <div class="col-md-12 mb-2">
        <label for="mucdichsudung" class="form-label fw-bold">Mục đích sử dụng</label>
        <input id="mucdichsudung" type="text" name="mucdichsudung" class="form-control" placeholder="Nhập mục đích sử dụng" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['mucdichsudung']); ?>">
      </div>
      <div class="col-md-6 mb-2">
        <label for="mucdichsudung" class="form-label fw-bold">Văn bản đính kèm</label>
        <?= Core::inputAttachmentOneFile('uploadImageHopDong', null, 1, date('Y'), -1); ?>
        <!-- Đây là nơi ảnh sẽ hiển thị sau khi upload -->
        <div id="imagePreview" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
      </div>
      <div class="col-md-6 mb-2 vanbancu">
        <?php if (!empty($detailViaHe['filedinhkem'])): ?>
          <label for="mucdichsudung" class="form-label fw-bold">Tệp đính kèm</label>
          <?php foreach ($detailViaHe['filedinhkem'] as $item): ?>
            <div class="d-flex align-items-center justify-content-between" id="file-<?= $item['id'] ?>">
              <span class="d-block mb-1">
                <?php if ($item['mime'] === 'application/pdf'): ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/index.php?option=com_dungchung&view=hdsd&format=raw&task=viewpdf&file=<?= $item['code'] ?>&folder=<?= $item['folder'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php elseif (in_array($item['mime'], ['image/jpeg', 'image/png'])): ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/uploader/get_image.php/<?= $item['folder'] ?>?code=<?= $item['code'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php else: ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/index.php?option=com_core&controller=attachment&format=raw&task=download&year=<?= date('Y') ?>&code=<?= $item['code'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php endif; ?>
              </span>
              <span id="xoatepdinhkem" class="btn btn-small" data-idviahe="<?php echo htmlspecialchars($detailViaHe['thongtin']['thongtinviahe_id']); ?>" data-idvanban="<?php echo htmlspecialchars($item['id']); ?>">
                <i class="fa fa-trash"></i>
              </span>
              <input type="hidden" name="idFile-uploadImageHopDong[]" value="<?php echo $item['id'] ?>">
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
      <h5 class="">Thông tin hợp đồng</h5>
      <button type="button" data-bs-toggle="modal" data-bs-target="#modalThemHopDong" class="btn btn-primary">Thêm</button>
    </div>
    <div class="row g-3 mb-4" style="border: 1px solid #d9d9d9; border-radius: 4px;">
      <table id="table-thannhan" class="table table-striped table-bordered" style="table-layout: fixed; width: 100%; margin: 0px">
        <thead class="table-primary text-white">
          <tr>
            <th class="text-center align-middle">STT</th>
            <th class="text-center align-middle">Số giấy phép</th>
            <th class="text-center align-middle">Số lần</th>
            <th class="text-center align-middle">Ngày ký hợp đồng</th>
            <th class="text-center align-middle">Ngày hết hạn</th>
            <th class="text-center align-middle">Thời gian</th>
            <th class="text-center align-middle">Số tiền</th>
            <th class="text-center align-middle">Ghi chú</th>
            <th class="text-center align-middle"></th>
          </tr>
        </thead>
        <tbody class="dsHopDong">
        </tbody>
      </table>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>


<div class="modal modal-right fade" id="modalThemHopDong" tabindex="-1" aria-labelledby="modalThemHopDongLabel">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mb-0 text-primary" data-editTitle="Thêm mới thông tin hợp đồng">
          <span class="title-edit"></span> thông tin hợp đồng
        </h4>
      </div>
      <div class="modal-body">
        <form id="formThongtinHopDong" name="formThongtinHopDong" method="post" action="index.php?option=com_vhytgd&controller=doanhoi&task=save_doanhoi">
          <div class="row g-3 mb-4">
            <div class="col-md-4 mb-2">
              <label for="modal_sogiayphep" class="form-label fw-bold">Số giấy phép</label>
              <input id="modal_sogiayphep" type="text" name="modal_sogiayphep" class="form-control" placeholder="Nhập số giấy phép">
            </div>
            <div class="col-md-4 mb-2">
              <label for="modal_solan" class="form-label fw-bold">Số lần</label>
              <input id="modal_solan" type="text" name="modal_solan" class="form-control" placeholder="Nhập số lần">
            </div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4 mb-2">
              <label for="modal_ngayky" class="form-label fw-bold">Ngày ký hợp đồng</label>
              <div class="input-group">
                <input type="text" id="modal_ngayky" name="modal_ngayky" class="form-control" placeholder="dd/mm/yyyy">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              </div>
            </div>
            <div class="col-md-4 mb-2">
              <label for="modal_ngayhethan" class="form-label fw-bold">Ngày hết hạn hợp đồng</label>
              <div class="input-group">
                <input type="text" id="modal_ngayhethan" name="modal_ngayhethan" class="form-control" placeholder="dd/mm/yyyy">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              </div>
            </div>
            <div class="col-md-4 mb-2">
              <label for="modal_thoigian" class="form-label fw-bold">Thời gian</label>
              <input id="modal_thoigian" type="text" name="modal_thoigian" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-2">
              <label for="modal_sotien" class="form-label fw-bold">Số tiền </label>
              <input id="modal_sotien" type="text" name="modal_sotien" class="form-control" placeholder="Nhập số tiền">
            </div>
            <div class="col-md-8 mb-2">
              <label for="modal_ghichu" class="form-label fw-bold">Ghi chú</label>
              <input id="modal_ghichu" type="text" name="modal_ghichu" class="form-control" placeholder="Nhập ghi chú">
            </div>
          </div>
          <input type="hidden" name="id" value="">
          <?php echo HTMLHelper::_('form.token'); ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">X Đóng</button>
        <button type="submit" id="btn_luuhopdong" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </div>
    </div>
  </div>
</div>

<script>
  let detailViaHe = <?php echo json_encode($detailViaHe ?? []); ?>;
  let timeout = null;
  let params = new URLSearchParams(window.location.search);
  let task = params.get('task');
  let isEditHopDong = false;
  let isGiaHan = false;
  let giaHanParentRowIndex = null;
  $(document).ready(function() {
    renderDanhSachHopDong()
    $('#btn_quaylai').click(() => {
      window.location.href = '<?php echo Route::_('/index.php/component/dcxddt/?view=viahe&task=default'); ?>';
    });
    $('button[data-bs-target="#modalThemHopDong"]').on('click', function() {
      const $form = $('#formThongtinHopDong');
      $form[0].reset();
      $form.find('#modal_sogiayphep').prop('readonly', false);
      $form.find('input[type="hidden"]').val('');
    });
    // Khởi tạo datepicker cho các trường ngày tháng
    const datepickerFields = [
      '#select_namsinh',
      '#cccd_ngaycap',
      '#modal_ngayky',
      '#modal_ngayhethan',
    ];

    $(datepickerFields.join(',')).datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy'
    });

    let hopDongIndex = 0;
    let isEditHopDong = false

    // Hàm convert định dạng ngày dd/mm/yyyy → Date
    function convertToDate(str) {
      const [day, month, year] = str.split('/');
      return new Date(`${year}-${month}-${day}`);
    }

    // Nút lưu hợp đồng
    $('#btn_luuhopdong').on('click', function(e) {
      e.preventDefault();

      const sogiayphep = $('#modal_sogiayphep').val().trim();
      const solan = $('#modal_solan').val().trim();
      const ngayKyStr = $('#modal_ngayky').val().trim();
      const ngayHetHanStr = $('#modal_ngayhethan').val().trim();
      const thoigian = $('#modal_thoigian').val().trim();

      if (!sogiayphep || !solan || !ngayKyStr || !ngayHetHanStr || !thoigian) {
        showToast('Vui lòng nhập đầy đủ: số giấy phép, số lần, ngày ký, ngày hết hạn', false);
        return;
      }

      const ngayKy = convertToDate(ngayKyStr);
      const ngayHetHan = convertToDate(ngayHetHanStr);
      if (ngayKy > ngayHetHan) {
        showToast('Ngày ký không được lớn hơn ngày hết hạn!', false);
        return;
      }

      const sotien = $('#modal_sotien').val().trim();
      const ghichu = $('#modal_ghichu').val().trim();
      const editIndex = $('#formThongtinHopDong').attr('data-edit-index');

      if (isEditHopDong === true) {
        const $row = $(`.dsHopDong tr[data-row="${editIndex}"]`);
        $row.find('td:eq(1) input').val(sogiayphep);
        $row.find('td:eq(2) input').val(solan);
        $row.find('td:eq(3) input').val(ngayKyStr);
        $row.find('td:eq(4) input').val(ngayHetHanStr);
        $row.find('td:eq(5) input').val(thoigian);
        $row.find('td:eq(6) input').val(sotien);
        $row.find('td:eq(7) input').val(ghichu);
        isEditHopDong = false;
        showToast('Cập nhật hợp đồng thành công!');
      } else {
        // === THÊM MỚI ===

        // Tính STT mới
        let rowSTT = '';
        if (isGiaHan && giaHanParentRowIndex) {
          const parentSTT = $(`.dsHopDong tr[data-row="${giaHanParentRowIndex}"]`).find('td:first').text().trim();
          const childCount = $(`.dsHopDong tr`).filter(function() {
            return $(this).find('td:first').text().startsWith(parentSTT + '.');
          }).length;
          rowSTT = `${parentSTT}.${childCount + 1}`;
        } else {
          let maxSTT = 0;
          $('.dsHopDong tr').each(function() {
            const sttText = $(this).find('td:first').text().trim();
            if (/^\d+$/.test(sttText)) {
              const stt = parseInt(sttText);
              if (stt > maxSTT) maxSTT = stt;
            }
          });
          rowSTT = maxSTT + 1;
        }

        // Nếu là dòng gốc (không có dấu '.'), hiển thị nút gia hạn
        let giaHanBtn = '';
        if (!rowSTT.toString().includes('.')) {
          giaHanBtn = `
        <span class="btn btn-sm btn_giahan" style="font-size:18px;padding:5px 7px; cursor: pointer; border-right: 2px solid #9b9b9b; border-radius: 0px" data-title="Gia hạn">
          <i class="fas fa-plus"></i>
        </span>`;
        }

        const rowCount = $('.dsHopDong tr').length + 1;
        const newRow = `
        <tr data-row="${rowCount}">
          <td class="text-center">${rowSTT}</td>
          <input type="hidden" name="id_hopdong[]" value="">
          <td class="text-center"><input type="text" class="form-control" name="sogiayphep[]" value="${sogiayphep}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="solan[]" value="${solan}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="ngayKyStr[]" value="${ngayKyStr}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="ngayHetHanStr[]" value="${ngayHetHanStr}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="thoigian[]" value="${thoigian}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="sotien[]" value="${sotien}" readonly></td>
          <td class="text-center"><input type="text" class="form-control" name="ghichu[]" value="${ghichu}" readonly></td>
          <td class="text-center">
            ${giaHanBtn}
            <span class="btn btn-sm btn_edithopdong" style="font-size:18px;padding:5px 7px; cursor: pointer; border-right: 2px solid #9b9b9b; border-radius: 0px" data-title="Hiệu chỉnh">
                <i class="fas fa-pencil-alt"></i>
            </span>
            <span class="btn btn-sm btn_xoahopdong" style="font-size:18px;padding:5px; cursor: pointer;" data-idhopdong="0" data-title="Xóa">
                <i class="fas fa-trash-alt"></i>
            </span>
          </td>
        </tr>`;

        $('.dsHopDong').append(newRow);
        isGiaHan = false;
        giaHanParentRowIndex = null;
        showToast('Thêm hợp đồng thành công!');
      }

      // Reset modal
      $('#formThongtinHopDong')[0].reset();
      $('#modal_thoigian').val('');
      $('#formThongtinHopDong').removeAttr('data-edit-index');

      const modal = $('#formThongtinHopDong').closest('.modal');
      const modalInstance = bootstrap.Modal.getInstance(modal[0]);
      if (modalInstance) modalInstance.hide();
    });

    // Xóa dòng
    $('#table-thannhan').on('click', '.btn_xoahopdong', function() {
      const $row = $(this).closest('tr');
      const idhopdong = $(this).data('idhopdong');
      console.log(idhopdong)

      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span style="font-size:18px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
        buttons: {
          confirm: {
            label: '<i class="icon-ok"></i> Đồng ý',
            className: 'btn-success'
          },
          cancel: {
            label: '<i class="icon-remove"></i> Không',
            className: 'btn-danger'
          }
        },
        callback: async function(result) {
          if (result) {
            if (idhopdong && idhopdong > 0) {
              try {
                const response = await fetch(`index.php?option=com_dcxddt&controller=viahe&task=xoa_hopdong`, {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                    idhopdong
                  })
                });

                const data = await response.json();
                showToast(data.message || 'Xóa hợp đồng thành công', data.success !== false);

                $row.remove();
              } catch (error) {
                console.error('Error deleting:', error);
                showToast(error, data.success)
              }
            } else {
              $row.remove();

              // Cập nhật lại STT và data-row
              $('.dsHopDong tr').each(function(index) {
                $(this).attr('data-row', index + 1);
                $(this).find('td:first').text(index + 1);
              });

              showToast('Xóa hợp đồng thành công!');
            }
          } else {
            return
          }
        }
      });
    });

    $('body').on('click', '#xoatepdinhkem', function() {
      const viahe_id = $(this).data('idviahe');
      const filedinhkem_id = $(this).data('idvanban');
      const fileElementId = `#file-${filedinhkem_id}`;
      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span style="font-size:18px;">Bạn có chắc chắn muốn xóa tệp đính kèm này?</span>',
        buttons: {
          confirm: {
            label: '<i class="icon-ok"></i> Đồng ý',
            className: 'btn-success'
          },
          cancel: {
            label: '<i class="icon-remove"></i> Không',
            className: 'btn-danger'
          }
        },
        callback: async function(result) {
          if (!result) return;

          try {
            const response = await fetch(`index.php?option=com_dcxddt&controller=viahe&task=xoa_tepdinhkem`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                viahe_id,
                filedinhkem_id
              })
            });

            const data = await response.json();
            showToast(data.message || 'Xóa file thành công', data.success !== false);

            if (data.success !== false) {
              $(fileElementId).remove();
            }
          } catch (error) {
            console.error('Lỗi khi xóa:', error);
            showToast('Đã xảy ra lỗi khi xóa dữ liệu', false);
          }
        }
      });
    });

    // Sửa dòng (hiển thị lại vào form)
    $('#table-thannhan').on('click', '.btn_edithopdong', function() {
      let $row = $(this).closest('tr');
      let index = $row.data('row');
      isEditHopDong = true
      $('#formThongtinHopDong #modal_sogiayphep').prop('readonly', true);

      // Lấy giá trị từ input trong từng ô
      $('#modal_sogiayphep').val($row.find('td:eq(1) input').val());
      $('#modal_solan').val($row.find('td:eq(2) input').val());
      $('#modal_ngayky').val($row.find('td:eq(3) input').val());
      $('#modal_ngayhethan').val($row.find('td:eq(4) input').val());
      $('#modal_thoigian').val($row.find('td:eq(5) input').val());
      $('#modal_sotien').val($row.find('td:eq(6) input').val());
      $('#modal_ghichu').val($row.find('td:eq(7) input').val());

      // Lưu index nếu muốn xử lý update (bạn có thể dùng để biết dòng nào đang được chỉnh sửa)
      $('#formThongtinHopDong').attr('data-edit-index', index);

      // Mở modal
      let modal = $('#formThongtinHopDong').closest('.modal');
      let modalInstance = bootstrap.Modal.getOrCreateInstance(modal[0]);
      modalInstance.show();
    });

    function laysolangiahan(sogiayphep) {
      let max = 0;
      $('.dsHopDong tr').each(function() {
        const currentSP = $(this).find('td:eq(1) input').val();
        const currentSolan = parseInt($(this).find('td:eq(2) input').val());
        if (currentSP === sogiayphep && !isNaN(currentSolan)) {
          if (currentSolan > max) max = currentSolan;
        }
      });
      return max;
    }

    $('#table-thannhan').on('click', '.btn_giahan', function() {
      const $row = $(this).closest('tr');
      const rowIndex = $row.data('row');
      const sogiayphep = $row.find('td:eq(1) input').val();

      // Set lại giá trị vào modal
      $('#modal_sogiayphep').val(sogiayphep).prop('readonly', true);

      // Tính số lần mới bằng cách lấy số lớn nhất + 1
      const newSolan = laysolangiahan(sogiayphep) + 1;
      $('#modal_solan').val(newSolan);

      // Reset các trường còn lại
      $('#modal_ngayky').val('');
      $('#modal_ngayhethan').val('');
      $('#modal_thoigian').val('');
      $('#modal_sotien').val('');
      $('#modal_ghichu').val('');

      // Reset trạng thái modal
      $('#formThongtinHopDong').removeAttr('data-edit-index');
      isEditHopDong = false;
      isGiaHan = true;
      giaHanParentRowIndex = rowIndex;

      // Hiển thị modal
      const modal = $('#formThongtinHopDong').closest('.modal');
      const modalInstance = bootstrap.Modal.getOrCreateInstance(modal[0]);
      modalInstance.show();
    });

    function tinhSoNgay() {
      const ngayKyStr = $('#modal_ngayky').val();
      const ngayHetHanStr = $('#modal_ngayhethan').val();

      if (!ngayKyStr || !ngayHetHanStr) {
        $('#modal_thoigian').val('');
        return;
      }

      const ngayKy = convertToDate(ngayKyStr);
      const ngayHetHan = convertToDate(ngayHetHanStr);

      if (isNaN(ngayKy) || isNaN(ngayHetHan)) {
        $('#modal_thoigian').val('');
        return;
      }

      const timeDiff = ngayHetHan - ngayKy;
      const soNgay = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1; // tính cả ngày ký

      $('#modal_thoigian').val(soNgay > 0 ? `${soNgay} ngày` : 'Không hợp lệ');
    }

    // Gọi lại hàm mỗi khi thay đổi input
    $('#modal_ngayky, #modal_ngayhethan').on('change blur input', tinhSoNgay);

    // validate form
    $('#formViaHe').validate({
      ignore: [],
      rules: {
        hoten: {
          required: true
        },
        sodienthoai: {
          required: true
        },
        diachiviahe: {
          required: true
        },
      },
      messages: {
        hoten: 'Vui lòng nhập họ và tên',
        sodienthoai: 'Vui lòng nhập số điện thoại',
        diachiviahe: 'Vui lòng nhập số địa chỉ vỉa hè',
      },
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      }
    });

    // submit form chính
    $('#formViaHe').on('submit', function(e) {
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
            setTimeout(() => location.href = "/index.php/component/dcxddt/?view=viahe&task=default", 500);
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

  function renderDanhSachHopDong() {
    if (!detailViaHe || !detailViaHe.giayphep) return;

    let parentIndex = 1;

    Object.entries(detailViaHe.giayphep).forEach(([sogiayphep, danhSachHopDong]) => {
      let childCount = 0;

      danhSachHopDong.forEach((hopdong, idx) => {
        let rowIndex;
        if (idx === 0) {
          // Hợp đồng gốc
          rowIndex = parentIndex;
        } else {
          // Các hợp đồng gia hạn
          childCount++;
          rowIndex = `${parentIndex}.${childCount}`;
        }

        // Nếu là dòng gốc, hiển thị nút gia hạn
        let giaHanBtn = '';
        if (idx === 0) {
          giaHanBtn = `
          <span class="btn btn-sm btn_giahan" style="font-size:18px;padding:5px 7px; cursor: pointer; border-right: 2px solid #9b9b9b; border-radius: 0px" data-title="Gia hạn">
            <i class="fas fa-plus"></i>
          </span>`;
        }

        const newRow = `
        <tr data-row="${rowIndex}">
          <td class="text-center">${rowIndex}</td>
          <input type="hidden" name="id_hopdong[]" value="${hopdong.id_hopdong}">
          <td class="text-center">
            <input type="text" class="form-control" name="sogiayphep[]" value="${sogiayphep}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="solan[]" value="${hopdong.solan ?? (idx + 1)}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="ngayKyStr[]" value="${hopdong.ngayky}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="ngayHetHanStr[]" value="${hopdong.ngayhethan}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="thoigian[]" value="${tinhSoNgayTuChuoi(hopdong.ngayky, hopdong.ngayhethan)}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="sotien[]" value="${hopdong.sotien}" readonly>
          </td>
          <td class="text-center">
            <input type="text" class="form-control" name="ghichu[]" value="${hopdong.ghichu}" readonly>
          </td>
          <td class="text-center">
            ${giaHanBtn}
            <span class="btn btn-sm btn_edithopdong" style="font-size:18px;padding:5px 7px; cursor: pointer; border-right: 2px solid #9b9b9b; border-radius: 0px" data-title="Hiệu chỉnh">
              <i class="fas fa-pencil-alt"></i>
            </span>
            <span class="btn btn-sm btn_xoahopdong" style="font-size:18px;padding:5px; cursor: pointer;" data-idhopdong="0" data-title="Xóa">
                <i class="fas fa-trash-alt"></i>
            </span>
          </td>
        </tr>
      `;
        $('.dsHopDong').append(newRow);
      });
      parentIndex++;
    });
  }

  function tinhSoNgayTuChuoi(ngay1, ngay2) {
    const [d1, m1, y1] = ngay1.split('/');
    const [d2, m2, y2] = ngay2.split('/');
    const start = new Date(`${y1}-${m1}-${d1}`);
    const end = new Date(`${y2}-${m2}-${d2}`);
    const diff = (end - start) / (1000 * 60 * 60 * 24) + 1;
    return diff > 0 ? `${diff} ngày` : '';
  }
</script>

<style>
  .card-body {
    padding: 2.5rem;
    font-size: 15px;
  }

  .modal.modal-right .modal-dialog {
    position: fixed;
    right: -100%;
    top: 0;
    transition: right 0.6s ease-in-out;
  }

  .modal.modal-right.show .modal-dialog {
    right: 0;
  }

  .modal-right .modal-content {
    height: 100%;
    border-radius: 5px 0px 0px 5px;
  }

  @media (min-width: 992px) {

    .modal-lg {
      max-width: 1000px;
    }
  }

  .input-group-text {
    border-radius: 0px 4px 4px 0px;
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
    color: #fff
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }

  span.btn_giahan,
  span.btn_edithopdong,
  span.btn_xoahopdong {
    font-size: 18px;
    padding: 10px;
    cursor: pointer;
    position: relative;
    transition: color 0.3s;
  }

  span.btn_giahan,
  span.btn_edithopdong,
  span.btn_xoahopdong {
    cursor: pointer;
    pointer-events: auto;
    color: #999;
    padding: 10px;
  }

  .btn_giahan:hover i,
  .btn_edithopdong:hover i,
  .btn_xoahopdong:hover i {
    color: #007b8bb8;
  }

  .btn_giahan::after,
  .btn_edithopdong::after,
  .btn_xoahopdong::after {
    content: attr(data-title);
    position: absolute;
    bottom: 72%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(79, 89, 102, .08);
    color: #000000;
    padding: 6px 10px;
    font-size: 14px;
    white-space: nowrap;
    border-radius: 6px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    border: 1px solid #ccc;
  }

  .btn_giahan:hover::after,
  .btn_edithopdong:hover::after,
  .btn_xoahopdong:hover::after {
    opacity: 1;
    visibility: visible;
  }
</style>