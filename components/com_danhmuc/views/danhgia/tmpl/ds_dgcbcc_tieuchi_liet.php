<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_dgcbcc_tieuchi_liet">
	<h2 class="header">
		Quản lý tiêu chí liệt
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_dgcbcc_tieuchi_liet" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_dgcbcc_tieuchi_liet">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseTwentytwo" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseTwentytwo">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<label class="control-label span3">Tên tiêu chí:</label>
						<div class="controls span9">
							<input type="text" class="span12" id="tk_dgcbcc_tieuchi_phanloai_name">
						</div>
					</div>
					<div class="row-fluid center">
						<span class="btn btn-small btn-info" id="btn_tk_dgcbcc_tieuchi_phanloai" style="margin-top:1%">Tìm kiếm</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_dgcbcc_tieuchi_liet" style="margin-top:1%"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php } ?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_dgcbcc_tieuchi_phanloai').on('click',function(){
			$.blockUI();
			var tk_tieuchi_name = $('#tk_dgcbcc_tieuchi_phanloai_name').val();
			$('#table_dgcbcc_tieuchi_liet').load('index.php?option=com_danhmuc&controller=danhgia&task=table_dgcbcc_tieuchi_liet&format=raw&tk_tieuchi_name='+tk_tieuchi_name,function(){
				$.unblockUI();
			});
		});
		$('#btn_tk_dgcbcc_tieuchi_phanloai').click();
		$('#btn_themmoi_dgcbcc_tieuchi_liet').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_dgcbcc_tieuchi_liet&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_dgcbcc_tieuchi_liet').on('click',function(){
			var array_id = [];
			$('.array_id_dgcbcc_tieuchi_liet:checked').each(function(){
				array_id.push($(this).val());
			});
			if(array_id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=dgcbcc_tieuchiliet&task=xoanhieu_dgcbcc_tieuchi_liet',
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
									$('#btn_tk_dgcbcc_tieuchi_phanloai').click();
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
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một tiêu chí để xóa');
				return false;
			}
		});
	});
</script>