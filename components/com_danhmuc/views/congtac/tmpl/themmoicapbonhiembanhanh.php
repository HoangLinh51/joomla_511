<?php 
	$capbonhiembanhanh_id = JRequest::getVar('id');
	if($capbonhiembanhanh_id){
		$capbonhiembanhanh = $this->capbonhiembanhanh;
	}
?>
<form id="form_capbonhiembanhanh" class="form-horizontal" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" for="form-field-1" style="width:31%;margin-right:10%">Tên cấp bổ nhiệm / ban hành:</label>
		<div class="controls">
			<input type="text" name="ten" id="ten" style="width:45%" value="<?php if($capbonhiembanhanh_id) echo $capbonhiembanhanh['ten'];  ?>">
			<input type="hidden" name="id" value="<?php if($capbonhiembanhanh_id) echo $capbonhiembanhanh['id']; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:31%;margin-right:10%" for="trangthai">Trạng thái:</label>
		<div class="control">
			<label>
				<input type="radio" name="trangthai" value="1" <?php echo ($capbonhiembanhanh_id && $capbonhiembanhanh['trangthai']==1)?'checked':''; ?>> <span class="lbl">Đang hoạt động</span>
			</label>
			<label>
				<input type="radio" name="trangthai" value="0" <?php echo ($capbonhiembanhanh_id && $capbonhiembanhanh['trangthai']==0)?'checked':''; ?>> <span class="lbl">Không hoạt động</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_capbonhiembanhanh').validate({
			rules:{
				ten:{required:true},
				trangthai:{required:true}
			},
			messages:{
				ten:{required:"Vui lòng nhập tên"},
				trangthai:{required:"Vui lòng chọn trạng thái"}
			},
			invalidHandler: function (event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                        var message = errors == 1
                        ? 'Ki?m tra l?i sau:<br/>'
                        : 'Phát hi?n ' + errors + ' l?i sau:<br/>';
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