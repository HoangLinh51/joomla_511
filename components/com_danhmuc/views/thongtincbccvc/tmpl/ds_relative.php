<div class="ds_relative">
	<h3 class="header blue" >Danh sách quan hệ gia đình
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_relative"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_relative"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_relative"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkrelative">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSeventeen" data-parent="#accordion_tkrelative" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSeventeen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên quan hệ gia đình: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_relative" id="ten_relative"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_relative">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_relative"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_relative','click',function(){
			$('#table_relative').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_relative&format=raw&ten='+$('#ten_relative').val());
		});
		$('#btn_search_relative').click();
		$('#btn_themmoi_relative').on('click',function(){
			$('#modal-title').html('Thêm mới quan hệ gia đình');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoirelative&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_relative_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_relative_luu','click',function(){
			if($('#form_relative').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=relative&task=themthongtinrelative',
					data: $('#form_relative').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_relative').click();
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
		$('body').delegate('#btn_delete_relative','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=relative&task=xoarelative',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_relative').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_relative','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa quan hệ gia đình');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuarelative&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_relative_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_relative_update','click',function(){
			if($('#form_relative').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=relative&task=chinhsuathongtinrelative',
					data: $('#form_relative').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_relative').click();
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
		$('body').delegate('#btn_xoaall_relative','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idrelative:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=relative&task=xoanhieurelative',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_relative').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_relative').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=relative&task=xuatdsrelative";
		});
	});
</script>