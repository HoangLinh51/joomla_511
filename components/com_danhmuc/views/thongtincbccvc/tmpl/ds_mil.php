<div class="ds_mil">
	<h3 class="header blue" >Danh sách chức vụ lực lượng vũ trang
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_mil"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_mil"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_mil"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkmil">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTen" data-parent="#accordion_tkmil" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseTen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên chức vụ lực lượng vũ trang: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_mil" id="ten_mil"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_mil">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_mil"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_mil','click',function(){
			$('#table_mil').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_mil&format=raw&ten='+$('#ten_mil').val());
		});
		$('#btn_search_mil').click();
		$('#btn_themmoi_mil').on('click',function(){
			$('#modal-title').html('Thêm mới chức vụ lực lượng vũ trang');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoimil&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_mil_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_mil_luu','click',function(){
			if($('#form_mil').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mil&task=themthongtinmil',
					data: $('#form_mil').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_mil').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					},
				});
			}
			else{
				return false;
			}
		});
		$('body').delegate('#btn_delete_mil','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mil&task=xoamil',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_mil').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_mil','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa chức vụ lực lượng vũ trang');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuamil&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_mil_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_mil_update','click',function(){
			if($('#form_mil').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mil&task=chinhsuathongtinmil',
					data: $('#form_mil').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_mil').click();
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
		$('body').delegate('#btn_xoaall_mil','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idmil:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mil&task=xoanhieumil',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_mil').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_mil').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=mil&task=xuatdsmil";
		});
	});
</script>