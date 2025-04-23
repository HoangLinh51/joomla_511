<?php 
    $ds_dotdanhgia = $this->ds_dotdanhgia;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$loaicongviec = $this->loaicongviec;
        $ds_iddotdanhgia = $this->ds_iddotdanhgia;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($id>0)?'Chỉnh sửa đánh giá cán bộ công chức theo loại công việc':'Thêm đánh giá cán bộ công chức theo loại công việc' ?></h4>
</div>
<div class="modal-body overflow-visible" style="overflow-y:scroll">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_loaicongviec" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#thongtin_loaicongviec">Thông tin loại công việc</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#cauhinh_dotdanhgia">Thiết lập đợt đánh giá sử dụng loại công việc</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="thongtin_loaicongviec" class="tab-pane in active">
                    <div class="row-fluid">
                        <div class="control-group">
                            <label class="control-label span4">Tên loại công việc<span style="color:red">*</span></label>
                            <div class="controls span8">
                                <input type="text" name="frm[name]" class="span12" autocomplete="off" value="<?php if($id>0) echo $loaicongviec['name']; ?>">
                                <input type="hidden" name="frm[id]" class="span12" value="<?php if($id>0) echo $loaicongviec['id']; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label span4">Trạng thái</label>
                            <div class="controls span8">
                                <label>
                                    <input type="checkbox" name="frm[status]" value="1" <?php if($id>0&&$loaicongviec['status']==1) echo 'checked'; ?>>
                                    <span class="lbl">Đang hoạt động</span>
                                </label>
                            </div>
                        </div>          
                    </div>
                </div>
                <div id="cauhinh_dotdanhgia" class="tab-pane">
                    <table class="table table-bordered">
                        <thead>
                            <th class="center">Danh sách đợt đánh giá</th>
                        </thead>
                        <tbody>
                            <?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
                            <?php 
                                $check = 0;
                                if($id>0&&count($ds_iddotdanhgia)>0){
                                    for($j=0;$j<count($ds_iddotdanhgia);$j++){
                                        if($ds_iddotdanhgia[$j]['id_dotdanhgia']==$ds_dotdanhgia[$i]['id']){
                                            $check = 1;
                                            break;
                                        }
                                    }
                                }
                            ?>
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" name="id_dotdanhgia[]" value="<?php echo $ds_dotdanhgia[$i]['id']; ?>" <?php if($check==1) echo 'checked'; ?>>
                                        <span class="lbl"><?php echo $ds_dotdanhgia[$i]['name']; ?></span>   
                                    </label>                                        
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_loaicongviec_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('#form_loaicongviec').validate({
            rules:{
                "frm[name]": {required: true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên loại công việc'}
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
        $('#btn_loaicongviec_luu').on('click',function(){
        	if($('#form_loaicongviec').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=loaicongviec&task=save_loaicongviec',
        			data: $('#form_loaicongviec').serialize(),
        			success:function(data){
        				if(data>0){
        					$('#modal-form').modal('hide');
        					$('#btn_tk_loaicongviec').click();
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