<div id="ds_phanloaidonvisunghiep">
	<h2 class="header" style="padding-bottom:1%">Danh sách phân loại đơn vị sự nghiệp
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_phanloaidonvisunghiep">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_phanloaidonvisunghiep">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_phanloaidonvisunghiep">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="tk_accordionphanloaidonvisunghiep" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFourteen" data-parent="#tk_accordionphanloaidonvisunghiep" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseFourteen" >
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<div class="span4">
								<label class="pull-right" style="padding-top:2%">Tên phân loại đơn vị sự nghiệp: </label>
							</div>
							<div class="span8">
								<input type="text" id="tk_tenphanloaidonvisunghiep" name="tk_tenphanloaidonvisunghiep">
								<span class="btn btn-small btn-primary pull-right" id="btn_tkphanloaidonvisunghiep" name="btn_tkphanloaidonvisunghiep">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_phanloaidonvisunghiep" style="padding-left:2%"></div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){
		$("#btn_tkphanloaidonvisunghiep").on('click',function(){
			$('#table_phanloaidonvisunghiep').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_phanloaidonvisunghiep&format=raw&ten='+$('#tk_tenphanloaidonvisunghiep').val());
		});
		$('#btn_tkphanloaidonvisunghiep').click();
		$('#btn_themmoi_phanloaidonvisunghiep').on('click',function(){
			$('#modal-title').html('Thêm mới phân loại đơn vị sự nghiệp');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoiphanloaidonvisunghiep&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phanloaidonvisunghiep_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_phanloaidonvisunghiep_luu','click',function(){
			if($('#form_phanloaidonvisunghiep').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=phanloaidonvisunghiep&task=themthongtinphanloaidonvisunghiep',
					data: $('#form_phanloaidonvisunghiep').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkphanloaidonvisunghiep').click();
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
		$('body').delegate('#btn_edit_phanloaidonvisunghiep','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa phân loại đơn vị sự nghiệp');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuaphanloaidonvisunghiep&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phanloaidonvisunghiep_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_phanloaidonvisunghiep_update','click',function(){
			if($('#form_phanloaidonvisunghiep').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=phanloaidonvisunghiep&task=chinhsuathongtinphanloaidonvisunghiep',
					data: $('#form_phanloaidonvisunghiep').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkphanloaidonvisunghiep').click();
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
		$('body').delegate('#btn_delete_phanloaidonvisunghiep','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=phanloaidonvisunghiep&task=xoaphanloaidonvisunghiep',
					data: {id:id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkphanloaidonvisunghiep').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_phanloaidonvisunghiep').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idphanloaidonvisunghiep:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=phanloaidonvisunghiep&task=xoanhieuphanloaidonvisunghiep',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkphanloaidonvisunghiep').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_phanloaidonvisunghiep').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=phanloaidonvisunghiep&task=xuatdsphanloaidonvisunghiep';
		});
	});
</script>