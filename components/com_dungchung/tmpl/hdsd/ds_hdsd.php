<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>

<div class="m-4">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-book-open"></i> Hướng dẫn sử dụng</h3>
      </div>
      <?php if ($this->permissionAdmin === true) { ?>
        <div class="col-sm-6 text-right" style="padding:0;">
          <a href="index.php?option=com_dungchung&view=hdsd&task=add_hdsd" class="btn btn-primary" style="font-size:16px;width:136px">
            <i class="fas fa-plus"></i> Thêm mới
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php foreach ($this->listHdsd as $hdsd) : ?>
    <div class="card flex-row justify-content-between align-items-center p-3">
      <div class="">
        <?php if ($hdsd->icon && !empty($hdsd->icon)) { ?>
          <i class="<?php echo $hdsd->icon ?> text-primary pr-3" style="font-size: 24px"></i>
        <?php } ?>
        <span style="font-weight: 600;"><?php echo $hdsd->tieude ?></span>
      </div>
      <div>
        <button class="btn btn-primary btn-sm btn-xemfile" data-code="<?php echo $hdsd->code ?>" data-folder="<?php echo $hdsd->folder ?>">
          <i class=" fas fa-eye"></i>
          Xem trực tiếp  
        </button>
        <button class="btn btn-primary btn-sm btn-taifile" data-code="<?php echo $hdsd->code ?>" data-folder="<?php echo $hdsd->folder ?>">
          <i class="fas fa-download"></i> Tải file
        </button>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  $(document).ready(function() {
    $('body').delegate('.btn-taifile', 'click', function() {
      window.location.href = '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' + $(this).data('nam') + '&code=' + $(this).data('code');
    });
    $('body').on('click', '.btn-xemfile', function() {
      const fileCode = $(this).data('code');
      const folder = $(this).data('folder');
      const url = '/index.php?option=com_dungchung&view=hdsd&format=raw&task=viewpdf&file=' + fileCode + '&folder=' + folder;
      window.open(url, '_blank'); // mở ra tab mới
    });
  })
</script>