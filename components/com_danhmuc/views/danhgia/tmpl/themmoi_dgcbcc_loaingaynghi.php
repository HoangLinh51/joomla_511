<?php 
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_loaingaynghi = $this->dgcbcc_loaingaynghi;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($id>0)?'Chỉnh sửa đánh giá cán bộ công chức theo loại ngày nghỉ':'Thêm đánh giá cán bộ công chức theo loại ngày nghỉ' ?></h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_dgcbcc_loaingaynghi" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span4">Tên loại ngày nghỉ<span style="color:red">*</span></label>
				<div class="controls span8">
					<input type="text" name="frm[name]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_loaingaynghi['name']; ?>">
					<input type="hidden" name="frm[id]" class="span12" value="<?php if($id>0) echo $dgcbcc_loaingaynghi['id']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span4">Mô tả</label>
				<div class="controls span8">
					<input type="text" name="frm[mota]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_loaingaynghi['mota']; ?>">
				</div>
			</div>		
            <div class="control-group">
                <label class="control-label span4">Tỉ trọng</label>
                <div class="controls span8">
                    <input type="text" name="frm[titrong]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_loaingaynghi['titrong']; ?>">
                </div>
            </div>  	
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dgcbcc_loaingaynghi_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('#form_dgcbcc_loaingaynghi').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[titrong]": {number:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên loại ngày nghỉ'},
                "frm[titrong]": {number:'Vui lòng nhập số cho trường tỉ trọng'}
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
        $('#btn_dgcbcc_loaingaynghi_luu').on('click',function(){
        	if($('#form_dgcbcc_loaingaynghi').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_loaingaynghi&task=save_dgcbcc_loaingaynghi',
        			data: $('#form_dgcbcc_loaingaynghi').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_dgcbcc_loaingaynghi').click();
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