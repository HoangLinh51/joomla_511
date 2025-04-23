<div class="ds_maried">
	<h3 class="header blue" >Danh sách tình trạng hôn nhân
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_maried"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_maried"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_maried"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkmaried">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseNine" data-parent="#accordion_tkmaried" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseNine">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên tình trạng hôn nhân: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_maried" id="ten_maried"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_maried">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_maried"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_maried','click',function(){
			$('#table_maried').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_maried&format=raw&ten='+$('#ten_maried').val());
		});
		$('#btn_search_maried').click();
		$('#btn_themmoi_maried').on('click',function(){
			$('#modal-title').html('Thêm mới tình trạng hôn nhân');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoimaried&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_maried_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_maried_luu','click',function(){
			if($('#form_maried').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=maried&task=themthongtinmaried',
					data: $('#form_maried').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_maried').click();
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
		$('body').delegate('#btn_delete_maried','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=maried&task=xoamaried',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_maried').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_maried','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa tình trạng hôn nhân');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuamaried&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_maried_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_maried_update','click',function(){
			if($('#form_maried').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=maried&task=chinhsuathongtinmaried',
					data: $('#form_maried').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_maried').click();
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
		$('body').delegate('#btn_xoaall_maried','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idmaried:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=maried&task=xoanhieumaried',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_maried').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_maried').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=maried&task=xuatdsmaried";
		});
	});
</script>