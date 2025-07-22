<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$item = $this->item;

// Default empty object if $item is not set
$item = $item ?? (object)[
  'id' => 0,
  'nhankhau_id' => 0,
  'n_hoten' => '',
  'n_cccd' => '',
  'n_dienthoai' => '',
  'n_namsinh' => '',
  'n_gioitinh_id' => 0,
  'n_dantoc_id' => 0,
  'n_phuongxa_id' => 0,
  'n_thonto_id' => 0,
  'n_diachi' => '',
  'makh' => '',
  'vayvon_id' => 0,
  'thannhan' => []
];
// var_dump($item);
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="form" name="form" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=giadinhtreem&task=saveGiadinhtreem'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3" style="margin-bottom: 1rem !important;">
      <h2 class="text-primary mb-3" style="padding: 10px 10px 10px 0px;">
        <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin gia đình trẻ em
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </span>
    </div>
    <input type="hidden" name="giadinh_id" value="<?php echo htmlspecialchars($item->giadinh_id ?? 0); ?>">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->id); ?>">
    <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($item->nhankhau_id); ?>">

    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
      <h5 style="margin: 0">Thông tin cá nhân</h5>
      <div class="d-flex align-items-center" style="gap:5px">
        <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo $item->nhankhau_id ? 'checked' : ''; ?>>
        <small>Chọn công dân từ danh sách nhân khẩu</small>
      </div>
    </div>
    <div id="select-container" style="display: <?php echo $item->nhankhau_id ? 'block' : 'none'; ?>;" class="mb-3">
      <label for="select_top" class="form-label fw-bold">Tìm kiếm công dân</label>
      <select id="select_top" name="select_top" class="custom-select">
        <option value="">Chọn công dân</option>
        <?php if (!empty($this->danhsach_thanhvien) && is_array($this->danhsach_thanhvien)) { ?>
          <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
            <option value="<?php echo htmlspecialchars($tv['id']); ?>" <?php echo $item->nhankhau_id == $tv['id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($tv['hoten']); ?>
            </option>
          <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="row g-3 mb-4">
      <div class="col-md-4 mb-2">
        <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
        <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($item->n_hoten); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_gioitinh_id" class="form-label fw-bold">Giới tính</label>
        <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="<?php echo htmlspecialchars($item->n_gioitinh_id); ?>">
        <select id="select_gioitinh_id" name="select_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
          <option value=""></option>
          <?php foreach ($this->gioitinh as $gt) { ?>
            <option value="<?php echo htmlspecialchars($gt['id']); ?>" <?php echo $item->n_gioitinh_id == $gt['id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($gt['tengioitinh']); ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label for="cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
        <input id="cccd" type="text" name="cccd" class="form-control" value="<?php echo htmlspecialchars($item->n_cccd); ?>" placeholder="Nhập CCCD/CMND">
      </div>
      <div class="col-md-4 mb-2">
        <label for="namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
        <input type="hidden" id="input_namsinh" name="input_namsinh" value="<?php echo htmlspecialchars($item->n_namsinh); ?>">
        <div class="input-group">
          <input type="text" id="select_namsinh" name="select_namsinh" class="form-control namsinh" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($item->n_namsinh); ?>">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <label for="dienthoai" class="form-label fw-bold">Điện thoại</label>
        <input id="dienthoai" type="text" name="dienthoai" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($item->n_dienthoai); ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label for="select_dantoc_id" class="form-label fw-bold">Dân tộc</label>
        <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="<?php echo htmlspecialchars($item->n_dantoc_id); ?>">
        <select id="select_dantoc_id" name="select_dantoc_id" class="custom-select" data-placeholder="Chọn dân tộc">
          <option value=""></option>
          <?php foreach ($this->dantoc as $dt) { ?>
            <option value="<?php echo htmlspecialchars($dt['id']); ?>" <?php echo $item->n_dantoc_id == $dt['id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($dt['tendantoc']); ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label for="select_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
        <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="<?php echo htmlspecialchars($item->n_phuongxa_id); ?>">
        <select id="select_phuongxa_id" name="select_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
          <option value=""></option>
          <?php if (is_array($this->phuongxa)) { ?>
            <?php foreach ($this->phuongxa as $px) { ?>
              <option value="<?php echo htmlspecialchars($px['id']); ?>" <?php echo $item->n_phuongxa_id == $px['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
              </option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="select_thonto_id" class="form-label fw-bold">Thôn tổ</label>
        <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="<?php echo htmlspecialchars($item->n_thonto_id); ?>">
        <select id="select_thonto_id" name="select_thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
          <option value=""></option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
        <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($item->n_diachi); ?>">
      </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin khác</h5>
    <div class="row g-3 mb-4">
      <div class="col-md-4 mb-2">
        <label for="mahogd" class="form-label fw-bold">Mã hộ gia đình</label>
        <div class="input-group">
          <input type="text" id="mahogd" name="mahogd" class="form-control" placeholder="Nhập mã hộ gia đình" value="<?php echo htmlspecialchars($item->makh); ?>">
        </div>
      </div>
    </div>


    <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
      <h5 class="">Thông tin nhân thân</h5>
      <button type="button" class="btn btn-success btn-themnhanthan">Thêm nhân thân</button>
    </div>
    <div class="row g-3 mb-4" style="height: 200px; overflow-y: auto; border: 1px solid #d9d9d9; border-radius: 4px;">
      <table id="table-thannhan" class="table table-striped table-bordered" style="table-layout: fixed; width: 100%; margin: 0px">
        <thead class="table-primary text-white">
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
    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>
<!-- Modal thông tin hưởng bảo trợ -->
<div class="modal fade" id="modalTroCap" tabindex="-1" role="dialog" aria-labelledby="modalTroCapLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTroCapLabel">Thêm thông vay vốn</h5>
      </div>
      <div class="modal-body">
        <form id="frmModalTroCap">
          <div id="trocap_fields">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Số món vay</label>
                  <input type="text" id="modal_somonvay" name="modal_somonvay" class="form-control" placeholder="Nhập sổ món vay">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nguồn vốn<span class="text-danger">*</span></label>
                  <select id="modal_nguonvon" name="modal_nguonvon" class="custom-select" data-placeholder="Chọn nguồn vốn" required>
                    <option value=""></option>
                    <?php if (is_array($this->vayvon) && count($this->vayvon) > 0) { ?>
                      <?php foreach ($this->vayvon as $ht) { ?>
                        <option value="<?php echo $ht['id']; ?>" data-text="<?php echo htmlspecialchars($ht['tennguonvon']); ?>">
                          <?php echo htmlspecialchars($ht['tennguonvon']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu trạng thái</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_nguonvon"></label>
                </div>
              </div>
              <div class="col-md-6" id="container_tyle">
                <div class="mb-3">
                  <label class="form-label">Chương trình<span class="text-danger">*</span></label>
                  <select id="modal_chuongtrinh" name="modal_chuongtrinh" class="custom-select" data-placeholder="Chọn loại hỗ trợ" required>
                    <option value=""></option>
                    <?php if (is_array($this->chuongtrinh) && count($this->chuongtrinh) > 0) { ?>
                      <?php foreach ($this->chuongtrinh as $ht) { ?>
                        <option value="<?php echo $ht['id']; ?>" data-text="<?php echo htmlspecialchars($ht['tenchuongtrinhvay']); ?>">
                          <?php echo htmlspecialchars($ht['tenchuongtrinhvay']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu trạng thái</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_chuongtrinh"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Lãi suất</label>
                  <input type="text" id="modal_laisuat" name="modal_laisuat" class="form-control" placeholder="Nhập lãi suất">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Giải ngân<span class="text-danger">*</span></label>
                  <input type="text" id="modal_giaingan" name="modal_giaingan" class="form-control" placeholder="Nhập giải ngân">
                  <label class="error_modal" for="modal_giaingan"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tổng dư nợ<span class="text-danger">*</span></label>
                  <input type="text" id="modal_tongduno" name="modal_tongduno" class="form-control" placeholder="Nhập tổng dư nợ">
                  <label class="error_modal" for="modal_tongduno"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Ngày giải ngân</label>
                  <input type="text" id="modal_ngaygiaingan" name="modal_ngaygiaingan" class="form-control date-picker" placeholder="../../....">
                  <label class="error_modal" for="modal_ngaygiaingan"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Ngày đến hạn cuối</label>
                  <input type="text" id="modal_ngaydenhan" name="modal_ngaydenhan" class="form-control date-picker" placeholder="../../....">
                  <label class="error_modal" for="modal_ngaydenhan"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tình trạng<span class="text-danger">*</span></label>
                  <select id="modal_tinhtrang" name="modal_tinhtrang" class="custom-select" data-placeholder="Chọn tình trạng" required>
                    <option value=""></option>
                    <?php if (is_array($this->tinhtrang) && count($this->tinhtrang) > 0) { ?>
                      <?php foreach ($this->tinhtrang as $ht) { ?>
                        <option value="<?php echo $ht['id']; ?>" data-text="<?php echo htmlspecialchars($ht['tentrangthaivay']); ?>">
                          <?php echo htmlspecialchars($ht['tentrangthaivay']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu trạng thái</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_tinhtrang"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Thành viên tổ tiết kiệm và vay vốn</label>
                  <select id="modal_thanhviento" name="modal_thanhviento" class="custom-select" data-placeholder="Chọn ">
                    <option value=""></option>
                    <option value="1">Có</option>
                    <option value="2">Không</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3" style="margin-bottom: 1rem !important;">
                  <label class="form-label">Tổ trưởng tổ vay vốn</label>
                  <input type="text" id="modal_totruong" name="modal_totruong" class="form-control" placeholder="Nhập">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Thuộc tổ chức hội</label>
                  <select id="modal_tochuchoi" name="modal_tochuchoi" class="custom-select" data-placeholder="Chọn tổ chức hội">
                    <option value=""></option>
                    <?php if (is_array($this->tochuc) && count($this->tochuc) > 0) { ?>
                      <?php foreach ($this->tochuc as $ht) { ?>
                        <option value="<?php echo $ht['id']; ?>" data-text="<?php echo htmlspecialchars($ht['tendoanhoi']); ?>">
                          <?php echo htmlspecialchars($ht['tendoanhoi']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu trạng thái</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Ghi chú</label>
                  <input type="text" id="modal_ghichu" name="modal_ghichu" class="form-control" placeholder="Nhập ghi chú">
                  <label class="error_modal" for="modal_ghichu"></label>
                </div>
              </div>

            </div>
          </div>
      </div>
      <input type="hidden" id="modal_trocap_id" name="modal_trocap_id" value="">

      <input type="hidden" id="modal_edit_index" name="modal_edit_index" value="">
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
        <input type="hidden" id="modal_trocap_id" name="modal_trocap_id" value="">

        <button type="button" class="btn btn-primary" id="btn_luu_trocap"><i class="fas fa-save"></i> Lưu</button>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function($) {
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
      }).appendTo('body').fadeIn();
      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
    }

    function formatCurrency(value) {
      if (!value) return '';
      if (typeof value === 'string' && value.match(/[\.,]/)) {
        return value;
      }
      const num = parseFloat(value.toString().replace(/[^\d]/g, ''));
      return isNaN(num) ? '' : num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function initSelect2($element, options) {
      if ($element.length && $.fn.select2) {
        if ($element.data('select2')) {
          try {
            $element.select2('destroy');
          } catch (e) {
            console.warn('Lỗi khi hủy Select2:', e);
          }
        }
        $element.select2($.extend({
          width: '100%',
          allowClear: true,
          placeholder: function() {
            return $(this).data('placeholder') || 'Chọn một tùy chọn';
          },
          minimumResultsForSearch: 0
        }, options));
      }
    }

    function initializeModalSelect2() {
      $('#modalTroCap select.custom-select').each(function() {
        initSelect2($(this), {
          width: '100%',
          allowClear: true,
          placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
          dropdownParent: $('#modalTroCap')
        });
      });
    }

    $('#modalTroCap .date-picker').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy'
    });

    if ($.fn.validate) {
      $('#frmModalTroCap').validate({
        ignore: [],
        errorPlacement: function(error, element) {
          error.addClass('error_modal');
          error.appendTo(element.closest('.mb-3'));
        },
        success: function(label) {
          label.remove();
        },
        rules: {
          modal_nguonvon: {
            required: true
          },
          modal_chuongtrinh: {
            required: true
          },
          modal_giaingan: {
            required: true
          },
          modal_tongduno: {
            required: true
          },
          modal_tinhtrang: {
            required: true
          }
        },
        messages: {
          modal_nguonvon: 'Vui lòng chọn nguồn vốn',
          modal_chuongtrinh: 'Vui lòng chọn chương trình',
          modal_giaingan: 'Vui lòng nhập giải ngân',
          modal_tongduno: 'Vui lòng nhập tổng dư nợ',
          modal_tinhtrang: 'Vui lòng chọn tình trạng'
        }
      });
    }

    function updateVayVonSTT() {
      $('.dsThongtintrocap tr').each(function(index) {
        $(this).find('.stt').text(index + 1);
      });
    }

    $('.dsThongtintrocap').on('click', '.btn_edit_vayvon', function() {
      const $row = $(this).closest('tr');
      const data = {
        id_2nguonvon: $row.find('[name="id_2nguonvon[]"]').val() || '',
        somonvay: $row.find('[name="somonvay[]"]').val() || '',
        nguonvon_id: $row.find('[name="nguonvon_id[]"]').val() || '',
        chuongtrinh_id: $row.find('[name="chuongtrinh_id[]"]').val() || '',
        tongduno: $row.find('[name="tongduno[]"]').val() || '',
        ngaygiaingan: $row.find('[name="ngaygiaingan[]"]').val() || '',
        ngaydenhan: $row.find('[name="ngaydenhan[]"]').val() || '',
        tochuchoi_id: $row.find('[name="tochuchoi_id[]"]').val() || '',
        tinhtrang_id: $row.find('[name="tinhtrang_id[]"]').val() || '',
        laisuat: $row.find('[name="laisuat[]"]').val() || '',
        giaingan: $row.find('[name="giaingan[]"]').val() || '',
        thanhviento: $row.find('[name="thanhviento[]"]').val() || '',
        totruong: $row.find('[name="totruong[]"]').val() || '',
        ghichu: $row.find('[name="ghichu[]"]').val() || ''
      };

      $('#modalTroCapLabel').text('Chỉnh sửa thông tin vay vốn');
      $('#frmModalTroCap')[0].reset();
      initializeModalSelect2();

      $('#modal_trocap_id').val(data.id_2nguonvon);
      $('#modal_edit_index').val($row.index());
      $('#modal_somonvay').val(data.somonvay);
      $('#modal_nguonvon').val(data.nguonvon_id).trigger('change');
      $('#modal_chuongtrinh').val(data.chuongtrinh_id).trigger('change');
      $('#modal_tongduno').val(data.tongduno);
      $('#modal_ngaygiaingan').val(data.ngaygiaingan);
      $('#modal_ngaydenhan').val(data.ngaydenhan);
      $('#modal_tochuchoi').val(data.tochuchoi_id).trigger('change');
      $('#modal_tinhtrang').val(data.tinhtrang_id).trigger('change');
      $('#modal_laisuat').val(data.laisuat);
      $('#modal_giaingan').val(data.giaingan);
      $('#modal_thanhviento').val(data.thanhviento).trigger('change');
      $('#modal_totruong').val(data.totruong);
      $('#modal_ghichu').val(data.ghichu);

      $('#modalTroCap').modal('show');
    });

    $('#btn_luu_trocap').on('click', function() {
      const $form = $('#frmModalTroCap');
      if ($form.valid()) {
        const formData = $form.serializeArray();
        const data = {};
        formData.forEach(item => {
          data[item.name] = item.value;
        });

        const nguonvon_text = $('#modal_nguonvon option:selected').data('text') || $('#modal_nguonvon option:selected').text() || '';
        const chuongtrinh_text = $('#modal_chuongtrinh option:selected').data('text') || $('#modal_chuongtrinh option:selected').text() || '';
        const tochuchoi_text = $('#modal_tochuchoi option:selected').data('text') || $('#modal_tochuchoi option:selected').text() || '';
        const tinhtrang_text = $('#modal_tinhtrang option:selected').data('text') || $('#modal_tinhtrang option:selected').text() || '';

        const html = `
                <tr>
                    <td class="align-middle text-center stt"></td>
                    <td class="align-middle">${data.modal_somonvay || ''}</td>
                    <td class="align-middle">${nguonvon_text}</td>
                    <td class="align-middle">${chuongtrinh_text}</td>
                    <td class="align-middle">${formatCurrency(data.modal_tongduno) || ''}</td>
                    <td class="align-middle">${data.modal_ngaygiaingan || ''} - ${data.modal_ngaydenhan || ''}</td>
                    <td class="align-middle">${tochuchoi_text}</td>
                    <td class="align-middle">${tinhtrang_text}</td>
                    <td class="align-middle text-center" style="min-width:100px">
                        <input type="hidden" name="somonvay[]" value="${data.modal_somonvay || ''}" />
                        <input type="hidden" name="nguonvon_id[]" value="${data.modal_nguonvon || ''}" />
                        <input type="hidden" name="chuongtrinh_id[]" value="${data.modal_chuongtrinh || ''}" />
                        <input type="hidden" name="tongduno[]" value="${data.modal_tongduno || ''}" />
                        <input type="hidden" name="ngaygiaingan[]" value="${data.modal_ngaygiaingan || ''}" />
                        <input type="hidden" name="ngaydenhan[]" value="${data.modal_ngaydenhan || ''}" />
                        <input type="hidden" name="tochuchoi_id[]" value="${data.modal_tochuchoi || ''}" />
                        <input type="hidden" name="tinhtrang_id[]" value="${data.modal_tinhtrang || ''}" />
                        <input type="hidden" name="laisuat[]" value="${data.modal_laisuat || ''}" />
                        <input type="hidden" name="giaingan[]" value="${data.modal_giaingan || ''}" />
                        <input type="hidden" name="thanhviento[]" value="${data.modal_thanhviento || ''}" />
                        <input type="hidden" name="totruong[]" value="${data.modal_totruong || ''}" />
                        <input type="hidden" name="ghichu[]" value="${data.modal_ghichu || ''}" />
                        <input type="hidden" name="id_2nguonvon[]" value="${data.modal_trocap_id || ''}" />
                        <span class="btn btn-sm btn-warning btn_edit_vayvon"><i class="fas fa-edit"></i></span>
                        <span class="btn btn-sm btn-danger btn_xoa_vayvon" data-trocap-id="${data.modal_trocap_id || ''}"><i class="fas fa-trash-alt"></i></span>
                    </td>
                </tr>`;

        if ($('.dsThongtintrocap .no-data').length) {
          $('.dsThongtintrocap .no-data').remove();
        }

        const editIndex = parseInt(data.modal_edit_index);
        if (!isNaN(editIndex) && editIndex >= 0 && $('.dsThongtintrocap tr').eq(editIndex).length) {
          $('.dsThongtintrocap tr').eq(editIndex).replaceWith(html);
          showToast('Cập nhật thông tin vay vốn thành công', true);
        } else {
          $('.dsThongtintrocap').append(html);
          showToast('Thêm thông tin vay vốn thành công', true);
        }

        updateVayVonSTT();
        $('#modal_edit_index').val('');
        $('#modalTroCap').modal('hide');
      } else {
        showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
      }
    });

    $('.dsThongtintrocap').on('click', '.btn_xoa_vayvon', async function() {
      const $row = $(this).closest('tr');
      const trocap_id = $(this).data('trocap-id');

      if (!confirm('Bạn có chắc chắn muốn xóa thông tin vay vốn này?')) {
        return;
      }

      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'vayvon',
          task: 'delThongtinvayvon',
          trocap_id: trocap_id
        }, null, 'json');

        if (response.success) {
          $row.remove();
          updateVayVonSTT();
          showToast('Xóa thông tin vay vốn thành công', true);
          if ($('.dsThongtintrocap tr').length === 0) {
            $('.dsThongtintrocap').html('<tr class="no-data"><td colspan="9" class="text-center">Không có dữ liệu</td></tr>');
          }
        } else {
          showToast('Xóa thông tin vay vốn thất bại: ' + (response.message || 'Lỗi không xác định'), false);
        }
      } catch (error) {
        console.error('Delete error:', error);
        showToast('Lỗi khi xóa thông tin vay vốn', false);
      }
    });

    $('#btn_themvayvon').on('click', function(e) {
      e.preventDefault();
      $('#modalTroCapLabel').text('Thêm thông tin vay vốn');
      $('#frmModalTroCap')[0].reset();
      $('#modal_trocap_id').val('');
      $('#modal_edit_index').val('');
      initializeModalSelect2();
      $('#modalTroCap').modal('show');
    });
  });
</script>

<script>
  const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
  const item = <?php echo json_encode($this->item); ?>;
  const quanhethannhan = <?php echo json_encode($this->quanhethannhan ?? []); ?>;
  const nghenghiep = <?php echo json_encode($this->nghenghiep ?? []); ?>;
  const detailphuongxa_id = <?php echo json_encode($this->item->n_phuongxa_id ?? 0); ?>;
  const detailthonto_id = <?php echo json_encode($this->item->n_thonto_id ?? 0); ?>;
  let isEditMode = <?php echo (isset($this->item->id) && (int)$this->item->id > 0) ? 'true' : 'false'; ?>;
  let isFetchingFromSelect = false;

  $(document).ready(function() {
    $('#btn_quaylai').click(() => {
      window.location.href = '<?php echo Route::_('/index.php/component/vhytgd/?view=giadinhtreem&task=default'); ?>';
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

    function formatDateToDMY(dateStr) {
      if (!dateStr) return '';
      const date = new Date(dateStr);
      if (isNaN(date)) return '';
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }

    if (item && item.n_namsinh) {
      const formattedDate = formatDateToDMY(item.n_namsinh);
      $('#select_namsinh').val(formattedDate);
      $('#input_namsinh').val(formattedDate);
    }

    const initSelect2 = (selector, width = '100%') => {
      $(selector).select2({
        placeholder: $(selector).data('placeholder') || 'Chọn',
        allowClear: true,
        width,
      });
    };
    ['#select_dantoc_id', '#select_gioitinh_id', '#select_tongiao_id', '#select_phuongxa_id',
      '#select_thonto_id', '#doituonguutien_id', '#doituong_id', '#vithe_id', '#nghenghiep_id',
      '#phuongxagioithieu_id', '#trinhdohocvan_id', '#nganhang_id'
    ].forEach(selector => {
      initSelect2(selector);
    });

    function initializeSelect2() {
      $('#select_top').select2({
        placeholder: 'Chọn nhân khẩu',
        allowClear: true,
        width: '100%',
        ajax: {
          url: 'index.php?option=com_vhytgd&task=giadinhtreem.timkiem_nhankhau&format=json',
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

    async function fetchThonTo(phuongxa_id, element = '#select_thonto_id', thontoSelect = null) {
      if (!phuongxa_id) {
        $(element).html('<option value=""></option>').trigger('change');
        return;
      }

      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'dongbaodantoc',
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

    async function fetchNhanKhauTheoLaoDongDetail() {
      if (item && item.nhankhau_id) {
        try {
          const nhankhauResponse = await $.post('index.php', {
            option: 'com_vhytgd',
            task: 'giadinhtreem.timkiem_nhankhau',
            format: 'json',
            nhankhau_id: item.nhankhau_id,
          }, null, 'json');

          if (nhankhauResponse && nhankhauResponse.items && Array.isArray(nhankhauResponse.items) && nhankhauResponse.items.length > 0) {
            const nhankhau = nhankhauResponse.items.find(nk => nk.id === item.nhankhau_id) || nhankhauResponse.items[0];

            if (nhankhau) {
              const optionText = `${nhankhau.hoten} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${nhankhau.ngaysinh || ''} - Địa chỉ: ${nhankhau.diachi || ''}`;
              const newOption = new Option(optionText, nhankhau.id, true, true);
              $('#select_top').append(newOption).trigger('change');

              $('#select_top').trigger({
                type: 'select2:select',
                params: {
                  data: nhankhau
                }
              });
            } else {
              console.warn('Không tìm thấy nhân khẩu với nhankhau_id:', item.nhankhau_id);
              showToast('Không tìm thấy nhân khẩu phù hợp', false);
              $('#checkbox_toggle').prop('checked', false).trigger('change');
            }
          } else {
            console.warn('Không có dữ liệu nhân khẩu từ API');
            showToast('Không tìm thấy thông tin nhân khẩu', false);
            $('#checkbox_toggle').prop('checked', false).trigger('change');
          }
        } catch (error) {
          console.error('Fetch nhankhau error:', error);
          showToast('Lỗi khi tải thông tin nhân khẩu', false);
          $('#checkbox_toggle').prop('checked', false).trigger('change');
        }
      } else {
        console.warn('Không có nhankhau_id trong item:', item);
      }
    }

    $('.btn-themnhanthan').click(function() {
      const stt = $('.dsThanNhan tr').length;

      let quanheOptions = '<option value="">Chọn quan hệ</option>';
      for (const q of quanhethannhan) {
        quanheOptions += `<option value="${q.id}">${q.tenquanhenhanthan}</option>`;
      }

      let nghenghiepOptions = '<option value="">Chọn nghề nghiệp</option>';
      for (const n of nghenghiep) {
        nghenghiepOptions += `<option value="${n.id}">${n.tennghenghiep}</option>`;
      }

      const currentYear = new Date().getFullYear();
      const startYear = 1900;
      const endYear = currentYear;
      let namsinhOption = '<option value="">Chọn năm sinh</option>';
      for (let y = endYear; y >= startYear; y--) {
        namsinhOption += `<option value="${y}">${y}</option>`;
      }

      let isdisabled = $('#checkbox_toggle').is(':checked') ? 'disabled' : '';

      const newRow = `
            <tr>
                <td class="text-center" style="max-width: 50px;">${stt + 1}</td>
                <td style="max-width: 175px;">
                    <select name="thannhan_quanhe_id[]" class="form-control select-quanhe">
                        ${quanheOptions}
                    </select>
                </td>
                <td style="max-width: 200px;">
                    <input type="text" name="thannhan_hoten[]" placeholder="Nhập họ tên" class="form-control">
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
                <td class="text-center">
                            <input type="hidden" name="id_nhanthan" value="">

                    <button type="button" class="btn btn-danger btn-xoathannhan" ${isdisabled}><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `;

      $('.dsThanNhan').append(newRow);

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

    $('.dsThanNhan').on('click', '.btn-xoathannhan', async function() {
      const $row = $(this).closest('tr');
      const nhanthan_id = $(this).data('nhanthan-id');

      if (!confirm('Bạn có chắc chắn muốn xóa thông tin này?')) {
        return;
      }

      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'giadinhtreem',
          task: 'delThongtingiadinh',
          nhanthan_id: nhanthan_id
        }, null, 'json');

        if (response.success) {
          $row.remove();
          $('.dsThanNhan tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
          });
          showToast('Xóa thông tin thành công', true);
          if ($('.dsThanNhan tr').length === 0) {
            $('.dsThanNhan').html('<tr class="no-data"><td colspan="5" class="text-center">Không có dữ liệu</td></tr>');
          }
        } else {
          showToast('Xóa thông tin trợ cấp thất bại: ' + (response.message || 'Lỗi không xác định'), false);
        }
      } catch (error) {
        console.error('Delete error:', error);
        showToast('Lỗi khi xóa thông tin trợ cấp', false);
      }
    });
    // $(document).on('click', '.btn-xoathannhan', function(e) {
    //     e.preventDefault();
    //     $(this).closest('tr').remove();
    //     $('.dsThanNhan tr').each(function(index) {
    //         $(this).find('td:first').text(index + 1);
    //     });
    // });

    function populateThanNhan(item) {
      if (item && item.thannhan && Array.isArray(item.thannhan) && item.thannhan.length > 0) {
        $('.dsThanNhan').empty();

        item.thannhan.forEach((thannhan, index) => {
          const stt = index + 1;

          let quanheOptions = '<option value="">Chọn quan hệ</option>';
          for (const q of quanhethannhan) {
            const selected = thannhan.quanhenhanthan_id ? (parseInt(thannhan.quanhenhanthan_id) === q.id ? 'selected' : '') : '';
            quanheOptions += `<option value="${q.id}" ${selected}>${q.tenquanhenhanthan}</option>`;
          }

          let nghenghiepOptions = '<option value="">Chọn nghề nghiệp</option>';
          for (const n of nghenghiep) {
            const selected = thannhan.nghenghiep_id ? (parseInt(thannhan.nghenghiep_id) === n.id ? 'selected' : '') : '';
            nghenghiepOptions += `<option value="${n.id}" ${selected}>${n.tennghenghiep}</option>`;
          }

          const currentYear = new Date().getFullYear();
          const startYear = 1900;
          const endYear = currentYear;
          let namsinhOption = '<option value="">Chọn năm sinh</option>';
          for (let y = endYear; y >= startYear; y--) {
            const selected = thannhan.namsinh ? (parseInt(thannhan.namsinh) === y ? 'selected' : '') : '';
            namsinhOption += `<option value="${y}" ${selected}>${y}</option>`;
          }

          let isdisabled = $('#checkbox_toggle').is(':checked') ? 'disabled' : '';

          const newRow = `
                    <tr>
                        <td class="text-center" style="max-width: 50px;">${stt}</td>
                        <td style="max-width: 175px;">
                            <select name="thannhan_quanhe_id[]" class="form-control select-quanhe">
                                ${quanheOptions}
                            </select>
                        </td>
                        <td style="max-width: 200px;">
                            <input type="text" name="thannhan_hoten[]" placeholder="Nhập họ tên" value="${thannhan.hoten || ''}" class="form-control">
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
                        <td class="text-center">
                            <input type="hidden" name="id_nhanthan" value="${thannhan.thanhvien_id || ''}">
                            <button type="button" class="btn btn-danger btn-xoathannhan" ${isdisabled}" data-nhanthan-id="${thannhan.thanhvien_id || ''}" ><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                `;

          $('.dsThanNhan').append(newRow);
        });

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
      } else {
        $('.dsThanNhan').empty().append(`
                <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu thân nhân</td>
                </tr>
            `);
      }
    }

    $('#checkbox_toggle').change(function() {
      toggleFormFields($(this).is(':checked'));
    });

    $('#datunglamviec').on('change', function() {
      const is_lamviec = $(this).val();
      $('.thoigianlamviec_container').toggle(is_lamviec === '1').toggleClass('d-flex flex-column', is_lamviec === '1');
      if (is_lamviec !== '1') {
        $('#thoigianlamviec').val('').trigger('change');
      }
    });

    $('#select_phuongxa_id').on('change', function() {
      if (!isFetchingFromSelect) {
        fetchThonTo($(this).val(), '#select_thonto_id');
      }
    });

    $('#select_top').on('select2:select', async function(e) {
      const data = e.params.data;
      if (!isEditMode) {
        try {
          const response = await $.post('index.php', {
            option: 'com_vhytgd',
            controller: 'giadinhtreem',
            task: 'checkTreem',
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

      isEditMode = false;

      try {
        const response = await $.post('index.php', {
          option: 'com_vhytgd',
          controller: 'giadinhtreem',
          task: 'getThanNhan',
          nhankhau_id: data.id,
        }, null, 'json');


        // Kiểm tra nếu response không phải là mảng
        let responses = Array.isArray(response) ? response : (response.thannhan || []);

        $('.dsThanNhan').empty();

        if (responses && Array.isArray(responses) && responses.length > 0) {
          responses.forEach((thannhan, index) => {
            if (thannhan.id !== data.id) {
              const namsinh = thannhan.namsinh && /^\d{4}-\d{2}-\d{2}$/.test(thannhan.namsinh) ?
                new Date(thannhan.namsinh).getFullYear() :
                thannhan.namsinh || '';

              let isdisabled = $('#checkbox_toggle').is(':checked') ? 'disabled' : '';
              const boldStyle = thannhan.is_chuho == 1 ? 'font-weight:bold' : '';

              let quanheOptions = '<option value="">Chọn quan hệ</option>';
              for (const q of quanhethannhan) {
                const selected = thannhan.quanhenhanthan_id ? (parseInt(thannhan.quanhenhanthan_id) === q.id ? 'selected' : '') : '';
                quanheOptions += `<option value="${q.id}" ${selected}>${q.tenquanhenhanthan}</option>`;
              }

              let nghenghiepOptions = '<option value="">Chọn nghề nghiệp</option>';
              for (const n of nghenghiep) {
                const selected = thannhan.nghenghiep_id ? (parseInt(thannhan.nghenghiep_id) === n.id ? 'selected' : '') : '';
                nghenghiepOptions += `<option value="${n.id}" ${selected}>${n.tennghenghiep}</option>`;
              }

              const currentYear = new Date().getFullYear();
              const startYear = 1900;
              const endYear = currentYear;
              let namsinhOption = '<option value="">Chọn năm sinh</option>';
              for (let y = endYear; y >= startYear; y--) {
                const selected = namsinh ? (parseInt(namsinh) === y ? 'selected' : '') : '';
                namsinhOption += `<option value="${y}" ${selected}>${y}</option>`;
              }

              const newRow = `
                            <tr>
                                <td class="text-center" style="max-width: 50px;">${index + 1}</td>
                                <td style="max-width: 175px;">
                                     <input type="hidden" name="nhankhau_id_nhanthan[]" value="${thannhan.id || ''}">
                                     <input type="hidden" name="gioitinh_thanthan[]" value="${thannhan.gioitinh_id || ''}">

                                    <select name="thannhan_quanhe_id[]" class="form-control select-quanhe">
                                        ${quanheOptions}
                                    </select>
                                </td>
                                <td style="max-width: 200px;">
                                    <input type="text" name="thannhan_hoten[]" class="form-control" value="${thannhan.hoten || ''}" style="${boldStyle}">
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
                                <td class="text-center">

                                    <button type="button" class="btn btn-danger btn-xoathannhan" ${isdisabled}><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
              $('.dsThanNhan').append(newRow);
            }
          });

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
        } else {
          showToast('Không có dữ liệu thân nhân', false);
          $('.dsThanNhan').empty().append(`
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu thân nhân</td>
                    </tr>
                `);
        }
      } catch (error) {
        console.error('GetThanNhan error:', error);
        showToast('Lỗi khi tải danh sách thân nhân', false);
        $('.dsThanNhan').empty().append(`
                <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu thân nhân</td>
                </tr>
            `);
      }
    });

    $('#form').validate({
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
          }
        },
        select_phuongxa_id: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        },
        select_gioitinh_id: {
          required: function() {
            return !$('#checkbox_toggle').is(':checked');
          }
        }
      },
      messages: {
        select_top: 'Vui lòng chọn công dân',
        hoten: 'Vui lòng nhập họ và tên',
        cccd: 'Vui lòng nhập CCCD/CMND',
        select_namsinh: 'Vui lòng chọn năm sinh',
        select_phuongxa_id: 'Vui lòng chọn phường/xã',
        select_gioitinh_id: 'Vui lòng chọn giới tính',
      },
      errorPlacement: function(error, element) {
        if (element.hasClass('custom-select')) {
          error.insertAfter(element.next('.select2-container'));
        } else if (element.closest('.input-group').length) {
          error.insertAfter(element.closest('.input-group'));
        } else {
          error.insertAfter(element);
        }
      }
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

    toggleFormFields($('#checkbox_toggle').is(':checked'));
    initializePhuongXaAndThonTo();
    fetchNhanKhauTheoLaoDongDetail();
    populateThanNhan(item);
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

  .select2-container .select2-selection--single {
    height: 38px;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px;
    padding-left: 8px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
  }

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
    color: #fff
  }

  .table#tblThongtin td.align-middle {
    width: 33.33%;
    padding: .75rem 0rem .75rem .75rem;
  }

  .table#tblThongtin .form-control,
  .table#tblThongtin .custom-select,
  .table#tblThongtin .input-group {
    width: 100% !important;
    box-sizing: border-box;
  }

  .table#tblThongtin .input-group .form-control {
    flex: 1;
  }

  .status-verified {
    color: green;
  }

  .status-unverified {
    color: red;
  }

  .hideOpt {
    display: none !important;
  }

  /* CSS cụ thể cho #modalTroCap */
  #modalTroCap .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 20px;
    word-break: break-word;
  }

  #modalTroCap .select2-container .select2-selection--single {
    height: 38px;
  }

  #modalTroCap .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px;
    padding-left: 8px;
  }

  #modalTroCap .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
  }

  #modalTroCap {
    overflow-x: hidden;
  }

  #modalTroCap .modal-dialog {
    max-width: 1200px;
    min-width: 300px;
    width: 1000px;
    margin-left: auto;
    margin-right: 0;
    margin-top: 1.75rem;
    margin-bottom: 1.75rem;
    transform: translateX(100%);
    transition: transform 0.5s ease-in-out;
  }

  #modalTroCap.show .modal-dialog {
    transform: translateX(0);
  }

  #modalTroCap.fade .modal-dialog {
    transition: transform 0.5s ease-in-out;
    opacity: 1;
  }

  #modalTroCap.fade:not(.show) .modal-dialog {
    transform: translateX(100%);
  }

  #modalTroCap .modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  #modalTroCap .error_modal {
    margin-bottom: 0px;
    margin-top: 0;
    font-size: 12px;
    color: red;
  }

  .error_modal {
    margin-bottom: 0px;
    margin-top: 0;
    font-size: 12px;
    color: red;
  }

  /* CSS riêng cho modal thông báo xóa của Bootbox (nếu cần) */
  .custom-bootbox .modal-dialog {
    max-width: 500px;
    /* Kích thước mặc định cho Bootbox */
    margin: 1.75rem auto;
    /* Căn giữa */
    transform: none !important;
    /* Vô hiệu hóa transform */
    transition: none !important;
    /* Vô hiệu hóa transition */
  }

  .custom-bootbox .modal-content {
    border-radius: 4px;
    /* Góc bo mặc định */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    /* Hiệu ứng bóng nhẹ */
  }

  .custom-bootbox .modal-body {
    padding: 15px;
    /* Padding mặc định của Bootbox */
    word-break: normal;
    /* Giữ giao diện mặc định */
  }

  /* CSS cho bảng tableFixHead (không liên quan đến modal) */
  table.tableFixHead {
    border-collapse: collapse;
    max-width: 800px;
    overflow-x: scroll;
    display: block;
  }

  table.tableFixHead thead {
    background-color: #027be3;
  }

  table.tableFixHead thead,
  table.tableFixHead tbody {
    display: block;
  }

  table.tableFixHead tbody {
    overflow-y: scroll;
    overflow-x: hidden;
    height: 250px;
  }

  td.stt,
  th.stt {
    min-width: 50px;
    max-width: 80px;
  }

  td.hoten,
  th.hoten {
    min-width: 250px;
    max-width: 300px;
  }

  td.diachi,
  th.diachi {
    min-width: 150px;
    max-width: 200px;
  }

  td.tieuchigdvanhoa,
  th.tieuchigdvanhoa {
    min-width: 200px;
    max-width: 250px;
  }

  td.thongtinchucdanh,
  th.thongtinchucdanh {
    min-width: 200px;
    max-width: 250px;
  }

  td.tinhtrang,
  th.tinhtrang {
    min-width: 100px;
    max-width: 150px;
  }

  td.lydo,
  th.lydo {
    min-width: 100px;
    max-width: 200px;
  }

  td.chucnang,
  th.chucnang {
    min-width: 100px;
    max-width: 150px;
  }

  #modalTroCap .mb-3 {
    margin-bottom: 0rem !important;

  }
</style>