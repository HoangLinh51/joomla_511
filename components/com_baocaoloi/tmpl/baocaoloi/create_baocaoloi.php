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
    <h2 class="mb-3 text-primary">
      <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin lỗi
    </h2>
    <form action="<?= Route::_('index.php?option=com_baocaoloi&task=baocaoloi.create_baocaoloi') ?>" id="errorReportForm" name="errorReportForm" method="post">
      <div class="form-group">
        <label for="name_error">Tên lỗi</label>
        <div class="form-group">
          <select class="form-control" id="selectNameError" name="error_id" required>
            <option value="">
              -- Hãy chọn lỗi --
            </option>
            <?php foreach ($nameError as $nameError) : ?>
              <option value="<?= $nameError->id ?>" data-nameError="<?= $nameError->id ?>">
                <?= htmlspecialchars($nameError->name_error) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group" id="enterOtherError" >
        <label for="nameOtherError">Nhập tên lỗi khác</label>
        <input type="text" class="form-control" id="nameOtherError" name="name_otherError" placeholder="Hãy nhập tên lỗi khác vào đây">
      </div>


      <div class="form-group">
        <label for="name_module">Tên module</label>
        <div class="form-group">
          <select class="form-control" id="selectModule" name="module_id" required>
            <option value="">
              -- Hãy chọn module --
            </option>
            <?php foreach ($nameModule as $nameModule) : ?>
              <option value="<?= $nameModule->id ?>" data-nameModule="<?= $nameModule->id ?>">
                <?= htmlspecialchars($nameModule->name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="error_content">Nội dung lỗi</label>
        <textarea class="form-control" id="error_content" name="error_content" rows="4" minlength="20" maxlength="510"
          placeholder="Hãy mô tả về lỗi đó" required></textarea>
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
        <div id="lightboxOverlay" >
          <span class="lightbox-close" >&times;</span>
          <img class="lightbox-content" id="lightboxImage" src="" alt="Preview lớn">
        </div>
      </div>

      <div class="float-right button">
        <a href="index.php/component/baocaoloi/?view=baocaoloi&task=ds_baocaoloi" class="btn btn-secondary">Hủy</a>
        <button type="submit" id="submitBtn" class="btn btn-primary">Lưu</button>
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
    width:100%; 
    height:100%;
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
  document.addEventListener('DOMContentLoaded', function() {
    // ==== Toggle image Preview ====
    const previewContainer = document.getElementById('imagePreview');
    const lightbox = document.getElementById('lightboxOverlay');
    const lightboxImg = document.getElementById('lightboxImage');
    const closeBtn = document.querySelector('.lightbox-close');

    // Áp dụng nếu có container
    if (previewContainer && lightbox && lightboxImg && closeBtn) {
      // Khi click vào bất kỳ ảnh nào trong #imagePreview
      previewContainer.addEventListener('click', function(e) {
        if (e.target.tagName.toLowerCase() === 'img') {
          e.preventDefault();
          lightboxImg.src = e.target.src;
          lightbox.style.display = 'flex';
        }
      });

      closeBtn.addEventListener('click', function() {
        lightbox.style.display = 'none';
        lightboxImg.src = '';
      });

      lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
          lightbox.style.display = 'none';
          lightboxImg.src = '';
        }
      });
    }

    // ==== Toggle 'Lỗi khác' Input ====
    const selectNameError = document.getElementById('selectNameError');
    const enterOtherError = document.getElementById('enterOtherError');
    const nameOtherErrorInput = document.getElementById('nameOtherError');

    function togglenameOtherErrorInput() {
      const show = parseInt(selectNameError.value, 10) === 12;
      enterOtherError.style.display = show ? 'block' : 'none';
      if (!show) nameOtherErrorInput.value = '';
    }

    if (selectNameError && enterOtherError && nameOtherErrorInput) {
      togglenameOtherErrorInput(); // Initial check
      selectNameError.addEventListener('change', togglenameOtherErrorInput);
    }

    // ==== Form Submit AJAX ====
    const form = document.getElementById('errorReportForm');

    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const child = $('#imagePreview').children();
        const uploadedImageId = document.querySelector('input[name="idObject"]')?.value || '';

        console.log('child:', child);
        console.log('Uploaded Image ID:', uploadedImageId);

        if (child.length > 0) {
          $('#imageIdInput') .val(uploadedImageId);
        } else {
          $('#imageIdInput').val('');
        }

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
          })
          .then(response => response.json())
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

    // ==== showToast Function ====
    window.showToast = function(message, isSuccess = true) {
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
    };
  });
</script>