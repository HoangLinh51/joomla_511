<?php

use Joomla\CMS\Uri\Uri;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/global/style.bundle.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/global/plugins.bundle.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo Uri::root(true); ?>/templates/adminlte/dist/css/adminltev3.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo Uri::root(true); ?>/templates/adminlte/dist/css/_all-skins.min.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo Uri::root(true); ?>/templates/adminlte//plugins/fontawesome-free/css/all.min.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<?php
/**
 * @file: input.php
 * @author: LinhLH
 * @date: 19-05-2025
 * @company : http://dnict.vn
 * 
 **/

$formId = "imageUploadForm_" . $this->idObject;
$formName = "frmUploadMulti_" . $this->idObject;
$fileInputId = "uploadfiles_" . $this->idObject;
$previewContainerId = "imagePreviewsContainer_" . $this->idObject;
$iframeId = "tftemp" . $this->idObject;

?>

<?php if ($this->isCapnhat == 1): ?>
  <form id="<?php echo $formId; ?>" name="<?php echo $formName; ?>" enctype="multipart/form-data" action="<?php echo Uri::root(true); ?>/index.php?option=com_core&controller=attachment&task=uploadMultiImages" method="post" target="<?php echo $iframeId; ?>">
    <div class="mb-2">
      <label for="<?php echo $fileInputId; ?>" class="btn btn-sm btn-primary" style="cursor: pointer;">
        <i class="fas fa-upload"></i> Chọn ảnh (có thể chọn nhiều file)
      </label>
      <input type="file" id="<?php echo $fileInputId; ?>" name="uploadfiles[]" accept=".jpg, .jpeg, .png"
        onchange="document.forms['<?php echo $formName; ?>'].submit();" hidden multiple />
      <?php // input file: name="uploadfiles[]" cho phép gửi mảng file, "multiple" cho phép chọn nhiều file từ dialog 
      ?>
    </div>
    <?php // Các input hidden chứa thông tin bổ sung gửi kèm theo file 
    ?>
    <input type="hidden" name="idObject" value="<?php echo $this->idObject ?>" />
    <input type="hidden" name="isTemp" value="<?php echo $this->isTemp ?>" />
    <input type="hidden" name="year" value="<?php echo $this->year ?>" />
    <input type="hidden" name="iddiv" value="<?php echo $this->iddiv ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type ?>" />
    <input type="hidden" name="from" value="<?php echo $this->from ?>" />
    <input type="hidden" name="pdf" value="<?php echo $this->pdf ?>" />
    <input type="hidden" name="is_nogetcontent" value="<?php echo $this->is_nogetcontent ?>" />
    <input type="hidden" name="id_user" value="<?php echo $this->id_user ?>" />
  </form>
<?php endif; ?>

<span class="form-text text-muted mb-2">Kích thước tối đa mỗi file là 1MB. Định dạng: JPG, JPEG, PNG.</span>

<div id="<?php echo $previewContainerId; ?>" class="mt-2" style="display: flex; flex-wrap: wrap; gap: 10px;">
  <?php // Nếu có ảnh đã tồn tại và muốn hiển thị sẵn, bạn có thể load chúng ở đây bằng PHP 
  ?>
</div>

<iframe style="display:none;" id="<?php echo $iframeId; ?>" name="<?php echo $iframeId; ?>"></iframe>

<script type="text/javascript">
  function updateImagePreview_<?php echo $this->idObject ?>(htmlContent) {
    const container = document.getElementById("<?php echo $previewContainerId ?>");
    if (container) {
      container.innerHTML = htmlContent;
    }
  }
</script>

<style>
  a.dz-clickable:hover {
    border-top: 3px solid transparent !important;
  }

  .filetaga {
    color: #7E8299;
  }

  .linkFile a:hover {
    border-top: 3px solid transparent !important;
  }

  #attactment_tochuc-error {
    color: red;
  }
</style>