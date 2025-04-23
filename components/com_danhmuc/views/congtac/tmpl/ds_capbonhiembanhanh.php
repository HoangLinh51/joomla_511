<?php ?>
<div id="ds_capbonhiembanhanh">
	<h2 class="header" style="padding-bottom:2%">Cấp bổ nhiệm / ban hành
	<div class="pull-right">
		<span class="btn btn-small btn-primary" id="btn_themmoi_capbonhiembanhanh">Thêm mới</span>
		<span class="btn btn-small btn-danger" id="btn_xoa_capbonhiembanhanh">Xóa</span>
		<span class="btn btn-small btn-success" id="btn_xuatexcel_capbonhiembanhanh">Xuất danh sách ra excel</span>
	</div>
	</h2>
	<div class="accordion" id="accordion-tk_tencapbonhiembanhanh">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion-tk_tencapbonhiembanhanh" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3">Tên cấp bổ nhiệm / ban hành:</label>
							<div class="control span6">
								<input type="text" name="tk_tencapbonhiembanhanh" id="tk_tencapbonhiembanhanh">
							</div>
							<span class="btn btn-small btn-primary span2" id="tencapbonhiembanhanh_search" name="tencapbonhiembanhanh_search">Tìm kiếm</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_capbonhiembanhanh" style="padding-left:3%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#tencapbonhiembanhanh_search','click',function(){
			$('#table_capbonhiembanhanh').load('index.php?option=com_danhmuc&view=congtac&task=table_capbonhiembanhanh&format=raw&ten='+$('#tk_tencapbonhiembanhanh').val());
		});
		$('#tencapbonhiembanhanh_search').click();
		$('#btn_themmoi_capbonhiembanhanh').on('click',function(){
			$('#modal-title').html('Thêm mới cấp bổ nhiệm / ban hành');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtac&task=themmoicapbonhiembanhanh&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_capbonhiembanhanh_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_capbonhiembanhanh_luu','click',function(){
			if($('#form_capbonhiembanhanh').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=capbonhiembanhanh&task=themthongtincapbonhiembanhanh',
					data: $('#form_capbonhiembanhanh').serialize(),
					success: function(data){
						if(data == 'true'){
                            $('#tencapbonhiembanhanh_search').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
					}
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_delete_capbonhiembanhanh','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=capbonhiembanhanh&task=xoacapbonhiembanhanh',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
                            $('#tencapbonhiembanhanh_search').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_capbonhiembanhanh','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa cấp bổ nhiệm / ban hành');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtac&task=chinhsuacapbonhiembanhanh&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_capbonhiembanhanh_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_capbonhiembanhanh_update','click',function(){
			if($('#form_capbonhiembanhanh').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=capbonhiembanhanh&task=chinhsuathongtincapbonhiembanhanh',
					data: $('#form_capbonhiembanhanh').serialize(),
					success: function(data){
						if(data == 'true'){
                            $('#tencapbonhiembanhanh_search').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
					}
				});
			}
			else{
				return false;
			}
		});
		$('#btn_xoa_capbonhiembanhanh').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id=[];
				$('.array_idcapbonhiembanhanh:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=capbonhiembanhanh&task=xoanhieucapbonhiembanhanh',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
                            $('#tencapbonhiembanhanh_search').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
					}
				});
			}
		});
		$('#btn_xuatexcel_capbonhiembanhanh').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=capbonhiembanhanh&task=xuatdscbnbh';
		});
	});
</script>