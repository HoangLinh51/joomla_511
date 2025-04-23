<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_mucdothamgia">
	<h2 class="header">
		Danh sách mức độ tham gia
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_mucdothamgia" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_mucdothamgia">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseEightteen" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseEightteen">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<label class="span4 control-label">Tên mức độ tham gia:</label>
						<div class="controls span8">
							<input type="text" id="tk_mucdothamgia_ten" class="span10">
						</div>
					</div>
					<div class="row-fluid center">
						<span class="btn btn-small btn-info" id="btn_tk_mucdothamgia">Tìm kiếm</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_mucdothamgia" style="margin-top:2%"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php } ?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_mucdothamgia').on('click',function(){
			$.blockUI();
			var tk_ten = $('#tk_mucdothamgia_ten').val();
			$('#table_mucdothamgia').load('index.php?option=com_danhmuc&controller=danhgia&task=table_mucdothamgia&format=raw&tk_ten='+tk_ten,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_mucdothamgia').click();
		$('#btn_themmoi_mucdothamgia').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_mucdothamgia&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_mucdothamgia').on('click',function(){
			var array_id = [];
			$('.array_id_mucdothamgia:checked').each(function(){
				array_id.push($(this).val());
			});
			if(array_id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=mucdothamgia&task=xoanhieu_mucdothamgia',
						data: {id:array_id},
						success:function(data){
							if(data.length>0){
								var count = 0;
								for(var i=0;i<data.length;i++){
									if(data[i]==true){
										count++;
									}
								}
								if(count>0){
									$('#btn_tk_mucdothamgia').click();
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
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một mức độ tham gia để xóa');
				return false;
			}
		});
	});
</script>