<?php 
	$party_pos_id = JRequest::getVar('id');
	if($party_pos_id){
		$party_pos = $this->party_pos;
	}
?>
<form id="form_party_pos" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" style="width:25%;margin-right:2%">Tên chức vụ Đảng <span style="color:red">*</span> </label>
		<div class="controls">
			<input type="text" name="name" value="<?php if($party_pos_id) echo $party_pos['name']; ?>"/>
			<input type="hidden" name="id" value="<?php if($party_pos_id) echo $party_pos['code']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:25%;margin-right:2%">Cấp độ</label>
		<div class="controls">
			<input type="text" name="level" value="<?php if($party_pos_id) echo $party_pos['level']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:25%;margin-right:2%">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" value="1" <?php echo ($party_pos_id && $party_pos['status']==1)?'checked':''; ?>><span class="lbl"> Đang sử dụng</span>
			</label>
			<label>
				<input type="radio" name="status" value="0" <?php echo ($party_pos_id && $party_pos['status']==0)?'checked':''; ?>><span class="lbl"> Không sử dụng</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_party_pos').validate({
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