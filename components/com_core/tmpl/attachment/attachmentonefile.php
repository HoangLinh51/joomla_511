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
if ($this->isCapnhat == 12) {
?>
	<span class="btn btn-danger btn-mini" style="line-height: 22px !important;" onclick='
    var ln = 0;
	var arr = document.getElementsByName("DELidfiledk<?php echo $this->idObject ?>[]");
	for(var i = 0 ; i < arr.length ;i++ ){
		if(arr[i].checked == true){
			ln = 1;
		}
	}
	if(ln == 1){
		if(confirm("Bạn có muốn xóa không")){
		var names = [];
		for(var i = 0 ; i < arr.length ;i++ ){
			if(arr[i].checked == true){
				names.push(arr[i].value);
			}
		}     
			var url="index.php?option=com_core&controller=attachment&format=raw&task=delete&type=<?php echo $this->type ?>&year=<?php echo $this->year ?>&iddiv=<?php echo $this->iddiv ?>&idObject=<?php echo $this->idObject ?>&isTemp=<?php echo $this->isTemp ?>&from=attachment";
   			jQuery.post(url,{"DELidfiledk<?php echo $this->idObject ?>[]":names},function(resp){
   				jQuery("#tftemp<?php echo $this->idObject ?>").html(resp);
   			});
		}
	}
	else
	{
		alert("Bạn phải chọn ít nhất một dòng để xóa");
	}
    return false;
    '><i class="icon-trash"></i></span>
<?php } ?>
<?php if ($this->isCapnhat == 1) { ?>
	<form name=frmUploadOne enctype="multipart/form-data" action="<?php echo Uri::root(true); ?>/index.php?option=com_core&controller=attachment&task=doattachmentone" method="post" target="tftemp<?php echo $this->idObject ?>">
		<div class="dropzone-panel mb-lg-0 mb-2">
			<label for="uploadfileone" class="dropzone-select btn btn-sm btn-primary me-2">Đính kèm file</label>
			<input type="file" id="uploadfileone" name="uploadfile[]" onchange="document.frmUploadOne.submit();" style="display:none;" />
		</div>

		<div class="progress" style="display:none; margin-top: 10px;">
			<div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
<?php } ?>
<!-- <span class="form-text text-muted">Kích thước tệp tối đa là 1MB và số lượng tệp tối đa là 1.</span> -->
<span class="form-text text-muted">Kích thước tệp tối đa là 1MB.</span>
<span id="<?php echo $this->iddiv ?>-error" data-dz-errormessage></span>
<?php
$stt = 0;
$maxFiles = 10; // Maximum number of files allowed
$maxFileSizeKB = 1024; // Maximum file size allowed (in KB)
if (count($this->data) > $maxFiles) {
	echo "Error: You can only upload up to $maxFiles files.";
} else {

	for ($i = 0, $n = count($this->data); $i < $n; $i++) {
		$item = $this->data[$i];
		$file =  $item['folder'] . '/' . $item['code'];
		$fileSizeMB = round(filesize($file) / 1024, 2);
		if ($fileSizeMB > $maxFileSizeKB) {
			echo "<div class='dropzone-error'>Error: The file {$item['filename']} exceeds the maximum allowed size of {$maxFileSizeKB}KB.</div>";
			continue; // Skip processing this file
		}
		$stt++;
?>
		<?php if ($this->isCapnhat == 1) { ?>
			<input type="hidden" name="fileupload_id[]" value="<?php echo $item['id']; ?>">
			<input type="hidden" class="fileUploaded" name="idFile-<?php echo $this->iddiv; ?>[]" value=<?php echo $item['code']; ?>>
			<!-- <input checked="checked" type=checkbox class="DELidfiledk<?php echo $this->idObject ?>" name='DELidfiledk<?php echo $this->idObject ?>[]' value='<?php echo $item['code']; ?>'> -->
		<?php } else
			echo $stt . ".";
		?>
		<div class="<?php echo $this->iddiv; ?> dropzone dropzone-multi col-lg-8">
			<div class="dropzone-items wm-200px">
				<div class="dropzone-item">
					<!--begin::File-->
					<div class="dropzone-file">
						<div class="dropzone-filename" title="some_image_file_name.jpg">
							<span data-dz-name class="linkFile"><a target="_blank" href="<?php echo Uri::root(true) ?>/index.php?option=com_core&controller=attachment&format=raw&task=download&year=<?php echo $this->year; ?>&code=<?php echo $item['code'] ?>"><?php echo $item['filename']; ?></a></span>
							<strong>(<span data-dz-size><?php echo $fileSizeMB ?>kb</span>)</strong>
						</div>
						<div class="dropzone-error" data-dz-errormessage></div>
					</div>
					<!--end::File-->


					<!--begin::Toolbar-->
					<div class="dropzone-toolbar">
						<span class="dropzone-delete" onclick="removeFile()" data-code="<?php echo $item['code'] ?>" name="DELidfiledk<?php echo $this->idObject ?>[]" data-dz-remove><i class="fa fa-times"></i></span>
					</div>
					<!--end::Toolbar-->
				</div>
			</div>
			<!--end::Items-->
		</div>
	<?php } ?>
<?php } ?>
<iframe style="overflow-x:visible;display:none;" id="tftemp<?php echo $this->idObject ?>" name="tftemp<?php echo $this->idObject ?>"></iframe>
<script type="text/javascript">
	if (jQuery('.div_secured').length > 0) {
		if (jQuery('.fileUploaded').length > 0 || jQuery('.btn_remove_soqd').length > 0) {
			jQuery('.div_secured').show();
		} else {
			jQuery('.div_secured').hide();
		}
	}


	function removeFile() {
		var arr = document.getElementsByName("DELidfiledk<?php echo $this->idObject ?>[]");

		if (jQuery(arr).attr('data-code') != '') {
			if (confirm("Bạn có muốn xóa không")) {

				// Build the URL and send the AJAX request
				var url = "index.php?option=com_core&controller=attachment&format=raw&task=delete&type=<?php echo $this->type ?>&year=<?php echo $this->year ?>&iddiv=<?php echo $this->iddiv ?>&idObject=<?php echo $this->idObject ?>&isTemp=<?php echo $this->isTemp ?>&from=attachment";

				jQuery.post(url, {
					"DELidfiledk<?php echo $this->idObject ?>[]": jQuery(arr).attr('data-code')
				}, function(resp) {
					jQuery("#tftemp<?php echo $this->idObject ?>").html(resp);
				});
			}
		} else {
			alert("Bạn phải chọn ít nhất một dòng để xóa");
		}

		return false;
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