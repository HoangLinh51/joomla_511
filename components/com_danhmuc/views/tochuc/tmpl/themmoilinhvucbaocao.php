<?php 
	$jinput = JFactory::getApplication()->input;
    $id = $jinput->getInt('id',0);
    if($id&&$id>0){
    	$linhvucbaocao = $this->linhvucbaocao;
    }
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">
        <?php echo ($id&&$id>0)?'Chỉnh sửa lĩnh vực báo cáo':'Thêm mới lĩnh vực báo cáo' ?>         
    </h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
		<form class="form-horizontal" id="form_linhvucbaocao" enctype="multipart/form-data">
			<?php echo JHtml::_( 'form.token' ); ?>
			<div class="row-fluid">
				<div class="control-group">
					<label class="control-label span3">Tên lĩnh vực <span style="color:red">*</span></label>
					<div class="controls span7">
						<input type="text" name="frm[ten_linhvuc]" class="span12" value="<?php if($id&&$id>0) echo $linhvucbaocao['ten']; ?>">
						<input type="hidden" name="frm[id_linhvuc]" value="<?php if($id&&$id>0) echo $linhvucbaocao['id']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span3">Mã</label>
					<div class="controls span7">
						<input type="text" name="frm[ma_linhvuc]"  class="span12" value="<?php if($id&&$id>0) echo $linhvucbaocao['ma']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span3">Sử dụng</label>
					<div class="controls span7">
						<input type="checkbox" value="1" name="frm[trangthai]" <?php if($id&&$id>0&&$linhvucbaocao['trangthai']==1) echo 'checked'; ?>><label class="lbl"></label>
					</div>
				</div>
			</div>
		</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-primary" id="<?php echo ($id&&$id>0)?'btn_linhvucbaocao_update':'btn_linhvucbaocao_luu' ?>">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
    jQuery(document).ready(function($){
		$('#form_linhvucbaocao').validate({
            rules:{
                "frm[ten_linhvuc]": {required: true},
            },
            messages:{
                "frm[ten_linhvuc]": {required:"Vui lòng nhập tên lĩnh vực báo cáo"},
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
    	$('#btn_linhvucbaocao_luu').on('click',function(){
    		if($('#form_linhvucbaocao').valid()==true){
    			$.blockUI();
    			$.ajax({
    				type: 'post',
    				url: 'index.php?option=com_danhmuc&controller=linhvucbaocao&task=themmoilinhvucbaocao',
    				data: $('#form_linhvucbaocao').serialize(),
    				success:function(data){
    					if(data==true){
    						$('#btn_timkiem_linhvucbaocao').click();
    						$('#modal-form').modal('hide');
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
    	$('#btn_linhvucbaocao_update').on('click',function(){
    		if($('#form_linhvucbaocao').valid()==true){
    			$.blockUI();
    			$.ajax({
    				type: 'post',
    				url: 'index.php?option=com_danhmuc&controller=linhvucbaocao&task=updatelinhvucbaocao',
    				data: $('#form_linhvucbaocao').serialize(),
    				success:function(data){
    					if(data==true){
    						$('#btn_timkiem_linhvucbaocao').click();
    						$('#modal-form').modal('hide');
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