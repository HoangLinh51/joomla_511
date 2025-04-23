<div id="ds_nhiemvuduocgiao">
	<div id="accordion_tknhiemvuduocgiao" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách nhiệm vụ được giao
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_nhiemvuduocgiao">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_nhiemvuduocgiao">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdsnhiemvuduocgiao">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFour" data-parent="#accordion_tknhiemvuduocgiao" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseFour">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên nhiệm vụ được giao:</label>
							<div class="controls">
								<input type="text" name="tk_tennhiemvuduocgiao" id="tk_tennhiemvuduocgiao"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tknhiemvuduocgiao" name="search_tknhiemvuduocgiao">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_nhiemvuduocgiao" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tknhiemvuduocgiao').on('click',function(){
			$('#table_nhiemvuduocgiao').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_nhiemvuduocgiao&format=raw&ten='+$('#tk_tennhiemvuduocgiao').val());
		});
		$('#search_tknhiemvuduocgiao').click();
		$('#btn_themmoi_nhiemvuduocgiao').on('click',function(){
			$('#modal-title').html('Thêm mới nhiệm vụ được giao');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=congtaccbcc&task=themmoinhiemvuduocgiao&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nhiemvuduocgiao_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nhiemvuduocgiao_luu','click',function(){
			if($('#form_nhiemvuduocgiao').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhiemvuduocgiao&task=themthongtinnhiemvuduocgiao',
					data: $('#form_nhiemvuduocgiao').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tknhiemvuduocgiao').click();
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
		$('body').delegate('#btn_edit_nhiemvuduocgiao','click',function(){
			var id_nhiemvuduocgiao = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa nhiệm vụ được giao');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuanhiemvuduocgiao&format=raw&id='+id_nhiemvuduocgiao, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nhiemvuduocgiao_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_nhiemvuduocgiao_update','click',function(){
			if($('#form_nhiemvuduocgiao').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhiemvuduocgiao&task=chinhsuathongtinnhiemvuduocgiao',
					data: $('#form_nhiemvuduocgiao').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tknhiemvuduocgiao').click();
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
		$('body').delegate('#btn_delete_nhiemvuduocgiao','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_nhiemvuduocgiao = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhiemvuduocgiao&task=xoanhiemvuduocgiao',
					data: {id:id_nhiemvuduocgiao},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tknhiemvuduocgiao').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_nhiemvuduocgiao').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idnhiemvuduocgiao = [];
				$('.array_idnhiemvuduocgiao:checked').each(function(){
					array_idnhiemvuduocgiao.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhiemvuduocgiao&task=xoanhieunhiemvuduocgiao',
					data: {id:array_idnhiemvuduocgiao},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tknhiemvuduocgiao').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdsnhiemvuduocgiao').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=nhiemvuduocgiao&task=xuatdsnhiemvuduocgiao';
		});
	});
</script>