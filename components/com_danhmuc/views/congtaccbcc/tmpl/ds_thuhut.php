<div id="ds_thuhut">
	<div id="accordion_tkthuhut" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách thu hút
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_thuhut">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_thuhut">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdsthuhut">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTwo" data-parent="#accordion_tkthuhut" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseTwo">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên thu hút:</label>
							<div class="controls">
								<input type="text" name="tk_tenthuhut" id="tk_tenthuhut"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tkthuhut" name="search_tkthuhut">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_thuhut" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tkthuhut').on('click',function(){
			$('#table_thuhut').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_thuhut&format=raw&ten='+$('#tk_tenthuhut').val());
		});
		$('#search_tkthuhut').click();
		$('#btn_themmoi_thuhut').on('click',function(){
			$('#modal-title').html('Thêm mới thu hút');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoithuhut&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_thuhut_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_thuhut_luu','click',function(){
			if($('#form_thuhut').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuhut&task=themthongtinthuhut',
					data: $('#form_thuhut').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkthuhut').click();
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
		$('body').delegate('#btn_edit_thuhut','click',function(){
			var id_thuhut = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa thu hút');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuathuhut&format=raw&id='+id_thuhut, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_thuhut_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_thuhut_update','click',function(){
			if($('#form_thuhut').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuhut&task=chinhsuathongtinthuhut',
					data: $('#form_thuhut').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkthuhut').click();
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
		$('body').delegate('#btn_delete_thuhut','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_thuhut = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuhut&task=xoathuhut',
					data: {id:id_thuhut},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkthuhut').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_thuhut').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idthuhut = [];
				$('.array_idthuhut:checked').each(function(){
					array_idthuhut.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=thuhut&task=xoanhieuthuhut',
					data: {id:array_idthuhut},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkthuhut').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdsthuhut').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=thuhut&task=xuatdsthuhut';
		});
	});
</script>