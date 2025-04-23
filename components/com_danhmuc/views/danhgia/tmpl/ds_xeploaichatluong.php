<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_xeploaichatluong">
	<h2 class="header">Danh sách đánh giá cán bộ công chức theo xếp loại chất lượng
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_them_xeploaichatluong" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_xeploaichatluong">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseEleven" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseEleven">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<div class="span12">
							<label class="span3 control-label">Tên xếp loại chất lượng:</label>
							<div class="span5">
								<input type="text" class="span12" id="tk_xeploaichatluong_name">
							</div>
						</div>
						<div class="span12 center">
							<span class="btn btn-small btn-info" id="btn_tk_xeploaichatluong">Tìm kiếm</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_xeploaichatluong" style="margin-top:1%"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_xeploaichatluong').on('click',function(){
			$.blockUI();
			var tk_xeploaichatluong_name = $('#tk_xeploaichatluong_name').val();
			$('#table_xeploaichatluong').load('index.php?option=com_danhmuc&controller=danhgia&task=table_xeploaichatluong&format=raw&tk_xeploaichatluong_name='+tk_xeploaichatluong_name,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_xeploaichatluong').click();
		$('#btn_them_xeploaichatluong').on('click',function(){
	    	$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_xeploaichatluong&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_xeploaichatluong').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var array_id = [];
				$('.array_id_xeploaichatluong:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=xeploaichatluong&task=xoanhieu_xeploaichatluong',
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
								$('#btn_tk_xeploaichatluong').click();
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