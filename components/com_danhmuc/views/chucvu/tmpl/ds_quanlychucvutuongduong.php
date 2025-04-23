<div class="row-fluid">
	<h2 class="header" style="padding-bottom:1%">Danh sách quản lý chức vụ tương đương
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_qlcvtd">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_qlcvtd">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_qlcvtd">Xuất danh sách</span>
		</div>
	</h2>
	<div id="accordion_tkqlcvtd" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion_tkqlcvtd" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span5">Tên chức vụ tương đương:</label>
							<div class="controls span7">
								<input type="text" id="tk_tencvtd">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label span5">Tên chức vụ tương đương 2:</label>
							<div class="controls span7">
								<input type="text" id="tk_tencvtd2">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label span5">Tên chức vụ tương đương 3:</label>
							<div class="controls span7">
								<input type="text" id="tk_tencvtd3">
							</div>
						</div>
						<div class="span6">
							<span class="btn btn-small btn-primary pull-right" id="btn_search_qlcvtd" style="margin-bottom:1%">Tìm kiếm</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_qlcvtd" style="padding-left:2%;"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_qlcvtd').on('click',function(){
			$('#table_qlcvtd').load('index.php?option=com_danhmuc&view=chucvu&task=table_qlcvtd&format=raw&ten='+$('#tk_tencvtd').val()+'&ten2='+$('#tk_tencvtd2').val()+'&ten3='+$('#tk_tencvtd3').val());
		});
		$('#btn_search_qlcvtd').click();
		$('#btn_themmoi_qlcvtd').on('click',function(){
			$('#modal-title').html('Thêm mới chức vụ tương đương');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=chucvu&task=themmoichucvutuongduong&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_chucvutuongduong_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_chucvutuongduong_luu','click',function(){
			if($('#form_chucvutuongduong').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=quanlychucvutuongduong&task=themthongtinchucvutuongduong',
					data: $('#form_chucvutuongduong').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_qlcvtd').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_edit_cvtd','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa chức vụ tương đương');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=chucvu&task=chinhsuachucvutuongduong&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_chucvutuongduong_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_chucvutuongduong_update','click',function(){
			if($('#form_chucvutuongduong').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=quanlychucvutuongduong&task=chinhsuathongtinchucvutuonduong',
					data: $('#form_chucvutuongduong').serialize(),
					success: function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_qlcvtd').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_xoa_cvtd','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=quanlychucvutuongduong&task=xoachucvutuongduong',
					data: {id:id},
					success: function(data){
						if(data=='true'){
							$('#btn_search_qlcvtd').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xoaall_qlcvtd').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id =[];
				$('.array_idcvtd:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=quanlychucvutuongduong&task=xoanhieuchucvutuongduong',
					data: {id:array_id},
					success:function(data){
						if(data=='true'){
							$('#btn_search_qlcvtd').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatds_qlcvtd').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=quanlychucvutuongduong&task=xuatdscvtd';
		});
	});
</script>