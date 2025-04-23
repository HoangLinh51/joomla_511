<div id="ds_doituongquanly">
	<div id="accordion_tkdoituongquanly" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách đối tượng quản lý
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_doituongquanly">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_doituongquanly">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdsdoituongquanly">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSeven" data-parent="#accordion_tkdoituongquanly" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSeven">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên đối tượng quản lý:</label>
							<div class="controls">
								<input type="text" name="tk_tendoituongquanly" id="tk_tendoituongquanly"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tkdoituongquanly" name="search_tkdoituongquanly">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_doituongquanly" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tkdoituongquanly').on('click',function(){
			$('#table_doituongquanly').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_doituongquanly&format=raw&ten='+$('#tk_tendoituongquanly').val());
		});
		$('#search_tkdoituongquanly').click();
		$('#btn_themmoi_doituongquanly').on('click',function(){
			$('#modal-title').html('Thêm mới đối tượng quản lý');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoidoituongquanly&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_doituongquanly_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_doituongquanly_luu','click',function(){
			if($('#form_doituongquanly').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=doituongquanly&task=themthongtindoituongquanly',
					data: $('#form_doituongquanly').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkdoituongquanly').click();
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
		$('body').delegate('#btn_edit_doituongquanly','click',function(){
			var id_doituongquanly = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa đối tượng quản lý');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuadoituongquanly&format=raw&id='+id_doituongquanly, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_doituongquanly_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_doituongquanly_update','click',function(){
			if($('#form_doituongquanly').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=doituongquanly&task=chinhsuathongtindoituongquanly',
					data: $('#form_doituongquanly').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkdoituongquanly').click();
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
		$('body').delegate('#btn_delete_doituongquanly','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_doituongquanly = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=doituongquanly&task=xoadoituongquanly',
					data: {id:id_doituongquanly},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkdoituongquanly').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_doituongquanly').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_iddoituongquanly = [];
				$('.array_iddoituongquanly:checked').each(function(){
					array_iddoituongquanly.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=doituongquanly&task=xoanhieudoituongquanly',
					data: {id:array_iddoituongquanly},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkdoituongquanly').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdsdoituongquanly').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=doituongquanly&task=xuatdsdoituongquanly';
		});
	});
</script>