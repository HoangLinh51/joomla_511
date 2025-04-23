<?php 
	$cyu_id = JRequest::getVar('id');
	if($cyu_id){
		$cyu = $this->cyu;
	}
?>
<form id="form_cyu" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" style="width:20%">Tên chức vụ Đoàn <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" value="<?php if($cyu_id) echo $cyu['name']; ?>"/>
			<input type="hidden" name="id" value="<?php if($cyu_id) echo $cyu['id']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:20%">Cấp độ</label>
		<div class="controls">
			<input type="text" name="level" value="<?php if($cyu_id) echo $cyu['level']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" value="1" <?php echo ($cyu_id && $cyu['status']==1)?'checked':''; ?>><span class="lbl"> Đang sử dụng</span>
			</label>
			<label>
				<input type="radio" name="status" value="0" <?php echo ($cyu_id && $cyu['status']==0)?'checked':''; ?>><span class="lbl"> Không sử dụng</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_cyu').validate({
			rules:{
				name:{required:true},
				status:{required:true},
			},
			messages:{
				name:{required:"Vui lòng nhập tên"},
				status:{required:"Vui lòng chọn trạng thái"},
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