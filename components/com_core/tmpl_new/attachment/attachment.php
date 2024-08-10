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

// $is_new = Factory::getApplication()->input->getVar('is_new');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>



	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/legacy/js/jquery-noconflict.js" type="text/javascript"></script>

	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap/moment.min.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap/tempusdominus-bootstrap-4.min.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/global/plugins.bundle.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jstree-3.2.1/jstree.min.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/ace-elements.min.js" type="text/javascript"></script>

	<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/plugins/global/style.bundle.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/plugins/global/plugins.bundle.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/dist/css/adminltev3.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php  echo Uri::root(true); ?>/templates/adminlte/dist/css/_all-skins.min.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php  echo Uri::root(true); ?>/templates/adminlte//plugins/fontawesome-free/css/all.min.css" media="screen" rel="stylesheet" type="text/css" />

</head>

<body>
	<div id="" class="row" style="">
		<div class="col-lg-6">
			<!--begin::Form-->
			<div class="form" action="#" id="my-dropzone" method="post">
				<!--begin::Input group-->
				<div class="form-group row">
					<!--begin::Label-->
					<!-- <label class="col-lg-2 col-form-label">Upload Files:</label> -->
					<!--end::Label-->

					<!--begin::Col-->
					<div class="col-lg-10">
						<!--begin::Dropzone-->
						<div class="dropzone dropzone-multi" id="tftemp<?php echo $this->idObject ?>">
							<!--begin::Controls-->
							<div class="dropzone-panel mb-lg-0 mb-2">
								<a class="dropzone-select btn btn-sm btn-primary me-2">Đính kèm quyết định</a>
							</div>
							<!--end::Controls-->

							<!--begin::Items-->
							<div class="dropzone-items wm-200px">
								<div class="dropzone-item" style="display:none">
									<!--begin::File-->
									<div class="dropzone-file">
										<div class="dropzone-filename" title="some_image_file_name.jpg">
											<span data-dz-name class="linkFile"><a>some_image_file_name.jpg</a></span>
											<strong>(<span data-dz-size>340kb</span>)</strong>
										</div>

										<div class="dropzone-error" data-dz-errormessage></div>
									</div>
									<!--end::File-->

									<!--begin::Progress-->
									<div class="dropzone-progress">
										<div class="progress">
											<div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
											</div>
										</div>
									</div>
									<!--end::Progress-->

									<!--begin::Toolbar-->
									<div class="dropzone-toolbar">
										<span class="dropzone-delete" data-dz-remove><i class="fa fa-times"></i></span>
									</div>
									<!--end::Toolbar-->
								</div>
							</div>
							<!--end::Items-->
						</div>
						<!--end::Dropzone-->

						<!--begin::Hint-->
						<span class="form-text text-muted">Kích thước tệp tối đa là 1MB và số lượng tệp tối đa là 5.</span>
						<!--end::Hint-->
					</div>
					<!--end::Col-->
				</div>
				<!--end::Input group-->
				<input type="hidden" id="is_new" name="is_new" value="<?php echo $this->is_new ?>" />
				<input type="hidden" id="idObject" name="idObject" value="<?php echo $this->idObject ?>" />
				<input type="hidden" id="isTemp" name="isTemp" value="<?php echo $this->isTemp ?>" />
				<input type="hidden" id="year" name="year" value="<?php echo $this->year ?>" />
				<input type="hidden" id="iddiv" name="iddiv" value="<?php echo $this->iddiv ?>" />
				<input type="hidden" id="type" name="type" value="<?php echo $this->type ?>" />
				<input type="hidden" id="from" name="from" value="<?php echo $this->from ?>" />
				<input type="hidden" id="pdf" name="pdf" value="<?php echo $this->pdf ?>" />
				<input type="hidden" id="is_nogetcontent" name="is_nogetcontent" value="<?php echo $this->is_nogetcontent ?>" />
				<input type="hidden" id="id_user" name="id_user" value="<?php echo $this->id_user ?>" />
			</div>
			<!--end::Form-->
		</div>
	</div>
    <div id="upload-links"></div>



	
	
	
	
	
</body>

