<div id="ds_congviecchuyenmon">
	<h2 class="header" style="padding-bottom:1%">Danh sách công việc chuyên môn
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_congviecchuyenmon">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoaall_congviecchuyenmon">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_congviecchuyenmon">Xuất ra danh sách</span>
		</div>
	</h2>
	<div id="tk_accordioncongviecchuyenmon" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTwelve" data-parent="#tk_accordioncongviecchuyenmon" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseTwelve" >
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<div class="span4">
								<label class="pull-right" style="padding-top:2%">Tên công việc chuyên môn: </label>
							</div>
							<div class="span8">
								<input type="text" id="tk_tencongviecchuyenmon" name="tk_tencongviecchuyenmon">
								<span class="btn btn-small btn-primary pull-right" id="btn_tkcongviecchuyenmon" name="btn_tkcongviecchuyenmon">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_congviecchuyenmon" style="padding-left:2%"></div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){
		$("#btn_tkcongviecchuyenmon").on('click',function(){
			$('#table_congviecchuyenmon').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_congviecchuyenmon&format=raw&ten='+$('#tk_tencongviecchuyenmon').val());
		});
		$('#btn_tkcongviecchuyenmon').click();
		$('#btn_themmoi_congviecchuyenmon').on('click',function(){
			$('#modal-title').html('Thêm mới công việc chuyên môn');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoicongviecchuyenmon&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_congviecchuyenmon_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_congviecchuyenmon_luu','click',function(){
			if($('#form_congviecchuyenmon').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=congviecchuyenmon&task=themthongtincongviecchuyenmon',
					data: $('#form_congviecchuyenmon').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkcongviecchuyenmon').click();
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
		$('body').delegate('#btn_edit_congviecchuyenmon','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa công việc chuyên môn');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuacongviecchuyenmon&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_congviecchuyenmon_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_congviecchuyenmon_update','click',function(){
			if($('#form_congviecchuyenmon').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=congviecchuyenmon&task=chinhsuathongtincongviecchuyenmon',
					data: $('#form_congviecchuyenmon').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_tkcongviecchuyenmon').click();
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
		$('body').delegate('#btn_delete_congviecchuyenmon','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=congviecchuyenmon&task=xoacongviecchuyenmon',
					data: {id:id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkcongviecchuyenmon').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_congviecchuyenmon').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idcongviecchuyenmon:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=congviecchuyenmon&task=xoanhieucongviecchuyenmon',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_tkcongviecchuyenmon').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_congviecchuyenmon').on('click',function(){
			window.location.href='index.php?option=com_danhmuc&controller=congviecchuyenmon&task=xuatdscongviecchuyenmon';
		});
	});
</script>