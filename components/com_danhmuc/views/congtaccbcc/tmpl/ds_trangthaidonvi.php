<div id="ds_trangthaidonvi">
	<h2 class="header" style="padding-bottom:1%">Danh sách trạng thái đơn vị
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_trangthaidonvi">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_trangthaidonvi">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_trangthaidonvi">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="tk_accordiontrangthaidonvi" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTen" data-parent="#tk_accordiontrangthaidonvi" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseTen" >
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<div class="span4">
								<label class="pull-right" style="padding-top:2%">Tên trạng thái đơn vị: </label>
							</div>
							<div class="span8">
								<input type="text" id="tk_tentrangthaidonvi" name="tk_tentrangthaidonvi">
								<span class="btn btn-small btn-primary pull-right" id="btn_tktrangthaidonvi" name="btn_tktrangthaidonvi">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_trangthaidonvi" style="padding-left:2%"></div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){
		$("#btn_tktrangthaidonvi").on('click',function(){
			$('#table_trangthaidonvi').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_trangthaidonvi&format=raw&ten='+$('#tk_tentrangthaidonvi').val());
		});
		$('#btn_tktrangthaidonvi').click();
		$('#btn_themmoi_trangthaidonvi').on('click',function(){
			$('#modal-title').html('Thêm mới trạng thái đơn vị');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoitrangthaidonvi&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trangthaidonvi_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_trangthaidonvi_luu','click',function(){
			if($('#form_trangthaidonvi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaidonvi&task=themthongtintrangthaidonvi',
					data: $('#form_trangthaidonvi').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tktrangthaidonvi').click();
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
		$('body').delegate('#btn_edit_trangthaidonvi','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa trạng thái đơn vị');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuatrangthaidonvi&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trangthaidonvi_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_trangthaidonvi_update','click',function(){
			if($('#form_trangthaidonvi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaidonvi&task=chinhsuathongtintrangthaidonvi',
					data: $('#form_trangthaidonvi').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tktrangthaidonvi').click();
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
		$('body').delegate('#btn_delete_trangthaidonvi','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaidonvi&task=xoatrangthaidonvi',
					data: {id:id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tktrangthaidonvi').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_trangthaidonvi').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idtrangthaidonvi:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaidonvi&task=xoanhieutrangthaidonvi',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tktrangthaidonvi').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_trangthaidonvi').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=trangthaidonvi&task=xuatdstrangthaidonvi';
		});
	});
</script>