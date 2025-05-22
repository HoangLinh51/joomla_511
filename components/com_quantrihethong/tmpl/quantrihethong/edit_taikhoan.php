<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('jquery.framework');

$chucNang = $this->chucNang;

$phuong_xa = $this->dmKhuvuc;
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
    <form action="<?= Route::_('index.php?option=com_quantrihethong&task=quantrihethong.create_quantrihethong') ?>" id="errorReportForm" name="errorReportForm" method="post">
      <div class="formGroup">
        <label for="name">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
      </div>
      <div class="formGroup">
        <label for="username">Tên tài khoản <span class="text-danger">*</span></label>
        <input type="text" id="username" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
      </div>
      <div class="formGroup">
        <label for="password">Mật khẩu <span class="text-danger">*</span></label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
      <div class="formGroup">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
      </div>
      <div class="formGroup">
        <label for="chucnang">Chức năng sử dụng <span class="text-danger">*</span></label>
        <div class="select-checkbox-container">
          <div class="select-checkbox" id="chucnang-select">-- Hãy chọn chức năng sử dụng --</div>
          <div class="dropdown" id="chucnang-dropdown">
            <?php foreach ($chucNang as $cn): ?>
              <label class="option">
                <input type="checkbox" name="chucnang[]" value="<?php echo $cn->id; ?>">
                <?php echo htmlspecialchars($cn->title); ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="formGroup">
        <label for="donviquanly">Đơn vị quản lý <span class="text-danger">*</span></label>
        <div class="select-dv">
          <div class="select-checkbox-container">
            <div class="select-checkbox" id="phuong-xa-select">-- Chọn Phường/Xã --</div>
            <div class="dropdown" id="phuong-xa-dropdown">
              <?php foreach ($phuong_xa as $px): ?>
                <?php if ($px['level'] == 2): ?>
                  <label class="option">
                    <input type="checkbox" name="phuong_xa[]" value="<?php echo $px['id']; ?>">
                    <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
                  </label>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="select-checkbox-container">
            <div class="select-checkbox" id="thon-to-select">-- Chọn Thôn/Tổ --</div>
            <div class="dropdown" id="thon-to-dropdown">
              <label class="option select-all-option">
                <input type="checkbox" id="select-all-thon-to"> Chọn tất cả
              </label>
              <!-- Thôn/Tổ options sẽ được thêm động bằng jQuery -->
            </div>
          </div>
        </div>
      </div>

      <div class="formGroup">
        <label for="requireresetpassword">Yêu cầu đổi mật khẩu</label>
        <label class="custom-toggle">
          <input type="checkbox" <?php echo ($user['block'] == 0) ? 'checked' : ''; ?>>
          <span class="slider"></span>
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
</style>

<script>
  $(document).ready(function() {
    // Dữ liệu từ PHP
    const khuVucData = <?php echo json_encode($phuong_xa); ?>;

    // Mở/đóng dropdown
    function toggleDropdown($select, $dropdown) {
      const $allDropdowns = $('.dropdown');
      const $targetDropdown = $dropdown;
      const isOpen = $targetDropdown.hasClass('show');

      // Đóng tất cả dropdown
      $allDropdowns.removeClass('show');

      // Nếu dropdown chưa mở, mở nó
      if (!isOpen) {
        $targetDropdown.addClass('show');
      }
    }

    // Đóng tất cả dropdown khi click bên ngoài
    $(document).on('click', function(e) {
      if (!$(e.target).closest('.select-checkbox-container').length) {
        $('.dropdown').removeClass('show');
      }
    });

    // Cập nhật hiển thị cho dropdown
    function updateSelection($dropdown, $select, placeholder) {
      const selectedLabels =$dropdown.find('input:checked:not(#select-all-thon-to)').map(function() {
        return $(this).parent().text().trim();
      }).get();
      $select.html(selectedLabels.length > 0 ? selectedLabels.join(', ') : placeholder)
        .append('<span></span>');
    }

    // Xử lý dropdown Chức năng
    $('#chucnang-select').on('click', function() {
      toggleDropdown($(this), $('#chucnang-dropdown'));
    });


    $('#chucnang-dropdown input').on('change', function() {
      updateSelection($('#chucnang-dropdown'), $('#chucnang-select'), '-- Hãy chọn chức năng sử dụng --');
    });

    // Xử lý dropdown Phường/Xã
    $('#phuong-xa-select').on('click', function() {
      toggleDropdown($(this), $('#phuong-xa-dropdown'));
    });

    $('#phuong-xa-dropdown input').on('change', function() {
      updateSelection($('#phuong-xa-dropdown'), $('#phuong-xa-select'), '-- Chọn Phường/Xã --');
      const selectedIds = $('#phuong-xa-dropdown input:checked').map(function() {
        return $(this).val();
      }).get();
      updateThonToOptions(selectedIds);
    });

    // Xử lý dropdown Thôn/Tổ
    $('#thon-to-select').on('click', function() {
      toggleDropdown($(this), $('#thon-to-dropdown'));
    });

    $(document).on('change', '#thon-to-dropdown input:not(#select-all-thon-to)', function() {
      updateThonToSelection();
    });

    // Xử lý "Chọn tất cả" cho Thôn/Tổ
    $('#select-all-thon-to').on('change', function() {
      $('#thon-to-dropdown input:not(#select-all-thon-to)').prop('checked', this.checked);
      updateThonToSelection();
    });

    // Cập nhật tùy chọn Thôn/Tổ
    function updateThonToOptions(selectedPhuongXaIds) {
      $('#thon-to-dropdown .option:not(.select-all-option)').remove();
      const idPhuongxa = selectedPhuongXaIds.map(Number)
      const thonToOptions = khuVucData.filter(item =>
        item.level === 3 && selectedPhuongXaIds.includes(String(item.cha_id))
      );

      thonToOptions.forEach(item => {
        $('#thon-to-dropdown').append(`
          <label class="option">
              <input type="checkbox" name="thon_to[]" value="${item.id}">
              ${item.tenkhuvuc}
          </label>
        `);
      });

      $('#select-all-thon-to').prop('checked', false);
      updateThonToSelection();
    }

    // Cập nhật hiển thị Thôn/Tổ
    function updateThonToSelection() {
      updateSelection($('#thon-to-dropdown'), $('#thon-to-select'), '-- Chọn Thôn/Tổ --');
      const allCheckboxes = $('#thon-to-dropdown input:not(#select-all-thon-to)');
      $('#select-all-thon-to').prop('checked',
        allCheckboxes.length > 0 && allCheckboxes.filter(':checked').length === allCheckboxes.length
      );
    }
  });
</script>