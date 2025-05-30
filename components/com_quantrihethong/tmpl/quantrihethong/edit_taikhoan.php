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
    <form action="<?= Route::_('index.php?option=com_quantrihethong&task=quantrihethong.save_user ') ?>" id="accountForm" name="accountForm" method="post">
      <div class="form-header">
        <h2 class="text-primary">
          <?php echo ((int)$user['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> tài khoản
        </h2>
        <div class="button-action">
          <button id="btn_luu_themmoi" class="btn btn-small btn-success"><i class="fa fa-save"></i> Lưu và thêm mới</button>
          <button id="btn_luu_quaylai" class="btn btn-small btn-primary"><i class="fa fa-save"></i> Lưu và quay lại</button>
          <button id="btn_quaylai" class="btn btn-small btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</button>
        </div>
      </div>
      <input type="hidden" name="id" id="id" value="<?php echo $user['id']; ?>">
      <div class="formGroup">
        <label for="name">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control"
          value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" />
      </div>
      <div class="formGroup">
        <label for="username">Tên tài khoản <span class="text-danger">*</span></label>
        <input type="text" id="username" name="username" class="form-control"
          value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" />
      </div>
      <div class="formGroup">
        <label for="password">Mật khẩu<?php if ((int)$user['id'] == 0): ?><span class="text-danger">*</span><?php endif; ?></label>
        <input type="password" id="password" name="password" class="form-control"
          title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm 1 chữ in hoa, 1 số và 1 ký tự đặc biệt (!@#$%^&*)"
          placeholder="<?php echo ((int)$user['id'] > 0) ? 'Để trống nếu không đổi mật khẩu' : 'Nhập mật khẩu'; ?>" />
      </div>
      <div class="formGroup">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email" class="form-control"
          value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" />
      </div>
      <div class="formGroup">
        <label for="chucnang">Chức năng sử dụng <span class="text-danger">*</span></label>
        <div class="select-checkbox-container">
          <div class="select-checkbox" id="chucnang_select">-- Hãy chọn chức năng sử dụng --</div>
          <div class="dropdown" id="chucnang-dropdown">
            <?php foreach ($chucNang as $cn): ?>
              <label class="option">
                <input type="checkbox" class="chucNang" value="<?php echo $cn->id; ?>">
                <?php echo htmlspecialchars($cn->title); ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
        <label for="chucnang" class="error"></label>
        <input type="hidden" id="chucNang" name="chucNang" required>
      </div>
      <div class="formGroup">
        <label for="donviquanly">Đơn vị quản lý <span class="text-danger">*</span></label>
        <div class="select-dv">
          <div class="phuongxa">
            <div class="select-checkbox-container">
              <div class="select-checkbox" id="phuongxa_select">-- Chọn Phường/Xã --</div>
              <div class="dropdown" id="phuongXa-dropdown">
                <?php foreach ($khuVuc as $px): ?>
                  <?php if ($px['level'] == 2): ?>
                    <label class="option">
                      <input type="checkbox" class="phuongXa" value="<?php echo $px['id']; ?>">
                      <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
                    </label>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <label for="phuongXa" class="error"></label>
            <input type="hidden" id="phuongXa" name="phuongXa" required>
          </div>
          <div class="thonto">
            <div class="select-checkbox-container">
              <div class="select-checkbox" id="thonto_select">-- Chọn Thôn/Tổ --</div>
              <div class="dropdown" id="thonTo_dropdown">
                <label class="option select-all-option">
                  <input type="checkbox" id="select-all-thon-to"> Chọn tất cả
                </label>

                <!-- Thôn/Tổ options sẽ được thêm động bằng jQuery -->
              </div>
            </div>
            <label for="thonTo" class="error"></label>
            <input type="hidden" id="thonTo" name="thonTo" required>
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
    <input type="hidden" name="action" value="<?php echo ((int)$user['id'] > 0) ? 'edit' : 'create'; ?>">
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

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>

<script>
  function showToast(message, isSuccess = true, error = '') {
    const toast = document.createElement('div');
    Object.assign(toast.style, {
      position: 'fixed',
      top: '20px',
      right: '20px',
      background: isSuccess ? '#28a745' : '#dc3545',
      color: 'white',
      padding: '10px 20px',
      borderRadius: '5px',
      boxShadow: '0 0 10px rgba(0,0,0,0.3)',
      zIndex: '9999',
      maxWidth: '300px',
      fontFamily: 'sans-serif'
    });

    // Tạo nội dung HTML
    toast.innerHTML = `
      <strong style="display:block; font-size: 16px; margin-bottom: 5px;">
       ${message}
      </strong>
      <span style="font-size: 14px;">${error}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.transition = `opacity 500ms`;
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 500);
    }, 2000);
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Cache DOM elements
    const elements = {
      form: document.getElementById('accountForm'),
      chucnang: {
        dropdown: document.getElementById('chucnang-dropdown'),
        select: document.getElementById('chucnang_select'),
        hidden: document.getElementById('chucNang')
      },
      phuongxa: {
        dropdown: document.getElementById('phuongXa-dropdown'),
        select: document.getElementById('phuongxa_select'),
        hidden: document.getElementById('phuongXa')
      },
      thonto: {
        dropdown: document.getElementById('thonTo_dropdown'),
        select: document.getElementById('thonto_select'),
        hidden: document.getElementById('thonTo'),
        selectAll: document.getElementById('select-all-thon-to')
      },
      buttons: {
        saveNew: document.getElementById('btn_luu_themmoi'),
        saveBack: document.getElementById('btn_luu_quaylai'),
        back: document.getElementById('btn_quaylai')
      },
      requireReset: document.querySelector('.requireReset')
    };

    // Data from PHP
    const khuVucData = <?php echo json_encode($khuVuc); ?>;
    const userData = <?php echo json_encode($user); ?>;
    const chucNang = <?php echo json_encode($chucNang); ?>;
    const editData = {
      group_id: <?php echo json_encode($user["group_ids"] ?? []); ?>,
      phuongxa_id: <?php echo json_encode($user["phuongxa_id"] ?? ''); ?>,
      thonto_id: <?php echo json_encode($user["thonto_id"] ?? ''); ?>
    };

    const phuongXaData = khuVucData.filter(item => item.level === 2);
    const thonToData = khuVucData.filter(item => item.level === 3);

    const toggleDropdown = (dropdown) => {
      const allDropdowns = document.querySelectorAll('.dropdown');
      const isOpen = dropdown.classList.contains('show');
      allDropdowns.forEach(dd => dd.classList.remove('show'));
      if (!isOpen) dropdown.classList.add('show');
    };

    const updateSelection = (dropdown, select, placeholder) => {
      const selectedLabels = Array.from(dropdown.querySelectorAll('input:checked:not(#select-all-thon-to)'))
        .map(input => input.parentElement.textContent.trim());
      select.innerHTML = selectedLabels.length ? selectedLabels.join(', ') : placeholder;
      select.appendChild(document.createElement('span'));
    };

    const updateHiddenInput = (dropdown, hiddenInput) => {
      const selectedIds = Array.from(dropdown.querySelectorAll('input:checked:not(#select-all-thon-to)'))
        .map(input => input.value);
      hiddenInput.value = selectedIds.join(',');
    };

    const updateThonToOptions = (selectedPhuongXaIds) => {
      const container = elements.thonto.dropdown;
      container.querySelectorAll('.option:not(.select-all-option)').forEach(opt => opt.remove());

      const thonToOptions = thonToData.filter(item => selectedPhuongXaIds.includes(String(item.cha_id)));
      thonToOptions.forEach(item => {
        const label = document.createElement('label');
        label.className = 'option';
        label.innerHTML = `
        <input type="checkbox" class="thonTo" value="${item.id}">
        ${item.tenkhuvuc}
      `;
        container.appendChild(label);
      });

      if (editData.thonto_id) {
        editData.thonto_id.split(',').map(id => id.trim())
          .forEach(id => {
            const input = container.querySelector(`input[value="${id}"]`);
            if (input) input.checked = true;
          });
      }

      updateThonToSelection();
    };

    const updateThonToSelection = () => {
      updateSelection(elements.thonto.dropdown, elements.thonto.select, '-- Chọn Thôn/Tổ --');
      const allCheckboxes = elements.thonto.dropdown.querySelectorAll('input:not(#select-all-thon-to)');
      elements.thonto.selectAll.checked = allCheckboxes.length > 0 &&
        allCheckboxes.length === Array.from(allCheckboxes).filter(cb => cb.checked).length;
      updateHiddenInput(elements.thonto.dropdown, elements.thonto.hidden);
    };

    const setupDropdownEvents = (select, dropdown, placeholder, hiddenInput, onChange) => {
      select.addEventListener('click', () => toggleDropdown(dropdown));
      dropdown.addEventListener('change', (e) => {
        if (e.target.tagName === 'INPUT') {
          updateSelection(dropdown, select, placeholder);
          updateHiddenInput(dropdown, hiddenInput);
          if (onChange) onChange();
        }
      });
    };

    const initializeEditState = () => {
      if (Array.isArray(editData.group_id) && editData.group_id.length) {
        editData.group_id.forEach(id => {
          const input = elements.chucnang.dropdown.querySelector(`input[value="${id}"]`);
          if (input) input.checked = true;
        });
        updateSelection(elements.chucnang.dropdown, elements.chucnang.select, '-- Hãy chọn chức năng sử dụng --');
        updateHiddenInput(elements.chucnang.dropdown, elements.chucnang.hidden);
      }

      if (editData.phuongxa_id) {
        const phuongxaIds = editData.phuongxa_id.split(',').map(id => id.trim());
        phuongxaIds.forEach(id => {
          const input = elements.phuongxa.dropdown.querySelector(`input[value="${id}"]`);
          if (input) input.checked = true;
        });
        updateSelection(elements.phuongxa.dropdown, elements.phuongxa.select, '-- Chọn Phường/Xã --');
        updateHiddenInput(elements.phuongxa.dropdown, elements.phuongxa.hidden);
        updateThonToOptions(phuongxaIds);
      }
    };

    const setupValidation = () => {
      $.validator.addMethod("validName", (value) => /^[A-Za-zÀ-ỹ\s]+$/.test(value),
        "Họ và tên chỉ được chứa chữ cái và khoảng trắng");
      $.validator.addMethod("validUsername", (value) => /^[A-Za-z0-9_]+$/.test(value),
        "Tên tài khoản chỉ được chứa chữ cái, số, dấu gạch dưới");
      $.validator.addMethod("strongPassword", (value) => {
        return value === '' || /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/.test(value);
      }, "Mật khẩu phải có ít nhất 8 ký tự, gồm 1 chữ in hoa, 1 số và 1 ký tự đặc biệt");

      $(elements.form).validate({
        ignore: [],
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
              return $('input[name="action"]').val() === 'create';
            },
            strongPassword: true
          },
          email: {
            required: true,
            email: true
          },
          chucNang: {
            required: true,
          },
          phuongXa: {
            required: true,
          },
          thonTo: {
            required: true,
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
          chucNang: {
            required: 'Vui lòng chọn chức năng sử dụng',
          },
          phuongXa: {
            required: 'Vui lòng chọn Phường/Xã',
          },
          thonTo: {
            required: 'Vui lòng chọn Thôn/Tổ',
          }
        },
        errorPlacement: (error, element) => {
          if (element.hasClass('select-checkbox')) {
            error.insertAfter(element.next('.select-checkbox-container'));
          } else {
            error.insertAfter(element);
          }
        }
      });
    };

    const submitForm = async (redirectAfterSave) => {
      [elements.chucnang, elements.phuongxa, elements.thonto].forEach(item => {
        const selected = Array.from(item.dropdown.querySelectorAll('input:checked'))
          .map(input => input.value);
        item.hidden.value = selected.join(',');
      });
      elements.requireReset.value = elements.requireReset.checked ? '1' : '0';

      if (!$(elements.form).valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }

      try {
        const response = await fetch(elements.form.action, {
          method: 'POST',
          body: new FormData(elements.form)
        });
        const data = await response.json();
        const isSuccess = data.success ?? true;
        showToast(data.message || 'Lưu dữ liệu thành công', isSuccess, data.error || '');

        if (isSuccess && redirectAfterSave) {
          setTimeout(() => {
            window.location.href = redirectAfterSave === 'new' ?
              '/index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user' :
              '/index.php/component/quantrihethong/?view=quantrihethong&task=default';
          }, 500);
        }
      } catch (err) {
        console.error('Lỗi gửi dữ liệu:', err);
        showToast('Gửi dữ liệu thất bại', false, data.error || '');
      }
    };

    // Event listeners
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.select-checkbox-container')) {
        document.querySelectorAll('.dropdown').forEach(dd => dd.classList.remove('show'));
      }
    });

    setupDropdownEvents(
      elements.chucnang.select,
      elements.chucnang.dropdown,
      '-- Hãy chọn chức năng sử dụng --',
      elements.chucnang.hidden
    );

    setupDropdownEvents(
      elements.phuongxa.select,
      elements.phuongxa.dropdown,
      '-- Chọn Phường/Xã --',
      elements.phuongxa.hidden,
      () => updateThonToOptions(
        Array.from(elements.phuongxa.dropdown.querySelectorAll('input:checked'))
        .map(input => input.value)
      )
    );

    setupDropdownEvents(
      elements.thonto.select,
      elements.thonto.dropdown,
      '-- Chọn Thôn/Tổ --',
      elements.thonto.hidden
    );

    elements.thonto.selectAll.addEventListener('change', (e) => {
      elements.thonto.dropdown.querySelectorAll('input:not(#select-all-thon-to)')
        .forEach(cb => cb.checked = e.target.checked);
      updateThonToSelection();
    });

    elements.buttons.saveNew.addEventListener('click', (e) => {
      e.preventDefault();
      submitForm('new');
    });

    elements.buttons.saveBack.addEventListener('click', (e) => {
      e.preventDefault();
      submitForm('back');
    });

    elements.buttons.back.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = '/index.php/component/quantrihethong/?view=quantrihethong&task=default';
    });

    // Initialize
    setupValidation();
    initializeEditState();
  });
</script>