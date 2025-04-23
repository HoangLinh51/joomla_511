<?php 
	$ds_dgcbcc_loaicongviec = $this->ds_dgcbcc_loaicongviec;
	$ds_dgcbcc_botieuchi = $this->ds_dgcbcc_botieuchi;
	$ds_nhomtieuchi = $this->ds_nhomtieuchi;
	$ds_dgcbcc_nhiemvu = $this->ds_dgcbcc_nhiemvu;
	$ds_dgcbcc_tieuchuan = $this->ds_dgcbcc_tieuchuan;
	$ds_dgcbcc_xeploai = $this->ds_dgcbcc_xeploai;
	// var_dump($ds_dgcbcc_xeploai);die;
	$ds_fk_tieuchuan_dg_botieuchi = $this->ds_fk_tieuchuan_dg_botieuchi;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_botieuchi = $this->dgcbcc_botieuchi;
		$ds_tieuchi = $this->ds_tieuchi;
		$ds_fk_theonhiemvu_botieuchi = $this->ds_fk_theonhiemvu_botieuchi;
	}
	$model = Core::model('Danhmuchethong/Dgcbcc_botieuchi');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm mới bộ tiêu chí đánh giá cán bộ công chức</h4>
</div>
<div class="modal-body overflow-visible" style="overflow-x:scroll">
    <div id="modal-content" class="slim-scroll" data-height="350">
		<form class="form-horizontal" id="form_dgcbcc_botieuchi" enctype="multipart/form-data">
			<?php echo JHtml::_( 'form.token' ); ?>
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#content_dgcbcc_botieuchi">Thông tin bộ tiêu chí</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_dgcbcc_botieuchi_tieuchi">Tiêu chí</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_dgcbcc_botieuchi_nhiemvu">Nhiệm vụ</a>
					</li>
					<li>
						<a data-toggle="tab" href="#content_dgcbcc_botieuchi_tieuchuan">Tiêu chuẩn</a>
					</li>
				</ul>
				<div class="tab-content" style="overflow-x:hidden">
					<div id="content_dgcbcc_botieuchi" class="tab-pane in active">
						<div class="row-fluid">
							<div class="control-group">
								<label class="control-label span2">Tên bộ tiêu chí (<span style="color:red">*</span>)</label>
								<div class="controls span10">						
									<textarea name="frm[name]"  class="span12" rows="5"><?php if($id>0) echo $dgcbcc_botieuchi['name']; ?></textarea>
									<input type="hidden" name="frm[id]" value="<?php if($id>0) echo $dgcbcc_botieuchi['id']; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Bộ tiêu chí cha (<span style="color:red">*</span>)</label>
								<div class="controls span10">
									<select class="span12 chzn-select" name="frm[parent_id]">
										<option value="">--Chọn--</option>
										<?php for($i=0;$i<count($ds_dgcbcc_botieuchi);$i++){ ?>
										<option value="<?php echo $ds_dgcbcc_botieuchi[$i]['id']; ?>" <?php if($id>0&&$dgcbcc_botieuchi['parent_id']==$ds_dgcbcc_botieuchi[$i]['id']) echo 'selected'; ?>>
											<?php echo $ds_dgcbcc_botieuchi[$i]['name']; ?>
										</option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Mã bộ tiêu chí (<span style="color:red">*</span>)</label>
								<div class="controls span10">
									<input type="text" name="frm[code]" class="span12" value="<?php if($id>0) echo $dgcbcc_botieuchi['code']; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Loại công việc</label>
								<div class="controls span10">
									<select class="span12 chzn-select" name="frm[id_loaicongviec]">
										<option value="">--Chọn--</option>
										<?php for($i=0;$i<count($ds_dgcbcc_loaicongviec);$i++){ ?>
										<option value="<?php echo $ds_dgcbcc_loaicongviec[$i]['id'] ?>"  <?php if($id>0&&$dgcbcc_botieuchi['id_loaicongviec']==$ds_dgcbcc_loaicongviec[$i]['id']) echo 'selected'; ?>>
											<?php echo $ds_dgcbcc_loaicongviec[$i]['name'] ?>
										</option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Hiện bộ tiêu chí</label>
								<div class="controls span10">
									<label>
										<input type="checkbox" value="1" name="frm[published]" <?php if($id>0&&$dgcbcc_botieuchi['published']==1) echo 'checked'; ?>>
										<span class="lbl">Có</span>
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Đề xuất điểm</label>
								<div class="controls span10">
									<label>
										<input type="checkbox" value="1" name="frm[is_dexuat]" <?php if($id>0&&$dgcbcc_botieuchi['is_dexuat']==1) echo 'checked'; ?>>
										<span class="lbl">Có</span>
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Nhóm bộ tiêu chí</label>
								<div class="controls span10">
									<label>
										<input type="checkbox" value="1" name="frm[group]" <?php if($id>0&&$dgcbcc_botieuchi['group']==1) echo 'checked'; ?>>
										<span class="lbl">Có</span>
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Điểm chính</label>
								<div class="controls span10">
									<input type="text" name="frm[tk_diemchinh]" class="span12" value="<?php if($id>0) echo $dgcbcc_botieuchi['tk_diemchinh']; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Điểm cộng</label>
								<div class="controls span10">
									<input type="text" name="frm[tk_diemcong]" class="span12" value="<?php if($id>0) echo $dgcbcc_botieuchi['tk_diemcong']; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Điểm trừ</label>
								<div class="controls span10">
									<input type="text" name="frm[tk_diemtru]" class="span12" value="<?php if($id>0) echo $dgcbcc_botieuchi['tk_diemtru']; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label span2">Trạng thái</label>
								<div class="controls span10">
									<label>
										<input type="checkbox" value="1" name="frm[status]" <?php if($id>0&&$dgcbcc_botieuchi['status']==1) echo 'checked'; ?>>
										<span class="lbl">Đang hoạt động</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="content_dgcbcc_botieuchi_tieuchi" class="tab-pane" style="height:300px">
						<div class="row-fluid">
							<div class="span4">Chọn nhóm tiêu chí</div>
							<div class="span8">
								<select class="span8 chzn-select" style="z-index:999" id="selectbox_nhomtieuchi">
									<option value="">--Chọn--</option>
									<?php for($i=0;$i<count($ds_nhomtieuchi);$i++){ ?>
									<option value="<?php echo $ds_nhomtieuchi[$i]['id']; ?>" <?php if($id>0&&$ds_tieuchi[0]['id_nhom']==$ds_nhomtieuchi[$i]['id']) echo 'selected'; ?>>
										<?php echo $ds_nhomtieuchi[$i]['name']; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<table class="table table-bordered" style="overflow-y:scroll">
							<thead>
								<th class="center" style="width:40%"><b>Tiêu chí</b></th>
								<th class="center" style="width:20%"><b>Điểm thấp nhất</b></th>
								<th class="center" style="width:20%"><b>Điểm cao nhất</b></th>
								<th class="center" style="width:20%"><b>Xếp loại</b></th>
							</thead>
							<tbody id="content_data_tieuchi_by_nhom" style="overflow:scroll">
								<?php
									if($id>0){ 
									$ds_tieuchi_by_nhomtieuchi = $model->find_tieuchi_by_nhomtieuchi($ds_tieuchi[0]['id_nhom']);
									for($i=0;$i<count($ds_tieuchi_by_nhomtieuchi);$i++){
										$check = 0;
										$stt = $i+1;
										for($j=0;$j<count($ds_tieuchi);$j++){
											if($ds_tieuchi[$j]['id_tieuchi']==$ds_tieuchi_by_nhomtieuchi[$i]['id']){
												$check = 1;
												$diem_min_tieuchi = $ds_tieuchi[$j]['diem_min'];
												$diem_max_tieuchi = $ds_tieuchi[$j]['diem_max'];
												$code_xeploai_tieuchi = $ds_tieuchi[$j]['code_xeploai'];
											}
										}
								?>
								<tr>
									<td>
										<label>
											<input type="checkbox" class="array_checkbox_tieuchi" data-stt="<?php echo $stt; ?>" name="tieuchi[<?php echo $i; ?>]" value="<?php echo $ds_tieuchi_by_nhomtieuchi[$i]['id'] ?>" <?php if($check==1) echo 'checked'; ?>>
											<span class="lbl"><?php echo $ds_tieuchi_by_nhomtieuchi[$i]['name']; ?></span>
										</label>
									</td>
									<td><input type="text" id="diem_min_tieuchi<?php echo $stt; ?>" name="diem_min_tieuchi[<?php echo $i; ?>]" style="width:90%" value="<?php if($check==1) echo $diem_min_tieuchi; ?>"></td>
									<td><input type="text" id="diem_max_tieuchi<?php echo $stt; ?>" name="diem_max_tieuchi[<?php echo $i; ?>]" style="width:90%" value="<?php if($check==1) echo $diem_max_tieuchi; ?>"></td>
									<td>
										<select style="width:100%" id="code_xeploai_tieuchi<?php echo $stt; ?>" name="code_xeploai_tieuchi[]">
											<option value="">--Chọn--</option>
											<?php for($j=0;$j<count($ds_dgcbcc_xeploai);$j++){ ?>
											<option value="<?php echo $ds_dgcbcc_xeploai[$j]['code']; ?>" <?php if($code_xeploai_tieuchi==$ds_dgcbcc_xeploai[$j]['code']&&$check==1) echo 'selected'; ?>>
												<?php echo $ds_dgcbcc_xeploai[$j]['code']; ?>			
											</option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php }?>
								<?php }?>		
							</tbody>
						</table>
					</div>
					<div id="content_dgcbcc_botieuchi_nhiemvu" class="tab-pane">
						<table class="table table-bordered">
							<thead>
								<th class="center" style="width:5%"><b>#</b></th>
								<th class="center" style="width:70%"><b>Tên nhiệm vụ</b></th>
								<th class="center" style="width:10%"><b>Điểm Min</b></th>
								<th class="center" style="width:10%"><b>Điểm Max</b></th>
								<th class="center" style="width:5%"><b>ID</b></th>
							</thead>
							<tbody>
								<?php for($i=0;$i<count($ds_dgcbcc_nhiemvu);$i++){ ?>
								<?php 
									$check = 0;
									$diem_min = 0;
									$diem_max = 0;
									if($id>0&&count($ds_fk_theonhiemvu_botieuchi>0)){
										for($j=0;$j<count($ds_fk_theonhiemvu_botieuchi);$j++){
											if($ds_fk_theonhiemvu_botieuchi[$j]['id_theonhiemvu']==$ds_dgcbcc_nhiemvu[$i]['id']){
												$check = 1;
												$diem_min = $ds_fk_theonhiemvu_botieuchi[$j]['diem_min'];
												$diem_max = $ds_fk_theonhiemvu_botieuchi[$j]['diem_max'];
											}
										}
									}
								?>
								<tr>
									<td class="center">
										<input type="checkbox" name="id_theonhiemvu[]" value="<?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?>" <?php if($check==1) echo 'checked' ?>><label class="lbl"></label>
									</td>
									<td><?php echo $ds_dgcbcc_nhiemvu[$i]['name']; ?></td>
									<td class="center"><input type="text" style="width:80%" autocomplete="off" value="<?php echo $diem_min; ?>" name="diem_min[<?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?>]"></td>
									<td class="center"><input type="text" style="width:80%" autocomplete="off" value="<?php echo $diem_max; ?>" name="diem_max[<?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?>]"></td>
									<td class="center"><?php echo $ds_dgcbcc_nhiemvu[$i]['id']; ?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					<div id="content_dgcbcc_botieuchi_tieuchuan" class="tab-pane">
						<table class="table table-bordered">
							<thead>
								<th class="center" style="width:5%"><b>#</b></th>
								<th class="center" style="width:90%"><b>Tiêu chuẩn</b></th>
								<th class="center" style="width:5%"><b>ID</b></th>
							</thead>
							<tbody>
								<?php for($i=0;$i<count($ds_dgcbcc_tieuchuan);$i++){ ?>
								<?php 
									$check = 0;
									if($id>0&&count($ds_fk_tieuchuan_dg_botieuchi)>0){
										for($j=0;$j<count($ds_fk_tieuchuan_dg_botieuchi);$j++){
											if($ds_fk_tieuchuan_dg_botieuchi[$j]['id_tieuchuan_dg']==$ds_dgcbcc_tieuchuan[$i]['id']){
												$check = 1;
											}
										}
									}
								?>
								<tr>
									<td class="center">
										<input type="checkbox" value="<?php echo $ds_dgcbcc_tieuchuan[$i]['id']; ?>" name="id_tieuchuan_dg[]" <?php if($check==1) echo 'checked'; ?>>
										<label class="lbl"></label>
									</td>
									<td><?php echo $ds_dgcbcc_tieuchuan[$i]['name']; ?></td>
									<td class="center"><?php echo $ds_dgcbcc_tieuchuan[$i]['id']; ?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
    </div>
</div>
<div class="modal-footer">
	<span class="btn btn-small btn-primary" id="btn_dgcbcc_botieuchi_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$(".chzn-select").chosen({"width":"100%","search_contains": true });
		$('#form_dgcbcc_botieuchi').validate({
            rules:{
                "frm[name]": {required: true},
                "frm[parent_id]": {required: true},
                "frm[code]":{required:true},
                "frm[tk_diemchinh]":{digits:true},
                "frm[tk_diemcong]":{digits:true},
                "frm[tk_diemtru]":{digits:true},
                "diem_min_tieuchi[]":{number:true},
                "diem_max_tieuchi[]":{number:true}
            },
            messages:{
                "frm[name]": {required: 'Vui lòng nhập tên bộ tiêu chí'},
                "frm[parent_id]": {required: 'Vui lòng chọn bộ tiêu chí cha'},
                "frm[code]":{required:'Vui lòng nhập mã bộ tiêu chí'},
                "frm[tk_diemchinh]":{digits:'Vui lòng nhập số cho trường điểm chính'},
                "frm[tk_diemcong]":{digits:'Vui lòng nhập số cho trường điểm cộng'},
                "frm[tk_diemtru]":{digits:'Vui lòng nhập số cho trường điểm trừ'},
                "diem_min_tieuchi[]":{number:'Vui lòng nhập số cho trường điểm thấp nhất'},
                "diem_max_tieuchi[]":{number:'Vui lòng nhập số cho trường điểm cao nhất'}
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
        $('#selectbox_nhomtieuchi').on('change',function(){
        	$.blockUI();
        	var id_nhomtieuchi = $(this).val();
        	if(id_nhomtieuchi!=''){
        		$.ajax({
	        		type: 'post',
	        		url: 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=find_tieuchi_by_nhomtieuchi',
	        		data: {id_nhomtieuchi:id_nhomtieuchi},
	        		success:function(data){
	        			if(data==false){
	        				loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
	        				$.unblockUI();
	        			}
	        			else{
	        				var ds_dgcbcc_xeploai = '<?php echo json_encode($ds_dgcbcc_xeploai); ?>';
	        				ds_dgcbcc_xeploai = JSON.parse(ds_dgcbcc_xeploai);	
	        				var stt;        				
	        				if(data.length>0){
	        					var xhtml = '';	        					
	        					for(var i=0;i<data.length;i++){
	        						stt = i+1;
	        						var select_html = '<select style="width:100%" name="code_xeploai_tieuchi['+i+']" id="code_xeploai_tieuchi'+i+'">';
	        						select_html += '<option value="">--Chọn--</option>';
			        				for(var j=0;j<ds_dgcbcc_xeploai.length;j++){
			        					select_html+= '<option value="'+ds_dgcbcc_xeploai[j]['code']+'">'+ds_dgcbcc_xeploai[j]['code']+'</option>';
			        				}
			        				select_html += '</select>';
	        						xhtml+= '<tr>';
	        						xhtml += '<td>';
	        						xhtml+= '<label><input type="checkbox" name="tieuchi[]" value="'+data[i]['id']+'"><span class="lbl">'+data[i]['name']+'</span></label>';
	        						xhtml+= '</td>';
	        						xhtml+= '<td><input type="text" name="diem_min_tieuchi['+i+']" style="width:90%"></td>';
	        						xhtml+= '<td><input type="text" name="diem_max_tieuchi['+i+']" style="width:90%"></td>';
	        						xhtml += '<td>'+select_html+'</td>';
	        						xhtml+= '</tr>';
	        					}
	        					$('#content_data_tieuchi_by_nhom').html(xhtml);
	        				}
	        				else{
	        					$('#content_data_tieuchi_by_nhom').html('Không có dữ liệu');
	        				}
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
        		$('#content_data_tieuchi_by_nhom').html('<p class="center" style="vertical-align:middle">Không có dữ liệu</p>');
        		$.unblockUI();
        	}
        });
        $('#btn_dgcbcc_botieuchi_luu').on('click',function(){
        	if($('#form_dgcbcc_botieuchi').valid()==true){
        		$.blockUI();
        		var array_checkbox_tieuchi = [];
        		var stt= 0;
        		var code_xeploai_tieuchi;
        		var check = 0;
        		$('.array_checkbox_tieuchi:checked').each(function(){
        			stt = $(this).data('stt');
        			var diem_min = $('#diem_min_tieuchi'+stt).val();
        			var diem_max = $('#diem_max_tieuchi'+stt).val();
        			code_xeploai_tieuchi = $('#code_xeploai_tieuchi'+stt).val();
        			if(code_xeploai_tieuchi!=''&&diem_min==''){
        				check = 1;
        				loadNoticeBoardError('Thông báo','Điểm nhỏ nhất không được để trống');
        				$.unblockUI();
        				return false;
        			}
        			if(code_xeploai_tieuchi!=''&&diem_min>=0){
        				check = 0;
        			}
        			else if(code_xeploai_tieuchi==''){
        				check = 0;
        			}
        			else{
        				check = 1;
        				loadNoticeBoardError('Thông báo','Phải nhập số nguyên dương cho trường điểm nhỏ nhất');
        				$.unblockUI();
        				return false;
        			}
        			if(code_xeploai_tieuchi!=''&&diem_max==''){
        				check = 1;
        				loadNoticeBoardError('Thông báo','Điểm lớn nhất không được để trống');
        				$.unblockUI();
        				return false;
        			}
        			if(code_xeploai_tieuchi!=''&&diem_max>0){
        				check = 0;
        			}
        			else if(code_xeploai_tieuchi==''){
        				check = 0;
        			}
        			else{
        				check = 1;
        				loadNoticeBoardError('Thông báo','Phải nhập số nguyên dương cho trường điểm lớn nhất');
        				$.unblockUI();
        				return false;
        			}
        		});
        		if(check==1){
        			$.unblockUI();
        			return false;
        		}
        		$.ajax({
        			type: 'post',
        			url: 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=luu_dgcbcc_botieuchi',
        			data: $('#form_dgcbcc_botieuchi').serialize(),
        			success:function(data){
        				if(data>0){
        					$('#modal-form').modal('hide');
        					window.location.href = 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=reset_tree_dgcbcc_botieuchi';
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