</html>
<script>
	
	Dropzone.autoDiscover = false
    // set the dropzone container id
	const id = "#tftemp<?php echo $this->idObject ?>";
    const dropzone = document.querySelector(id);
	console.log(dropzone);
    // set the preview element template
    var previewNode = dropzone.querySelector(".dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
		url: "/index.php?option=com_core&controller=attachment&format=raw&task=doattachment", // Set the url
		paramName: "file",
		autoProcessQueue: true, // Prevent automatic file upload
		uploadMultiple: false, // Upload files one by one
        parallelUploads: 20,
		maxFiles: 5, // Allow only one file
        maxFilesize: 10, // Max filesize in MB
        previewTemplate: previewTemplate,
        previewsContainer: id + " .dropzone-items", // Define the container to display the previews
        clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
        dropzoneItems.forEach(dropzoneItem => {
            dropzoneItem.style.display = '';
        });
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        const progressBars = dropzone.querySelectorAll('.progress-bar');
        progressBars.forEach(progressBar => {
            progressBar.style.width = progress + "%";
        });
    });
	var formData = jQuery("#my-dropzone").serializeArray();
    myDropzone.on("sending", function (file, xhr, formDataObject) {
        // Show the total progress bar when upload starts
		// formData.append("is_new", document.getElementById("is_new").value);
		// formData.append("idObject", document.getElementById("idObject").value);
		// formData.append("isTemp", document.getElementById("isTemp").value);
		// formData.append("year", document.getElementById("year").value);
		// formData.append("iddiv", document.getElementById("iddiv").value);
		// formData.append("type", document.getElementById("type").value);
		// formData.append("from", document.getElementById("from").value);
		// formData.append("pdf", document.getElementById("pdf").value);
		// formData.append("is_nogetcontent", document.getElementById("is_nogetcontent").value);
		// formData.append("id_user", document.getElementById("id_user").value);
		
		jQuery.each(formData, function(key, value) {
            formDataObject.append(value.name, value.value);
        });
        const progressBars = dropzone.querySelectorAll('.progress-bar');
        progressBars.forEach(progressBar => {
            progressBar.style.opacity = "1";
        });
    });

    // Hide the total progress bar when nothing"s uploading anymore
    myDropzone.on("complete", function (progress) {
        const progressBars = dropzone.querySelectorAll('.dz-complete');

        setTimeout(function () {
            progressBars.forEach(progressBar => {
                progressBar.querySelector('.progress-bar').style.opacity = "0";
                progressBar.querySelector('.progress').style.opacity = "0";
            });
        }, 300);
    });	
	
	myDropzone.on("success", function(file, response, index) {
		var fileElement = file.previewElement;
		var data =  JSON.parse(response)
		var iddiv = "<?php echo $this->iddiv ?>";
		if (fileElement) {
			// Find the .dropzone-filename element
			var filenameElement = fileElement.querySelector(".dropzone-filename");
			var linkElement = document.createElement("a");
				linkElement.href = data.fileUrl; // Use the returned file URL
				linkElement.textContent = data.file; // Use the returned file name
				linkElement.target = "_blank"; // Open link in a new tab
				linkElement.className = "filetaga";

			var hiddenElement = document.createElement('input');
				hiddenElement.type = 'hidden';
				hiddenElement.name = 'idFile-' + iddiv + '[]'; // Set the name attribute dynamically
				hiddenElement.id = 'idFile-' + iddiv; // Set the ID attribute dynamically
				hiddenElement.className = 'file-ids'; // Set the class attribute
				hiddenElement.value = data.code; // Set the value of the hidden input
				

			if (filenameElement) {
				// Set the data-dz-name attribute to the file name
				var nameSpan = filenameElement.querySelector("span[data-dz-name]");
				
				if (nameSpan) {
					nameSpan.setAttribute('data-dz-name', file.name);
					nameSpan.textContent  = '';
					nameSpan.appendChild(linkElement);
					nameSpan.appendChild(hiddenElement);
				}
			}
		}
    });
</script>
<style>
a.dz-clickable:hover{
    border-top: 3px solid transparent !important;
}
.filetaga{
	color: #7E8299;

}
.filetaga:hover{
	border-top: 3px solid transparent !important;

}
</style>