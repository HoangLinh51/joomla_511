<div id="ds_trangthaihoso">
	<div id="accordion_tktrangthaihoso" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách trạng thái hồ sơ
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_trangthaihoso">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_trangthaihoso">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdstrangthaihoso">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseEight" data-parent="#accordion_tktrangthaihoso" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseEight">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên trạng thái hồ sơ:</label>
							<div class="controls">
								<input type="text" name="tk_tentrangthaihoso" id="tk_tentrangthaihoso"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tktrangthaihoso" name="search_tktrangthaihoso">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_trangthaihoso" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tktrangthaihoso').on('click',function(){
			$('#table_trangthaihoso').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_trangthaihoso&format=raw&ten='+$('#tk_tentrangthaihoso').val());
		});
		$('#search_tktrangthaihoso').click();
		$('#btn_themmoi_trangthaihoso').on('click',function(){
			$('#modal-title').html('Thêm mới trạng thái hồ sơ');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoitrangthaihoso&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trangthaihoso_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_trangthaihoso_luu','click',function(){
			if($('#form_trangthaihoso').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaihoso&task=themthongtintrangthaihoso',
					data: $('#form_trangthaihoso').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tktrangthaihoso').click();
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
		$('body').delegate('#btn_edit_trangthaihoso','click',function(){
			var id_trangthaihoso = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa trạng thái hồ sơ');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuatrangthaihoso&format=raw&id='+id_trangthaihoso, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trangthaihoso_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_trangthaihoso_update','click',function(){
			if($('#form_trangthaihoso').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaihoso&task=chinhsuathongtintrangthaihoso',
					data: $('#form_trangthaihoso').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tktrangthaihoso').click();
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
		$('body').delegate('#btn_delete_trangthaihoso','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_trangthaihoso = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaihoso&task=xoatrangthaihoso',
					data: {id:id_trangthaihoso},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tktrangthaihoso').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_trangthaihoso').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idtrangthaihoso = [];
				$('.array_idtrangthaihoso:checked').each(function(){
					array_idtrangthaihoso.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=trangthaihoso&task=xoanhieutrangthaihoso',
					data: {id:array_idtrangthaihoso},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tktrangthaihoso').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdstrangthaihoso').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=trangthaihoso&task=xuatdstrangthaihoso';
		});
	});
</script>