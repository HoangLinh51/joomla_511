<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$modelThongbao = Core::model('Thongbao/Thongbao');
$item = $this->item;
?>

<div class="container my-3">
  <div class="content-box">
    <h2 class="mb-3 text-primary">
      <?php echo ((int)$item->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin thông báo
    </h2>
    <form action="<?= Route::_('index.php?option=com_thongbao&task=thongbao.edit_thongbao&id=' . (int)$item->id) ?>" id="formThongBao" name="formThongBao" method="post">
      <div class="form-group">
        <label for="tieude">Tiêu đề</label>
        <input type="text" class="form-control" id="tieude" name="tieude" maxlength="255" required
          value="<?= htmlspecialchars($item->tieude) ?>" oninput="validateLength(this, 255)">
        <small id="tieudeHelp" class="form-text text-muted text-danger d-none">Tiêu đề không được vượt quá 255 ký tự.</small>
      </div>

      <div class="form-group">
        <label for="noidung">Nội dung</label>
        <textarea class="form-control" id="noidung" name="noidung" rows="4" maxlength="510" required
          oninput="validateLength(this, 510)"><?= htmlspecialchars($item->noidung) ?></textarea>
        <small id="noidungHelp" class="form-text text-muted text-danger d-none">Nội dung không được vượt quá 510 ký tự.</small>
      </div>

      <div class="form-group">
        <label for="vanbandinhkem">Tệp đính kèm</label>
        <?php echo Core::inputAttachmentOneFile('dinhkem_vanbanlienquan', null, 1, date('Y'), -1); ?>
        <input id="idTepDinhKem" name="idTepDinhKem" type="hidden" value="<?= $item->vanbandinhkem ?>">
        <?php if (!empty($item->vanbandinhkem)) : ?>
          <small>Hiện tại:
            <div class="d-flex flex-column">
              <?php foreach ($item->vanban as $vanban) : ?>
                <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>">
                  <?php echo $vanban->filename ?>
                </a>
              <?php endforeach ?>
            </div>
          </small>
        <?php endif; ?>
      </div>

      <?php if ($item->id > 0): ?>
        <h5>Thông tin hệ thống</h5>
        <p><strong>Người tạo:</strong> <?= htmlspecialchars($item->name) ?></p>
        <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($item->ngay_tao) ?></p>
        <p><strong>Email người tạo:</strong> <?= htmlspecialchars($item->email) ?></p>
      <?php endif ?>

      <input type="hidden" name="id" value="<?= (int)$item->id ?>">
      <div class="float-right button">
        <a href="index.php/component/thongbao/?view=thongbao&task=default&id=<?= (int)$item->id ?>" class="btn btn-secondary">Hủy</a>
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
</style>

<script>
  // hàm check validate độ dài của input 
  function validateLength(input, maxLength) {
    const helpId = input.id + 'Help';
    const helpEl = document.getElementById(helpId);
    if (input.value.length > maxLength) {
      input.classList.add('is-invalid');
      if (helpEl) helpEl.classList.remove('d-none');
    } else {
      input.classList.remove('is-invalid');
      if (helpEl) helpEl.classList.add('d-none');
    }
  }
  // hàm thông báo 
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
  //hành động submit khi thêm mới hoặc sửa 
  $(document).ready(function() {
    $('#formThongBao').on('submit', function(e) {
      e.preventDefault();
      const fileInput = $('#dinhkem_vanbanlienquan').find('input[class="fileUploaded"]').val();
      if (fileInput && fileInput !== undefined) {
        const idVanban = $('#dinhkem_vanbanlienquan').find('input[name="idObject"]').val();
        $('#idTepDinhKem').val(idVanban);
      } else {
        $('#idTepDinhKem').val('<?= $item->vanbandinhkem ?? '' ?>');
      }
      let formData = new FormData(this);

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
            setTimeout(() => window.location.href = '/index.php/component/thongbao/?view=thongbao&task=ds_thongbao', 500);
          }
        },
        error: function(xhr, status, error) {
          console.error('Submit error:', xhr.responseText);
        }
      });
    });
  });
</script>