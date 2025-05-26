<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelBaoCaoLoi = Core::model('BaoCaoLoi/BaoCaoLoi');
$nameError = $this->nameError;
$nameModule = $this->nameModule;
?>

<div class="container my-3">
  <div class="content-box">
    <div class="d-flex align-item-center justify-content-between">
      <h2 class="text-primary">
        <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin lỗi
      </h2>
      <div>
        <a href="index.php/component/baocaoloi/?view=baocaoloi&task=ds_baocaoloi" class="btn btn-secondary"><i class="fa fa-share"></i> Hủy</a>
        <button type="submit" id="submitBtn" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
      </div>
    </div>
    <form action="<?= Route::_('index.php?option=com_baocaoloi&task=baocaoloi.create_baocaoloi') ?>" id="errorReportForm" name="errorReportForm" method="post">
      <div class="form-group">
        <label for="selectNameError">Tên lỗi <span class="text-danger">*</span></label>
        <select class="form-control select2" id="selectNameError" name="type_error_id" required onchange="validateNameError(this)">
          <option value="">-- Hãy chọn lỗi --</option>
          <?php foreach ($nameError as $error) : ?>
            <option value="<?= $error->id ?>" data-nameError="<?= $error->id ?>">
              <?= htmlspecialchars($error->name_error) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small id="nameError" class="text-danger"></small>
      </div>

      <div class="form-group" style="display: none" id="enterOtherError">
        <label for="nameOther">Nhập tên lỗi khác <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nameOther" name="name_other" minlength="10" maxlength="255"
          placeholder="Hãy nhập tên lỗi khác vào đây" oninput="validateNameOtherError(this)">
        <small id="nameOtherError" class="text-danger"></small>
      </div>

      <div class="form-group">
        <label for="selectModuleError">Tên module <span class="text-danger">*</span></label>
        <select class="form-control select2" id="selectModuleError" name="module_id" required onchange="validateModuleError(this)">
          <option value="">-- Hãy chọn tên module --</option>
          <?php foreach ($nameModule as $nameModule) : ?>
            <option value="<?= $nameModule->id ?>" data-nameModule="<?= $nameModule->id ?>">
              <?= htmlspecialchars($nameModule->name) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small id="moduleError" class="text-danger"></small>
      </div>

      <div class="form-group">
        <label for="error_content">Nội dung lỗi <span class="text-danger">*</span></label>
        <textarea class="form-control" id="error_content" name="error_content" rows="4" minlength="10" maxlength="510"
          placeholder="Hãy mô tả về lỗi đó" required oninput="validateContent(this)"></textarea>
        <small id="contentError" class="text-danger"></small>
      </div>

      <div class="bottom-page">
        <div class="form-group">
          <label for="error_image">Hình ảnh đính kèm</label>
          <?= Core::uploadImages('uploadImageError', null, 1, date('Y'), -1); ?>

          <!-- Đây là nơi ảnh sẽ hiển thị sau khi upload -->
          <div id="imagePreview" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
          <input type="hidden" id="imageIdInput" name="imageIdInput" value="" />
        </div>

        <!-- Lightbox overlay -->
        <div id="lightboxOverlay">
          <span class="lightbox-close">&times;</span>
          <img class="lightbox-content" id="lightboxImage" src="" alt="Preview lớn">
        </div>
      </div>
      <?php echo HTMLHelper::_('form.token'); ?>
    </form>
  </div>
</div>

