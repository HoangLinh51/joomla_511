<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelThongbao = Core::model('Thongbao/Thongbao');
$item = $this->item;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="container my-3">
  <div class="content-box">
    <form action="<?= Route::_('index.php?option=com_thongbao&task=thongbao.edit_thongbao&id=' . (int)$item->id) ?>" id="formThongBao" name="formThongBao" method="post">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0 text-primary">
          <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin thông báo
        </h2>
        <div>
          <a href="index.php/component/thongbao/?view=thongbao&task=default&id=<?= (int)$item->id ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
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
        <?php echo Core::inputAttachmentOneFile('dinhkem_vanbanlienquan', null, 1, date('Y'), -1); ?>
        <input id="idTepDinhKem" name="idTepDinhKem" type="hidden" value="<?= $item->vanbandinhkem ?>">
        <?php if (!empty($item->vanbandinhkem)) : ?>
          <small>Hiện tại:
            <div class="d-flex flex-column">
              <?php foreach ($item->vanban as $vanban) : ?>
                <div>
                  <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>" class="mr-2">
                    <?php echo $vanban->filename ?>
                  </a>
                  <i class="fa fa-trash-alt bnt-deleteVanBan" data-idobject="<?= $item->vanbandinhkem ?>"
                    data-code="<?= $vanban->code ?>"></i>
                </div>
              <?php endforeach ?>
            </div>
          </small>
        <?php endif; ?>
      </div>

      <?php if ($item->id > 0): ?>
        <h5>Thông tin hệ thống</h5>
        <p><strong>Người tạo:</strong> <?= htmlspecialchars($item->name) ?></p>
        <p><strong>Ngày tạo mới:</strong> <?= htmlspecialchars($item->ngay_tao) ?></p>
        <p><strong>Email người tạo:</strong> <?= htmlspecialchars($item->email) ?></p>
      <?php endif ?>

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

      const fileInput = $('#dinhkem_vanbanlienquan .fileUploaded').val();
      const idVanban = $('#dinhkem_vanbanlienquan input[name="idObject"]').val();
      $('#idTepDinhKem').val(fileInput ? idVanban : '<?= $item->vanbandinhkem ?? '' ?>');

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
              window.location.href = '/index.php/component/thongbao/?view=thongbao&task=ds_thongbao';
            }, 500);
          }
        },
        error: function(xhr, status, error) {
          console.error('Submit error:', xhr.responseText);
          showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        }
      });
    });

    $('.bnt-deleteVanBan').on('click', async function(e) {
      const idObject = $(this).data('idobject')
      const codeVB = $(this).data('code')

      try {
        const response = await fetch(`index.php?option=com_thongbao&task=thongbao.deleteVanBan`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            idObject,
            codeVB,
          })
        });
        console.log(response)
      } catch (error) {
        console.error('Error:', error);
        showToast('Đã xảy ra lỗi khi xóa dữ liệu', 'danger');
      }
    })
  });
</script>