<div class="ds_ran">
	<h3 class="header blue" >Danh sách thành phần xuất thân
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_ran"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_ran"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_ran"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkran">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFourteen" data-parent="#accordion_tkran" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseFourteen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên thành phần xuất thân: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_ran" id="ten_ran"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_ran">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_ran"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_ran','click',function(){
			$('#table_ran').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_ran&format=raw&ten='+$('#ten_ran').val());
		});
		$('#btn_search_ran').click();
		$('#btn_themmoi_ran').on('click',function(){
			$('#modal-title').html('Thêm mới thành phần xuất thân');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoiran&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ran_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ran_luu','click',function(){
			if($('#form_ran').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ran&task=themthongtinran',
					data: $('#form_ran').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ran').click();
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
		$('body').delegate('#btn_delete_ran','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ran&task=xoaran',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ran').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_ran','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa thành phần xuất thân');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuaran&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ran_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ran_update','click',function(){
			if($('#form_ran').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ran&task=chinhsuathongtinran',
					data: $('#form_ran').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ran').click();
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
		$('body').delegate('#btn_xoaall_ran','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idran:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ran&task=xoanhieuran',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ran').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_ran').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=ran&task=xuatdsran";
		});
	});
</script>