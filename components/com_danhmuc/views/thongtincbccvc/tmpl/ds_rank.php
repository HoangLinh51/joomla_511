<div class="ds_rank">
	<h3 class="header blue" >Danh sách cấp bậc lực lượng vũ trang
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_rank"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_rank"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_rank"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkrank">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFifteen" data-parent="#accordion_tkrank" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseFifteen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên cấp bậc lực lượng vũ trang: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_rank" id="ten_rank"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_rank">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_rank"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_rank','click',function(){
			$('#table_rank').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_rank&format=raw&ten='+$('#ten_rank').val());
		});
		$('#btn_search_rank').click();
		$('#btn_themmoi_rank').on('click',function(){
			$('#modal-title').html('Thêm mới cấp bậc lực lượng vũ trang');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoirank&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_rank_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_rank_luu','click',function(){
			if($('#form_rank').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rank&task=themthongtinrank',
					data: $('#form_rank').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_rank').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					},
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_delete_rank','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rank&task=xoarank',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_rank').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_rank','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa cấp bậc lực lượng vũ trang');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuarank&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_rank_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_rank_update','click',function(){
			if($('#form_rank').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rank&task=chinhsuathongtinrank',
					data: $('#form_rank').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_rank').click();
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
		$('body').delegate('#btn_xoaall_rank','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idrank:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rank&task=xoanhieurank',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_rank').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_rank').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=rank&task=xuatdsrank";
		});
	});
</script>