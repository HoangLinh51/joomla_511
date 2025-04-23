<?php 
	defined('_JEXEC') or die('Restricted access');
	$jinput = JFactory::getApplication()->input;
	$tc_id = $jinput->getString('tc_id','');
	if($tc_id){
		$tieuchi = $this->tieuchi;
	}
	$ds_nhomtieuchi = $this->ds_nhomtieuchi;
?>
<form id="form_tieuchi" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="row-fluid">
		<div class="control-group">
			<label class="control-label span3">Nhóm tiêu chí <span style="color:red">*</span></label>
			<div class="controls span8">
				<select name="id_nhom" class="span12">
					<option value="">Chọn nhóm tiêu chí</option>
					<?php 
						for($i=0;$i<count($ds_nhomtieuchi);$i++){ 
							if($tc_id&&$ds_nhomtieuchi[$i]['id']==$tieuchi['id_nhom']){
								$select = 'selected';
							}
							else{
								$select = '';
							}
					?>

						<option value="<?php echo $ds_nhomtieuchi[$i]['id']; ?>" <?php echo $select; ?>><?php echo $ds_nhomtieuchi[$i]['name']; ?></option>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Mã tiêu chí <span style="color:red">*</span></label>
			<div class="controls span8">
				<input type="text" class="span12" name="code" id="code" value="<?php if($tc_id) echo $tieuchi['code']; ?>"/>
				<input type="hidden" name="id" id="id" value="<?php if($tc_id) echo $tieuchi['id']; ?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Tên tiêu chí <span style="color:red">*</span></label>
			<div class="controls span8">
				<input type="text" class="span12" name="name" id="name" value="<?php if($tc_id) echo $tieuchi['name']; ?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Điểm min</label>
			<div class="controls span8">
				<input type="text" class="span12" name="diemmin" id="name" value="<?php if($tc_id) echo $tieuchi['diemmin']; ?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Điểm max</label>
			<div class="controls span8">
				<input type="text" class="span12" name="diemmax" id="name" value="<?php if($tc_id) echo $tieuchi['diemmax']; ?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Xếp loại</label>
			<div class="controls span8">
				<select name="code_xeploai" class="span12">
					<option value="">--Chọn--</option>
					<option value="Yếu" <?php if($tc_id>0&&$tieuchi['code_xeploai']=='Yếu') echo 'selected'; ?>>Yếu</option>
					<option value="Khá" <?php if($tc_id>0&&$tieuchi['code_xeploai']=='Khá') echo 'selected'; ?>>Khá</option>
					<option value="Tốt" <?php if($tc_id>0&&$tieuchi['code_xeploai']=='Tốt') echo 'selected'; ?>>Tốt</option>
					<option value="XS" <?php if($tc_id>0&&$tieuchi['code_xeploai']=='XS') echo 'selected'; ?>>XS</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label span3">Trạng thái <span style="color:red">*</span></label>
			<div class="controls span8">
				<label>
					<input type="radio" name="published" value="1" <?php echo ($tc_id&&$tieuchi['published']==1)?'checked':''; ?>><span class="lbl">Đang sử dụng</span>
				</label>
				<label>
					<input type="radio" name="published" value="0" <?php echo ($tc_id&&$tieuchi['published']==0)?'checked':''; ?>><span class="lbl">Không sử dụng</span>
				</label>
			</div>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_tieuchi').validate({
			rules:{
				'code':{required:true},
				'name':{required:true},
				'published':{required:true},
				'id_nhom':{required:true}
			},
			messages:{
				'code':{required:'Vui lòng nhập mã tiêu chí'},
				'name':{required:'Vui lòng nhập tên tiêu chí'},
				'published':{required:'Vui lòng chọn trạng thái'},
				'id_nhom':{required:'Vui lòng chọn nhóm tiêu chí'}
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