<?php 
	$ds_botieuchi = $this->ds_botieuchi;
	$jinput = JFactory::getApplication()->input;
	$model = Core::model('Danhmuchethong/Dotdanhgia');
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dotdanhgia = $this->dotdanhgia;
		$date_dot = $model->ConvertFormatDateFromDb($dotdanhgia['date_dot']);
		$ngaybatdau = $model->ConvertFormatDateFromDb($dotdanhgia['ngaybatdau']);
		$ngaytudanhgia = $model->ConvertFormatDateFromDb($dotdanhgia['ngaytudanhgia']);
		$ngayketthuc = $model->ConvertFormatDateFromDb($dotdanhgia['ngayketthuc']);
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm đợt đánh giá cán bộ công chức</h4>
</div>
<div class="modal-body overflow-visible">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_dotdanhgia" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label span3">Tên bộ tiêu chí (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<select class="chzn-select span12" name="frm[id_botieuchi]">
						<option value="">--Chọn--</option>
						<?php for($i=0;$i<count($ds_botieuchi);$i++){ ?>
						<option value="<?php echo $ds_botieuchi[$i]['id']; ?>" <?php if($id>0&&$dotdanhgia['id_botieuchi']==$ds_botieuchi[$i]['id']) echo 'selected'; ?>>
							<?php echo $ds_botieuchi[$i]['name']; ?>		
						</option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Tên đợt đánh giá (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[name]" class="span12" value="<?php if($id>0) echo $dotdanhgia['name']; ?>">
					<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $dotdanhgia['id']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Ngày diễn ra đánh giá</label>
				<div class="controls span9 input-append">
					<input type="text" class="date-picker" data-date-format="dd/mm/yyyy" name="frm[date_dot]" style="width:94%" value="<?php if($id>0) echo $date_dot; ?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Ngày bắt đầu (<span style="color:red">*</span>)</label>
				<div class="controls span9 input-append">
					<input type="text" class="date-picker" data-date-format="dd/mm/yyyy" name="frm[ngaybatdau]" style="width:94%" value="<?php if($id>0) echo $ngaybatdau; ?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Ngày tự đánh giá (<span style="color:red">*</span>)</label>
				<div class="controls span9 input-append">
					<input type="text" class="date-picker" data-date-format="dd/mm/yyyy" name="frm[ngaytudanhgia]" style="width:94%" value="<?php if($id>0) echo $ngaytudanhgia; ?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Ngày kết thúc (<span style="color:red">*</span>)</label>
				<div class="controls span9 input-append">
					<input type="text" class="date-picker" data-date-format="dd/mm/yyyy" name="frm[ngayketthuc]" style="width:94%" value="<?php if($id>0) echo $ngayketthuc; ?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Thời gian diễn ra đợt đánh giá (<span style="color:red">*</span>)</label>
				<div class="controls span9">
					<input type="text" name="frm[time_dot]" class="span12" value="<?php if($id>0) echo $dotdanhgia['time_dot']; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Đánh giá năm</label>
				<div class="controls span9">
					<label>
						<input type="checkbox" name="frm[is_danhgianam]" value="1" <?php if($id>0&&$dotdanhgia['is_danhgianam']==1) echo 'checked'; ?>>
						<span class="lbl">Đã đánh giá</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Khóa</label>
				<div class="controls span9">
					<label>
						<input type="checkbox" name="frm[is_lock]" value="1" <?php if($id>0&&$dotdanhgia['is_lock']==1) echo 'checked'; ?>>
						<span class="lbl">Đã khóa</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label span3">Ghi chú</label>
				<div class="controls span9">
					<input type="text" name="frm[ghichu]" class="span12"value="<?php if($id>0) echo $dotdanhgia['ghichu']; ?>">
				</div>
			</div>
		</div>
	</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-success" id="btn_dotdanhgia_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('.date-picker').datepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('#form_dotdanhgia').validate({
            rules:{
                "frm[id_botieuchi]": {required: true},
                "frm[name]": {required: true},
                "frm[ngaybatdau]":{required:true},
                "frm[ngaytudanhgia]":{required:true},
                "frm[ngayketthuc]":{required:true},
                "frm[time_dot]":{required:true,number:true}
            },
            messages:{
                "frm[id_botieuchi]": {required: 'Vui lòng chọn bộ tiêu chí'},
                "frm[name]": {required: 'Vui lòng nhập tên đợt đánh giá'},
                "frm[ngaybatdau]":{required:'Vui lòng chọn ngày bắt đầu'},
                "frm[ngaytudanhgia]":{required:'Vui lòng chọn ngày tự đánh giá'},
                "frm[ngayketthuc]":{required:'Vui lòng chọn ngày kết thúc'},
                "frm[time_dot]":
                {
                	required:'Vui lòng nhập thời gian diễn ra đợt đánh giá',
                	number: 'Vui lòng nhập số cho trường thời gian diễn ra đợt đánh giá'
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
        $('#btn_dotdanhgia_luu').on('click',function(){
        	if($('#form_dotdanhgia').valid()==true){
        		$.blockUI();
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dotdanhgia&task=luu_dotdanhgia',
        			data: $('#form_dotdanhgia').serialize(),
        			success:function(data){
        				if(data>0){
        					$('#modal-form').modal('hide');      					
        					loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
        					$.unblockUI();
        					window.location.href='index.php?option=com_danhmuc&controller=danhgia&task=ds_dotdanhgia';
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