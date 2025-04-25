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
 * @author: huuthanh3108@gmaill.com
 * @date: 01-04-2015
 * @company : http://dnict.vn
 * 
 **/
if ($this->isCapnhat == 12): ?>
  <button class="btn btn-danger btn-sm" onclick="handleDelete('<?php echo $this->idObject ?>')" title="Xóa file">
    <i class="fas fa-trash-alt"></i> Xóa file đã chọn
  </button>
<?php endif; ?>

<?php if ($this->isCapnhat == 1): ?>
  <form name="frmUploadOne" enctype="multipart/form-data" action="<?php echo Uri::root(true); ?>/index.php?option=com_core&controller=attachment&task=uploadSingleImage" method="post" target="tftemp<?php echo $this->idObject ?>">
    <div class="mb-2">
      <label for="uploadfileone" class="btn btn-sm btn-primary">
        <i class="fas fa-upload"></i> Cập nhật Avatar
      </label>
      <input type="file" id="uploadfileone" name="uploadfile[]" onchange="document.frmUploadOne.submit();" hidden />
    </div>
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

<span class="form-text text-muted mb-2">Kích thước tối đa là 1MB.</span>
<iframe style="display:none;" id="tftemp<?php echo $this->idObject ?>" name="tftemp<?php echo $this->idObject ?>"></iframe>

<script>
  function handleDelete(objectId) {
    const checkboxes = document.getElementsByName(`DELidfiledk${objectId}[]`);
    let selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

    if (selected.length === 0) {
      alert("Bạn phải chọn ít nhất một dòng để xóa");
      return false;
    }

    if (confirm("Bạn có muốn xóa không")) {
      const url = `index.php?option=com_core&controller=attachment&format=raw&task=delete&type=<?php echo $this->type ?>&year=<?php echo $this->year ?>&iddiv=<?php echo $this->iddiv ?>&idObject=${objectId}&isTemp=<?php echo $this->isTemp ?>&from=attachment`;
      jQuery.post(url, {
        [`DELidfiledk${objectId}[]`]: selected
      }, function(resp) {
        jQuery(`#tftemp${objectId}`).html(resp);
      });
    }
    return false;
  }

  function removeFile(code) {
    if (confirm("Bạn có muốn xóa không")) {
      const url = `index.php?option=com_core&controller=attachment&format=raw&task=delete&type=<?php echo $this->type ?>&year=<?php echo $this->year ?>&iddiv=<?php echo $this->iddiv ?>&idObject=<?php echo $this->idObject ?>&isTemp=<?php echo $this->isTemp ?>&from=attachment`;
      jQuery.post(url, {
        [`DELidfiledk<?php echo $this->idObject ?>[]`]: code
      }, function(resp) {
        jQuery("#tftemp<?php echo $this->idObject ?>").html(resp);
      });
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