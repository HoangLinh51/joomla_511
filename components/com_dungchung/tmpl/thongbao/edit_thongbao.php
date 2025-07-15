<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelThongbao = Core::model('DungChung/Thongbao');
$item = $this->item;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="container my-3">
  <div class="content-box">
    <form action="<?= Route::_('index.php?option=com_dungchung&task=thongbao.edit_thongbao&id=' . (int)$item->id) ?>" id="formThongBao" name="formThongBao" method="post">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0 text-primary">
          <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin thông báo
        </h2>
        <div>
          <a href="index.php/component/dungchung/?view=thongbao&task=default&id=<?= (int)$item->id ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
          <button type="submit" id="submitBtn" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
        </div>
      </div>
      <div class="form-group">
        <label for="tieude">Tiêu đề <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="tieude" name="tieude" maxlength="255"
          value="<?= htmlspecialchars($item->tieude) ?>">
      </div>

      <div class="form-group">
        <label for="noidung">Nội dung <span class="text-danger">*</span></label>
        <textarea class="form-control" id="noidung" name="noidung" rows="4" maxlength="510"><?= htmlspecialchars($item->noidung) ?></textarea>
      </div>

      <div class="form-group">
        <label for="vanbandinhkem">Tệp đính kèm</label>
        <?php echo Core::inputAttachmentOneFile('vanban', null, 1, date('Y'), -1); ?>
        <?php if (!empty($item->vanban)) : ?>
          <small>Hiện tại:
            <div class="d-flex flex-column">
              <?php foreach ($item->vanban as $vanban) : ?>
                <div class="vanban_<?= $vanban['id'] ?>">
                  <?php if ($vanban['type'] === 'application/pdf') { ?>
                    <a href="<?php echo '/index.php?option=com_dungchung&view=thongbao&format=raw&task=viewpdf&file=' . $vanban['code']  ?>" class="mr-2">
                      <?php echo $vanban['filename'] ?>
                    </a>
                  <?php } else { ?>
                    <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban['nam'] . '&code=' . $vanban['code'] ?>" class="mr-2">
                      <?php echo $vanban['filename'] ?>
                    </a>
                  <?php } ?>
                  <button type="button" class="btn bnt-deleteVanBan" data-id="<?= $vanban['id'] ?>" title="Xóa">
                    <i class="fa fa-trash-alt"></i>
                  </button>
                </div>
              <?php endforeach ?>
            </div>
          </small>
        <?php endif; ?>
      </div>

      <input type="hidden" name="id" value="<?= (int)$item->id ?>">
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

  .error {
    margin-bottom: 0;
    font-size: 12px;
    color: #dc3545;
  }
</style>

<script>
  // Hàm thông báo toast
  function showToast(message, isSuccess = true) {
    $('<div></div>')
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
      .appendTo('body')
      .delay(1000)
      .fadeOut(500, function() {
        $(this).remove();
      });
  }

  $(document).ready(function() {
    // Cấu hình validate
    const $form = $('#formThongBao');
    $form.validate({
      rules: {
        tieude: {
          required: true,
          minlength: 5,
        },
        noidung: {
          required: true
        },
      },
      messages: {
        tieude: {
          required: 'Nhập tiêu đề',
          minlength: 'Tiêu đề quá ngắn'
        },
        noidung: 'Nhập nội dung',
      }
    });

    // Xử lý submit
    $form.on('submit', function(e) {
      e.preventDefault();

      if (!$form.valid()) {
        showToast('Vui lòng nhập đầy đủ thông tin', false)
        return;
      }
      const formData = new FormData(this);

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
              window.location.href = '/index.php/component/dungchung/?view=thongbao&task=ds_thongbao';
            }, 500);
          }
        },
        error: function(xhr, status, error) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });

    $('body').on('click', '.bnt-deleteVanBan', function() {
      if (!confirm('Bạn có chắc chắn muốn xóa dữ liệu này?')) return;

      const idVanban = $(this).data('id');
      const idThongbao = <?= (int)$item->id ?>;

      $.ajax({
        url: 'index.php?option=com_dungchung&task=thongbao.deleteVanBanCTL',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          idVanban: idVanban,
          idThongbao: idThongbao
        }),
        success: function(response) {
          showToast(response.message || 'Xóa file thành công', response.success ?? true);
          $(`.vanban_${idVanban}`).remove();
        },
        error: function(xhr) {
          let response = {};
          try {
            response = JSON.parse(xhr.responseText);
          } catch (e) {
            response.message = 'Có lỗi xảy ra trong quá trình xử lý';
            response.success = false;
          }
          showToast(response.message || 'Có lỗi khi xóa file', response.success);
        }
      });
    });
  });
</script>