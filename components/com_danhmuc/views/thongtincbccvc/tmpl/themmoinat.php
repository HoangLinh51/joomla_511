<?php 
	$nat_id = JRequest::getVar('id');
	if($nat_id){
		$nat = $this->nat;
	}
?>
<form id="form_nat" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" style="width:25%;margin-right:2%">Tên dân tộc <span style="color:red">*</span> </label>
		<div class="controls">
			<input type="text" name="name" value="<?php if($nat_id) echo $nat['name']; ?>"/>
			<input type="hidden" name="id" value="<?php if($nat_id) echo $nat['id']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:25%;margin-right:2%">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" value="1" <?php echo ($nat_id && $nat['status']==1)?'checked':''; ?>><span class="lbl"> Đang sử dụng</span>
			</label>
			<label>
				<input type="radio" name="status" value="0" <?php echo ($nat_id && $nat['status']==0)?'checked':''; ?>><span class="lbl"> Không sử dụng</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_nat').validate({
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