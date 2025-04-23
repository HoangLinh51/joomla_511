<div class="ds_cost">
	<h3 class="header blue" >Danh sách nguồn kinh phí
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_cost"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_cost"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_cost"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkcost">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFour" data-parent="#accordion_tkcost" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseFour">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên nguồn kinh phí: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_cost" id="ten_cost"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_cost">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_cost"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_cost','click',function(){
			$('#table_cost').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_cost&format=raw&ten='+$('#ten_cost').val());
		});
		$('#btn_search_cost').click();
		$('#btn_themmoi_cost').on('click',function(){
			$('#modal-title').html('Thêm mới nguồn kinh phí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoicost&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_cost_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cost_luu','click',function(){
			if($('#form_cost').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cost&task=themthongtincost',
					data: $('#form_cost').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_cost').click();
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
		$('body').delegate('#btn_delete_cost','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cost&task=xoacost',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_cost').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_cost','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa nguồn kinh phí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuacost&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_cost_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_cost_update','click',function(){
			if($('#form_cost').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cost&task=chinhsuathongtincost',
					data: $('#form_cost').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_cost').click();
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
		$('body').delegate('#btn_xoaall_cost','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idcost:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=cost&task=xoanhieucost',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_cost').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_cost').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=cost&task=xuatdscost";
		});
	});
</script>