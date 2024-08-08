<?php
/**
* @file: attachment.php
* @author: huuthanh3108@gmaill.com
* @date: 01-04-2015
* @company : http://dnict.vn
* 
**/

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$doc = Factory::getDocument();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap/moment.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap/tempusdominus-bootstrap-4.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/plugins/global/style.bundle.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/plugins/global/plugins.bundle.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/dist/css/adminltev3.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/dist/css/_all-skins.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php  echo Uri::root(true); ?>/templates/adminlte//plugins/fontawesome-free/css/all.min.css" media="screen" rel="stylesheet" type="text/css" />




</head>
<body style="background-color:transparent">
<form name=frmUpload enctype="multipart/form-data" action="<?php echo Uri::root(true); ?>/index.php?option=com_core&controller=attachment&task=doattachment" method="post" target="tftemp<?php echo $this->idObject?>">
<table class="table">
<tr>
	<td nowrap="nowrap">
		<input type="file" name="uploadfile"/> <?php echo '<b style="color:red;">(Lưu ý: Dung lượng tối đa: '.(ini_get('upload_max_filesize')).'B)</b>'; ?>
	</td>
</tr>
<tr>
	<td>
		<a href="#" class="btn btn-mini btn-danger" onclick="window.parent.document.getElementById('tftemp<?php echo $this->idObject?>').style.display='none'; return false;"> 
		[Hủy]
		</a>
		<a href="#" class="btn btn-mini btn-primary" onclick="document.frmUpload.submit(); return false;">
		[Đính kèm]</a>
	</td>
</tr>
</table>
<input type="hidden" name="idObject" value="<?php echo $this->idObject?>" />
<input type="hidden" name="isTemp" value="<?php echo $this->isTemp?>" />
<input type="hidden" name="year" value="<?php echo $this->year?>" />
<input type="hidden" name="iddiv" value="<?php echo $this->iddiv?>" />
<input type="hidden" name="type" value="<?php echo $this->type?>" />
<input type="hidden" name="from" value="<?php echo $this->from?>" />
<input type="hidden" name="pdf" value="<?php echo $this->pdf?>"/>
<input type="hidden" name="is_nogetcontent" value="<?php echo $this->is_nogetcontent?>"/>
<input type="hidden" name="id_user" value="<?php echo $this->id_user?>"/>
</form>
<p id="lasttext"></p>

</body>
</html>