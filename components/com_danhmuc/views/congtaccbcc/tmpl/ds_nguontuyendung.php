<div id="ds_nguontuyendung">
	<h2 class="header" style="padding-bottom:1%">Danh sách nguồn tuyển dụng
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_nguontuyendung">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_nguontuyendung">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_nguontuyendung">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="tk_accordionnguontuyendung" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseEleven" data-parent="#tk_accordionnguontuyendung" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseEleven" >
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<div class="span4">
								<label class="pull-right" style="padding-top:2%">Tên nguồn tuyển dụng: </label>
							</div>
							<div class="span8">
								<input type="text" id="tk_tennguontuyendung" name="tk_tennguontuyendung">
								<span class="btn btn-small btn-primary pull-right" id="btn_tknguontuyendung" name="btn_tknguontuyendung">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_nguontuyendung" style="padding-left:2%"></div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){
		$("#btn_tknguontuyendung").on('click',function(){
			$('#table_nguontuyendung').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_nguontuyendung&format=raw&ten='+$('#tk_tennguontuyendung').val());
		});
		$('#btn_tknguontuyendung').click();
		$('#btn_themmoi_nguontuyendung').on('click',function(){
			$('#modal-title').html('Thêm mới nguồn tuyển dụng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoinguontuyendung&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nguontuyendung_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nguontuyendung_luu','click',function(){
			if($('#form_nguontuyendung').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nguontuyendung&task=themthongtinnguontuyendung',
					data: $('#form_nguontuyendung').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tknguontuyendung').click();
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
		$('body').delegate('#btn_edit_nguontuyendung','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa nguồn tuyển dụng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuanguontuyendung&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nguontuyendung_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_nguontuyendung_update','click',function(){
			if($('#form_nguontuyendung').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nguontuyendung&task=chinhsuathongtinnguontuyendung',
					data: $('#form_nguontuyendung').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tknguontuyendung').click();
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
		$('body').delegate('#btn_delete_nguontuyendung','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nguontuyendung&task=xoanguontuyendung',
					data: {id:id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tknguontuyendung').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_nguontuyendung').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idnguontuyendung:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nguontuyendung&task=xoanhieunguontuyendung',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tknguontuyendung').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_nguontuyendung').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=nguontuyendung&task=xuatdsnguontuyendung';
		});
	});
</script>