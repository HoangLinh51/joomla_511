<div id="ds_nghiepvuthaydoi">
	<h2 class="header">Quản lý nghiệp vụ thay đổi
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_nghiepvuthaydoi" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_nghiepvuthaydoi">Xóa</span>
		</div>
	</h2>
	<div id="accordion2" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="accordion-inner">
					<form class="form-horizontal">
						<div class="row-fluid">
							<label class="control-label span3">Tên nghiệp vụ thay đổi:</label>
							<div class="controls span9">
								<input type="text" id="tk_nghiepvuthaydoi_name" class="span10">
							</div>
						</div>
						<div class="row-fluid center" style="margin-top:2%">
							<span class="btn btn-small btn-info" id="btn_tk_nghiepvuthaydoi">Tìm kiếm</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_nghiepvuthaydoi"></div>
</div>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_nghiepvuthaydoi').on('click',function(){
			$.blockUI();
			var nghiepvuthaydoi_name = $('#tk_nghiepvuthaydoi_name').val();
			$('#table_nghiepvuthaydoi').load('index.php?option=com_danhmuc&view=nghiepvuthaydoi&task=table_nghiepvuthaydoi&format=raw&nghiepvuthaydoi_name='+nghiepvuthaydoi_name,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_nghiepvuthaydoi').click();
		$('#btn_themmoi_nghiepvuthaydoi').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=nghiepvuthaydoi&task=themmoi_nghiepvuthaydoi&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_nghiepvuthaydoi').on('click',function(){
			var array_id = [];
			$('.array_id_nghiepvuthaydoi:checked').each(function(){
				array_id.push($(this).val());
			});
			if(array_id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=nghiepvuthaydoi&task=xoanhieu_nghiepvuthaydoi',
						data: {array_id:array_id},
						success:function(data){
							if(data.length>0){
								var count = 0;
								for(var i=0;i<data.length;i++){
									if(data[i]==true){
										count++;
									}
								}
								if(count>0){
									$('#btn_tk_nghiepvuthaydoi').click();
									loadNoticeBoardSuccess('Thông báo','Xử lý thành công '+count+'/'+data.length);
        							$.unblockUI();
								}
								else{
									loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
        							$.unblockUI();
								}
							}
							else{
								loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
        						$.unblockUI();
							}
						},
						error:function(){
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
        					$.unblockUI();
						}
					});
				}
			}
			else{
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một nghiệp vụ thay đổi để xóa');
				return false;
			}
		});
	});
</script>