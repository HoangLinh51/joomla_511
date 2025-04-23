<?php 
	defined('_JEXEC') or die('Restricted access');
	$jinput = JFactory::getApplication()->input;
	$ntc_id = $jinput->getString('ntc_id','');
	if($ntc_id){
		$nhomtieuchi = $this->nhomtieuchi;
	}
?>
<form id="form_nhomtieuchi" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label">Mã nhóm tiêu chí <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="code" id="code" value="<?php if($ntc_id) echo $nhomtieuchi['code']; ?>"/>
			<input type="hidden" name="id" id="id" value="<?php if($ntc_id) echo $nhomtieuchi['id']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Tên nhóm tiêu chí <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" id="name" value="<?php if($ntc_id) echo $nhomtieuchi['name']; ?>"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Trạng thái <span style="color:red">*</span></label>
		<div class="controls">
			<label>
				<input type="radio" name="published" value="1" <?php echo ($ntc_id&&$nhomtieuchi['published']==1)?'checked':''; ?>><span class="lbl">Đang sử dụng</span>
			</label>
			<label>
				<input type="radio" name="published" value="0" <?php echo ($ntc_id&&$nhomtieuchi['published']==0)?'checked':''; ?>><span class="lbl">Không sử dụng</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_nhomtieuchi').validate({
			rules:{
				'code':{required:true},
				'name':{required:true},
				'published':{required:true}
			},
			messages:{
				'code':{required:'Vui lòng nhập mã nhóm tiêu chí'},
				'name':{required:'Vui lòng nhập tên nhóm tiêu chí'},
				'published':{required:'Vui lòng chọn trạng thái'}
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