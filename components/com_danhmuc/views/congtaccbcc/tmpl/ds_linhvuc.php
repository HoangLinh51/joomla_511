<div id="ds_linhvuc">
	<div id="accordion_tklinhvuc" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách lĩnh vực
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_linhvuc">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_linhvuc">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdslinhvuc">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion_tklinhvuc" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên lĩnh vực:</label>
							<div class="controls">
								<input type="text" name="tk_tenlinhvuc" id="tk_tenlinhvuc"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tklinhvuc" name="search_tklinhvuc">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_linhvuc" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tklinhvuc').on('click',function(){
			$('#table_linhvuc').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_linhvuc&format=raw&ten='+$('#tk_tenlinhvuc').val());
		});
		$('#search_tklinhvuc').click();
		$('#btn_themmoi_linhvuc').on('click',function(){
			$('#modal-title').html('Thêm mới lĩnh vực');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoilinhvuc&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_linhvuc_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_linhvuc_luu','click',function(){
			if($('#form_linhvuc').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=linhvuc&task=themthongtinlinhvuc',
					data: $('#form_linhvuc').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tklinhvuc').click();
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
		$('body').delegate('#btn_edit_linhvuc','click',function(){
			var id_linhvuc = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa lĩnh vực');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsualinhvuc&format=raw&id='+id_linhvuc, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_linhvuc_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_linhvuc_update','click',function(){
			if($('#form_linhvuc').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=linhvuc&task=chinhsuathongtinlinhvuc',
					data: $('#form_linhvuc').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tklinhvuc').click();
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
		$('body').delegate('#btn_delete_linhvuc','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_linhvuc = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=linhvuc&task=xoalinhvuc',
					data: {id:id_linhvuc},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tklinhvuc').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_linhvuc').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idlinhvuc = [];
				$('.array_idlinhvuc:checked').each(function(){
					array_idlinhvuc.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=linhvuc&task=xoanhieulinhvuc',
					data: {id:array_idlinhvuc},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tklinhvuc').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdslinhvuc').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=linhvuc&task=xuatdslinhvuc';
		});
	});
</script>