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
$item = $item;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="form" name="form" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=giadinhtreem&task=saveBaoLuc'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3" style="margin-bottom: 1rem !important;">
      <h2 class="text-primary mb-3" style="padding: 10px 10px 10px 0px;">
        Thêm thông tin trẻ em
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
        <thead class="table-primary text-white">
          <tr>
            <th style="width: 50px; text-align: center;" rowspan="2">STT</th>
            <th style="width: 175px; text-align: center;" colspan="3">Thông tin trẻ em</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Trình trạng học tập</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Trình trạng sức khỏe</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Nhóm hoàn cảnh</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Nội dung</th>
            <th style="width: 150px; text-align: center;" rowspan="2">Trợ giúp</th>
            <th style="width: 100px; text-align: center;" rowspan="2">Hành động</th>
          </tr>
          <tr>
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

<!-- Modal thông tin trẻ em -->
<div class="modal fade" id="modalTreEm" tabindex="-1" role="dialog" aria-labelledby="modalTreEmLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTreEmLabel">Thêm thông tin trẻ em</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmmodalTreEm">
          <div id="baoluc_fields">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Trẻ em<span class="text-danger">*</span></label>
                  <select id="modal_treem_id" name="modal_treem_id" class="custom-select" data-placeholder="Chọn trẻ em" required>
                    <option value=""></option>
                  </select>
                  <label class="error_modal" for="modal_treem_id"></label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Giới tính</label>
                  <input type="text" id="modal_gioitinh_id" name="modal_gioitinh_id" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Năm sinh</label>
                  <input type="number" id="modal_namsinh" name="modal_namsinh" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tình trạng học tập</label>
                  <input type="text" id="modal_tinhtranghoctap" name="modal_tinhtranghoctap" class="form-control" placeholder="Nhập tình trạng học tập">
                  <label class="error_modal" for="modal_tinhtranghoctap"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tình trạng sức khỏe</label>
                  <input type="text" id="modal_tinhtrangsuckhoe" name="modal_tinhtrangsuckhoe" class="form-control" placeholder="Nhập tình trạng sức khỏe">
                  <label class="error_modal" for="modal_tinhtrangsuckhoe"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nhóm hoàn cảnh<span class="text-danger">*</span></label>
                  <select id="modal_hoancanh" name="modal_hoancanh" class="custom-select" data-placeholder="Chọn nhóm hoàn cảnh" required>
                    <option value=""></option>
                    <?php if (is_array($this->hoancanh) && count($this->hoancanh) > 0) { ?>
                      <?php foreach ($this->hoancanh as $xp) { ?>
                        <option value="<?php echo $xp['id']; ?>" data-text="<?php echo htmlspecialchars($xp['tennhom']); ?>">
                          <?php echo htmlspecialchars($xp['tennhom']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_hoancanh"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Trợ giúp<span class="text-danger">*</span></label>
                  <select id="modal_trogiup" name="modal_trogiup" class="custom-select" data-placeholder="Chọn trợ giúp" required>
                    <option value=""></option>
                    <?php if (is_array($this->trogiup) && count($this->trogiup) > 0) { ?>
                      <?php foreach ($this->trogiup as $xp) { ?>
                        <option value="<?php echo $xp['id']; ?>" data-text="<?php echo htmlspecialchars($xp['tenhotro']); ?>">
                          <?php echo htmlspecialchars($xp['tenhotro']); ?>
                        </option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="">Không có dữ liệu</option>
                    <?php } ?>
                  </select>
                  <label class="error_modal" for="modal_trogiup"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nội dung hỗ trợ</label>
                  <input type="text" id="modal_noidung" name="modal_noidung" class="form-control" placeholder="Nhập nội dung">
                  <label class="error_modal" for="modal_noidung"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tình trạng<span class="text-danger">*</span></label>
                  <select id="modal_tinhtrang" name="modal_tinhtrang" class="custom-select" data-placeholder="Chọn tình trạng" required>
                    <option value=""></option>
                    <option value="1">Đã hỗ trợ</option>
                    <option value="2">Chưa hỗ trợ</option>
                  </select>
                  <label class="error_modal" for="modal_tinhtrang"></label>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="modal_hotrotreem" name="modal_hotrotreem" value="">
          <input type="hidden" id="modal_edit_index" name="modal_edit_index" value="">
          <input type="hidden" id="thanhviengiadinh_id" name="thanhviengiadinh_id" value="">
          <input type="hidden" id="modal_hoten" name="modal_hoten" value="">
          <input type="hidden" id="hogiadinh_id" name="hogiadinh_id" value="<?php echo htmlspecialchars($gdte_id); ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
      $('#modalTreEm select.custom-select').each(function() {
        initSelect2($(this), {
          width: '100%',
          allowClear: true,
          placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
          dropdownParent: $('#modalTreEm')
        });
      });
    }

    function fetchHouseholdMembers() {
      return new Promise((resolve, reject) => {
        const nhankhau_id = $('#nhankhau_id').val();
        if (!nhankhau_id || nhankhau_id == '0') {
          showToast('Không tìm thấy ID gia đình', false);
          $('#modal_treem_id').empty().append('<option value="">Không có dữ liệu</option>');
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
              const $treemSelect = $('#modal_treem_id');
              $treemSelect.empty().append('<option value=""></option>');

              response.forEach(member => {
                const option = `<option value="${member.nhankhau_id}" data-hoten="${member.hoten}" data-gioitinh="${member.gioitinh || ''}" data-namsinh="${member.namsinh || ''}">${member.hoten}</option>`;
                $treemSelect.append(option);
              });

              initializeModalSelect2();
              resolve(response);
            } else {
              showToast('Không tìm thấy thành viên gia đình', false);
              $('#modal_treem_id').empty().append('<option value="">Không có dữ liệu</option>');
              initializeModalSelect2();
              reject('Không tìm thấy thành viên gia đình');
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi lấy danh sách thành viên:', error);
            showToast('Lỗi khi lấy danh sách thành viên gia đình', false);
            $('#modal_treem_id').empty().append('<option value="">Không có dữ liệu</option>');
            initializeModalSelect2();
            reject(error);
          }
        });
      });
    }

    function loadTreEmList() {
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
          task: 'getTreEmList',
          giadinh_id: giadinh_id,
          '<?php echo JSession::getFormToken(); ?>': 1
        },
        dataType: 'json',
        success: function(response) {
          if (response.success && response.data && Array.isArray(response.data)) {
            $('.dsBaoluc').empty();
            if (response.data.length === 0) {
              $('.dsBaoluc').html('<tr class="no-data"><td colspan="10s" class="text-center">Không có dữ liệu</td></tr>');
              return;
            }

            response.data.forEach((item, index) => {
              const tinhtrangText = item.tinhtrang == 1 ? 'Đã hỗ trợ' : item.tinhtrang == 1 ? 'Chưa hỗ trợ' : '';
              const html = `
                        <tr>
                            <td class="align-middle text-center stt">${index + 1}</td>
                            <td class="align-middle">${item.hoten || ''}</td>
                            <td class="align-middle text-center">${item.tengioitinh || ''}</td>
                            <td class="align-middle text-center">${item.namsinh || ''}</td>
                            <td class="align-middle">${item.tinhtranghoctap || ''}</td>

                            <td class="align-middle">${item.tinhtrangsuckhoe || ''}</td>

                            <td class="align-middle">${item.tennhom || ''}</td>
                            <td class="align-middle">${item.noidunghotro || ''}</td>
                            <td class="align-middle">${item.tenhotro || ''}</td>

                            <td class="align-middle text-center" style="min-width:100px">
                                <input type="hidden" name="nhankhau_id[]" value="${item.nhankhau_id || ''}" />
                                <input type="hidden" name="hotrotreem_id[]" value="${item.id || ''}" />
                                <input type="hidden" name="hoten[]" value="${item.hoten || ''}" />
                                <input type="hidden" name="gioitinh_id[]" value="${item.tengioitinh || ''}" />
                                <input type="hidden" name="namsinh[]" value="${item.namsinh || ''}" />
                                <input type="hidden" name="tinhtranghoctap[]" value="${item.tinhtranghoctap || ''}" />
                                <input type="hidden" name="tinhtrangsuckhoe[]" value="${item.tinhtrangsuckhoe || ''}" />
                                <input type="hidden" name="tennhom[]" value="${item.nhomhoancanh_id || ''}" />
                                <input type="hidden" name="noidunghotro[]" value="${item.noidunghotro || ''}" />
                                <input type="hidden" name="tenhotro[]" value="${item.trogiup_id || ''}" />
                                <input type="hidden" name="tinhtrang[]" value="${item.tinhtrang || ''}" />
                                <span class="btn btn-sm btn-warning btn_edit_baoluc"><i class="fas fa-edit"></i></span>
                                <span class="btn btn-sm btn-danger btn_xoa_treem" data-treem-id="${item.id || ''}"><i class="fas fa-trash-alt"></i></span>
                            </td>
                        </tr>`;
              $('.dsBaoluc').append(html);
            });
          } else {
            $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
            showToast('Không tìm thấy dữ liệu trẻ em', false);
          }
        },
        error: function(xhr, status, error) {
          console.error('Lỗi khi tải danh sách bạo lực:', error);
          showToast('Lỗi khi tải danh sách trẻ em', false);
          $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
        }
      });
    }

    $('#modal_treem_id').on('change', function() {
      const selectedOption = $(this).find('option:selected');
      const hoten = selectedOption.data('hoten') || '';
      const gioitinh = selectedOption.data('gioitinh') || '';
      const namsinh = selectedOption.data('namsinh') || '';
      const nhankhau_id = $(this).val() || '';
      $('#thanhviengiadinh_id').val(nhankhau_id);

      $('#modal_hoten').val(hoten);
      $('#modal_gioitinh_id').val(gioitinh);
      $('#modal_namsinh').val(namsinh);
    });


    $('.date-picker').datepicker({
      autoclose: true,
      language: 'vi',
      format: 'dd/mm/yyyy'
    });

    if ($.fn.validate) {
      $('#frmmodalTreEm').validate({
        ignore: [],
        errorPlacement: function(error, element) {
          error.addClass('error_modal');
          error.appendTo(element.closest('.mb-3'));
        },
        success: function(label) {
          label.remove();
        },
        rules: {
          modal_treem_id: {
            required: true
          },

          modal_hoancanh: {
            required: true
          },
          modal_trogiup: {
            required: true
          },
          modal_tinhtrang: {
            required: true
          }
        },
        messages: {
          modal_treem_id: 'Vui lòng chọn người gây bạo lực',
          modal_hoancanh: 'Vui lòng chọn biện pháp xử lý',
          modal_trogiup: 'Vui lòng chọn biện pháp hỗ trợ',
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
        hotrotreem_id: $row.find('[name="hotrotreem_id[]"]').val() || '',
        nhankhau_id: $row.find('[name="nhankhau_id[]"]').val() || '', // Sử dụng hotrotreem_id làm nhankhau_id
        hoten: $row.find('[name="hoten[]"]').val() || '',
        gioitinh: $row.find('[name="gioitinh_id[]"]').val() || '',
        namsinh: $row.find('[name="namsinh[]"]').val() || '',
        tinhtranghoctap: $row.find('[name="tinhtranghoctap[]"]').val() || '',
        tinhtrangsuckhoe: $row.find('[name="tinhtrangsuckhoe[]"]').val() || '',
        hoancanh_id: $row.find('[name="tennhom[]"]').val() || '',
        noidung: $row.find('[name="noidunghotro[]"]').val() || '',
        trogiup_id: $row.find('[name="tenhotro[]"]').val() || '',
        tinhtrang: $row.find('[name="tinhtrang[]"]').val() || ''
      };

      $('#modalTreEmLabel').text('Chỉnh sửa thông tin trẻ em');
      $('#frmmodalTreEm')[0].reset();

      // Gán giá trị vào các trường
      $('#modal_hotrotreem').val(data.hotrotreem_id);

      $('#thanhviengiadinh_id').val(data.nhankhau_id);
      $('#modal_edit_index').val($row.index());
      $('#modal_tinhtranghoctap').val(data.tinhtranghoctap);
      $('#modal_tinhtrangsuckhoe').val(data.tinhtrangsuckhoe);
      $('#modal_hoancanh').val(data.hoancanh_id);
      $('#modal_trogiup').val(data.trogiup_id);
      $('#modal_noidung').val(data.noidung);
      $('#modal_tinhtrang').val(data.tinhtrang);
      $('#modal_treem_id').val(data.nhankhau_id);
      $('#modal_gioitinh_id').val(data.gioitinh);
      $('#modal_namsinh').val(data.namsinh);

      // Tải danh sách thành viên và gán giá trị select box
      fetchHouseholdMembers().then(() => {
        // $('#modal_hotrotreem').val(data.nhankhau_id).trigger('change.select2');
        $('#modal_hoancanh').trigger('change.select2');
        $('#modal_trogiup').trigger('change.select2');
        $('#modal_tinhtrang').trigger('change.select2');
        $('#modal_treem_id').val(data.nhankhau_id).trigger('change.select2');

        // Đảm bảo giữ giá trị từ dữ liệu hàng
        // $('#modal_treem_id').val(data.nhankhau_id);
        $('#modal_gioitinh_id').val(data.gioitinh);
        $('#modal_namsinh').val(data.namsinh);

        $('#modalTreEm').modal('show');
      }).catch(error => {
        console.error('Lỗi khi tải danh sách thành viên:', error);
        showToast('Lỗi khi tải danh sách thành viên gia đình', false);
        $('#modalTreEm').modal('show');
      });
    });

    $('#btn_luu_baoluc').on('click', function() {
      const $form = $('#frmmodalTreEm');
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
          url: '<?php echo JRoute::_('index.php?option=com_vhytgd&controller=giadinhtreem&task=saveTreEm'); ?>',
          type: 'POST',
          data: data,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Sau khi lưu thành công, làm mới danh sách bạo lực
              loadTreEmList();
              showToast('Lưu thông tin trẻ em thành công', true);
              $('#modalTreEm').modal('hide');
            } else {
              showToast('Lưu thông tin trẻ em thất bại: ' + (response.message || 'Lỗi không xác định'), false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi lưu:', error);
            showToast('Lỗi khi lưu thông tin trẻ em', false);
          }
        });
      } else {
        showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
      }
    });

    $('.dsBaoluc').on('click', '.btn_xoa_treem', function() {
      const $row = $(this).closest('tr');
      const hotrotreem_id = $(this).data('treem-id');

      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span style="font-size:18px;">Bạn có chắc chắn muốn xóa thông tin trẻ em này?</span>',
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
            const response = await $.post('index.php', {
              option: 'com_vhytgd',
              controller: 'giadinhtreem',
              task: 'delThongtinTreem',
              hotrotreem_id: hotrotreem_id,
              '<?php echo JSession::getFormToken(); ?>': 1
            }, null, 'json');

            if (response.success) {
              $row.remove();
              updateBaoLucSTT();
              showToast('Xóa thông tin trẻ em thành công', true);
              if ($('.dsBaoluc tr').length === 0) {
                $('.dsBaoluc').html('<tr class="no-data"><td colspan="10" class="text-center">Không có dữ liệu</td></tr>');
              }
            } else {
              showToast(
                'Xóa thông tin trẻ em thất bại: ' + (response.message || 'Lỗi không xác định'),
                false
              );
            }
          } catch (error) {
            console.error('Lỗi khi xóa:', error);
            showToast('Lỗi khi xóa thông tin trẻ em', false);
          }
        }
      });
    });


    $('.btn-thembaoluc').on('click', function(e) {
      e.preventDefault();
      $('#modalTreEmLabel').text('Thêm thông tin trẻ em');
      $('#frmmodalTreEm')[0].reset();
      $('#modal_treem_id').val('');
      $('#modal_edit_index').val('');
      $('#modal_hoten').val('');
      $('#modal_gioitinh_id').val('');
      $('#modal_namsinh').val('');
      $('#modal_hoten_nannhan').val('');
      $('#modal_gioitinh_nannhan').val('');
      $('#modal_namsinh_nannhan').val('');
      $('#modal_hoancanh').val('');
      $('#modal_trogiup').val('');
      $('#modal_noidung').val('');
      $('#modal_mavuviec').val('');
      $('#modal_ngayxuly').val('');
      $('#modal_tinhtrang').val('');
      initializeModalSelect2();
      fetchHouseholdMembers();
      $('#modalTreEm').modal('show');
    });

    // Tải danh sách bạo lực khi trang được tải
    loadTreEmList();
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

  /* CSS cụ thể cho #modalTreEm */
  #modalTreEm .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 20px;
    word-break: break-word;
  }

  #modalTreEm .select2-container .select2-selection--single {
    height: 38px;
  }

  #modalTreEm .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px;
    padding-left: 8px;
  }

  #modalTreEm .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
  }

  #modalTreEm {
    overflow-x: hidden;
  }

  #modalTreEm .modal-dialog {
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

  #modalTreEm.show .modal-dialog {
    transform: translateX(0);
  }

  #modalTreEm.fade .modal-dialog {
    transition: transform 0.5s ease-in-out;
    opacity: 1;
  }

  #modalTreEm.fade:not(.show) .modal-dialog {
    transform: translateX(100%);
  }

  #modalTreEm .modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  #modalTreEm .error_modal {
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

  #modalTreEm .mb-3 {
    margin-bottom: 0rem !important;

  }
</style>