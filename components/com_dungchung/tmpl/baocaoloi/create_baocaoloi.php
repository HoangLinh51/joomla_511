<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelBaoCaoLoi = Core::model('DungChung/BaoCaoLoi');
$nameError = $this->nameError;
$nameModule = $this->nameModule;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="container my-3">
  <div class="content-box">
    <form action="<?= Route::_('index.php?option=com_dungchung&task=baocaoloi.create_baocaoloi') ?>" id="errorReportForm" name="errorReportForm" method="post">
      <div class="d-flex align-item-center justify-content-between">
        <h2 class="text-primary">
          <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin lỗi
        </h2>
        <div>
          <a href="index.php/component/dungchung/?view=baocaoloi&task=ds_baocaoloi" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Hủy</a>
          <button type="submit" id="submitBtn" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
        </div>
      </div>
      <div class="form-group">
        <label for="type_error_id">Tên lỗi <span class="text-danger">*</span></label>
        <select class="form-control select2" id="type_error_id" name="type_error_id" data-placeholder="-- Hãy chọn lỗi --" required>
          <option value=""></option>
          <?php foreach ($nameError as $error) : ?>
            <option value="<?= $error->id ?>" data-nameError="<?= $error->id ?>">
              <?= htmlspecialchars($error->name_error) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="display: none" id="enterOtherError">
        <label for="name_other">Nhập tên lỗi khác <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name_other" name="name_other" minlength="10" maxlength="255"
          placeholder="Hãy nhập tên lỗi khác vào đây">
      </div>

      <div class="form-group">
        <label for="module_id">Tên module <span class="text-danger">*</span></label>
        <select class="form-control select2" id="module_id" name="module_id" data-placeholder="-- Hãy chọn tên module --" required>
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
          <img class="lightbox-content" id="lightboxImage" src="" alt="Preview">
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
  $(document).ready(function() {
    // Tích hợp Select2 với jQuery Validation
    $.validator.addMethod('select2', function(value, element) {
      return value !== '';
    }, 'Vui lòng chọn một giá trị');

    $('#type_error_id, #module_id').select2({
      placeholder: function() {
        return $(this).data('placeholder');
      },
      allowClear: true,
      width: '100%'
    });

    const $form = $('#errorReportForm');
    $form.validate({
      ignore: [],
      rules: {
        type_error_id: {
          required: true,
          select2: true
        },
        name_other: {
          required: function(element) {
            return $('#type_error_id').val() == '12';
          },
          minlength: 5
        },
        module_id: {
          required: true,
          select2: true
        },
        error_content: {
          required: true,
          minlength: 10
        }
      },
      messages: {
        type_error_id: 'Vui lòng chọn tên lỗi',
        name_other: {
          required: 'Vui lòng nhập tên lỗi khác',
          minlength: 'Tên lỗi khác quá ngắn'
        },
        module_id: 'Vui lòng chọn module gặp lỗi',
        error_content: {
          required: 'Vui lòng nhập nội dung lỗi',
          minlength: 'Nội dung lỗi quá ngắn'
        }
      },
      errorPlacement: function(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('.select2-container'));
        } else {
          error.insertAfter(element);
        }
      }
    });

    $('#type_error_id').on('change', function() {
      toggleOtherErrorInput();
      $(this).valid();
    });

    $('#module_id').on('change', function() {
      $(this).valid();
    });

    $form.on('submit', async (e) => {
      e.preventDefault();

      if (!$form.valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }

      const form = document.getElementById('errorReportForm');
      const formData = new FormData(form);

      const imageIds = $('#imageUploadForm input[name="image_id"]').map(function() {
        return $(this).val();
      }).get();
      formData.set('imageIdInput', imageIds.join(','));

      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          const isSuccess = response.success ?? true;
          showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
          if (isSuccess) {
            setTimeout(() => {
              window.location.href = '/index.php/component/dungchung/?view=baocaoloi&task=ds_baocaoloi';
            }, 500);
          }
        },
        error: function(xhr, status, error) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });

    // Lightbox Preview
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
  });

  function toggleOtherErrorInput() {
    const selectNameError = document.getElementById('type_error_id');
    const enterOther = document.getElementById('enterOtherError');
    const otherErrorInput = document.getElementById('name_other');

    const show = parseInt(selectNameError.value, 10) === 12;
    enterOther.style.display = show ? 'block' : 'none';
    if (!show) otherErrorInput.value = '';
  }

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
      transition: 'opacity 0.5s'
    });

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 500);
    }, 1000);
  }
</script>