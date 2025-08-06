<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('jquery.framework');

$chucNang = $this->chucNang;

$khuVuc = $this->dmKhuvuc;
$user = $this->user;
?>

<div class="container my-3">
  <div class="content-box">
    <form action="<?= Route::_('index.php?option=com_quantrihethong&task=quantrihethong.saveInfoAccount ') ?>" id="accountForm" name="accountForm" method="post">
      <div class="form-header">
        <h2 class="text-primary">
          <?php echo ((int)$user['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> tài khoản
        </h2>
        <div class="button-action">
          <button id="btn_luu_themmoi" type="submit" class="btn btn-small btn-success"><i class="fa fa-save"></i> Lưu và thêm mới</button>
          <button id="btn_luu_quaylai" type="submit" class="btn btn-small btn-primary"><i class="fa fa-save"></i> Lưu và quay lại</button>
          <a id="btn_quaylai" href="/index.php/component/quantrihethong/?view=quantrihethong&task=ds_taikhoan" class="btn btn-small btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
      </div>
      <input type="hidden" name="id" id="id" value="<?php echo $user['id']; ?>" require>
      <div class="formGroup">
        <label for="name">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control"
          value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Nhập họ và tên" />
      </div>
      <div class="formGroup">
        <label for="username">Tên tài khoản <span class="text-danger">*</span></label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Nhập tên đăng nhập"
          value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" />
      </div>
      <div class="formGroup">
        <label for="password">Mật khẩu <?php if ((int)$user['id'] == 0): ?><span class="text-danger">*</span><?php endif; ?></label>
        <input type="password" id="password" name="password" class="form-control"
          title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm 1 chữ in hoa, 1 số và 1 ký tự đặc biệt (!@#$%^&*)"
          placeholder="<?php echo ((int)$user['id'] > 0) ? 'Để trống nếu không đổi mật khẩu' : 'Nhập mật khẩu'; ?>" />
      </div>
      <div class="formGroup">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email"
          value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" />
      </div>
      <div class="formGroup">
        <label for="chucnang">Chức năng sử dụng <span class="text-danger">*</span></label>
        <select id="chucnang" name="chucnang[]" class="form-control" multiple="multiple">
          <?php foreach ($chucNang as $cn): ?>
            <option value="<?php echo $cn->id; ?>">
              <?php echo htmlspecialchars($cn->title); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <label for="chucnang" class="error"></label>
      </div>

      <div class="formGroup">
        <label for="donviquanly">Đơn vị quản lý <span class="text-danger">*</span></label>
        <div class="phuongxa">
          <select id="phuongxa" name="phuongxa[]" class="form-control" multiple="multiple">
            <?php foreach ($khuVuc as $px): ?>
              <?php if ($px['level'] == 2): ?>
                <option value="<?php echo $px['id']; ?>">
                  <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
                </option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
          <label for="phuongxa" class="error"></label>
        </div>
        <div class="thonto">
          <select id="thonto" name="thonto[]" class="form-control" multiple="multiple">
            <!-- Thôn/Tổ sẽ được load động theo phường/xã bằng jQuery/Ajax -->
          </select>
          <label for="thonto" class="error"></label>
        </div>
      </div>

      <div class="formGroup">
        <label for="requireresetpassword">Yêu cầu đổi mật khẩu</label>
        <label class="custom-toggle">
          <input type="checkbox" class="requireReset"
            <?php echo ($user['requireReset'] == 1) ? 'checked' : ''; ?>>
          <span class="slider"></span>
          <input type="hidden" id="requireReset" name="requireReset" value="<?php echo ($user['requireReset'] == 1) ? '1' : '0'; ?>">
        </label>
      </div>
      <?php echo HTMLHelper::_('form.token'); ?>
    </form>
    <input type="hidden" name="action" value="<?php echo ((int)$user['id'] > 0) ? 'edit' : 'create'; ?>">
  </div>
</div>
<style>
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: #495057;
  }

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
  }

  .form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
  }

  .formGroup {
    margin-bottom: 20px;
  }

  .formGroup label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  .formGroup .required {
    color: red;
  }

  .select-dv label {
    display: block;
    margin-bottom: 5px;
  }

  .dropdown.show {
    display: block
  }

  .select-checkbox-container {
    position: relative;
    width: 100%;
    font-family: Tahoma, sans-serif;
    margin-bottom: 10px;
  }

  .select-checkbox {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    background: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 38px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .dropdown {
    position: absolute;
    bottom: 100%;
    left: 0;
    right: 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
    max-height: 200px;
    overflow-y: auto;
    overflow-X: auto;
    display: none;
    z-index: 100;
  }

  .option {
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .option:hover {
    background: #f0f0f0;
  }

  .option input {
    margin: 0;
  }

  .select-checkbox::after {
    content: '▼';
    font-size: 12px;
  }

  .select-all-option {
    padding: 10px;
    background: #e8e8e8;
    font-weight: bold;
  }

  .content-box {
    padding: 0px 20px;
  }

  .content-wrapper {
    background-color: #fff;
  }

  .custom-select {
    position: relative;
    width: 100%;
  }

  .options-container {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    border: 1px solid #ccc;
    border-top: none;
    max-height: 250px;
    overflow-y: auto;
    background: white;
    display: none;
    z-index: 1000;
  }

  .option {
    padding: 8px 10px;
    display: flex;
    align-items: center;
  }

  .option:hover {
    background: #f0f0f0;
  }

  .option input[type="checkbox"] {
    margin-right: 8px;
  }

  .select-all {
    border-bottom: 1px solid #ddd;
    background: #f9f9f9;
    padding: 8px 10px;
    font-weight: bold;
  }

  .formGroup .chosen-container,
  .formGroup .chosen-choices .search-choice span {
    font-size: 15px;
    font-weight: 400;
    line-height: 1.5;
    color: #495057
  }

  .formGroup .chosen-choices {
    padding: 3px 10px;
    border-radius: 3px;
    vertical-align: middle;
  }

  .formGroup .chosen-choices .search-choice {
    padding: 0px 20px 0px 5px !important;
    margin: 0px 5px 0px 0px !important;
  }

  .formGroup .chosen-choices .search-choice .search-choice-close {
    top: 6px !important
  }

  .custom-toggle {
    position: relative;
    width: 60px;
    height: 30px;
  }

  .custom-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #888;
    transition: 0.4s;
    border-radius: 30px;
  }

  .slider:before {
    position: absolute;
    content: "✕";
    height: 24px;
    width: 24px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    font-size: 15px;
    color: #888;
  }

  input:checked+.slider {
    background-color: #007bff;
  }

  input:checked+.slider:before {
    transform: translateX(30px);
    content: "✓";
    color: #007bff;
  }

  .text-danger {
    font-size: 0.875rem;
    margin-top: 5px;
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>

<script>
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

  $(document).ready(function() {
    const khuVucData = <?php echo json_encode($khuVuc); ?>;
    const userData = <?php echo json_encode($user); ?>;
    const chucNang = <?php echo json_encode($chucNang); ?>;

    const phuongxaData = khuVucData.filter(item => item.level === 2);
    const thontoData = khuVucData.filter(item => item.level === 3);
    const editData = {
      group_id: <?php echo json_encode($user["group_ids"] ?? []); ?>,
      phuongxa_id: <?php echo json_encode($user["phuongxa_id"] ?? ''); ?>,
      thonto_id: <?php echo json_encode($user["thonto_id"] ?? ''); ?>
    };
    console.log(editData)

    $('#chucnang').select2({
      placeholder: '--- Hãy chọn chức năng ---',
      allowClear: true,
      width: '100%'
    });
    $('#phuongxa').select2({
      placeholder: '--- Hãy chọn phường xã ---',
      allowClear: true,
      width: '100%'
    });
    $('#thonto').select2({
      placeholder: '--- Hãy chọn thôn tổ ---',
      allowClear: true,
      width: '100%'
    });
    $('#phuongxa').on('change', function() {
      const selectedPhuongXa = $(this).val() || [];

      const filteredThonTo = thontoData.filter(item =>
        selectedPhuongXa.includes(String(item.cha_id))
      );

      const $thonto = $('#thonto');
      $thonto.empty();

      // Thêm option "Chọn tất cả"
      $thonto.append(new Option('-- Chọn tất cả --', 'all', false, false));

      // Thêm các option thôn/tổ
      filteredThonTo.forEach(item => {
        $thonto.append(new Option(item.tenkhuvuc, item.id, false, false));
      });

      $thonto.trigger('change');
    })

    $('#thonto').on('change', function() {
      const selected = $(this).val() || [];
      const $options = $('#thonto option').not('[value="all"]'); // tất cả option trừ "all"
      const allOptionSelected = selected.includes('all');

      // Tổng số option thực sự (trừ all)
      const totalCount = $options.length;
      // Số lượng đang được chọn (trừ all nếu có)
      const selectedCount = selected.filter(v => v !== 'all').length;

      if (allOptionSelected) {
        // Nếu chưa chọn hết thì chọn hết
        if (selectedCount < totalCount) {
          const allValues = $options.map(function() {
            return $(this).val();
          }).get();
          $('#thonto').val(allValues).trigger('change.select2');
        } else {
          // Nếu đang chọn hết thì bỏ chọn hết
          $('#thonto').val([]).trigger('change.select2');
        }
      }
    });

    if (editData.group_id && editData.group_id.length > 0) {
      $('#chucnang').val(editData.group_id).trigger('change');
    }

    // Phường/Xã chỉ có 1 giá trị nên mình đưa vào mảng
    if (editData.phuongxa_id) {
      let pxArr = String(editData.phuongxa_id).split(',').map(v => v.trim()).filter(v => v !== '');
      if (pxArr.length > 0) {
        $('#phuongxa').val(pxArr).trigger('change');
      }
    }

    // Chuyển thonto_id thành mảng
    if (editData.thonto_id) {
      let thonArr = String(editData.thonto_id).split(',').map(v => v.trim()).filter(v => v !== '' && v !== 'on');
      if (thonArr.length > 0) {
        // Nếu bạn load thôn/tổ theo phường/xã thì cần delay chút để dữ liệu thôn tổ load xong
        setTimeout(() => {
          $('#thonto').val(thonArr).trigger('change');
        }, 300); // thời gian delay tùy chỉnh
      }
    }
    // validate họ tên
    $.validator.addMethod(
      "validName",
      function(value, element) {
        return this.optional(element) || /^[A-Za-zÀ-ỹ\s]+$/.test(value);
      },
      "Họ và tên chỉ được chứa chữ cái và khoảng trắng"
    );

    // validate username 
    $.validator.addMethod(
      "validUsername",
      function(value, element) {
        return this.optional(element) || /^[A-Za-z0-9_]+$/.test(value);
      },
      "Tên tài khoản chỉ được chứa chữ cái, số, dấu gạch dưới"
    );

    // validate password
    $.validator.addMethod(
      "strongPassword",
      function(value, element) {
        // cho phép bỏ trống khi update
        return (
          this.optional(element) ||
          /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/.test(value)
        );
      },
      "Mật khẩu phải có ít nhất 8 ký tự, gồm 1 chữ in hoa, 1 số và 1 ký tự đặc biệt"
    );

    // Validate form chính
    $('#accountForm').validate({
      ignore: [], // để không bỏ qua select2
      rules: {
        name: {
          required: true,
          minlength: 3,
          validName: true
        },
        username: {
          required: true,
          minlength: 5,
          validUsername: true
        },
        password: {
          required: function() {
            // chỉ bắt buộc nếu action=create
            return $('input[name="action"]').val() === 'create';
          },
          strongPassword: true
        },
        email: {
          required: true,
          email: true
        },
        'chucnang[]': {
          required: true
        },
        'phuongxa[]': {
          required: true
        },
        'thonto[]': {
          required: true
        }
      },
      messages: {
        name: {
          required: 'Vui lòng nhập tên',
          minlength: 'Họ và tên quá ngắn'
        },
        username: {
          required: 'Vui lòng nhập tên người dùng',
          minlength: 'Tên người dùng quá ngắn'
        },
        password: {
          required: 'Vui lòng nhập mật khẩu'
        },
        email: {
          required: 'Vui lòng nhập email',
          email: 'Vui lòng nhập email hợp lệ'
        },
        'chucNang[]': 'Vui lòng chọn chức năng sử dụng',
        'phuongxa[]': 'Vui lòng chọn Phường/Xã',
        'thonto[]': 'Vui lòng chọn Thôn/Tổ'
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
    let redirectAfterSave = 'back'; // mặc định
    $('#accountForm button[type="submit"]').on('click', function() {
      redirectAfterSave = $(this).val(); // lấy giá trị new/back
    });
    $('#accountForm').on('submit', function(e) {
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
              if (redirectAfterSave === 'new') {
                // Lưu và thêm mới
                window.location.href = '/index.php/component/quantrihethong/?view=quantrihethong&task=edit_user';
              } else {
                // Lưu và quay lại
                window.location.href = '/index.php/component/quantrihethong/?view=quantrihethong&task=default';
              }
            }, 500);
          }
        },
        error(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });
  })
</script>