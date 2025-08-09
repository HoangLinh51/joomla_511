<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detailViaHe = $this->item;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formViaHe" name="formViaHe" method="post" action="<?php echo Route::_('index.php?option=com_dcxddt&controller=viahe&task=save_logo'); ?>">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
      <h2 class="text-primary mb-3">
        <?php echo ((int)$detailViaHe['thongtin']['thongtinviahe_id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> logo phường xã
      </h2>
      <span>
        <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
      </span>
    </div>
    <div class="col-md-12 mb-3">
      <label for="phuongxa_id" class="form-label fw-bold">Phường/Xã <span class="text-danger">*</span></label>
      <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường">
        <option value=""></option>
        <?php foreach ($this->phuongxa as $px) { ?>
          <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-12 mb-3">
      <div class="col-md-6 mb-2">
        <label for="mucdichsudung" class="form-label fw-bold">Đính kèm logo</label>
        <?= Core::inputAttachmentOneFile('logophanquyen', null, 1, date('Y'), -1); ?>
        <!-- Đây là nơi ảnh sẽ hiển thị sau khi upload -->
        <div id="imagePreview" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
      </div>
      <div class="col-md-6 mb-2 vanbancu">
        <?php if (!empty($detailViaHe['filedinhkem'])): ?>
          <label for="mucdichsudung" class="form-label fw-bold">Tệp đính kèm</label>
          <?php foreach ($detailViaHe['filedinhkem'] as $item): ?>
            <div class="d-flex align-items-center justify-content-between" id="file-<?= $item['id'] ?>">
              <span class="d-block mb-1">
                <?php if ($item['mime'] === 'application/pdf'): ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/index.php?option=com_dungchung&view=hdsd&format=raw&task=viewpdf&file=<?= $item['code'] ?>&folder=<?= $item['folder'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php elseif (in_array($item['mime'], ['image/jpeg', 'image/png'])): ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/uploader/get_image.php/<?= $item['folder'] ?>?code=<?= $item['code'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php else: ?>
                  <a target="_blank"
                    href="<?= Uri::root(true) ?>/index.php?option=com_core&controller=attachment&format=raw&task=download&year=<?= date('Y') ?>&code=<?= $item['code'] ?>">
                    <?= htmlspecialchars($item['filename']) ?>
                  </a>
                <?php endif; ?>
              </span>
              <span id="xoatepdinhkem" class="btn btn-small" data-idviahe="<?php echo htmlspecialchars($detailViaHe['thongtin']['thongtinviahe_id']); ?>" data-idvanban="<?php echo htmlspecialchars($item['id']); ?>">
                <i class="fa fa-trash"></i>
              </span>
              <input type="hidden" name="idFile-uploadImageHopDong[]" value="<?php echo $item['id'] ?>">
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
  </div>
</form>


<script>
  let detailViaHe = <?php echo json_encode($detailViaHe ?? []); ?>;
  let timeout = null;
  let params = new URLSearchParams(window.location.search);
  let task = params.get('task');
  let isEditHopDong = false;
  let isGiaHan = false;
  let giaHanParentRowIndex = null;
  $(document).ready(function() {
    $('#phuongxa_id').select2({
      placeholder: $('#phuongxa_id').data('placeholder') || 'Chọn',
      allowClear: true,
      with: '100% '
    });

    // validate form
    $('#formViaHe').validate({
      ignore: [],
      rules: {
        phuongxa_id: {
          required: true
        },
      },
      messages: {
        phuongxa_id: 'Vui lòng chọn phường xã',
      },
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      }
    });

    // submit form chính
    $('#formViaHe').on('submit', function(e) {
      e.preventDefault();

      if (!$(this).valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false);
        return;
      }
      const formData = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          const isSuccess = response.success ?? true;
          showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
          if (isSuccess) {
            setTimeout(() => location.href = "/index.php/component/dcxddt/?view=viahe&task=default", 500);
          }
        },
        error: function(xhr) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });
    const showToast = (message, isSuccess = true) => {
      const toast = $('<div></div>')
        .text(message)
        .css({
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
        })
        .appendTo('body');
      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 3000);
    };
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

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
    color: #fff
  }

  .error {
    color: #dc3545;
    font-size: 12px;
    margin: 0px;
  }
</style>