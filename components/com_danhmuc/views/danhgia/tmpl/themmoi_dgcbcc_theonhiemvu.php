<?php 
	$ds_dgcbcc_tieuchuan = $this->ds_dgcbcc_tieuchuan;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_theonhiemvu = $this->dgcbcc_theonhiemvu;
		$ds_dgcbcc_fk_nhiemvu_tieuchuan = $this->ds_dgcbcc_fk_nhiemvu_tieuchuan;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($id>0)?'Chỉnh sửa nhiệm vụ đánh giá cán bộ công chức':'Thêm nhiệm vụ đánh giá cán bộ công chức' ?></h4>
</div>
<div class="modal-body overflow-visible" style="overflow:scroll">
    <div id="modal-content" class="slim-scroll" data-height="350">
		<form class="form-horizontal" id="form_dgcbcc_theonhiemvu" enctype="multipart/form-data">
			<?php echo JHtml::_( 'form.token' ); ?>
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#content_thongtinnhiemvu">Thông tin nhiệm vụ</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_cauhinhtieuchuan">Cấu hình tiêu chuẩn</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="content_thongtinnhiemvu" class="tab-pane in active">
						<div class="row-fluid control-group">
							<div class="control-label span3">Tên nhiệm vụ (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[name]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theonhiemvu['name']; ?>">
								<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $dgcbcc_theonhiemvu['id']; ?>">
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Mã nhiệm vụ (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[code]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theonhiemvu['code']; ?>">
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Biểu mẫu</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[template]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theonhiemvu['template']; ?>">
							</div>
						</div>
					</div>
					<div id="content_cauhinhtieuchuan" class="tab-pane">
						<?php for($i=0;$i<count($ds_dgcbcc_tieuchuan);$i++){ ?>
							<?php 
								$check = 0;
								if($id>0&&count($ds_dgcbcc_fk_nhiemvu_tieuchuan)>0){				
									for($j=0;$j<count($ds_dgcbcc_fk_nhiemvu_tieuchuan);$j++){
										if($ds_dgcbcc_fk_nhiemvu_tieuchuan[$j]['id_tieuchuan']==$ds_dgcbcc_tieuchuan[$i]['id']){
											$check = 1;
										}
									}
								}
							?>
							<div class="row-fluid control-group">
								<label>
									<input type="checkbox" value="<?php echo $ds_dgcbcc_tieuchuan[$i]['id']; ?>" name="fk_tieuchuan_nhiemvu[]" <?php if($id>0&&$check==1) echo 'checked'; ?>>
									<span class="lbl"><?php echo $ds_dgcbcc_tieuchuan[$i]['name']; ?></span>
								</label>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dgcbcc_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('#form_dgcbcc_theonhiemvu').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[code]": {required: true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên nhiệm vụ'},
                "frm[code]": {required: 'Vui lòng nhập mã nhiệm vụ'}
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
        $('#btn_dgcbcc_luu').on('click',function(){
        	if($('#form_dgcbcc_theonhiemvu').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_theonhiemvu&task=luu_dgcbcc_theonhiemvu',
        			data: $('#form_dgcbcc_theonhiemvu').serialize(),
        			success:function(data){
        				if(data>0){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_dgcbcc_theonhiemvu').click();
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