<style>
  .content-box {
    padding: 0px 20px;
  }

  .content-wrapper {
    background-color: #fff;
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
</style>
<script>
  // ==== Toast Message ====
  function showToast(message, isSuccess = true) {
    const toast = document.createElement('div');
    toast.textContent = message;
    Object.assign(toast.style, {
      position: 'fixed',
      top: '20px',
      right: '20px',
      background: isSuccess ? '#28a745' : '#dc3545',
      color: '#fff',
      padding: '10px 20px',
      borderRadius: '5px',
      boxShadow: '0 0 10px rgba(0,0,0,0.3)',
      zIndex: 9999,
      transition: 'opacity 0.5s',
    });

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 500);
    }, 1000);
  }

  // ==== DOM Ready ====
  $(function() {
    // Select2 init
    $('#selectNameError').select2({
      placeholder: '-- Hãy chọn lỗi --',
      allowClear: true,
      width: '100%'
    });
    $('#selectModuleError').select2({
      placeholder: '-- Hãy chọn Module --',
      allowClear: true,
      width: '100%'
    });
  });

  // ==== Validation ====
  function setValidation(input, errorEl, msg = '') {
    errorEl.textContent = msg;
    input.setCustomValidity(msg);
  }

  function validateNameError(input) {
    const errorEl = document.getElementById('nameError');
    setValidation(input, errorEl, !input.value ? 'Hãy chọn tên lỗi' : '');

    const selectNameError = document.getElementById('selectNameError');
    const enterOther = document.getElementById('enterOtherError');
    const otherErrorInput = document.getElementById('nameOther');

    if (selectNameError && enterOther && otherErrorInput) {
      toggleOtherErrorInput(selectNameError, enterOther, otherErrorInput);
      selectNameError.addEventListener('change', toggleOtherErrorInput);
    }
  }

  function toggleOtherErrorInput(selectNameError, enterOther, otherErrorInput) {
    const show = parseInt(selectNameError.value, 10) === 12;
    enterOther.style.display = show ? 'block' : 'none';
    if (!show) otherErrorInput.value = '';
  }

  function validateNameOtherError(input) {
    console.log('Validating other error name input');
    const errorEl = document.getElementById('nameOtherError');
    const val = input.value.trim();

    if (val.length < 10) return setValidation(input, errorEl, 'Tên lỗi khác quá ngắn');
    if (val.length > 255) return setValidation(input, errorEl, 'Tên lỗi khác quá dài');
    setValidation(input, errorEl);
  }

  function validateModuleError(input) {
    const errorEl = document.getElementById('moduleError');
    setValidation(input, errorEl, !input.value ? 'Hãy chọn tên module gặp lỗi' : '');
  }

  function validateContent(input) {
    const errorEl = document.getElementById('contentError');
    const val = input.value.trim();

    if (val.length < 10) return setValidation(input, errorEl, 'Nội dung thông báo quá ngắn');
    if (val.length > 255) return setValidation(input, errorEl, 'Nội dung thông báo quá dài');
    setValidation(input, errorEl);
  }

  // ==== DOMContentLoaded ====
  document.addEventListener('DOMContentLoaded', function() {
    // === Lightbox Preview ===
    const preview = document.getElementById('imagePreview');
    const lightbox = document.getElementById('lightboxOverlay');
    const lightboxImg = document.getElementById('lightboxImage');
    const closeBtn = document.querySelector('.lightbox-close');

    if (preview && lightbox && lightboxImg && closeBtn) {
      preview.addEventListener('click', e => {
        if (e.target.tagName.toLowerCase() === 'img') {
          e.preventDefault();
          lightboxImg.src = e.target.src;
          lightbox.style.display = 'flex';
        }
      });

      [closeBtn, lightbox].forEach(el => {
        el.addEventListener('click', e => {
          if (e.target === lightbox || e.target === closeBtn) {
            lightbox.style.display = 'none';
            lightboxImg.src = '';
          }
        });
      });
    }

    // === Form Submit ===
    const form = document.getElementById('errorReportForm');

    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        const previewChildren = $('#imagePreview').children();
        const imageIds = $('#imageUploadForm input[name="image_id"]').map(function() {
          return $(this).val();
        }).get();
        $('#imageIdInput').val(imageIds)

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
          })
          .then(res => res.json())
          .then(data => {
            const isSuccess = data.success ?? true;
            showToast(data.message || 'Lưu dữ liệu thành công', isSuccess);
            if (isSuccess) {
              setTimeout(() => {
                window.location.href = '/index.php/component/baocaoloi/?view=baocaoloi&task=ds_baocaoloi';
              }, 500);
            }
          })
          .catch(err => {
            console.error('Lỗi gửi dữ liệu:', err);
            showToast('Gửi dữ liệu thất bại', false);
          });
      });
    }
  });
</script>