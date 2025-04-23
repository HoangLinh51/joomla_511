<?php 
	$jinput = JFactory::getApplication()->input;
    $ds_dgcbcc_dotdanhgia = $this->ds_dgcbcc_dotdanhgia;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_xeploaichatluong = $this->dgcbcc_xeploaichatluong;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($id>0)?'Chỉnh sửa đánh giá cán bộ công chức theo xếp loại chất lượng':'Thêm đánh giá cán bộ công chức theo xếp loại chất lượng' ?></h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_dgcbcc_xeploaichatluong" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span4">Tên xếp loại chất lượng<span style="color:red">*</span></label>
				<div class="controls span8">
					<input type="text" name="frm[name]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_xeploaichatluong['name']; ?>">
					<input type="hidden" name="frm[id]" class="span12" value="<?php if($id>0) echo $dgcbcc_xeploaichatluong['id']; ?>">
				</div>
			</div>
            <div class="control-group">
                <label class="control-label span4">Hệ số</label>
                <div class="controls span8">
                    <input type="text" name="frm[heso]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_xeploaichatluong['heso']; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label span4">Hệ số từ đánh giá</label>
                <div class="controls span8">
                    <input type="text" name="frm[heso_tu_dg]" class="span12" autocomplete="off" value="<?php if($id>0) echo $dgcbcc_xeploaichatluong['heso_tu_dg']; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label span4">Đợt đánh giá</label>
                <div class="controls span8">
                    <select name="frm[id_dotdanhgia]" class="span12 chzn-select">
                        <option value="">--Chọn--</option>
                        <?php for($i=0;$i<count($ds_dgcbcc_dotdanhgia);$i++){ ?>
                        <option value="<?php echo $ds_dgcbcc_dotdanhgia[$i]['id']; ?>" <?php if($id>0&&$dgcbcc_xeploaichatluong['id_dotdanhgia']==$ds_dgcbcc_dotdanhgia[$i]['id']) echo 'selected'; ?>>
                            <?php echo $ds_dgcbcc_dotdanhgia[$i]['name']; ?>
                        </option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label span4">Trạng thái</label>
                <div class="controls span8">
                    <label>
                        <input type="checkbox" name="frm[status]" value="1" <?php if($id>0&&$dgcbcc_xeploaichatluong['status']==1) echo 'checked'; ?>>
                        <span class="lbl">Đang hoạt động</span>
                    </label>
                </div>
            </div>  		 	
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dgcbcc_xeploaichatluong_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
        $('.chzn-select').chosen({"width":"100%"});
		$('#form_dgcbcc_xeploaichatluong').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[heso]" :{number:true},
                "frm[heso_tu_dg]" :{number:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên xếp loại chất lượng'},
                "frm[heso]" :{number:'Vui lòng nhập số cho trường hệ số'},
                "frm[heso_tu_dg]" :{number:'Vui lòng nhập số cho trường hệ số từ đánh giá'}
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
        $('#btn_dgcbcc_xeploaichatluong_luu').on('click',function(){
        	if($('#form_dgcbcc_xeploaichatluong').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_xeploaichatluong&task=save_dgcbcc_xeploaichatluong',
        			data: $('#form_dgcbcc_xeploaichatluong').serialize(),
        			success:function(data){
        				if(data==true){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_dgcbcc_xeploaichatluong').click();
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