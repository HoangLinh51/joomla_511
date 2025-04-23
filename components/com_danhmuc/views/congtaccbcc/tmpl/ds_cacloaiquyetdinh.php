<div id="ds_cacloaiquyetdinh">
	<h2>Danh sách các loại quyết định
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_cacloaiquyetdinh">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_cacloaiquyetdinh">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_cacloaiquyetdinh">Xuất danh sách</span>
		</div>
	</h2>
	<div id="accordion_tkcacloaiquyetdinh" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFifteen" data-parent="#accordion_tkcacloaiquyetdinh" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseFifteen">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span4">Tên loại quyết định:</label>
							<div class="span5">
								<input type="text" name="tk_tencacloaiquyetdinh" id="tk_tencacloaiquyetdinh" >
							</div>
							<span class="btn btn-small btn-primary pull-right" id="btn_tkcacloaiquyetdinh" name="btn_tkcacloaiquyetdinh">Tìm kiếm</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_cacloaiquyetdinh" style="padding-left:2%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_tkcacloaiquyetdinh').on('click',function(){
			$('#table_cacloaiquyetdinh').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_cacloaiquyetdinh&format=raw&ten='+$('#tk_tencacloaiquyetdinh').val());
		});
		$("#btn_tkcacloaiquyetdinh").click();
		$('#btn_themmoi_cacloaiquyetdinh').on('click',function(){
			$('#modal-title').html('Thêm loại quyết định');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoicacloaiquyetdinh&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_cacloaiquyetdinh_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cacloaiquyetdinh_luu','click',function(){
			if($('#form_cacloaiquyetdinh').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cacloaiquyetdinh&task=themthongtincacloaiquyetdinh',
					data: $('#form_cacloaiquyetdinh').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$("#btn_tkcacloaiquyetdinh").click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}else{
				return false;
			}
		});
		$('body').delegate('#btn_edit_cacloaiquyetdinh','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa loại quyết định');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuacacloaiquyetdinh&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_cacloaiquyetdinh_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cacloaiquyetdinh_update','click',function(){
			if($('#form_cacloaiquyetdinh').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cacloaiquyetdinh&task=chinhsuathongtincacloaiquyetdinh',
					data: $('#form_cacloaiquyetdinh').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$("#btn_tkcacloaiquyetdinh").click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}else{
				return false;
			}
		});
		$('body').delegate('#btn_xoa_cacloaiquyetdinh','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cacloaiquyetdinh&task=xoacacloaiquyetdinh',
					data: {id:id},
					success: function(data){
						if(data=='true'){
							$("#btn_tkcacloaiquyetdinh").click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xoaall_cacloaiquyetdinh').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idcacloaiquyetdinh:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cacloaiquyetdinh&task=xoanhieucacloaiquyetdinh',
					data: {id:array_id},
					success:function(data){
						if(data=='true'){
							$("#btn_tkcacloaiquyetdinh").click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatds_cacloaiquyetdinh').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=cacloaiquyetdinh&task=xuatdscacloaiquyetdinh';
		});
	});
</script>