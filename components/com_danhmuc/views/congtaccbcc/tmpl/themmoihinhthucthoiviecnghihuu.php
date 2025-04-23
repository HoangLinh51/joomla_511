<?php
	$id_hinhthucthoiviecnghihuu = JRequest::getVar('id');
	if($id_hinhthucthoiviecnghihuu){
		$hinhthucthoiviecnghihuu = $this->hinhthucthoiviecnghihuu;
		// var_dump($hinhthucthoiviecnghihuu);die;
	}

?>
<form id="form_hinhthucthoiviecnghihuu" class="form-horizontal">
	<?php echo JHtml::_('form.token'); ?>
	<div class="control-group">
		<label class="span4">Tên hình thức thôi việc nghỉ hưu <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" id="name" value="<?php if($id_hinhthucthoiviecnghihuu) echo $hinhthucthoiviecnghihuu['name']; ?>">
			<input type="hidden" name="id" id="id" value="<?php if($id_hinhthucthoiviecnghihuu) echo $hinhthucthoiviecnghihuu['id']; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="span4">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" value="1" <?php echo ($id_hinhthucthoiviecnghihuu && $hinhthucthoiviecnghihuu['status']==1)?'checked':''; ?> >
				<span class="lbl">Đang hoạt động</span>
			</label>			
		</div>
	</div>
	<div class="control-group">
		<label class="span4"></label>
		<div class="controls">
			<label>
				<input type="radio" name="status" value="0" <?php echo ($id_hinhthucthoiviecnghihuu && $hinhthucthoiviecnghihuu['status']==0)?'checked':''; ?> >
				<span class="lbl">Không hoạt động</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_hinhthucthoiviecnghihuu').validate({
            rules:{
                name: {required: true},
                status:{required:true}
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