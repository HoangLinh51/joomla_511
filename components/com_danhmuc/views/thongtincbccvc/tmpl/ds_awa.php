<div class="ds_awa">
	<h3 class="header blue" >Danh sách danh hiệu phong tặng
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_awa"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_awa"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_awa"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkawa">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTwo" data-parent="#accordion_tkawa" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseTwo">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên danh hiệu phong tặng: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_awa" id="ten_awa"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_awa">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_awa"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_awa','click',function(){
			$('#table_awa').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_awa&format=raw&ten='+$('#ten_awa').val());
		});
		$('#btn_search_awa').click();
		$('#btn_themmoi_awa').on('click',function(){
			$('#modal-title').html('Thêm mới danh hiệu phong tặng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoiawa&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_awa_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_awa_luu','click',function(){
			if($('#form_awa').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=awa&task=themthongtinawa',
					data: $('#form_awa').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_awa').click();
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
		$('body').delegate('#btn_delete_awa','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=awa&task=xoaawa',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_awa').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_awa','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa danh hiệu phong tặng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuaawa&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_awa_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_awa_update','click',function(){
			if($('#form_awa').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=awa&task=chinhsuathongtinawa',
					data: $('#form_awa').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_awa').click();
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
		$('body').delegate('#btn_xoaall_awa','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idawa:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=awa&task=xoanhieuawa',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_awa').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_awa').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=awa&task=xuatdsawa";
		});
	});
</script>