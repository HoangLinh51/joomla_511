<div class="ds_ous">
	<h3 class="header blue" >Danh sách đối tượng chính sách
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_ous"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_ous"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_ous"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkous">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTwelve" data-parent="#accordion_tkous" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseTwelve">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên đối tượng chính sách: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_ous" id="ten_ous"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_ous">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_ous"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_ous','click',function(){
			$('#table_ous').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_ous&format=raw&ten='+$('#ten_ous').val());
		});
		$('#btn_search_ous').click();
		$('#btn_themmoi_ous').on('click',function(){
			$('#modal-title').html('Thêm mới đối tượng chính sách');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoious&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ous_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ous_luu','click',function(){
			if($('#form_ous').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ous&task=themthongtinous',
					data: $('#form_ous').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ous').click();
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
		$('body').delegate('#btn_delete_ous','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ous&task=xoaous',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ous').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_ous','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa đối tượng chính sách');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuaous&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ous_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ous_update','click',function(){
			if($('#form_ous').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ous&task=chinhsuathongtinous',
					data: $('#form_ous').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ous').click();
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
		$('body').delegate('#btn_xoaall_ous','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idous:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ous&task=xoanhieuous',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ous').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_ous').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=ous&task=xuatdsous";
		});
	});
</script>