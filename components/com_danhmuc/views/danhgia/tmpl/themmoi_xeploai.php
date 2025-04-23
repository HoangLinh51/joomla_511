<?php 
	$ds_dotdanhgia = $this->ds_dotdanhgia;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$xeploai = $this->xeploai;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm xếp loại</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_xeploai" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên xếp loại (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[name]" class="span12" value="<?php if($id>0) echo $xeploai['name']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $xeploai['id']; ?>">
				</div>
			</div>
            <div class="control-group">
                <label class="control-label span3">Mã xếp loại</label>
                <div class="controls span9">
                    <input type="text" name="frm[code]" class="span12" value="<?php if($id>0) echo $xeploai['code']; ?>">
                </div>
            </div>
			<div class="control-group">
				<label class="control-label span3">Điểm thấp nhất (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[diem_min]" class="span12" value="<?php if($id>0) echo $xeploai['diem_min']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Điểm cao nhất (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[diem_max]" class="span12" value="<?php if($id>0) echo $xeploai['diem_max']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Sử dụng</label>
				<div class="controls span9">
					<label>
						<input type="checkbox" value="1" name="frm[published]" <?php if($id>0&&$xeploai['published']==1) echo 'checked';?>>
						<span class="lbl">Có</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Đợt đánh giá (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[id_dotdanhgia]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
						<option value="<?php echo $ds_dotdanhgia[$i]['id']; ?>" <?php if($id>0&&$xeploai['id_dotdanhgia']==$ds_dotdanhgia[$i]['id']) echo 'selected';?>>
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
	<span class="btn btn-small btn-success" id="btn_xeploai_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_xeploai').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[diem_min]": {required: true,number:true},
                "frm[diem_max]":{required:true,number:true},
                "frm[id_dotdanhgia]": {required:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên xếp loại'},
                "frm[diem_min]": 
                {
                	required: 'Vui lòng nhập điểm thấp nhất',
                	number: 'Vui lòng nhập số cho trường điểm thấp nhất'
                },
                "frm[diem_max]":
                {
                	required:'Vui lòng nhập điểm cao nhất',
                	number: 'Vui lòng nhập số cho trường điểm cao nhất'
                },
                "frm[id_dotdanhgia]": {required:'Vui lòng chọn đợt đánh giá'}
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
        $('#btn_xeploai_luu').on('click',function(){
        	if($('#form_xeploai').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=xeploai&task=luu_xeploai',
        			data: $('#form_xeploai').serialize(),
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