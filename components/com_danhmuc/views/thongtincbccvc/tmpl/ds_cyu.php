<div class="ds_cyu">
	<h3 class="header blue" >Danh sách chức vụ Đoàn
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_cyu"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_cyu"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_cyu"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkcyu">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSix" data-parent="#accordion_tkcyu" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSix">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên chức vụ Đoàn: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_cyu" id="ten_cyu"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_cyu">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_cyu"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_cyu','click',function(){
			$('#table_cyu').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_cyu&format=raw&ten='+$('#ten_cyu').val());
		});
		$('#btn_search_cyu').click();
		$('#btn_themmoi_cyu').on('click',function(){
			$('#modal-title').html('Thêm mới chức vụ Đoàn');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoicyu&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_cyu_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cyu_luu','click',function(){
			if($('#form_cyu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cyu&task=themthongtincyu',
					data: $('#form_cyu').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_cyu').click();
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
		$('body').delegate('#btn_delete_cyu','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cyu&task=xoacyu',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_cyu').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_cyu','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa chức vụ Đoàn');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuacyu&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_cyu_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cyu_update','click',function(){
			if($('#form_cyu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cyu&task=chinhsuathongtincyu',
					data: $('#form_cyu').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_cyu').click();
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
		$('body').delegate('#btn_xoaall_cyu','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idcyu:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cyu&task=xoanhieucyu',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_cyu').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_cyu').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=cyu&task=xuatdscyu";
		});
	});
</script>