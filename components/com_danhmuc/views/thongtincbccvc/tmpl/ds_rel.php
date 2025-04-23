<div class="ds_rel">
	<h3 class="header blue" >Danh sách tôn giáo
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_rel"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_rel"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_rel"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkrel">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSixteen" data-parent="#accordion_tkrel" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSixteen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên tôn giáo: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_rel" id="ten_rel"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_rel">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_rel"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_rel','click',function(){
			$('#table_rel').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_rel&format=raw&ten='+$('#ten_rel').val());
		});
		$('#btn_search_rel').click();
		$('#btn_themmoi_rel').on('click',function(){
			$('#modal-title').html('Thêm mới tôn giáo');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoirel&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_rel_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_rel_luu','click',function(){
			if($('#form_rel').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rel&task=themthongtinrel',
					data: $('#form_rel').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_rel').click();
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
		$('body').delegate('#btn_delete_rel','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rel&task=xoarel',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_rel').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_rel','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa tôn giáo');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuarel&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_rel_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_rel_update','click',function(){
			if($('#form_rel').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rel&task=chinhsuathongtinrel',
					data: $('#form_rel').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_rel').click();
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
		$('body').delegate('#btn_xoaall_rel','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idrel:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=rel&task=xoanhieurel',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_rel').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_rel').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=rel&task=xuatdsrel";
		});
	});
</script>