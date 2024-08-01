<?php
/**
* @file: default.php
* @author: huuthanh3108@gmaill.com
* @date: 01-04-2015
* @company : http://dnict.vn
* 
**/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="background-color:transparent">
<form name=frmUpload enctype="multipart/form-data" action="" method="post" target="tftemp<?php echo $this->idObject?>">
<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
<table width=100% class="admintable" border=0>
<tr>
<td nowrap="nowrap" class=key>Chọn file đính kèm</td>
<td nowrap="nowrap">
<input type="file" />
			</td>
		</tr>
	</table>
	<a href="#" onclick="window.parent.document.getElementById('tftemp<?php echo $this->idObject?>').style.display='none'
	return false;"> 
	[ Hủy ] </a>
	<a href="#" onclick="document.frmUpload.submit(); return false;">[ Đính kèm ]</a>
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
<p id=lasttext></p>
<script>
var iframeElement = window.parent.document.getElementById('tftemp<?php echo $this->idObject?>');
iframeElement.style.height = ""+(document.getElementById("lasttext").offsetTop+10)+"px";
iframeElement.width = "100%"; 
if(typeof window.parent.resetHeight == "function") {	
	window.parent.resetHeight();
}
</script>
</body>
</html>