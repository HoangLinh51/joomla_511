<?php 
	$ds_dgcbcc_nhiemvu = $this->ds_dgcbcc_nhiemvu;
	$ds_dgcbcc_loaicongviec = $this->ds_dgcbcc_loaicongviec;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_theotieuchuan = $this->dgcbcc_theotieuchuan;
		$ds_dgcbcc_fk_nhiemvu_tieuchuan = $this->ds_dgcbcc_fk_nhiemvu_tieuchuan;
		$ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho = $this->ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($id>0)?'Chỉnh sửa tiêu chuẩn đánh giá cán bộ công chức':'Thêm tiêu chuẩn đánh giá cán bộ công chức' ?></h4>
</div>
<div class="modal-body overflow-visible" style="overflow:scroll">
    <div id="modal-content" class="slim-scroll" data-height="350">
		<form class="form-horizontal" id="form_dgcbcc_theotieuchuan" enctype="multipart/form-data">
			<?php echo JHtml::_( 'form.token' ); ?>
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#content_thongtintieuchuan">Thông tin tiêu chuẩn</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_cauhinhnguoidanhgia">Cấu hình người đánh giá</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_cauhinhnguoiduocdanhgia">Cấu hình người được đánh giá</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_cauhinhloaicongviec">Cấu hình loại công việc</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="content_thongtintieuchuan" class="tab-pane in active">
						<div class="row-fluid control-group">
							<div class="control-label span3">Tên tiêu chuẩn (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[name]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theotieuchuan['name']; ?>">
								<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $dgcbcc_theotieuchuan['id']; ?>">
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Mã tiêu chuẩn (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[code]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theotieuchuan['code']; ?>">
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Hệ số (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<input type="text" class="span12" name="frm[heso]" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_theotieuchuan['heso']; ?>">
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Cá nhân (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<select class="span12" name="frm[is_canhan]">
									<option value="">--Chọn--</option>
									<option value="0" <?php if($id>0&&$dgcbcc_theotieuchuan['is_canhan']==0) echo 'selected'; ?>>Không</option>
									<option value="1" <?php if($id>0&&$dgcbcc_theotieuchuan['is_canhan']==1) echo 'selected'; ?>>Có</option>
								</select>
							</div>
						</div>
						<div class="row-fluid control-group">
							<div class="span3 control-label">Đang sử dụng (<span style="color:red">*</span>)</div>
							<div class="controls span9">
								<select class="span12" name="frm[published]">
									<option value="">--Chọn--</option>
									<option value="0" <?php if($id>0&&$dgcbcc_theotieuchuan['published']==0) echo 'selected'; ?>>Không</option>
									<option value="1" <?php if($id>0&&$dgcbcc_theotieuchuan['published']==1) echo 'selected'; ?>>Có</option>
								</select>
							</div>
						</div>
					</div>
					<div id="content_cauhinhnguoidanhgia" class="tab-pane">
						<?php for($i=0;$i<count($ds_dgcbcc_nhiemvu);$i++){ ?>
							<?php 
								$check = 0;
								if($id>0&&count($ds_dgcbcc_fk_nhiemvu_tieuchuan)>0){				
									for($j=0;$j<count($ds_dgcbcc_fk_nhiemvu_tieuchuan);$j++){
										if($ds_dgcbcc_fk_nhiemvu_tieuchuan[$j]['id_nhiemvu']==$ds_dgcbcc_nhiemvu[$i]['id']){
											$check = 1;
										}
									}
								}
							?>
							<div class="row-fluid control-group">
								<label>
									<input type="checkbox" value="<?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?>" name="fk_tieuchuan_nhiemvu[]" <?php if($id>0&&$check==1) echo 'checked'; ?>>
									<span class="lbl"><?php echo $ds_dgcbcc_nhiemvu[$i]['name']; ?></span>
								</label>
							</div>
						<?php }?>
					</div>
					<div id="content_cauhinhnguoiduocdanhgia" class="tab-pane">
						<?php for($i=0;$i<count($ds_dgcbcc_nhiemvu);$i++){ ?>
							<?php 
								$check = 0;
								if($id>0&&count($ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho)>0){
									for($j=0;$j<count($ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho);$j++){
										if($ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho[$j]['id_nhiemvu']==$ds_dgcbcc_nhiemvu[$i]['id']){
											$check = 1;
										}
									}
								}
							?>
							<div class="row-fluid control-group">
								<label>
									<input type="checkbox" value="<?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?>" name="fk_tieuchuan_nhiemvu_danhgiacho[]" <?php if($id>0&&$check==1) echo 'checked'; ?>>
									<span class="lbl"><?php echo $ds_dgcbcc_nhiemvu[$i]['name']; ?></span>
								</label>
							</div>
						<?php }?>
					</div>
					<div id="content_cauhinhloaicongviec" class="tab-pane">
						<?php for($i=0;$i<count($ds_dgcbcc_loaicongviec);$i++){ ?>
							<?php 
								$check = 0;
								$arr_loaicongviec = explode(',',$dgcbcc_theotieuchuan['ids_loaicongviec']);
								if($id>0&&count($arr_loaicongviec)>0){				
									for($j=0;$j<count($arr_loaicongviec);$j++){
										if($arr_loaicongviec[$j]==$ds_dgcbcc_loaicongviec[$i]['id']){
											$check = 1;
										}
									}
								}
							?>
							<div class="row-fluid control-group">
								<label>
									<input type="checkbox" value="<?php echo $ds_dgcbcc_loaicongviec[$i]['id']; ?>" name="ids_loaicongviec[]" <?php if($id>0&&$check==1) echo 'checked'; ?>>
									<span class="lbl"><?php echo $ds_dgcbcc_loaicongviec[$i]['name']; ?></span>
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
		$('#form_dgcbcc_theotieuchuan').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[code]": {required: true},
                "frm[heso]": {required: true,number:true},
                "frm[is_canhan]": {required: true},
                "frm[published]": {required: true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên tiêu chuẩn'},
                "frm[code]": {required: 'Vui lòng nhập mã tiêu chuẩn'},
                "frm[heso]": {required: 'Vui lòng nhập hệ số',number: 'Vui lòng nhập số cho trường hệ số'},
                "frm[is_canhan]": {required: 'Vui lòng chọn trường cá nhân'},
                "frm[published]": {required: 'Vui lòng chọn trường đang sử dụng'}
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
        	if($('#form_dgcbcc_theotieuchuan').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_theotieuchuan&task=luu_dgcbcc_theotieuchuan',
        			data: $('#form_dgcbcc_theotieuchuan').serialize(),
        			success:function(data){
        				if(data>0){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_dgcbcc_theotieuchuan').click();
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