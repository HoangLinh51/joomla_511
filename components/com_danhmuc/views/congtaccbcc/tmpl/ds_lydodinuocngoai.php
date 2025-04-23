<div id="ds_lydodinuocngoai">
	<h2 class="header" style="padding-bottom:1%">Danh sách lý do đi nước ngoài
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_lydodinuocngoai">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_lydodinuocngoai">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_lydodinuocngoai">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="accordion-tklydodinuocngoai">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSixteen" data-parent="accordion-tklydodinuocngoai" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseSixteen">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span4">Tên lý do đi nước ngoài:</label>
							<div class="controls span6">
								<input type="text" name="tk_tenlydodinuocngoai" id="tk_tenlydodinuocngoai">
								<span class="btn btn-small btn-primary pull-right" id="btn_search_tklydodinuocngoai" style="margin-left:5%">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_lydodinuocngoai" style="padding-left:2%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_tklydodinuocngoai').on('click',function(){
			$('#table_lydodinuocngoai').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_lydodinuocngoai&format=raw&ten='+$('#tk_tenlydodinuocngoai').val());
		});
		$('#btn_search_tklydodinuocngoai').click();
		$('#btn_themmoi_lydodinuocngoai').on('click',function(){
			$('#modal-title').html('Thêm mới lý do đi nước ngoài');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoilydodinuocngoai&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_lydodinuocngoai_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_lydodinuocngoai_luu','click',function(){
			if($('#form_lydodinuocngoai').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=lydodinuocngoai&task=themthongtinlydodinuocngoai',
					data: $('#form_lydodinuocngoai').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tklydodinuocngoai').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}else{
				return false;
			}
		});
		$('body').delegate('#btn_edit_lydodinuocngoai','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa lý do đi nước ngoài');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=chinhsualydodinuocngoai&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_lydodinuocngoai_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_lydodinuocngoai_update','click',function(){
			if($('#form_lydodinuocngoai').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=lydodinuocngoai&task=chinhsuathongtinlydodinuocngoai',
					data: $('#form_lydodinuocngoai').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tklydodinuocngoai').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_xoa_lydodinuocngoai','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=lydodinuocngoai&task=xoalydodinuocngoai',
					data: {id:id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tklydodinuocngoai').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('body').delegate('#btn_xoaall_lydodinuocngoai','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idlydodinuocngoai:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=lydodinuocngoai&task=xoanhieulydodinuocngoai',
					data: {id:array_id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tklydodinuocngoai').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatds_lydodinuocngoai').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=lydodinuocngoai&task=xuatdslydodinuocngoai';
		});
	});
</script>