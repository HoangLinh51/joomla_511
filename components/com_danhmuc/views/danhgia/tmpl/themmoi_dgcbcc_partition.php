<?php 
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_partition = $this->dgcbcc_partition;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thiết lập partition</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_dgcbcc_partition" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span4">Table (<span style="color:red">*</span>)</label>
				<div class="controls span8">
					<input type="text" name="frm[table]" class="span12" value="<?php if($id>0) echo $dgcbcc_partition['table']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $dgcbcc_partition['id']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span4">Key Partition (<span style="color:red">*</span>)</label>
				<div class="controls span8">
					<input type="text" name="frm[key_partition]" class="span12" value="<?php if($id>0) echo $dgcbcc_partition['key_partition']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span4">Key Table (<span style="color:red">*</span>)</label>
				<div class="controls span8">
					<input type="text" name="frm[key_table]" class="span12" value="<?php if($id>0) echo $dgcbcc_partition['key_table']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span4">Trạng thái</label>
				<div class="controls span8">
					<label>
						<input type="checkbox" value="1" name="frm[status]" <?php if($id>0&&$dgcbcc_partition['status']==1) echo 'checked'; ?>>
						<span class="lbl">Đang hoạt động</span>
					</label>
				</div>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dgcbcc_partition_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('#form_dgcbcc_partition').validate({
            rules:{
                "frm[table]": {required: true},
                "frm[key_partition]": {required: true},
                "frm[key_table]":{required:true}
            },
            messages:{
                "frm[table]": {required: 'Vui lòng nhập vào trường table'},
                "frm[key_partition]": {required: 'Vui lòng nhập vào trường key partition'},
                "frm[key_table]":{required:'Vui lòng nhập vào trường key table'}
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
        $('#btn_dgcbcc_partition_luu').on('click',function(){
        	if($('#form_dgcbcc_partition').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_partition&task=luu_dgcbcc_partition',
        			data: $('#form_dgcbcc_partition').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_dgcbcc_partition').click();
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