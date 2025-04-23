<div id="ds_binhbauphanloaicbcc">
	<h2 class="header" style="padding-bottom:1%">Danh sách bình bầu phân loại cbcc
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_binhbauphanloaicbcc">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_binhbauphanloaicbcc">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_binhbauphanloaicbcc">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="tk_accordionbinhbauphanloaicbcc" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseThirteen" data-parent="#tk_accordionbinhbauphanloaicbcc" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseThirteen" >
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<div class="span4">
								<label class="pull-right" style="padding-top:2%">Tên bình bầu phân loại cbcc: </label>
							</div>
							<div class="span8">
								<input type="text" id="tk_tenbinhbauphanloaicbcc" name="tk_tenbinhbauphanloaicbcc">
								<span class="btn btn-small btn-primary pull-right" id="btn_tkbinhbauphanloaicbcc" name="btn_tkbinhbauphanloaicbcc">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_binhbauphanloaicbcc" style="padding-left:2%"></div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){
		$("#btn_tkbinhbauphanloaicbcc").on('click',function(){
			$('#table_binhbauphanloaicbcc').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_binhbauphanloaicbcc&format=raw&ten='+$('#tk_tenbinhbauphanloaicbcc').val());
		});
		$('#btn_tkbinhbauphanloaicbcc').click();
		$('#btn_themmoi_binhbauphanloaicbcc').on('click',function(){
			$('#modal-title').html('Thêm mới bình bầu phân loại cbcc');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoibinhbauphanloaicbcc&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_binhbauphanloaicbcc_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_binhbauphanloaicbcc_luu','click',function(){
			if($('#form_binhbauphanloaicbcc').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbauphanloaicbcc&task=themthongtinbinhbauphanloaicbcc',
					data: $('#form_binhbauphanloaicbcc').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkbinhbauphanloaicbcc').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}else{	
				return false;
			}
		});
		$('body').delegate('#btn_edit_binhbauphanloaicbcc','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa bình bầu phân loại cbcc');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuabinhbauphanloaicbcc&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_binhbauphanloaicbcc_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_binhbauphanloaicbcc_update','click',function(){
			if($('#form_binhbauphanloaicbcc').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbauphanloaicbcc&task=chinhsuathongtinbinhbauphanloaicbcc',
					data: $('#form_binhbauphanloaicbcc').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkbinhbauphanloaicbcc').click();
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
		$('body').delegate('#btn_delete_binhbauphanloaicbcc','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbauphanloaicbcc&task=xoabinhbauphanloaicbcc',
					data: {id:id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkbinhbauphanloaicbcc').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_binhbauphanloaicbcc').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idbinhbauphanloaicbcc:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbauphanloaicbcc&task=xoanhieubinhbauphanloaicbcc',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkbinhbauphanloaicbcc').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_binhbauphanloaicbcc').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=binhbauphanloaicbcc&task=xuatdsbinhbauphanloaicbcc';
		});
	});
</script>