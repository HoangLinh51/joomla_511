<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_tinhchat">
	<h2 class="header">Danh sách đánh giá cán bộ công chức theo tính chất
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_them_tinhchat" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_tinhchat">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseNine" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseNine">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<div class="span12">
							<label class="span3 control-label">Tên tính chất:</label>
							<div class="span5">
								<input type="text" class="span12" id="tk_tinhchat_name">
							</div>
						</div>
						<div class="span12 center">
							<span class="btn btn-small btn-info" id="btn_tk_tinhchat">Tìm kiếm</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_tinhchat" style="margin-top:1%"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_tinhchat').on('click',function(){
			$.blockUI();
			var tk_tinhchat_name = $('#tk_tinhchat_name').val();
			$('#table_tinhchat').load('index.php?option=com_danhmuc&controller=danhgia&task=table_tinhchat&format=raw&tk_tinhchat_name='+tk_tinhchat_name,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_tinhchat').click();
		$('#btn_them_tinhchat').on('click',function(){
	    	$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_tinhchat&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_tinhchat').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var array_id = [];
				$('.array_id_tinhchat:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tinhchat&task=xoanhieu_tinhchat',
					data: {id:array_id},
					success:function(data){
						if(data.length>0){
							var count =0;
							for(var i=0;i<data.length;i++){
								if(data[i]==true){
									count++;
								}
							}
							if(count>0){
								$('#btn_tk_tinhchat').click();
								loadNoticeBoardSuccess('Thông báo','Xử lý thành công '+count+'/'+data.length);
        						$.unblockUI();
							}
							else{
								loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
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
		});
	});
</script>