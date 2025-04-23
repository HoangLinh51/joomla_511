<div class="ds_defect">
	<h3 class="header blue" >Danh sách khuyết tật
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_defect"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_defect"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_defect"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkdefect">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSeven" data-parent="#accordion_tkdefect" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSeven">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên khuyết tật: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_defect" id="ten_defect"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_defect">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_defect"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_defect','click',function(){
			$('#table_defect').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_defect&format=raw&ten='+$('#ten_defect').val());
		});
		$('#btn_search_defect').click();
		$('#btn_themmoi_defect').on('click',function(){
			$('#modal-title').html('Thêm mới khuyết tật');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoidefect&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_defect_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_defect_luu','click',function(){
			if($('#form_defect').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=defect&task=themthongtindefect',
					data: $('#form_defect').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_defect').click();
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
		$('body').delegate('#btn_delete_defect','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=defect&task=xoadefect',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_defect').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_defect','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa khuyết tật');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuadefect&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_defect_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_defect_update','click',function(){
			if($('#form_defect').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=defect&task=chinhsuathongtindefect',
					data: $('#form_defect').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_defect').click();
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
		$('body').delegate('#btn_xoaall_defect','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_iddefect:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=defect&task=xoanhieudefect',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_defect').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_defect').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=defect&task=xuatdsdefect";
		});
	});
</script>