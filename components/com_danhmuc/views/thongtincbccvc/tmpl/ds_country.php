<div class="ds_country">
	<h3 class="header blue" >Danh sách quốc gia
	<div class="pull-right">
		<span class="btn btn-mini btn-primary" id="btn_themmoi_country"><i class="icon-plus"></i> Thêm mới</span>
		<span class="btn btn-mini btn-danger" id="btn_xoaall_country"><i class="icon-remove"></i> Xóa</span>
		<span class="btn btn-mini btn-success" id="btn_exportexcel_country"><i class="icon-download"></i> Xuất danh sách ra excel</span>
	</div>
	</h3>
	<div class="accordion" id="accordion_tkcountry">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseFive" data-parent="#accordion_tkcountry" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseFive">
				<div class="accordion-inner">
					 <form class="form-horizontal">
					 	<div class="control-group">
					 		<label class="control-label">Tên quốc gia: </label>
					 		<div class="controls span6">
					 			<input type="text" name="ten_country" id="ten_country"/>
					 		</div>
					 		<span class="btn btn-mini btn-primary" id="btn_search_country">Tìm kiếm</span>
					 	</div>
					 </form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_country"></div>
</div>
<script>
	jQuery(document).ready(function($){
		$('body').delegate('#btn_search_country','click',function(){
			$('#table_country').load('index.php?option=com_danhmuc&view=thongtincbccvc&task=table_country&format=raw&ten='+$('#ten_country').val());
		});
		$('#btn_search_country').click();
		$('#btn_themmoi_country').on('click',function(){
			$('#modal-title').html('Thêm mới quốc gia');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=themmoicountry&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_country_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_country_luu','click',function(){
			if($('#form_country').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=country&task=themthongtincountry',
					data: $('#form_country').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_country').click();
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
		$('body').delegate('#btn_delete_country','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				console.log(data_id);
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=country&task=xoacountry',
					data: {id:data_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_country').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('body').delegate('#btn_edit_country','click',function(){
			var data_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa quốc gia');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=thongtincbccvc&task=chinhsuacountry&format=raw&id='+data_id, function(){
	            $('.modal-footer').html('<button class="btn btn-mini" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-mini btn-primary" id="btn_country_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_country_update','click',function(){
			if($('#form_country').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=country&task=chinhsuathongtincountry',
					data: $('#form_country').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#btn_search_country').click();
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
		$('body').delegate('#btn_xoaall_country','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.array_idcountry:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=country&task=xoanhieucountry',
					data: {id:array_id},
					success:function(data){
						if(data == 'true'){
	                        $('#btn_search_country').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_exportexcel_country').on('click',function(){
			window.location.href = "index.php?option=com_danhmuc&controller=country&task=xuatdscountry";
		});
	});
</script>