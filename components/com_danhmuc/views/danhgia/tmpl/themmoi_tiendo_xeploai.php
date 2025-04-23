<?php 
	$ds_dotdanhgia = $this->ds_dotdanhgia;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$tiendo = $this->tiendo;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm tiến độ</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_tiendo" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên tiến độ (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[name]" class="span12" value="<?php if($id>0) echo $tiendo['name']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $tiendo['id']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Hệ số (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[heso]" class="span12" value="<?php if($id>0) echo $tiendo['heso']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Hệ số tự đánh giá (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[heso_tu_dg]" class="span12" value="<?php if($id>0) echo $tiendo['heso_tu_dg']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Trạng thái</label>
				<div class="controls span9">
					<label>
						<input type="checkbox" value="1" name="frm[status]" <?php if($id>0&&$tiendo['status']==1) echo 'checked';?>>
						<span class="lbl">Đang hoạt động</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Đợt đánh giá</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[id_dotdanhgia]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
						<option value="<?php echo $ds_dotdanhgia[$i]['id']; ?>" <?php if($id>0&&$tiendo['id_dotdanhgia']==$ds_dotdanhgia[$i]['id']) echo 'selected';?>>
							<?php echo $ds_dotdanhgia[$i]['name']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_tiendo_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_tiendo').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[heso]": {required: true,number:true},
                "frm[heso_tu_dg]":{required:true,number:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên tiến độ'},
                "frm[heso]": 
                {
                	required: 'Vui lòng nhập hệ số',
                	number: 'Vui lòng nhập số cho trường hệ số'
                },
                "frm[heso_tu_dg]":
                {
                	required:'Vui lòng nhập hệ số từ đánh giá',
                	number: 'Vui lòng nhập số cho trường hệ số tự đánh giá'
                }
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
        $('#btn_tiendo_luu').on('click',function(){
        	if($('#form_tiendo').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=tiendo&task=luu_tiendo',
        			data: $('#form_tiendo').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					$('#select_id_dotdanhgia').change();
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