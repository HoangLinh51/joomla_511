<div class="ds_blood">
	<h3 class="header blue" >Danh sách nhóm máu
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_blood"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_blood"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_blood"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkblood">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseThree" data-parent="#accordion_tkblood" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseThree">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên nhóm máu: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_blood" id="ten_blood"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_blood">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_blood"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_blood','click',function(){
			$('#table_blood').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_blood&format=raw&ten='+$('#ten_blood').val());
		});
		$('#btn_search_blood').click();
		$('#btn_themmoi_blood').on('click',function(){
			$('#modal-title').html('Thêm mới nhóm máu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoiblood&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_blood_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_blood_luu','click',function(){
			if($('#form_blood').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=blood&task=themthongtinblood',
					data: $('#form_blood').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_blood').click();
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
		$('body').delegate('#btn_delete_blood','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=blood&task=xoablood',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_blood').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_blood','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa nhóm máu');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuablood&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_blood_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_blood_update','click',function(){
			if($('#form_blood').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=blood&task=chinhsuathongtinblood',
					data: $('#form_blood').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_blood').click();
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
		$('body').delegate('#btn_xoaall_blood','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idblood:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=blood&task=xoanhieublood',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_blood').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_blood').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=blood&task=xuatdsblood";
		});
	});
</script>