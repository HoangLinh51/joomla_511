<div class="ds_party_pos">
	<h3 class="header blue" >Danh sách chức vụ Đảng
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_party_pos"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_party_pos"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_party_pos"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkparty_pos">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseThirteen" data-parent="#accordion_tkparty_pos" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseThirteen">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label" style="width:25%">Tên chức vụ Đảng: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_party_pos" id="ten_party_pos"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_party_pos">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_party_pos"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_party_pos','click',function(){
			$('#table_party_pos').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_party_pos&format=raw&ten='+$('#ten_party_pos').val());
		});
		$('#btn_search_party_pos').click();
		$('#btn_themmoi_party_pos').on('click',function(){
			$('#modal-title').html('Thêm mới chức vụ Đảng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoiparty_pos&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_party_pos_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_party_pos_luu','click',function(){
			if($('#form_party_pos').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=party_pos&task=themthongtinparty_pos',
					data: $('#form_party_pos').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_party_pos').click();
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
		$('body').delegate('#btn_delete_party_pos','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=party_pos&task=xoaparty_pos',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_party_pos').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_party_pos','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa chức vụ Đảng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuaparty_pos&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_party_pos_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_party_pos_update','click',function(){
			if($('#form_party_pos').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=party_pos&task=chinhsuathongtinparty_pos',
					data: $('#form_party_pos').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_party_pos').click();
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
		$('body').delegate('#btn_xoaall_party_pos','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idparty_pos:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=party_pos&task=xoanhieuparty_pos',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_party_pos').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_party_pos').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=party_pos&task=xuatdsparty_pos";
		});
	});
</script>