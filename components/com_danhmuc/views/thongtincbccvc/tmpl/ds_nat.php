<div class="ds_nat">
	<h3 class="header blue" >Danh sách dân tộc
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_nat"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_nat"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_nat"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tknat">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseEleven" data-parent="#accordion_tknat" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseEleven">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên dân tộc: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_nat" id="ten_nat"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_nat">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_nat"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_nat','click',function(){
			$('#table_nat').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_nat&format=raw&ten='+$('#ten_nat').val());
		});
		$('#btn_search_nat').click();
		$('#btn_themmoi_nat').on('click',function(){
			$('#modal-title').html('Thêm mới dân tộc');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoinat&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_nat_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nat_luu','click',function(){
			if($('#form_nat').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nat&task=themthongtinnat',
					data: $('#form_nat').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_nat').click();
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
		$('body').delegate('#btn_delete_nat','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nat&task=xoanat',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_nat').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_nat','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa dân tộc');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuanat&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_nat_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nat_update','click',function(){
			if($('#form_nat').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nat&task=chinhsuathongtinnat',
					data: $('#form_nat').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_nat').click();
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
		$('body').delegate('#btn_xoaall_nat','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idnat:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nat&task=xoanhieunat',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_nat').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_nat').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=nat&task=xuatdsnat";
		});
	});
</script>