<div id="ds_binhbaudonvi">
	<h2 class="header" style="padding-bottom:2%">Danh sách bình bầu đơn vị
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_bbdv">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoall_bbdv">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatds_bbdv">Xuất danh sách ra excel</span>
		</div>
	</h2>
	<div id="accordion_tkbinhbaudonvi">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFive" data-parent="#accordion_tkbinhbaudonvi" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseFive">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group" style="padding-left:5%">
							<label class="control-label" style="margin-right:10%">Tên bình bầu đơn vị:</label>
							<div class="controls">
								<input type="text" name="tk_tenbinhbaudonvi" id="tk_tenbinhbaudonvi">
								<span class="btn btn-mini btn-primary pull-right" style="margin-right:25%" id="btn_search_tenbinhbaudonvi">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_binhbaudonvi" style="padding-left:3%"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_tenbinhbaudonvi').on('click',function(){
			$('#table_binhbaudonvi').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_binhbaudonvi&format=raw&ten='+$('#tk_tenbinhbaudonvi').val());
		});
		$('#btn_search_tenbinhbaudonvi').click();
		$('#btn_themmoi_bbdv').on('click',function(){
			$('#modal-title').html('Thêm mới bình bầu đơn vị');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoibbdv&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_bbdv_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});	
		$('body').delegate('#btn_bbdv_luu','click',function(){
			if($('#form_bbdv').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbaudonvi&task=themthongtinvbbdv',
					data: $('#form_bbdv').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_tenbinhbaudonvi').click();
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
		$('body').delegate('#btn_edit_bbdv','click',function(){
			var id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa bình bầu đơn vị');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuabbdv&format=raw&id='+id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_bbdv_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_bbdv_update','click',function(){
			if($('#form_bbdv').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbaudonvi&task=chinhsuathongtinvbbdv',
					data: $('#form_bbdv').serialize(),
					success: function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_tenbinhbaudonvi').click();
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
		$('body').delegate('#btn_delete_bbdv','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbaudonvi&task=xoabbdv',
					data: {id:id},
					success: function(data){
						if(data == 'true'){
	                        $('#btn_search_tenbinhbaudonvi').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoall_bbdv').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idbbdv:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=binhbaudonvi&task=xoanhieubbdv',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_tenbinhbaudonvi').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xuatds_bbdv').on('click',function(){
			window.location.href = 'index.php?option=com_danhmuc&controller=binhbaudonvi&task=xuatdsbbdv'
		});	
	});
</script>