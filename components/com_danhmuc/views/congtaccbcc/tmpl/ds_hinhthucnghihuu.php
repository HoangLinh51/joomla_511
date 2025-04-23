<div id="ds_hinhthucnghihuu">
	<div id="accordion_tkhinhthucnghihuu" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách hình thức nghỉ hưu
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_hinhthucnghihuu">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_hinhthucnghihuu">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdshinhthucnghihuu">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseNine" data-parent="#accordion_tkhinhthucnghihuu" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseNine">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên hình thức nghỉ hưu:</label>
							<div class="controls">
								<input type="text" name="tk_tenhinhthucnghihuu" id="tk_tenhinhthucnghihuu"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tkhinhthucnghihuu" name="search_tkhinhthucnghihuu">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_hinhthucnghihuu" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tkhinhthucnghihuu').on('click',function(){
			$('#table_hinhthucnghihuu').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_hinhthucnghihuu&format=raw&ten='+$('#tk_tenhinhthucnghihuu').val());
		});
		$('#search_tkhinhthucnghihuu').click();
		$('#btn_themmoi_hinhthucnghihuu').on('click',function(){
			$('#modal-title').html('Thêm mới hình thức nghỉ hưu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoihinhthucnghihuu&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_hinhthucnghihuu_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_hinhthucnghihuu_luu','click',function(){
			if($('#form_hinhthucnghihuu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucnghihuu&task=themthongtinhinhthucnghihuu',
					data: $('#form_hinhthucnghihuu').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkhinhthucnghihuu').click();
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
		$('body').delegate('#btn_edit_hinhthucnghihuu','click',function(){
			var id_hinhthucnghihuu = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa hình thức nghỉ hưu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuahinhthucnghihuu&format=raw&id='+id_hinhthucnghihuu, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_hinhthucnghihuu_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_hinhthucnghihuu_update','click',function(){
			if($('#form_hinhthucnghihuu').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucnghihuu&task=chinhsuathongtinhinhthucnghihuu',
					data: $('#form_hinhthucnghihuu').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkhinhthucnghihuu').click();
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
		$('body').delegate('#btn_delete_hinhthucnghihuu','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_hinhthucnghihuu = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucnghihuu&task=xoahinhthucnghihuu',
					data: {id:id_hinhthucnghihuu},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkhinhthucnghihuu').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_hinhthucnghihuu').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idhinhthucnghihuu = [];
				$('.array_idhinhthucnghihuu:checked').each(function(){
					array_idhinhthucnghihuu.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=hinhthucnghihuu&task=xoanhieuhinhthucnghihuu',
					data: {id:array_idhinhthucnghihuu},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkhinhthucnghihuu').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdshinhthucnghihuu').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=hinhthucnghihuu&task=xuatdshinhthucnghihuu';
		});
	});
</script>