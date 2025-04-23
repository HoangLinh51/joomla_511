<div id="ds_thuocdienquanly">
	<h2 class="header" style="padding-bottom:1%">Danh sách thuộc diện quản lý
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_thuocdienquanly">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_thuocdienquanly">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_thuocdienquanly">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="accordion-tkthuocdienquanly">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseEightteen" data-parent="accordion-tkthuocdienquanly" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseEightteen">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span4">Tên thuộc diện quản lý:</label>
							<div class="controls span6">
								<input type="text" name="tk_tenthuocdienquanly" id="tk_tenthuocdienquanly">
								<span class="btn btn-small btn-primary pull-right" id="btn_search_tkthuocdienquanly" style="margin-left:5%">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_thuocdienquanly" style="padding-left:2%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_tkthuocdienquanly').on('click',function(){
			$('#table_thuocdienquanly').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_thuocdienquanly&format=raw&ten='+$('#tk_tenthuocdienquanly').val());
		});
		$('#btn_search_tkthuocdienquanly').click();
		$('#btn_themmoi_thuocdienquanly').on('click',function(){
			$('#modal-title').html('Thêm mới thuộc diện quản lý');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoithuocdienquanly&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_thuocdienquanly_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_thuocdienquanly_luu','click',function(){
			if($('#form_thuocdienquanly').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuocdienquanly&task=themthongtinthuocdienquanly',
					data: $('#form_thuocdienquanly').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tkthuocdienquanly').click();
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
		$('body').delegate('#btn_edit_thuocdienquanly','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa thuộc diện quản lý');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuathuocdienquanly&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_thuocdienquanly_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_thuocdienquanly_update','click',function(){
			if($('#form_thuocdienquanly').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuocdienquanly&task=chinhsuathongtinthuocdienquanly',
					data: $('#form_thuocdienquanly').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tkthuocdienquanly').click();
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
		$('body').delegate('#btn_xoa_thuocdienquanly','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuocdienquanly&task=xoathuocdienquanly',
					data: {id:id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tkthuocdienquanly').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('body').delegate('#btn_xoaall_thuocdienquanly','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idthuocdienquanly:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuocdienquanly&task=xoanhieuthuocdienquanly',
					data: {id:array_id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tkthuocdienquanly').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatds_thuocdienquanly').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=thuocdienquanly&task=xuatdsthuocdienquanly';
		});
	});
</script>