<?php 
	$ds_dgcbcc_botieuchi = $this->ds_dgcbcc_botieuchi;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Sao chép bộ tiêu chí</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_saochep_dgcbcc_botieuchi" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên bộ tiêu chí sao chép (<span style="color:red">*</span>)</label>
				<div class="controls span7">
					<select class="chzn-select span12" name="frm[botieuchicon]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dgcbcc_botieuchi);$i++){ ?>
						<option value="<?php echo $ds_dgcbcc_botieuchi[$i]['id']; ?>"><?php echo $ds_dgcbcc_botieuchi[$i]['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Tên bộ tiêu chí lưu (<span style="color:red">*</span>)</label>
				<div class="controls span7">
					<select class="chzn-select span12" name="frm[botieuchicha]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dgcbcc_botieuchi);$i++){ ?>
						<option value="<?php echo $ds_dgcbcc_botieuchi[$i]['id']; ?>"><?php echo $ds_dgcbcc_botieuchi[$i]['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>		
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dgcbcc_botieuchi_saochep">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_saochep_dgcbcc_botieuchi').validate({
            rules:{
                "frm[botieuchicon]": {required:true},
                "frm[botieuchicha]": {required:true},
            },
            messages:{
                "frm[botieuchicon]": {required: 'Vui lòng chọn bộ tiêu chí sao chép'},
                "frm[botieuchicha]": {required: 'Vui lòng chọn bộ tiêu chí lưu'},
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
        $("#btn_dgcbcc_botieuchi_saochep").on('click',function(){
        	if($('#form_saochep_dgcbcc_botieuchi').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=saochep_dgcbcc_botieuchi',
        			data: $('#form_saochep_dgcbcc_botieuchi').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
        					$.unblockUI();
        					$('#btn_thietlaplai_dgcbcc_botieuchi').click();
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