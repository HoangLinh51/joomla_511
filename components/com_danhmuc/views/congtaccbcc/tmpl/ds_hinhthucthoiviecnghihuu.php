<div id="ds_hinhthucthoiviecnghihuu">
	<h2 class="header" style="padding-bottom:1%">Danh sách hình thức thôi việc nghỉ hưu
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_hinhthucthoiviecnghihuu">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_hinhthucthoiviecnghihuu">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_hinhthucthoiviecnghihuu">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="accordion-tkhinhthucthoiviecnghihuu">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSeventeen" data-parent="accordion-tkhinhthucthoiviecnghihuu" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseSeventeen">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span4">Tên hình thức thôi việc nghỉ hưu:</label>
							<div class="controls span6">
								<input type="text" name="tk_tenhinhthucthoiviecnghihuu" id="tk_tenhinhthucthoiviecnghihuu">
								<span class="btn btn-small btn-primary pull-right" id="btn_search_tkhinhthucthoiviecnghihuu" style="margin-left:5%">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_hinhthucthoiviecnghihuu" style="padding-left:2%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_tkhinhthucthoiviecnghihuu').on('click',function(){
			$('#table_hinhthucthoiviecnghihuu').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_hinhthucthoiviecnghihuu&format=raw&ten='+$('#tk_tenhinhthucthoiviecnghihuu').val());
		});
		$('#btn_search_tkhinhthucthoiviecnghihuu').click();
		$('#btn_themmoi_hinhthucthoiviecnghihuu').on('click',function(){
			$('#modal-title').html('Thêm mới hình thức thôi việc nghỉ hưu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoihinhthucthoiviecnghihuu&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_hinhthucthoiviecnghihuu_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_hinhthucthoiviecnghihuu_luu','click',function(){
			if($('#form_hinhthucthoiviecnghihuu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucthoiviecnghihuu&task=themthongtinhinhthucthoiviecnghihuu',
					data: $('#form_hinhthucthoiviecnghihuu').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tkhinhthucthoiviecnghihuu').click();
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
		$('body').delegate('#btn_edit_hinhthucthoiviecnghihuu','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa hình thức thôi việc nghỉ hưu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuahinhthucthoiviecnghihuu&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_hinhthucthoiviecnghihuu_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_hinhthucthoiviecnghihuu_update','click',function(){
			if($('#form_hinhthucthoiviecnghihuu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucthoiviecnghihuu&task=chinhsuathongtinhinhthucthoiviecnghihuu',
					data: $('#form_hinhthucthoiviecnghihuu').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tkhinhthucthoiviecnghihuu').click();
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
		$('body').delegate('#btn_xoa_hinhthucthoiviecnghihuu','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucthoiviecnghihuu&task=xoahinhthucthoiviecnghihuu',
					data: {id:id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tkhinhthucthoiviecnghihuu').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('body').delegate('#btn_xoaall_hinhthucthoiviecnghihuu','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idhinhthucthoiviecnghihuu:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucthoiviecnghihuu&task=xoanhieuhinhthucthoiviecnghihuu',
					data: {id:array_id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_tkhinhthucthoiviecnghihuu').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatds_hinhthucthoiviecnghihuu').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=hinhthucthoiviecnghihuu&task=xuatdshinhthucthoiviecnghihuu';
		});
	});
</script>