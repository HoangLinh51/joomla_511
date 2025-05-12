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
        <input type="text" class="form-control" id="tieude" name="tieude" value="<?= htmlspecialchars($item->tieude) ?>">
      </div>

      <div class="form-group">
        <label for="noidung">Nội dung</label>
        <textarea class="form-control" id="noidung" name="noidung" rows="4" required><?= htmlspecialchars($item->noidung) ?></textarea>
      </div>

      <div class="form-group">
        <label for="vanbandinhkem">Tệp đính kèm</label>
        <?php echo Core::inputAttachmentOneFile('dinhkem_vanbanlienquan', null, 1, date('Y'), -1); ?>
        <input id="idTepDinhKem" name="idTepDinhKem" type="hidden" value="<?= $item->vanbandinhkem ?>">
        <?php if (!empty($item->vanbandinhkem)) : ?>
          <small>Hiện tại:
            <div class="d-flex flex-column">
              <?php foreach ($modelThongbao->getVanBan($item->vanbandinhkem) as $vanban) : ?>
                <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>">
                  <?php echo $vanban->filename ?>
                </a>
              <?php endforeach ?>
            </div>
          </small>
        <?php endif; ?>
      </div>

      <hr>
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

  .button {
    padding-bottom: 20px;
  }
</style>

<script>
  $(document).ready(function() {
    $('#formThongBao').on('#submitBtn', function(e) {
      e.preventDefault();
      const fileInput = $('#dinhkem_vanbanlienquan').find('input[class="fileUploaded"]').val()
      //check file upload 
      if (fileInput && fileInput != undefined) {
        const idVanban = $('#dinhkem_vanbanlienquan').find('input[name="idObject"]').val();
        $('#idTepDinhKem').val(idVanban);
      } else {
        $('#idTepDinhKem').val(<?= $item->vanbandinhkem ?>);
      }
      let formData = new FormData(this);

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          console.log('view  --->', response);
          window.location.href = '/index.php/component/thongbao/?view=thongbao&task=ds_thongbao'
        },
        error: function(xhr, status, error) {
          // Xử lý lỗi
          // console.log(xhr.responseText);
        }
      });
    });
  });
</script>