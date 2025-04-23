<div id="ds_khoicoquan">
	<div id="accordion_tkkhoicoquan" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách khối cơ quan
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_khoicoquan">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_khoicoquan">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdskhoicoquan">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseThree" data-parent="#accordion_tkkhoicoquan" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseThree">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên khối cơ quan:</label>
							<div class="controls">
								<input type="text" name="tk_tenkhoicoquan" id="tk_tenkhoicoquan"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tkkhoicoquan" name="search_tkkhoicoquan">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_khoicoquan" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tkkhoicoquan').on('click',function(){
			$('#table_khoicoquan').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_khoicoquan&format=raw&ten='+$('#tk_tenkhoicoquan').val());
		});
		$('#search_tkkhoicoquan').click();
		$('#btn_themmoi_khoicoquan').on('click',function(){
			$('#modal-title').html('Thêm mới khối cơ quan');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoikhoicoquan&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_khoicoquan_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_khoicoquan_luu','click',function(){
			if($('#form_khoicoquan').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=khoicoquan&task=themthongtinkhoicoquan',
					data: $('#form_khoicoquan').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkkhoicoquan').click();
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
		$('body').delegate('#btn_edit_khoicoquan','click',function(){
			var id_khoicoquan = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa khối cơ quan');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuakhoicoquan&format=raw&id='+id_khoicoquan, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_khoicoquan_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_khoicoquan_update','click',function(){
			if($('#form_khoicoquan').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=khoicoquan&task=chinhsuathongtinkhoicoquan',
					data: $('#form_khoicoquan').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkkhoicoquan').click();
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
		$('body').delegate('#btn_delete_khoicoquan','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_khoicoquan = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=khoicoquan&task=xoakhoicoquan',
					data: {id:id_khoicoquan},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkkhoicoquan').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_khoicoquan').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idkhoicoquan = [];
				$('.array_idkhoicoquan:checked').each(function(){
					array_idkhoicoquan.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=khoicoquan&task=xoanhieukhoicoquan',
					data: {id:array_idkhoicoquan},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkkhoicoquan').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdskhoicoquan').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=khoicoquan&task=xuatdskhoicoquan';
		});
	});
</script>