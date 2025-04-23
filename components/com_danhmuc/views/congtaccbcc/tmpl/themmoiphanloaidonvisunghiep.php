<?php 
	$id_phanloaidonvisunghiep = JRequest::getVar('id');
	if($id_phanloaidonvisunghiep){
		$phanloaidonvisunghiep = $this->phanloaidonvisunghiep;
	}
?>
<form id="form_phanloaidonvisunghiep" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="span3">Tên phân loại đơn vị sự nghiệp <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" id="name" value="<?php if($id_phanloaidonvisunghiep) echo $phanloaidonvisunghiep['name']; ?>">
			<input type="hidden" name="id" id="id" value="<?php if($id_phanloaidonvisunghiep) echo $phanloaidonvisunghiep['id']; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="span3">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" id="status" value="1" <?php echo ($id_phanloaidonvisunghiep && $phanloaidonvisunghiep['status']==1)?'checked':''; ?>>
				<span class="lbl">Đang hoạt động</span>
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="span3"></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" id="status" value="0" <?php echo ($id_phanloaidonvisunghiep && $phanloaidonvisunghiep['status']==0)?'checked':''; ?>>
				<span class="lbl">Không hoạt động</span>
			</label>
		</div>	
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_phanloaidonvisunghiep').validate({
	        rules:{
	            name: {required: true},
	            status: {required: true}
	        },
	        messages:{
	            status: {required:"Vui lòng chọn trạng thái"},
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