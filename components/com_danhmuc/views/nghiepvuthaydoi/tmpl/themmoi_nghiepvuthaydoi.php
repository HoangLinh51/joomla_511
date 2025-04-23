<?php 
	$jinput = JFactory::getApplication()->input;
    $id = $jinput->getInt('id',0);
    if($id>0){
    	$nghiepvuthaydoi = $this->nghiepvuthaydoi;
    }
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm nghiệp vụ thay đổi</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_nghiepvuthaydoi" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên nghiệp vụ thay đổi (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[ten]" class="span12" value="<?php if($id>0) echo $nghiepvuthaydoi['ten']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $nghiepvuthaydoi['id']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Mã nghiệp vụ thay đổi</label>
				<div class="controls span9">
					<input type="text" name="frm[ma]"  class="span12" value="<?php if($id>0) echo $nghiepvuthaydoi['ma']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Trạng thái</label>
				<div class="controls span9">
					<label>
						<input type="checkbox" name="frm[trangthai]" value="1" <?php if($id==0) echo 'checked'; ?> <?php echo ($id>0&&$nghiepvuthaydoi['trangthai']==1)?'checked':''; ?>><span class="lbl">Đang hoạt động</span>
					</label>
				</div>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_nghiepvuthaydoi_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('#form_nghiepvuthaydoi').validate({
            rules:{
                "frm[ten]": {required: true}
            },
            messages:{
                "frm[ten]": {required: 'Vui lòng nhập tên nghiệp vụ thay đổi'}
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
        $('#btn_nghiepvuthaydoi_luu').on('click',function(){
        	if($('#form_nghiepvuthaydoi').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=nghiepvuthaydoi&task=luu_nghiepvuthaydoi',
        			data: $('#form_nghiepvuthaydoi').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_nghiepvuthaydoi').click();
        					loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
        					$.unblockUI();
        				}
        				else{
        					loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
        					$.unblockUI();
        				}
        			},
        			error:function(){
        				loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
        				$.unblockUI();
        			}
        		});
        	}
        	else{
        		return false;
        	}
        });
	});
</script>