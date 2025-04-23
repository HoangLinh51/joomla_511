<?php 
	$ds_dotdanhgia_thang = $this->ds_dotdanhgia_thang;
	$jinput = JFactory::getApplication()->input;
	$id_tieuchi = $jinput->getInt('id_tieuchi',0);
	if($id_tieuchi>0){
		$tieuchi_donvi = $this->tieuchi_donvi;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thay đổi tiêu chí đánh giá cán bộ công chức</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_change_tieuchi_donvi" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Đợt đánh giá bắt đầu (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[id_dotdanhgia_batdau]" id="id_dotdanhgia_batdau">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dotdanhgia_thang);$i++){ ?>
						<option value="<?php echo $ds_dotdanhgia_thang[$i]['id_dotdanhgia']; ?>" <?php if($id_tieuchi>0&&$tieuchi_donvi['id_dotdanhgia_batdau']==$ds_dotdanhgia_thang[$i]['id_dotdanhgia']) echo 'selected'; ?>>
							<?php echo $ds_dotdanhgia_thang[$i]['name']; ?>
						</option>
						<?php }?>
					</select>
					<input type="hidden" name="frm[id_tieuchi]" value="<?php if($id_tieuchi>0) echo $id_tieuchi; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Đợt đánh giá kết thúc</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[id_dotdanhgia_ketthuc]" id="id_dotdanhgia_ketthuc">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_dotdanhgia_thang);$i++){ ?>
						<option value="<?php echo $ds_dotdanhgia_thang[$i]['id_dotdanhgia']; ?>" <?php if($id_tieuchi>0&&$tieuchi_donvi['id_dotdanhgia_ketthuc']==$ds_dotdanhgia_thang[$i]['id_dotdanhgia']) echo 'selected'; ?>>
							<?php echo $ds_dotdanhgia_thang[$i]['name']; ?>
						</option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Tên tiêu chí mới (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" class="span12" autocomplete="off" name="frm[name]" value="<?php if($id_tieuchi>0) echo $tieuchi_donvi['name']; ?>">
				</div>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_change_dgcbcc_tieuchi_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_change_tieuchi_donvi').validate({
            rules:{
                "frm[id_dotdanhgia_batdau]": {required: true},
                "frm[name]": {required: true}
            },
            messages:{
                "frm[id_dotdanhgia_batdau]": {required: 'Vui lòng chọn bắt đầu đợt đánh giá'},
                "frm[name]": {required: 'Vui lòng nhập tên bắt đầu đợt đánh giá'}
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
        $('#btn_change_dgcbcc_tieuchi_luu').on('click',function(){
        	if($('#form_change_tieuchi_donvi').valid()==true){
        		$.blockUI();
                var ds_dotdanhgia_thang = '<?php echo json_encode($ds_dotdanhgia_thang); ?>';
                ds_dotdanhgia_thang = JSON.parse(ds_dotdanhgia_thang);
                var id_dotdanhgia_batdau = $('#id_dotdanhgia_batdau').val();
                var id_dotdanhgia_ketthuc = $('#id_dotdanhgia_ketthuc').val();
                var date_dotdanhgia_batdau;
                var date_dotdanhgia_ketthuc;
                for(var i=0;i<ds_dotdanhgia_thang.length;i++){
                    if(ds_dotdanhgia_thang[i]['id_dotdanhgia']==id_dotdanhgia_batdau){
                        date_dotdanhgia_batdau = ds_dotdanhgia_thang[i]['date_dot'];
                    }
                    if(ds_dotdanhgia_thang[i]['id_dotdanhgia']==id_dotdanhgia_ketthuc){
                        date_dotdanhgia_ketthuc = ds_dotdanhgia_thang[i]['date_dot'];
                    }
                }
                if(date_dotdanhgia_batdau>=date_dotdanhgia_ketthuc){
                    loadNoticeBoardError('Thông báo','Đợt đánh giá bắt đầu phải nhỏ hơn đợt đánh giá kết thúc');
                    $.unblockUI();
                }
                else{
                    $.ajax({
                        type: 'post',
                        url: 'index.php?option=com_danhmuc&controller=tieuchi_donvi&task=luu_tieuchi_donvi',
                        data: $('#form_change_tieuchi_donvi').serialize(),
                        success:function(data){
                            if(data==true){
                                $('#modal-form').modal('hide');
                                $('#btn_tk_dgcbcc_botieuchi').click();
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
        	}
        	else{
        		return false;
        	}
        });
	});
</script>