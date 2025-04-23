<?php 
	$ds_nganh = $this->ds_nganh;
	$ds_ngach = $this->ds_ngach;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	$id_ngach = $jinput->getInt('id_ngach',0);
    if($id_ngach>0){
    	$cb_bac_heso = $this->cb_bac_heso;
    }
	// var_dump($ds_ngach);die;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm mới ngạch</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_thongtin_ngach">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên Ngạch (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[name]" class="span12" autocomplete="off" value="<?php if($id_ngach>0) echo $cb_bac_heso['name']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id_ngach>0) echo $cb_bac_heso['id']; ?>">
					<input type="hidden" name="frm[manhom]" value="<?php echo $id; ?>">
				</div>
			</div>
			
		</div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Mã Ngạch (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[mangach]" class="span12" autocomplete="off" value="<?php if($id_ngach>0) echo $cb_bac_heso['mangach']; ?>">
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Thuộc Ngành (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[idnganh]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_nganh);$i++){ ?>
						<option value="<?php echo $ds_nganh[$i]['id']; ?>" <?php if($id_ngach>0&&$cb_bac_heso['idnganh']==$ds_nganh[$i]['id']) echo 'selected'; ?>><?php echo $ds_nganh[$i]['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Ngạch nâng lên</label>
				<div class="controls span9">
					<select class="span12 chzn-select" name="frm[mangachtiep]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_ngach);$i++){ ?>
						<option value="<?php echo $ds_ngach[$i]['mangach']; ?>" <?php if($id_ngach>0&&$cb_bac_heso['mangachtiep']==$ds_ngach[$i]['mangach']) echo 'selected'; ?>><?php echo $ds_ngach[$i]['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<label class="control-label span3">Vượt khung</label>
			<div class="controls span9">
				<label>
					<input type="checkbox" name="frm[is_vuotkhung]" value="1" <?php if($id_ngach>0&&$cb_bac_heso['is_vuotkhung']=='1') echo 'checked'; ?>>
					<span class="lbl"> 	Có/Không</span>
				</label>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_luu_thongtin_ngach">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_thongtin_ngach').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[mangach]": {required: true},
                "frm[idnganh]":{required:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên ngạch'},
                "frm[mangach]": {required: 'Vui lòng nhập mã ngạch'},
                "frm[idnganh]":{required:'Vui lòng chọn ngành'}
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
        var loadTableNgach = function(id){
			$.blockUI();
			$('#table_thongtin_ngach').load('index.php?option=com_danhmuc&controller=luong&task=table_thongtin_ngach&format=raw&id='+id,function(){
				$.unblockUI();
			});
		}
        $('#btn_luu_thongtin_ngach').on('click',function(){
        	if($('#form_thongtin_ngach').valid()==true){
        		$.blockUI();
        		var id = '<?php echo $id; ?>';
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=ngachbac&task=luu_thongtin_ngachbac',
        			data: $('#form_thongtin_ngach').serialize(),
        			success:function(data){
        				if(data==true){
        					loadTableNgach(id);
        					$('#modal-form').modal('hide');
        					loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
        					$.unblockUI();
        				}
        				else if(data==0){
        					loadNoticeBoardError('Thông báo','Ngạch này đã tồn tại.');
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