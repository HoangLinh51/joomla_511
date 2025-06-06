<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelBaoCaoLoi = Core::model('BaoCaoLoi/BaoCaoLoi');
$nameError = $this->nameError;
$nameModule = $this->nameModule;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="container my-3">
  <div class="content-box">
    <div class="d-flex align-item-center justify-content-between">
      <h2 class="text-primary">
        <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin lỗi
      </h2>
      <div>
        <a href="index.php/component/baocaoloi/?view=baocaoloi&task=ds_baocaoloi" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Hủy</a>
        <button type="submit" id="submitBtn" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
      </div>
    </div>
    <form action="<?= Route::_('index.php?option=com_baocaoloi&task=baocaoloi.create_baocaoloi') ?>" id="errorReportForm" name="errorReportForm" method="post">
      <div class="form-group">
        <label for="selectNameError">Tên lỗi <span class="text-danger">*</span></label>
        <select class="form-control select2" id="selectNameError" name="type_error_id" data-placeholder="-- Hãy chọn lỗi --" required>
          <option value=""></option>
          <?php foreach ($nameError as $error) : ?>
            <option value="<?= $error->id ?>" data-nameError="<?= $error->id ?>">
              <?= htmlspecialchars($error->name_error) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="display: none" id="enterOtherError">
        <label for="nameOther">Nhập tên lỗi khác <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nameOther" name="name_other" minlength="10" maxlength="255"
          placeholder="Hãy nhập tên lỗi khác vào đây">
      </div>

      <div class="form-group">
        <label for="selectModuleError">Tên module <span class="text-danger">*</span></label>
        <select class="form-control select2" id="selectModuleError" name="module_id" data-placeholder="-- Hãy chọn tên module --" required>
          <option value=""></option>
          <?php foreach ($nameModule as $nameModule) : ?>
            <option value="<?= $nameModule->id ?>" data-nameModule="<?= $nameModule->id ?>">
              <?= htmlspecialchars($nameModule->name) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="error_content">Nội dung lỗi <span class="text-danger">*</span></label>
        <textarea class="form-control" id="error_content" name="error_content" rows="4" minlength="10" maxlength="510"
          placeholder="Hãy mô tả về lỗi đó"></textarea>
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

      <?= HTMLHelper::_('form.token'); ?>
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

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
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

  function toggleOtherErrorInput() {
    const selectNameError = document.getElementById('selectNameError');
    const enterOther = document.getElementById('enterOtherError');
    const otherErrorInput = document.getElementById('nameOther');

    const show = parseInt(selectNameError.value, 10) === 12;
    enterOther.style.display = show ? 'block' : 'none';
    if (!show) otherErrorInput.value = '';
  }

  // ==== DOM Ready ====
  $(function() {
    // Select2 init
    $('#selectNameError, #selectModuleError').select2({
      placeholder: function() {
        return $(this).data('placeholder');
      },
      allowClear: true,
      width: '100%',
    });

    // Nếu bạn cần toggleOtherErrorInput khi select thay đổi:
    $('#selectNameError').on('change', toggleOtherErrorInput);
  });

  document.addEventListener('DOMContentLoaded', () => {
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

    $(document).ready(function() {
      const $form = $('#errorReportForm');

      $form.validate({
        rules: {
          type_error_id: {
            required: true,
          },
          name_other: {
            required: true,
            minlength: 5,
          },
          module_id: {
            required: true,
          },
          error_content: {
            required: true,
            minlength: 10,
          },
        },
        messages: {
          type_error_id: 'Vui lòng chọn tên lỗi',
          name_other: {
            required: 'Vui lòng nhập tên lỗi khác',
            minlength: 'Tên lỗi khác quá ngắn',
          },
          module_id: 'Vui lòng chọn module gặp lỗi',
          error_content: {
            required: 'Vui lòng nhập nội dung lỗi',
            minlength: 'Nội dung lỗi quá ngắn',
          },
        }
      });

      const imageIdInput = document.getElementById('imageIdInput');

      $form.on('submit', async (e) => {
        e.preventDefault();

        const previewChildren = $('#imagePreview').children();
        const imageIds = $('#imageUploadForm input[name="image_id"]').map(function() {
          return $(this).val();
        }).get();
        $('#imageIdInput').val(imageIds)

        if (!$form.valid()) {
          showToast('Vui lòng nhập đầy đủ thông tin', false)
          return;
        }
        $.ajax({
          url: $form.attr('action'),
          type: 'POST',
          data: new FormData(form),
          contentType: false,
          processData: false,
          success: function(response) {
            const isSuccess = response.success ?? true;
            showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
            if (isSuccess) {
              setTimeout(() => {
                window.location.href = '/index.php/component/baocaoloi/?view=baocaoloi&task=ds_baocaoloi';
              }, 500);
            }
          },
          error: function(xhr, status, error) {
            console.error('Submit error:', xhr.responseText);
            showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
          }
        });
      });
    });
  });
</script>