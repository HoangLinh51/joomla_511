<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$item = $this->item;
$app = JFactory::getApplication();

$gdte_id = $app->input->getInt('gdte_id', 0);

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
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="form" name="form" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=giadinhtreem&task=saveBaoLuc'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3" style="margin-bottom: 1rem !important;">
      <h2 class="text-primary mb-3" style="padding: 10px 10px 10px 0px;">
        Thêm thông tin bạo lực gia đình
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="button" class="btn btn-primary btn-thembaoluc">Thêm thông tin</button>
      </span>
    </div>
    <input type="hidden" name="giadinh_id" value="<?php echo htmlspecialchars($gdte_id); ?>">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->id ?? 0); ?>">
    <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($gdte_id); ?>">
    <div class="row g-3 mb-4">
      <table id="table-baoluc" class="table table-striped table-bordered" style="table-layout: fixed; width: 100%; margin: 0px">
        <thead class="bg-primary text-white">
          <tr>
            <th style="width: 50px; text-align: center;" rowspan="2">STT</th>
            <th style="width: 175px; text-align: center;" colspan="3">Người gây bạo lực</th>
            <th style="width: 200px; text-align: center;" colspan="3">Nạn nhân</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Biện pháp hỗ trợ và xử lý</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Thông tin xử lí</th>
            <th style="width: 100px; text-align: center;" rowspan="2">Hành động</th>
          </tr>
          <tr>
            <th style="width: 300px; text-align: center;">Họ tên</th>
            <th style="width: 55px; text-align: center;">Giới tính</th>
            <th style="width: 55px; text-align: center;">Năm sinh</th>
            <th style="width: 300px; text-align: center;">Họ tên</th>
            <th style="width: 55px; text-align: center;">Giới tính</th>
            <th style="width: 55px; text-align: center;">Năm sinh</th>
          </tr>
        </thead>
        <tbody class="dsBaoluc">
          <tr class="no-data">
            <td colspan="10" class="text-center">Không có dữ liệu</td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>

