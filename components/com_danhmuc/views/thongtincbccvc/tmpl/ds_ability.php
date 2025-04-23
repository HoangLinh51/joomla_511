<div class="ds_ability">
	<h3 class="header blue">Danh sách năng lực sở trường
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_ability"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_ability"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_ability"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkability">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion_tkability" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên:</label>
					 		<div class="controls">
					 			<input type="text" name="ten_ability" id="ten_ability"/>
					 		</div>
						 </div>
						 <div class="control-group center">
						 <span class="btn btn-mini btn-primary" id="btn_search_ability">Tìm kiếm</span>
						 </div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_ability"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_ability','click',function(){
			$('#table_ability').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_ability&format=raw&ten='+$('#ten_ability').val());
		});
		$('#btn_search_ability').click();
		$('#btn_themmoi_ability').on('click',function(){
			$('#modal-title').html('Thêm mới năng lực sở trường');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoiability&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ability_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ability_luu','click',function(){
			if($('#form_ability').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ability&task=themthongtinability',
					data: $('#form_ability').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ability').click();
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
		$('body').delegate('#btn_delete_ability','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ability&task=xoaability',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ability').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_ability','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa năng lực sở trường');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuaability&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_ability_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_ability_update','click',function(){
			if($('#form_ability').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ability&task=chinhsuathongtinability',
					data: $('#form_ability').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_ability').click();
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
		$('body').delegate('#btn_xoaall_ability','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idability:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=ability&task=xoanhieuability',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_ability').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_ability').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=ability&task=xuatdsability";
		});
	});
</script>