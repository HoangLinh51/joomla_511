<?php
/**
* @file: attachment.php
* @author: huuthanh3108@gmaill.com
* @date: 01-04-2015
* @company : http://dnict.vn
* 
**/
$doc = JFactory::getDocument();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo JURI::root(true); ?>/media/jui/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/media/jui/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/media/jui/js/jquery-noconflict.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/media/cbcc/js/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/templates/ace/assets/js/jquery.gritter.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/templates/ace/assets/js/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/templates/ace/assets/js/ace-elements.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root(true); ?>/templates/ace/assets/js/ace.min.js" type="text/javascript"></script>
<link href="<?php echo JURI::root(true); ?>/templates/ace/assets/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo JURI::root(true); ?>/templates/ace/assets/css/bootstrap-responsive.min.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo JURI::root(true); ?>/templates/ace/assets/css/ace.min.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo JURI::root(true); ?>/templates/ace/assets/css/ace-responsive.min.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo JURI::root(true); ?>/templates/ace/assets/css/ace-skins.min.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="background-color:transparent">
<form name=frmUpload enctype="multipart/form-data" action="<?php echo JURI::root(true); ?>/index.php?option=com_core&controller=attachment&format=raw&task=doattachment" method="post" target="tftemp<?php echo $this->idObject?>">
<table class="table">
<tr>
	<td nowrap="nowrap">
		<input type="file" id="uploadCore" name="uploadfile" accept=".zip, .rar, .doc, .docx, .pdf" onchange="return fileuploadValidation()"/> <?php echo '<b style="color:red;">(Lưu ý: Dung lượng tối đa: '.(ini_get('upload_max_filesize')).'B)</b>'; ?>
	</td>
</tr>
<tr>
	<td>
		<a href="#" class="btn btn-mini btn-danger" onclick="window.parent.document.getElementById('tftemp<?php echo $this->idObject?>').style.display='none'; return false;"> 
		[Hủy]
		</a>
		<a href="#" class="btn btn-mini btn-primary btn-uploadcore" onclick="document.frmUpload.submit(); return false;">
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
<style>


</style>
<script>
var iframeElement = window.parent.document.getElementById('tftemp<?php echo $this->idObject?>');
iframeElement.style.height = ""+(document.getElementById("lasttext").offsetTop+10)+"px";
iframeElement.width = "100%"; 
if(typeof window.parent.resetHeight == "function") {	
	window.parent.resetHeight();
}
jQuery(document).ready(function($){
	$('input[name="uploadfile"]').ace_file_input({
		no_file:'Chưa chọn tập tin ...',
		btn_choose:'Chọn',
		btn_change:'Thay đổi',
		droppable:false,
		onchange:null,
		thumbnail:false, //| true | large
		whitelist:'doc|docx|xls|xlsx|pdf',
		blacklist:'exe|php'
		//onchange:''
		//
	});
});
</script>
<script>
var app = {};
var loadNoticeBoardError = function(title,text){
	jQuery.gritter.add({
		title: title,
		text: text,
		time: '207777777700',
		class_name: 'notice'
	});
};
</script>
<script>
	function fileuploadValidation() {
		var fileInput =document.getElementById('uploadCore');
		var filePath = fileInput.value;
		// Allowing file type

		var allowedExtensions =/(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
		if (!allowedExtensions.exec(filePath)) {
			alert ('Thông báo: Bản mềm các quyết định chỉ cho phép các định dạng: ZIP, RAR, DOC, DOCX, PDF');
			fileInput.value = '';
			return false;
		}
	}
</script>
</body>
</html>