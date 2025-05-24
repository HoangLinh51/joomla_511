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
    <div class="form-header">
      <h2 class="text-primary">
        <?php echo ((int)$user['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> tài khoản
      </h2>
      <div class="button-action">
        <button id="btn_luu_themmoi" class="btn btn-small btn-success"><i class="fa fa-save"></i> Lưu và thêm mới</button>
        <button id="btn_luu_quaylai" class="btn btn-small btn-primary"><i class="fa fa-save"></i> Lưu và quay lại</button>
        <button id="btn_quaylai" class="btn btn-small btn-secondary"><i class="fa fa-share"></i> Quay lại</button>
      </div>
    </div>
    <form action="<?= Route::_('index.php?option=com_quantrihethong&task=quantrihethong.save_user ') ?>" id="accountForm" name="accountForm" method="post">
      <input type="hidden" name="id" id="id" value="<?php echo $user['id']; ?>">
      <div class="formGroup">
        <label for="name">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>"
          required pattern="[A-Za-zÀ-ỹ\s]+" oninput="validateName(this)"
          title="Họ và tên chỉ được chứa chữ cái và khoảng trắng">
        <span id="nameError" class="text-danger"></span>
      </div>
      <div class="formGroup">
        <label for="username">Tên tài khoản <span class="text-danger">*</span></label>
        <input type="text" id="username" name="username" class="form-control" required pattern="[A-Za-z0-9_]{3,20}"
          value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>"
          title="Tên tài khoản chỉ được chứa chữ cái, số, dấu gạch dưới, từ 3 đến 20 ký tự"
          oninput="validateUsername(this)">
        <span id="usernameError" class="text-danger"></span>
      </div>
      <div class="formGroup">
        <label for="password">Mật khẩu <span class="text-danger">*</span></label>
        <input type="password" id="password" name="password" class="form-control" required
          pattern="(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}"
          title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm 1 chữ in hoa, 1 số và 1 ký tự đặc biệt (!@#$%^&*)"
          oninput="validatePassword(this)">
        <span id="passwordError" class="text-danger"></span>
      </div>
      <div class="formGroup">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
          oninput="validateEmail(this)" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
          title="Vui lòng nhập địa chỉ email hợp lệ (ví dụ: example@domain.com)">
        <span id="emailError" class="text-danger"></span>
      </div>
      <div class="formGroup">
        <label for="chucnang">Chức năng sử dụng <span class="text-danger">*</span></label>
        <div class="select-checkbox-container">
          <div class="select-checkbox" id="chucnang_select">-- Hãy chọn chức năng sử dụng --</div>
          <div class="dropdown" id="chucnang-dropdown">
            <?php foreach ($chucNang as $cn): ?>
              <label class="option">
                <input type="checkbox" class="chucNang" value="<?php echo $cn->id; ?>" onchange="validateChucNang()">
                <?php echo htmlspecialchars($cn->title); ?>
              </label>
            <?php endforeach; ?>
            <input type="hidden" id="chucNang" name="chucNang" required>
          </div>
        </div>
        <span id="chucNangError" class="text-danger"></span>
      </div>
      <div class="formGroup">
        <label for="donviquanly">Đơn vị quản lý <span class="text-danger">*</span></label>
        <div class="select-dv">
          <div class="select-checkbox-container">
            <div class="select-checkbox" id="phuongxa_select">-- Chọn Phường/Xã --</div>
            <div class="dropdown" id="phuongXa-dropdown">
              <?php foreach ($khuVuc as $px): ?>
                <?php if ($px['level'] == 2): ?>
                  <label class="option">
                    <input type="checkbox" class="phuongXa" value="<?php echo $px['id']; ?>"
                      onchange="validatePhuongXa(); loadThonTo()">
                    <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
                  </label>
                <?php endif; ?>
              <?php endforeach; ?>
              <input type="hidden" id="phuongXa" name="phuongXa" required>
            </div>
            <span id="phuongXaError" class="text-danger"></span>
          </div>

          <div class="select-checkbox-container">
            <div class="select-checkbox" id="thonto_select">-- Chọn Thôn/Tổ --</div>
            <div class="dropdown" id="thonTo_dropdown">
              <label class="option select-all-option">
                <input type="checkbox" id="select-all-thon-to"> Chọn tất cả
              </label>
              <input type="hidden" id="thonTo" name="thonTo">
              <!-- Thôn/Tổ options sẽ được thêm động bằng jQuery -->
            </div>
          </div>
        </div>
      </div>

      <div class="formGroup">
        <label for="requireresetpassword">Yêu cầu đổi mật khẩu</label>
        <label class="custom-toggle">
          <input type="checkbox" class="requireReset" <?php echo ($user['requireReset'] == 1) ? 'checked' : ''; ?>>
          <span class="slider"></span>
          <input type="hidden" id="requireReset" name="requireReset">
        </label>

      </div>
      <?php echo HTMLHelper::_('form.token'); ?>
    </form>
  </div>
</div>
<style>
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
    top: 100%;
    left: 0;
    right: 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: white;
    max-height: 200px;
    overflow-y: auto;
    display: none;
    z-index: 1000;
  }

  .dropdown.show {
    display: block;
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
    font-size: 16px;
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
    font-size: 16px;
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
</style>

<script>
  function showToast(message, isSuccess = true) {
    const toast = $('<div></div>')
      .text(message)
      .css({
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: isSuccess ? '#28a745' : '#dc3545',
        color: 'white',
        padding: '10px 20px',
        borderRadius: '5px',
        boxShadow: '0 0 10px rgba(0,0,0,0.3)',
        zIndex: 9999
      })
      .appendTo('body');

    setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
  }

  function setValidation(input, errorElement, message = '') {
    errorElement.textContent = message;
    input.setCustomValidity(message);
  }

  function validateName(input) {
    const value = input.value.trim();
    const errorElement = document.getElementById('nameError');

    if (value.length < 2) return setValidation(input, errorElement, 'Họ và tên phải có ít nhất 2 ký tự');
    if (value.length > 50) return setValidation(input, errorElement, 'Họ và tên không được vượt quá 50 ký tự');
    if (!/^[A-Za-zÀ-ỹ\s]+$/.test(value)) return setValidation(input, errorElement, 'Họ và tên chỉ được chứa chữ cái và khoảng trắng');

    setValidation(input, errorElement);
  }

  function validateUsername(input) {
    const value = input.value.trim();
    const errorElement = document.getElementById('usernameError');

    if (value.length < 5) return setValidation(input, errorElement, 'Tên tài khoản phải có ít nhất 5 ký tự');
    if (value.length > 20) return setValidation(input, errorElement, 'Tên tài khoản không được vượt quá 20 ký tự');
    if (!/^[A-Za-z0-9_]+$/.test(value)) return setValidation(input, errorElement, 'Chỉ dùng chữ, số, gạch dưới');
    if (/^[0-9_]/.test(value)) return setValidation(input, errorElement, 'Tên tài khoản phải bắt đầu bằng chữ cái');

    setValidation(input, errorElement);
  }

  function validatePassword(input) {
    const value = input.value;
    const errorElement = document.getElementById('passwordError');

    if (value.length < 8) return setValidation(input, errorElement, 'Mật khẩu phải có ít nhất 8 ký tự');
    if (value.length > 50) return setValidation(input, errorElement, 'Mật khẩu không được vượt quá 50 ký tự');
    if (!/[A-Z]/.test(value)) return setValidation(input, errorElement, 'Phải có ít nhất 1 chữ in hoa');
    if (!/[0-9]/.test(value)) return setValidation(input, errorElement, 'Phải có ít nhất 1 số');
    if (!/[!@#$%^&*]/.test(value)) return setValidation(input, errorElement, 'Phải có ít nhất 1 ký tự đặc biệt (!@#$%^&*)');

    setValidation(input, errorElement);
  }

  function validateEmail(input) {
    const value = input.value.trim();
    const errorElement = document.getElementById('emailError');
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!value) return setValidation(input, errorElement, 'Email là bắt buộc');
    if (!emailPattern.test(value)) return setValidation(input, errorElement, 'Email không hợp lệ');
    if (value.length > 100) return setValidation(input, errorElement, 'Email không được vượt quá 100 ký tự');

    setValidation(input, errorElement);
  }

  function validateCheckboxGroup({
    checkboxSelector,
    hiddenInputId,
    errorId,
    selectTextId,
    placeholder,
    label
  }) {
    const checkboxes = document.querySelectorAll(checkboxSelector);
    const hiddenInput = document.getElementById(hiddenInputId);
    const errorElement = document.getElementById(errorId);
    const selectText = document.getElementById(selectTextId);

    const selected = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    hiddenInput.value = selected.join(',');

    selectText.textContent = selected.length > 0 ? `${selected.length} ${label} được chọn` : placeholder;

    if (selected.length === 0) {
      setValidation(hiddenInput, errorElement, `Vui lòng chọn ít nhất một ${label}`);
    } else {
      setValidation(hiddenInput, errorElement);
    }
  }

  function validateChucNang() {
    validateCheckboxGroup({
      checkboxSelector: '.chucNang',
      hiddenInputId: 'chucNang',
      errorId: 'chucNangError',
      selectTextId: 'chucnang_select',
      placeholder: '-- Hãy chọn chức năng sử dụng --',
      label: 'chức năng'
    });
  }


  function validatePhuongXa() {
    const checkboxes = document.querySelectorAll('.phuongXa:checked');
    const hiddenInput = document.getElementById('phuongXa');
    const errorElement = document.getElementById('phuongXaError');

    if (checkboxes.length === 0) {
      errorElement.textContent = 'Vui lòng chọn ít nhất một Phường/Xã';
      hiddenInput.setCustomValidity('Vui lòng chọn ít nhất một Phường/Xã');
    } else {
      errorElement.textContent = '';
      hiddenInput.setCustomValidity('');
    }
  }

  function validateThonTo() {
    const checkboxes = document.querySelectorAll('.thonTo:checked');
    const hiddenInput = document.getElementById('thonTo');
    const errorElement = document.getElementById('thonToError');

    if (checkboxes.length === 0) {
      errorElement.textContent = 'Vui lòng chọn ít nhất một Thôn/Tổ';
      hiddenInput.setCustomValidity('Vui lòng chọn ít nhất một Thôn/Tổ');
    } else {
      errorElement.textContent = '';
      hiddenInput.setCustomValidity('');
    }
  }




  $(document).ready(function() {
    // Dữ liệu từ PHP
    const khuVucData = <?php echo json_encode($khuVuc); ?>;
    const userData = <?php echo json_encode($user); ?>;
    const chucNang = <?php echo json_encode($chucNang); ?>;
    const editData = {
      group_id: <?php echo json_encode($user["group_ids"] ?? []); ?>,
      phuongxa_id: <?php echo json_encode($user["phuongxa_id"] ?? ''); ?>,
      thonto_id: <?php echo json_encode($user["thonto_id"] ?? ''); ?>
    };

    // Bộ nhớ đệm các phần tử jQuery
    const $chucnangDropdown = $('#chucnang-dropdown');
    const $chucnangSelect = $('#chucnang_select');
    const $phuongXaDropdown = $('#phuongXa-dropdown');
    const $phuongXaSelect = $('#phuongxa_select');
    const $thonToDropdown = $('#thonTo_dropdown');
    const $thonToSelect = $('#thonto_select');
    const $selectAllThonTo = $('#select-all-thon-to');

    // Lọc khu vực theo level
    const filterKhuVuc = (data, level) => data.filter(item => item.level === level);
    const phuongXaData = filterKhuVuc(khuVucData, 2);
    const thonToData = filterKhuVuc(khuVucData, 3);

    // Mở/đóng dropdown
    const toggleDropdown = ($select, $dropdown) => {
      const $allDropdowns = $('.dropdown');
      const isOpen = $dropdown.hasClass('show');
      $allDropdowns.removeClass('show');
      if (!isOpen) $dropdown.addClass('show');
    };

    // Cập nhật hiển thị cho dropdown
    const updateSelection = ($dropdown, $select, placeholder) => {
      const selectedLabels = $dropdown.find('input:checked:not(#select-all-thon-to)')
        .map((_, el) => $(el).parent().text().trim()).get();
      $select.html(selectedLabels.length > 0 ? selectedLabels.join(', ') : placeholder)
        .append('<span></span>');
    };

    // Cập nhật giá trị hidden input
    const updateHiddenInput = ($dropdown, hiddenInputId) => {
      const selectedIds = $dropdown.find('input:checked:not(#select-all-thon-to)')
        .map((_, el) => $(el).val()).get();
      $(hiddenInputId).val(selectedIds.join(','));
    };

    // Cập nhật tùy chọn Thôn/Tổ
    const updateThonToOptions = (selectedPhuongXaIds) => {
      $thonToDropdown.find('.option:not(.select-all-option)').remove();
      const thonToOptions = thonToData.filter(item => selectedPhuongXaIds.includes(String(item.cha_id)));
      thonToOptions.forEach(item => {
        $thonToDropdown.append(`
                <label class="option">
                    <input type="checkbox" class="thonTo" value="${item.id}">
                    ${item.tenkhuvuc}
                </label>
            `);
      });

      // Tích chọn Thôn/Tổ nếu đang ở chế độ chỉnh sửa
      if (editData.thonto_id) {
        const thontoIds = editData.thonto_id.split(',').map(id => id.trim());
        thontoIds.forEach(id => {
          $thonToDropdown.find(`input[value="${id}"]`).prop('checked', true);
        });
      }

      updateThonToSelection();
    };

    // Cập nhật hiển thị và trạng thái "Chọn tất cả" cho Thôn/Tổ
    const updateThonToSelection = () => {
      updateSelection($thonToDropdown, $thonToSelect, '-- Chọn Thôn/Tổ --');
      const $allCheckboxes = $thonToDropdown.find('input:not(#select-all-thon-to)');
      $selectAllThonTo.prop('checked',
        $allCheckboxes.length > 0 && $allCheckboxes.filter(':checked').length === $allCheckboxes.length
      );
      updateHiddenInput($thonToDropdown, '#thonTo');
    };

    // Đóng dropdown khi click bên ngoài
    $(document).on('click', e => {
      if (!$(e.target).closest('.select-checkbox-container').length) {
        $('.dropdown').removeClass('show');
      }
    });

    // Xử lý sự kiện dropdown
    const setupDropdownEvents = ($select, $dropdown, placeholder, hiddenInputId, onChange) => {
      $select.on('click', () => toggleDropdown($select, $dropdown));
      $dropdown.on('change', 'input', () => {
        updateSelection($dropdown, $select, placeholder);
        updateHiddenInput($dropdown, hiddenInputId);
        if (onChange) onChange();
      });
    };

    // Thiết lập sự kiện cho các dropdown
    setupDropdownEvents($chucnangSelect, $chucnangDropdown, '-- Hãy chọn chức năng sử dụng --', '#chucNang');
    setupDropdownEvents($phuongXaSelect, $phuongXaDropdown, '-- Chọn Phường/Xã --', '#phuongXa', () => {
      const selectedIds = $phuongXaDropdown.find('input:checked').map((_, el) => $(el).val()).get();
      updateThonToOptions(selectedIds);
    });
    setupDropdownEvents($thonToSelect, $thonToDropdown, '-- Chọn Thôn/Tổ --', '#thonTo');

    // Xử lý "Chọn tất cả" cho Thôn/Tổ
    $selectAllThonTo.on('change', function() {
      $thonToDropdown.find('input:not(#select-all-thon-to)').prop('checked', this.checked);
      updateThonToSelection();
    });

    // Khởi tạo trạng thái chỉnh sửa
    const initializeEditState = () => {
      // Chức năng
      if (Array.isArray(editData.group_id) && editData.group_id.length) {
        editData.group_id.forEach(id => {
          $chucnangDropdown.find(`input[value="${id}"]`).prop('checked', true);
        });
        updateSelection($chucnangDropdown, $chucnangSelect, '-- Hãy chọn chức năng sử dụng --');
        updateHiddenInput($chucnangDropdown, '#chucNang');
      }

      // Phường/Xã
      if (editData.phuongxa_id) {
        const phuongxaIds = editData.phuongxa_id.split(',').map(id => id.trim());
        phuongxaIds.forEach(id => {
          $phuongXaDropdown.find(`input[value="${id}"]`).prop('checked', true);
        });
        updateSelection($phuongXaDropdown, $phuongXaSelect, '-- Chọn Phường/Xã --');
        updateHiddenInput($phuongXaDropdown, '#phuongXa');
        updateThonToOptions(phuongxaIds);
      }
    };

    // Khởi chạy
    initializeEditState();

    function submitForm(redirectAfterSave) {
      const form = document.getElementById('accountForm');
      let selectedChucNang = [];
      let selectedPhuongXa = [];
      let selectedThonTo = [];
      $('#chucnang-dropdown input[class="chucNang"]:checked').each(function() {
        let item = $(this).val();
        selectedChucNang.push(item);
      });
      $('#phuongXa-dropdown input[class="phuongXa"]:checked').each(function() {
        let item = $(this).val();
        selectedPhuongXa.push(item);
      });
      $('#thonTo_dropdown input[class="thonTo"]:checked').each(function() {
        let item = $(this).val();
        selectedThonTo.push(item);
      });
      let requireReset = $('input[class="requireReset"]').is(':checked')

      if (requireReset) {
        requireReset = 1;
      } else {
        requireReset = 0;
      }

      $('#chucNang').val(selectedChucNang)
      $('#phuongXa').val(selectedPhuongXa)
      $('#thonTo').val(selectedThonTo)
      $('#requireReset').val(requireReset)

      const formData = new FormData(form);

      fetch(form.action, {
          method: 'POST',
          body: formData,
        })
        .then(response => response.json())
        .then(data => {
          const isSuccess = data.success ?? true;
          showToast(data.message || 'Lưu dữ liệu thành công', isSuccess);
          if (isSuccess && redirectAfterSave === 'new') {
            setTimeout(() => {
              window.location.href = '/index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user';
            }, 500);
          } else if (isSuccess && redirectAfterSave === 'back') {
            setTimeout(() => {
              window.location.href = '/index.php/component/quantrihethong/?view=quantrihethong&task=default';
            }, 500);
          }
        })
        .catch(err => {
          console.error('Lỗi gửi dữ liệu:', err);
          showToast('Gửi dữ liệu thất bại', false);
        });
    }

    $('#btn_luu_themmoi').click(function(e) {
      e.preventDefault();
      submitForm('new');
    });

    $('#btn_luu_quaylai').click(function(e) {
      e.preventDefault();
      submitForm('back');
    });

    $('#btn_quaylai').click(function(e) {
      e.preventDefault();
      window.location.href = '/index.php/component/quantrihethong/?view=quantrihethong&task=default';
    });
  });
</script>