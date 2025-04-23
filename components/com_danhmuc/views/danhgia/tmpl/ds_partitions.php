<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_partitions">
	<h2 class="header">
		Danh sách thiết lập Partition
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_partition" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_partition">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseTwentyOne" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseTwentyOne">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<label class="control-label span4">Tên bảng</label>
						<div class="controls span8">
							<input type="text" class="span10" id="tk_table_partition">
						</div>
					</div>
					<div class="row-fluid center">
						<span class="btn btn-small btn-info" id="btn_tk_partition" style="margin-top:1%">Tìm kiếm</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_partitions" style="margin-top:1%"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php } ?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_partition').on('click',function(){
			$.blockUI();
			var name_table = $('#tk_table_partition').val();
			$('#table_partitions').load('index.php?option=com_danhmuc&controller=danhgia&task=table_partitions&format=raw&name_table='+name_table,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_partition').click();
		$('#btn_themmoi_partition').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_partition&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_partition').on('click',function(){
			var array_id = [];
			$('.array_id_partitions:checked').each(function(){
				array_id.push($(this).val());
			});
			if(array_id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=partition&task=xoanhieu_partition',
						data: {id:array_id},
						success:function(data){
							if(data.length>0){
								var count = 0;
								for(var i=0;i<data.length;i++){
									if(data[i]==true){
										count++
									}
								}
								if(count>0){
									$('#btn_tk_partition').click();
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
				else{
					return false;
				}
			}
			else{
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một partition để xóa');
				return false;
			}
		});
	});
</script>