<div id="ds_vitrituyendung">
	<div id="accordion_tkvitrituyendung" class="accordion">
		<h2 class="header" style="padding-bottom:1%">Danh sách vị trí tuyển dụng
			<div class="pull-right">
				<span class="btn btn-small btn-primary" id="btn_themmoi_vitrituyendung">Thêm mới</span>
				<span class="btn btn-small btn-danger" id="btn_xoaall_vitrituyendung">Xóa</span>
				<span class="btn btn-small btn-success" id="xuatdsvitrituyendung">Xuất danh sách ra file excel</span>
			</div>
		</h2>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseSix" data-parent="#accordion_tkvitrituyendung" data-toggle="collapse" class="accordion-toggle collapsed">
					Tìm kiếm
				</a>
			</div>
			<div class="accordion-body collapse" id="collapseSix">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label span3" style="margin-right:5%">Tên vị trí tuyển dụng:</label>
							<div class="controls">
								<input type="text" name="tk_tenvitrituyendung" id="tk_tenvitrituyendung"/>
								<span class="btn btn-small btn-primary pull-right" id="search_tkvitrituyendung" name="search_tkvitrituyendung">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="table_vitrituyendung" style="padding-left:2%"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#search_tkvitrituyendung').on('click',function(){
			$('#table_vitrituyendung').load('index.php?option=com_danhmuc&view=congtaccbcc&task=table_vitrituyendung&format=raw&ten='+$('#tk_tenvitrituyendung').val());
		});
		$('#search_tkvitrituyendung').click();
		$('#btn_themmoi_vitrituyendung').on('click',function(){
			$('#modal-title').html('Thêm mới vị trí tuyển dụng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=themmoivitrituyendung&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_vitrituyendung_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_vitrituyendung_luu','click',function(){
			if($('#form_vitrituyendung').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=vitrituyendung&task=themthongtinvitrituyendung',
					data: $('#form_vitrituyendung').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkvitrituyendung').click();
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
		$('body').delegate('#btn_edit_vitrituyendung','click',function(){
			var id_vitrituyendung = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa vị trí tuyển dụng');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=congtaccbcc&task=chinhsuavitrituyendung&format=raw&id='+id_vitrituyendung, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_vitrituyendung_update">Áp dụng</button>');
	            $('#modal-form').modal('show');
	        });
		});
		$('body').delegate('#btn_vitrituyendung_update','click',function(){
			if($('#form_vitrituyendung').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=vitrituyendung&task=chinhsuathongtinvitrituyendung',
					data: $('#form_vitrituyendung').serialize(),
					success:function(data){
						if(data == 'true'){
							$('#modal-form').modal('hide');
	                        $('#search_tkvitrituyendung').click();
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
		$('body').delegate('#btn_delete_vitrituyendung','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var id_vitrituyendung = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=vitrituyendung&task=xoavitrituyendung',
					data: {id:id_vitrituyendung},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkvitrituyendung').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#btn_xoaall_vitrituyendung').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_idvitrituyendung = [];
				$('.array_idvitrituyendung:checked').each(function(){
					array_idvitrituyendung.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=vitrituyendung&task=xoanhieuvitrituyendung',
					data: {id:array_idvitrituyendung},
					success:function(data){
						if(data == 'true'){
	                        $('#search_tkvitrituyendung').click();
	                        loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
	                    }
	                    else{
	                        loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
	                    }
					}
				});
			}
		});
		$('#xuatdsvitrituyendung').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=vitrituyendung&task=xuatdsvitrituyendung';
		});
	});
</script>