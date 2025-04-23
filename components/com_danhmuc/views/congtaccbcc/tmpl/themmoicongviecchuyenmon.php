<?php 
	$id_congviecchuyenmon = JRequest::getVar('id');
	if($id_congviecchuyenmon){
		$congviecchuyenmon = $this->congviecchuyenmon;
	}
?>
<form id="form_congviecchuyenmon" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<div class="row-fluid">
			<div class="span3">
				<label class="control-label span12">Tên công việc chuyên môn <span style="color:red">*</span></label>
			</div>
			<div class="controls span7">
				<input type="text" name="name" class="span12" id="name" value="<?php if($id_congviecchuyenmon) echo $congviecchuyenmon['name']; ?>">
				<input type="hidden" name="id" id="id" value="<?php if($id_congviecchuyenmon) echo $congviecchuyenmon['id']; ?>">
			</div>
		</div>	
	</div>
	<div class="control-group">
		<div class="row-fluid">
			<div class="span3">
				<label class="control-label span12">Trạng thái <span style="color:red">*</span></label>
			</div>
			<div class="controls span7">
				<label>
					<input type="radio" name="status" id="status" value="1" <?php echo ($id_congviecchuyenmon && $congviecchuyenmon['status']==1)?'checked':''; ?>>
					<span class="lbl">Đang hoạt động</span>
				</label>
				<label>
					<input type="radio" name="status" id="status" value="0" <?php echo ($id_congviecchuyenmon && $congviecchuyenmon['status']==0)?'checked':''; ?>>
					<span class="lbl">Không hoạt động</span>
				</label>
			</div>				
		</div>	
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_congviecchuyenmon').validate({
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