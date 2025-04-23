<?php 
	$ds_dgcbcc_dotdanhgia = $this->ds_dgcbcc_dotdanhgia;
	$ds_dgcbcc_dg_theonhiemvu = $this->ds_dgcbcc_dg_theonhiemvu;
	// var_dump($ds_dgcbcc_dg_theonhiemvu);die;
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	if($id>0){
		$dgcbcc_tieuchi_phanloai = $this->dgcbcc_tieuchi_phanloai;
		$ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai = $this->ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai;
		// var_dump($ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai);die;
	}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title">Thêm tiêu chí liệt</h4>
</div>
<div class="modal-body" style="height:300px">
    <div id="modal-content" class="slim-scroll" data-height="350">
	<form class="form-horizontal" id="form_dgcbcc_tieuchi_liet" enctype="multipart/form-data">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a data-toggle="tab" href="#thongtin_tieuchi_liet">Thông tin tiêu chí liệt</a>
				</li>
				<li>
					<a data-toggle="tab" href="#thietlap_nhiemvu_dotdanhgia">Thiết lập nhiệm vụ, đợt đánh giá</a>
				</li>
			</ul>
			<div class="tab-content" style="overflow:visible">
				<div id="thongtin_tieuchi_liet" class="tab-pane in active">
					<div class="row-fluid">
						<div class="control-group">
							<label class="control-label span3">Tên tiêu chí (<span style="color:red">*</span>)</label>
							<div class="controls span9">
								<input type="text" id="tieuchi_name" name="frm[name]" class="span12" value="<?php if($id>0) echo $dgcbcc_tieuchi_phanloai['name']; ?>">
								<input type="hidden" id="tieuchi_id" name="frm[id]" value="<?php if($id>0) echo $dgcbcc_tieuchi_phanloai['id']; ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label span3">Phát hành</label>
							<div class="controls span9">
								<label>
									<input type="checkbox" value="1" name="frm[published]" <?php if($id>0&&$dgcbcc_tieuchi_phanloai['published']==1) echo 'checked'; ?>>
									<span class="lbl">Đã phát hành</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div id="thietlap_nhiemvu_dotdanhgia" class="tab-pane">
					<div class="pull-right">
						<span class="btn btn-success btn-small" id="btn_add_row_nhiemvu_dotdanhgia">Thêm</span>
					</div>
					<table id="tbl_nhiemvu_dotdanhgia" class="table table-bordered">
						<thead>
							<th style="width:5%" class="center">#</th>
							<th style="width:40%" class="center">Nhiệm vụ</th>
							<th style="width:40%" class="center">Đợt đánh giá</th>
							<th style="width:15%" class="center">Xếp loại</th>
						</thead>
						<tbody id="content_table_nhiemvu_dotdanhgia">
							<?php if($id>0){ ?>
							<?php for($i=0;$i<count($ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai);$i++){ ?>
							<?php 
								$stt = $i+1;
							?>
							<tr>
								<td><input type="checkbox" value="<?php echo $stt; ?>" name="checkbox_nhiemvu_dotdanhgia[]" checked><span class="lbl"></span></td>
								<td>
									<select class="chzn-select" name="id_theonhiemvu[]" style="width:100%">
										<option value="">--Chọn--</option>
										<?php for($j=0;$j<count($ds_dgcbcc_dg_theonhiemvu);$j++){ ?>
										<option value="<?php echo $ds_dgcbcc_dg_theonhiemvu[$j]['id']; ?>" <?php if($ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai[$i]['id_theonhiemvu']==$ds_dgcbcc_dg_theonhiemvu[$j]['id']) echo 'selected'; ?>>
											<?php echo $ds_dgcbcc_dg_theonhiemvu[$j]['name']; ?>		
										</option>
										<?php } ?>
									</select>
								</td>
								<td>
									<select class="chzn-select id_dotdanhgia" name="id_dotdanhgia[]" data-stt="<?php echo $stt; ?>">
										<option value="">--Chọn--</option>
										<?php for($j=0;$j<count($ds_dgcbcc_dotdanhgia);$j++){ ?>
										<option value="<?php echo $ds_dgcbcc_dotdanhgia[$j]['id']; ?>" <?php if($ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai[$i]['id_dotdanhgia']==$ds_dgcbcc_dotdanhgia[$j]['id']) echo 'selected'; ?>>
											<?php echo $ds_dgcbcc_dotdanhgia[$j]['name']; ?>		
										</option>
										<?php } ?>
									</select>
								</td>
								<td>
									<select name="id_xeploai[]" id="select_xeploai_<?php echo $stt; ?>"></select>
								</td>
							</tr>
							<?php } ?>
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
	<span class="btn btn-small btn-success" id="btn_dgcbcc_tieuchi_liet_luu">Lưu</span>
	<button class="btn btn-small btn-danger" data-dismiss="modal">Quay lại</button>
</div>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true});
		$('#form_dgcbcc_tieuchi_liet').validate({
            rules:{
                "frm[name]": {required: true},
            },
            messages:{
                "frm[name]": {required:"Vui lòng nhập tên tiêu chí"},
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
		var ds_dgcbcc_dotdanhgia = '<?php echo json_encode($ds_dgcbcc_dotdanhgia); ?>';
		var ds_dgcbcc_dg_theonhiemvu = '<?php echo json_encode($ds_dgcbcc_dg_theonhiemvu); ?>';
		ds_dgcbcc_dotdanhgia = JSON.parse(ds_dgcbcc_dotdanhgia);
		ds_dgcbcc_dg_theonhiemvu = JSON.parse(ds_dgcbcc_dg_theonhiemvu);
		var select_nhiemvu = '<select class="chzn-select" name="id_theonhiemvu[]" style="width:100%">';
		select_nhiemvu += '<option value="">--Chọn--</option>';
		for(var i=0;i<ds_dgcbcc_dg_theonhiemvu.length;i++){
			select_nhiemvu += '<option value="'+ds_dgcbcc_dg_theonhiemvu[i]['id']+'">'+ds_dgcbcc_dg_theonhiemvu[i]['name']+'</option>'
		}
		select_nhiemvu += '</select>';
		$('#btn_add_row_nhiemvu_dotdanhgia').on('click',function(){
			var stt = $('#tbl_nhiemvu_dotdanhgia >tbody >tr').length+1;
			var select_dotdanhgia = '<select class="chzn-select id_dotdanhgia" name="id_dotdanhgia[]" data-stt="'+stt+'">';
			select_dotdanhgia += '<option value="">--Chọn--</option>';
			for(var i=0;i<ds_dgcbcc_dotdanhgia.length;i++){
				select_dotdanhgia += '<option value="'+ds_dgcbcc_dotdanhgia[i]['id']+'">'+ds_dgcbcc_dotdanhgia[i]['name']+'</option>';
			}
			select_dotdanhgia +='</select>';
			var xhtml = '<tr>';
			xhtml += '<td><input type="checkbox" value="'+stt+'" name="checkbox_nhiemvu_dotdanhgia[]"><span class="lbl"></span></td>';
			xhtml += '<td>'+select_nhiemvu+'</td>';
			xhtml += '<td>'+select_dotdanhgia+'</td>';
			xhtml += '<td><select name="id_xeploai[]" id="select_xeploai_'+stt+'"></select></td>';
			xhtml += '</tr>';
			$('#content_table_nhiemvu_dotdanhgia').append(xhtml);
			$('.chzn-select').chosen({"width":"100%","search_contains":true});
		});
		$('body').delegate('.id_dotdanhgia','change',function(){
			var id_dotdanhgia = $(this).val();
			var stt = $(this).data('stt');
			var id = $('#tieuchi_id').val();
			// console.log(stt);
			if(id>0){
				var ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai = '<?php echo json_encode($ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai); ?>';
				ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai = JSON.parse(ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai);
				if(stt<=ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai.length&&stt>=1){
					var id_xeploai = ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai[stt-1]['id_xeploai'];
				}
			}
			if(id_dotdanhgia>0){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_tieuchiliet&task=find_xeploai_by_id_dotdanhgia',
					data: {id_dotdanhgia:id_dotdanhgia},
					success:function(data){
						if(data.length>0){
							var select_xeploai = '<option value="">--Chọn--</option>';
							for(var i=0;i<data.length;i++){
								if(data[i]['id']==id_xeploai){
									select_xeploai += '<option value="'+data[i]['id']+'" selected="selected">'+data[i]['code']+'</option>';
								}
								else{
									select_xeploai += '<option value="'+data[i]['id']+'">'+data[i]['code']+'</option>';
								}
							}
							$('#select_xeploai_'+stt).html(select_xeploai);
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
		});
		var id = '<?php echo $id ?>';
		if(id>0){
			$('.id_dotdanhgia').change();
		}
		$('#btn_dgcbcc_tieuchi_liet_luu').on('click',function(){
			if($('#form_dgcbcc_tieuchi_liet').valid()==true){
				$.blockUI();
				var tieuchi_name = $('#tieuchi_name').val();
				if(tieuchi_name==''){
					loadNoticeBoardError('Thông báo','Vui lòng nhập tên tiêu chí');
					$.unblockUI();
					return false;
				}
				else{
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=dgcbcc_tieuchiliet&task=luu_dgcbcc_tieuchi_liet',
						data: $('#form_dgcbcc_tieuchi_liet').serialize(),
						success:function(data){
							if(data>0){
								$('#modal-form').modal('hide');
								$('#btn_tk_dgcbcc_tieuchi_phanloai').click();
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