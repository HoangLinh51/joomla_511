<div class="ds_hea">
	<h3 class="header blue" >Danh sách sức khỏe
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_hea"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_hea"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_hea"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkhea">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseEight" data-parent="#accordion_tkhea" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseEight">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên sức khỏe: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_hea" id="ten_hea"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_hea">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_hea"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_hea','click',function(){
			$('#table_hea').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_hea&format=raw&ten='+$('#ten_hea').val());
		});
		$('#btn_search_hea').click();
		$('#btn_themmoi_hea').on('click',function(){
			$('#modal-title').html('Thêm mới sức khỏe');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoihea&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_hea_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_hea_luu','click',function(){
			if($('#form_hea').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hea&task=themthongtinhea',
					data: $('#form_hea').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_hea').click();
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
		$('body').delegate('#btn_delete_hea','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hea&task=xoahea',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_hea').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_hea','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa sức khỏe');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuahea&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_hea_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_hea_update','click',function(){
			if($('#form_hea').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hea&task=chinhsuathongtinhea',
					data: $('#form_hea').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_hea').click();
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
		$('body').delegate('#btn_xoaall_hea','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idhea:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hea&task=xoanhieuhea',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_hea').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_hea').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=hea&task=xuatdshea";
		});
	});
</script>