<!-- Modal thông tin bạo lực gia đình -->
<div class="modal fade" id="modalBaoLuc" tabindex="-1" role="dialog" aria-labelledby="modalBaoLucLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBaoLucLabel">Thêm thông tin bạo lực gia đình</h5>
      </div>
      <div class="modal-body">
        <form id="frmModalBaoLuc">
          <div id="baoluc_fields">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Người gây bạo lực <span class="text-danger">*</span></label>
                  <select id="modal_nguoigay_id" name="modal_nguoigay_id" class="custom-select" data-placeholder="Chọn người gây bạo lực" required>
                    <option value=""></option>
                  </select>
                  <label class="error_modal" for="modal_nguoigay_id"></label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Giới tính</label>
                  <input type="text" id="modal_gioitinh_nguoigay" name="modal_gioitinh_nguoigay" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Năm sinh</label>
                  <input type="number" id="modal_namsinh_nguoigay" name="modal_namsinh_nguoigay" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nạn nhân <span class="text-danger">*</span></label>
                  <select id="modal_nannhan_id" name="modal_nannhan_id" class="custom-select" data-placeholder="Chọn nạn nhân" required>
                    <option value=""></option>
                  </select>
                  <label class="error_modal" for="modal_nannhan_id"></label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Giới tính</label>
                  <input type="text" id="modal_gioitinh_nannhan" name="modal_gioitinh_nannhan" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Năm sinh</label>
                  <input type="number" id="modal_namsinh_nannhan" name="modal_namsinh_nannhan" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Xử lý <span class="text-danger">*</span></label>
                  <select id="modal_bienphap" name="modal_bienphap" class="custom-select" data-placeholder="Chọn biện pháp xử lý" required>
                    <option value=""></option>
                    <?php if (is_array($this->xuly) && count($this->xuly) > 0) { ?>
                      <?php foreach ($this->xuly as $xp) { ?>
                        <option value="<?php echo $xp['id']; ?>" data-text="<?php echo htmlspecialchars($xp['tenxuly']); ?>">
                          <?php echo htmlspecialchars($xp['tenxuly']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_bienphap"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Hỗ trợ <span class="text-danger">*</span></label>
                  <select id="modal_hotro" name="modal_hotro" class="custom-select" data-placeholder="Chọn biện pháp hỗ trợ" required>
                    <option value=""></option>
                    <?php if (is_array($this->hotro) && count($this->hotro) > 0) { ?>
                      <?php foreach ($this->hotro as $xp) { ?>
                        <option value="<?php echo $xp['id']; ?>" data-text="<?php echo htmlspecialchars($xp['tenhotro']); ?>">
                          <?php echo htmlspecialchars($xp['tenhotro']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_hotro"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Cơ quan xử lý</label>
                  <input type="text" id="modal_coquanxl" name="modal_coquanxl" class="form-control" placeholder="Nhập cơ quan xử lý">
                  <label class="error_modal" for="modal_coquanxl"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Mã vụ việc</label>
                  <input type="text" id="modal_mavuviec" name="modal_mavuviec" class="form-control" placeholder="Nhập mã vụ việc">
                  <label class="error_modal" for="modal_mavuviec"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Ngày xử lý</label>
                  <input type="text" id="modal_ngayxuly" name="modal_ngayxuly" class="form-control date-picker" placeholder="dd/mm/yyyy">
                  <label class="error_modal" for="modal_ngayxuly"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tình trạng <span class="text-danger">*</span></label>
                  <select id="modal_tinhtrang" name="modal_tinhtrang" class="custom-select" data-placeholder="Chọn tình trạng" required>
                    <option value=""></option>
                    <option value="1">Đã xử lý</option>
                    <option value="0">Chưa xử lý</option>
                    <option value="2">Đang xử lý</option>
                  </select>
                  <label class="error_modal" for="modal_tinhtrang"></label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Ghi chú</label>
                  <input type="text" id="modal_ghichu" name="modal_ghichu" class="form-control" placeholder="Nhập ghi chú">
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="modal_baoluc_id" name="modal_baoluc_id" value="">
          <input type="hidden" id="modal_edit_index" name="modal_edit_index" value="">
          <input type="hidden" id="modal_hoten_nguoigay" name="modal_hoten_nguoigay" value="">
          <input type="hidden" id="modal_hoten_nannhan" name="modal_hoten_nannhan" value="">
          <input type="hidden" name="hogiadinh_id" id="hogiadinh_id" value="<?php echo htmlspecialchars($gdte_id); ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">X Đóng</button>
        <button type="button" class="btn btn-primary" id="btn_luu_baoluc"><i class="fas fa-save"></i> Lưu</button>
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
    $('#btn_quaylai').click(() => {
      window.location.href = '<?php echo Route::_('/index.php/component/vhytgd/?view=giadinhtreem&task=default'); ?>';
    });

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
      $('#modalBaoLuc select.custom-select').each(function() {
        initSelect2($(this), {
          width: '100%',
          allowClear: true,
          placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
          dropdownParent: $('#modalBaoLuc')
        });
      });
    }

    function fetchHouseholdMembers() {
      return new Promise((resolve, reject) => {
        const nhankhau_id = $('#nhankhau_id').val();
        if (!nhankhau_id || nhankhau_id == '0') {
          showToast('Không tìm thấy ID gia đình', false);
          $('#modal_nguoigay_id, #modal_nannhan_id').empty().append('<option value="">Không có dữ liệu</option>');
          initializeModalSelect2();
          reject('Không tìm thấy ID gia đình');
          return;
        }

        $.ajax({
          url: 'index.php',
          type: 'POST',
          data: {
            option: 'com_vhytgd',
            controller: 'giadinhtreem',
            task: 'getThannhanBaoluc',
            nhankhau_id: nhankhau_id,
            '<?php echo JSession::getFormToken(); ?>': 1
          },
          dataType: 'json',
          success: function(response) {
            if (response && Array.isArray(response) && response.length > 0) {
              const $nguoigaySelect = $('#modal_nguoigay_id');
              const $nannhanSelect = $('#modal_nannhan_id');
              $nguoigaySelect.empty().append('<option value=""></option>');
              $nannhanSelect.empty().append('<option value=""></option>');

              response.forEach(member => {
                const option = `<option value="${member.nhankhau_id}" data-hoten="${member.hoten}" data-gioitinh="${member.gioitinh || ''}" data-namsinh="${member.namsinh || ''}">${member.hoten}</option>`;
                $nguoigaySelect.append(option);
                $nannhanSelect.append(option);
              });

              initializeModalSelect2();
              resolve(response);
            } else {
              showToast('Không tìm thấy thành viên gia đình', false);
              $('#modal_nguoigay_id, #modal_nannhan_id').empty().append('<option value="">Không có dữ liệu</option>');
              initializeModalSelect2();
              reject('Không tìm thấy thành viên gia đình');
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi lấy danh sách thành viên:', error);
            showToast('Lỗi khi lấy danh sách thành viên gia đình', false);
            $('#modal_nguoigay_id, #modal_nannhan_id').empty().append('<option value="">Không có dữ liệu</option>');
            initializeModalSelect2();
            reject(error);
          }
        });
      });
    }

    function loadBaoLucList() {
      const giadinh_id = $('#nhankhau_id').val();
      if (!giadinh_id || giadinh_id == '0') {
        return;
      }

      $.ajax({
        url: 'index.php',
        type: 'POST',
        data: {
          option: 'com_vhytgd',
          controller: 'giadinhtreem',
          task: 'getBaoLucList',
          giadinh_id: giadinh_id,
          '<?php echo JSession::getFormToken(); ?>': 1
        },
        dataType: 'json',
        success: function(response) {
          if (response.success && response.data && Array.isArray(response.data)) {
            $('.dsBaoluc').empty();
            if (response.data.length === 0) {
              $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
              return;
            }

            response.data.forEach((item, index) => {
              const tinhtrangText = item.tinhtrang == 1 ? 'Đã xử lý' : item.tinhtrang == 0 ? 'Chưa xử lý' : item.tinhtrang == 2 ? 'Đang xử lý' : '';
              const html = `
                        <tr>
                            <td class="align-middle text-center stt">${index + 1}</td>
                            <td class="align-middle">${item.hoten_nguoigay || ''}</td>
                            <td class="align-middle text-center">${item.gioitinh_nguoigay || ''}</td>
                            <td class="align-middle text-center">${item.namsinh_nguoigay || ''}</td>
                            <td class="align-middle">${item.hoten_nannhan || ''}</td>
                            <td class="align-middle text-center">${item.gioitinh_nannhan || ''}</td>
                            <td class="align-middle text-center">${item.namsinh_nannhan || ''}</td>
                            <td class="align-middle"><strong>Biện pháp:</strong> ${item.bienphap_text || ''}<br><strong>Hỗ trợ:</strong> ${item.hotro_text || ''}</td>
                            <td class="align-middle"><strong>Cơ quan xử lý:</strong>${item.coquanxuly || ''}<br><strong>Mã vụ việc:</strong>${item.mavuviec || ''}<br><strong>Ngày xử lý:</strong>${item.ngayxuly2 || ''}<br><strong>Tình trạng:</strong>${tinhtrangText}</td>
                            <td class="align-middle text-center" style="min-width:100px">
                                <input type="hidden" name="baoluc_id[]" value="${item.id || ''}" />
                                <input type="hidden" name="nguoigay_id[]" value="${item.thanhvienbaoluc_id || ''}" />
                                <input type="hidden" name="hoten_nguoigay[]" value="${item.hoten_nguoigay || ''}" />
                                <input type="hidden" name="gioitinh_nguoigay[]" value="${item.gioitinh_nguoigay || ''}" />
                                <input type="hidden" name="namsinh_nguoigay[]" value="${item.namsinh_nguoigay || ''}" />
                                <input type="hidden" name="nannhan_id[]" value="${item.thanhviennanhan_id || ''}" />
                                <input type="hidden" name="hoten_nannhan[]" value="${item.hoten_nannhan || ''}" />
                                <input type="hidden" name="gioitinh_nannhan[]" value="${item.gioitinh_nannhan || ''}" />
                                <input type="hidden" name="namsinh_nannhan[]" value="${item.namsinh_nannhan || ''}" />
                                <input type="hidden" name="bienphap_id[]" value="${item.bienphapxulybl_id || ''}" />
                                <input type="hidden" name="hotro_id[]" value="${item.bienphaphotro_id || ''}" />
                                <input type="hidden" name="coquanxl[]" value="${item.coquanxuly || ''}" />
                                <input type="hidden" name="mavuviec[]" value="${item.mavuviec || ''}" />
                                <input type="hidden" name="ngayxuly[]" value="${item.ngayxuly2 || ''}" />
                                <input type="hidden" name="tinhtrang[]" value="${item.tinhtrang || ''}" />
                                <input type="hidden" name="ghichu[]" value="${item.ghichu || ''}" />
                                <span class="btn btn-sm btn-warning btn_edit_baoluc"><i class="fas fa-edit"></i></span>
                                <span class="btn btn-sm btn-danger btn_xoa_baoluc" data-baoluc-id="${item.id || ''}"><i class="fas fa-trash-alt"></i></span>
                            </td>
                        </tr>`;
              $('.dsBaoluc').append(html);
            });
          } else {
            $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
            showToast('Không tìm thấy dữ liệu bạo lực gia đình', false);
          }
        },
        error: function(xhr, status, error) {
          console.error('Lỗi khi tải danh sách bạo lực:', error);
          showToast('Lỗi khi tải danh sách bạo lực gia đình', false);
          $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
        }
      });
    }

    $('#modal_nguoigay_id').on('change', function() {
      const selectedOption = $(this).find('option:selected');
      const hoten = selectedOption.data('hoten') || '';
      const gioitinh = selectedOption.data('gioitinh') || '';
      const namsinh = selectedOption.data('namsinh') || '';
      $('#modal_hoten_nguoigay').val(hoten);
      $('#modal_gioitinh_nguoigay').val(gioitinh);
      $('#modal_namsinh_nguoigay').val(namsinh);
    });

    $('#modal_nannhan_id').on('change', function() {
      const selectedOption = $(this).find('option:selected');
      const hoten = selectedOption.data('hoten') || '';
      const gioitinh = selectedOption.data('gioitinh') || '';
      const namsinh = selectedOption.data('namsinh') || '';
      $('#modal_hoten_nannhan').val(hoten);
      $('#modal_gioitinh_nannhan').val(gioitinh);
      $('#modal_namsinh_nannhan').val(namsinh);
    });

    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy'
    });

    if ($.fn.validate) {
      $('#frmModalBaoLuc').validate({
        ignore: [],
        errorPlacement: function(error, element) {
          error.addClass('error_modal');
          error.appendTo(element.closest('.mb-3'));
        },
        success: function(label) {
          label.remove();
        },
        rules: {
          modal_nguoigay_id: {
            required: true
          },
          modal_nannhan_id: {
            required: true
          },
          modal_bienphap: {
            required: true
          },
          modal_hotro: {
            required: true
          },
          modal_tinhtrang: {
            required: true
          }
        },
        messages: {
          modal_nguoigay_id: 'Vui lòng chọn người gây bạo lực',
          modal_nannhan_id: 'Vui lòng chọn nạn nhân',
          modal_bienphap: 'Vui lòng chọn biện pháp xử lý',
          modal_hotro: 'Vui lòng chọn biện pháp hỗ trợ',
          modal_tinhtrang: 'Vui lòng chọn tình trạng'
        }
      });
    }

    function updateBaoLucSTT() {
      $('.dsBaoluc tr').each(function(index) {
        $(this).find('.stt').text(index + 1);
      });
    }

    $('.dsBaoluc').on('click', '.btn_edit_baoluc', function() {
      const $row = $(this).closest('tr');
      const data = {
        baoluc_id: $row.find('[name="baoluc_id[]"]').val() || '',
        nguoigay_id: $row.find('[name="nguoigay_id[]"]').val() || '',
        hoten_nguoigay: $row.find('[name="hoten_nguoigay[]"]').val() || '',
        gioitinh_nguoigay: $row.find('[name="gioitinh_nguoigay[]"]').val() || '',
        namsinh_nguoigay: $row.find('[name="namsinh_nguoigay[]"]').val() || '',
        nannhan_id: $row.find('[name="nannhan_id[]"]').val() || '',
        hoten_nannhan: $row.find('[name="hoten_nannhan[]"]').val() || '',
        gioitinh_nannhan: $row.find('[name="gioitinh_nannhan[]"]').val() || '',
        namsinh_nannhan: $row.find('[name="namsinh_nannhan[]"]').val() || '',
        bienphap_id: $row.find('[name="bienphap_id[]"]').val() || '',
        hotro_id: $row.find('[name="hotro_id[]"]').val() || '',
        coquanxl: $row.find('[name="coquanxl[]"]').val() || '',
        mavuviec: $row.find('[name="mavuviec[]"]').val() || '',
        ngayxuly: $row.find('[name="ngayxuly[]"]').val() || '',
        tinhtrang: $row.find('[name="tinhtrang[]"]').val() || '',
        ghichu: $row.find('[name="ghichu[]"]').val() || ''
      };
      $('#modalBaoLucLabel').text('Chỉnh sửa thông tin bạo lực gia đình');
      $('#frmModalBaoLuc')[0].reset();

      // Gán giá trị vào các trường
      $('#modal_baoluc_id').val(data.baoluc_id);
      $('#modal_edit_index').val($row.index());
      $('#modal_bienphap').val(data.bienphap_id);
      $('#modal_hotro').val(data.hotro_id);
      $('#modal_coquanxl').val(data.coquanxl);
      $('#modal_mavuviec').val(data.mavuviec);
      $('#modal_ngayxuly').val(data.ngayxuly);
      $('#modal_tinhtrang').val(data.tinhtrang);
      $('#modal_ghichu').val(data.ghichu);
      $('#modal_hoten_nguoigay').val(data.hoten_nguoigay);
      $('#modal_hoten_nannhan').val(data.hoten_nannhan);
      $('#modal_gioitinh_nguoigay').val(data.gioitinh_nguoigay);
      $('#modal_namsinh_nguoigay').val(data.namsinh_nguoigay);
      $('#modal_gioitinh_nannhan').val(data.gioitinh_nannhan);
      $('#modal_namsinh_nannhan').val(data.namsinh_nannhan);

      // Tải danh sách thành viên và gán giá trị select box
      fetchHouseholdMembers().then(() => {
        $('#modal_nguoigay_id').val(data.nguoigay_id).trigger('change.select2');
        $('#modal_nannhan_id').val(data.nannhan_id).trigger('change.select2');
        $('#modal_bienphap').trigger('change.select2');
        $('#modal_hotro').trigger('change.select2');
        $('#modal_tinhtrang').trigger('change.select2');

        // Đảm bảo giữ giá trị hoten từ dữ liệu hàng
        $('#modal_hoten_nguoigay').val(data.hoten_nguoigay);
        $('#modal_hoten_nannhan').val(data.hoten_nannhan);
        $('#modal_gioitinh_nguoigay').val(data.gioitinh_nguoigay);
        $('#modal_namsinh_nguoigay').val(data.namsinh_nguoigay);
        $('#modal_gioitinh_nannhan').val(data.gioitinh_nannhan);
        $('#modal_namsinh_nannhan').val(data.namsinh_nannhan);

        $('#modalBaoLuc').modal('show');
      }).catch(error => {
        console.error('Lỗi khi tải danh sách thành viên:', error);
        showToast('Lỗi khi tải danh sách thành viên gia đình', false);
        $('#modalBaoLuc').modal('show');
      });
    });

    $('#btn_luu_baoluc').on('click', function() {
      const $form = $('#frmModalBaoLuc');
      if ($form.valid()) {
        const formData = $form.serializeArray();
        const data = {};
        formData.forEach(item => {
          data[item.name] = item.value;
        });

        // Thêm token CSRF và các trường cần thiết
        data['<?php echo JSession::getFormToken(); ?>'] = 1;
        data['giadinh_id'] = $('#form input[name="giadinh_id"]').val();
        data['id'] = $('#form input[name="id"]').val();

        // Gửi dữ liệu qua AJAX
        $.ajax({
          url: '<?php echo JRoute::_('index.php?option=com_vhytgd&controller=giadinhtreem&task=saveBaoLuc'); ?>',
          type: 'POST',
          data: data,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Sau khi lưu thành công, làm mới danh sách bạo lực
              loadBaoLucList();
              showToast('Lưu thông tin bạo lực gia đình thành công', true);
              $('#modalBaoLuc').modal('hide');
            } else {
              showToast('Lưu thông tin bạo lực gia đình thất bại: ' + (response.message || 'Lỗi không xác định'), false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi lưu:', error);
            showToast('Lỗi khi lưu thông tin bạo lực gia đình', false);
          }
        });
      } else {
        showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
      }
    });
    $('.dsBaoluc').on('click', '.btn_xoa_baoluc', function() {
      const $row = $(this).closest('tr');
      const baoluc_id = $(this).data('baoluc-id');

      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span style="font-size:18px;">Bạn có chắc chắn muốn xóa thông tin bạo lực gia đình này?</span>',
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
          if (!result) return; // Người dùng bấm Không thì thoát

          try {
            const response = await $.post('index.php', {
              option: 'com_vhytgd',
              controller: 'giadinhtreem',
              task: 'delThongtinBaoluc',
              baoluc_id: baoluc_id,
              '<?php echo JSession::getFormToken(); ?>': 1
            }, null, 'json');

            if (response.success) {
              $row.remove();
              updateBaoLucSTT();
              showToast('Xóa thông tin bạo lực gia đình thành công', true);
              if ($('.dsBaoluc tr').length === 0) {
                $('.dsBaoluc').html(
                  '<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>'
                );
              }
            } else {
              showToast(
                'Xóa thông tin bạo lực gia đình thất bại: ' + (response.message || 'Lỗi không xác định'),
                false
              );
            }
          } catch (error) {
            console.error('Lỗi khi xóa:', error);
            showToast('Lỗi khi xóa thông tin bạo lực gia đình', false);
          }
        }
      });
    });


    $('.btn-thembaoluc').on('click', function(e) {
      e.preventDefault();
      $('#modalBaoLucLabel').text('Thêm thông tin bạo lực gia đình');
      $('#frmModalBaoLuc')[0].reset();
      $('#modal_baoluc_id').val('');
      $('#modal_edit_index').val('');
      $('#modal_hoten_nguoigay').val('');
      $('#modal_gioitinh_nguoigay').val('');
      $('#modal_namsinh_nguoigay').val('');
      $('#modal_hoten_nannhan').val('');
      $('#modal_gioitinh_nannhan').val('');
      $('#modal_namsinh_nannhan').val('');
      $('#modal_bienphap').val('');
      $('#modal_hotro').val('');
      $('#modal_coquanxl').val('');
      $('#modal_mavuviec').val('');
      $('#modal_ngayxuly').val('');
      $('#modal_tinhtrang').val('');
      initializeModalSelect2();
      fetchHouseholdMembers();
      $('#modalBaoLuc').modal('show');
    });

    // Tải danh sách bạo lực khi trang được tải
    loadBaoLucList();
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

  /* CSS cụ thể cho #modalBaoLuc */
  #modalBaoLuc .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 20px;
    word-break: break-word;
  }

  #modalBaoLuc .select2-container .select2-selection--single {
    height: 38px;
  }

  #modalBaoLuc .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px;
    padding-left: 8px;
  }

  #modalBaoLuc .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
  }

  #modalBaoLuc {
    overflow-x: hidden;
  }

  #modalBaoLuc .modal-dialog {
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

  #modalBaoLuc.show .modal-dialog {
    transform: translateX(0);
  }

  #modalBaoLuc.fade .modal-dialog {
    transition: transform 0.5s ease-in-out;
    opacity: 1;
  }

  #modalBaoLuc.fade:not(.show) .modal-dialog {
    transform: translateX(100%);
  }

  #modalBaoLuc .modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  #modalBaoLuc .error_modal {
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

  #modalBaoLuc .mb-3 {
    margin-bottom: 0rem !important;

  }
</style>