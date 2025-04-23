<?php
	$id_thuocdienquanly = JRequest::getVar('id');
	if($id_thuocdienquanly){
		$thuocdienquanly = $this->thuocdienquanly;
		// var_dump($thuocdienquanly);die;
	}

?>
<form id="form_thuocdienquanly" class="form-horizontal">
	<?php echo JHtml::_('form.token'); ?>
	<div class="control-group">
		<label class="span4">Tên thuộc diện quản lý <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" id="name" value="<?php if($id_thuocdienquanly) echo $thuocdienquanly['name']; ?>">
			<input type="hidden" name="id" id="id" value="<?php if($id_thuocdienquanly) echo $thuocdienquanly['id']; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="span4">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="trangthai" value="1" <?php echo ($id_thuocdienquanly && $thuocdienquanly['trangthai']==1)?'checked':''; ?> >
				<span class="lbl">Đang hoạt động</span>
			</label>			
		</div>
	</div>
	<div class="control-group">
		<label class="span4"></label>
		<div class="controls">
			<label>
				<input type="radio" name="trangthai" value="0" <?php echo ($id_thuocdienquanly && $thuocdienquanly['trangthai']==0)?'checked':''; ?> >
				<span class="lbl">Không hoạt động</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_thuocdienquanly').validate({
            rules:{
                name: {required: true},
                trangthai:{required:true}
            },
            messages:{
                trangthai: {required:"Vui lòng chọn trangthai"},
                name: {required:"Vui lòng nhập tên"},
            },
            invalidHandler: function (event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                        var message = errors == 1
                        ? 'Kiểm tra lỗi sau:<br/>'
                        : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errors = "";
                        if (validator.errorList.length > 0) {
                            for (x=0;x<validator.errorList.length;x++) {
                                    errors += "<br/>\u25CF " + validator.errorList[x].message;
                            }
                        }
                        loadNoticeBoardError('Thông báo',message + errors);
                }
                validator.focusInvalid();
            },
	    	errorPlacement: function(error, element) {
            }
        });
	});
</script>