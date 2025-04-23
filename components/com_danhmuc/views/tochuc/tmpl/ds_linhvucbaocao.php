<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_linhvucbaocao">
	<h2 class="header">Danh sách lĩnh vực báo cáo
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_linhvucbaocao" href="#modal-form" data-toggle="modal">Thêm mới</span>
		</div>
	</h2>
	<form class="form-horizontal">
		<div class="row-fluid">
			<div class="control-group">
				<div class="span6">
					<label class="control-label span5">Tên / Mã lĩnh vực báo cáo:</label>
					<div class="controls span7">
						<input type="text" id="tk_ten_linhvucbaocao" class="span12">
					</div>
				</div>
				<div class="span6">
					<label class="control-label span5">Trạng thái</label>
					<div class="controls span7">
						<select id="tk_trangthai_linhvucbaocao" class="span12">
							<option value="">Tất cả</option>
							<option value="0">Không sử dụng</option>
							<option value="1">Được sử dụng</option>
						</select>
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<span class="btn btn-small btn-info pull-right" id="btn_timkiem_linhvucbaocao">Tìm kiếm</span>
				</div>
			</div>
		</div>
	</form>
	<div id="table_linhvucbaocao"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php } ?>
<script>
	jQuery(document).ready(function($){
		$('#btn_timkiem_linhvucbaocao').on('click',function(){
			$.blockUI();
			var tk_ten_lvbc = $('#tk_ten_linhvucbaocao').val();
			var tk_trangthai_lvbc = $('#tk_trangthai_linhvucbaocao').val();
			$('#table_linhvucbaocao').load('index.php?option=com_danhmuc&controller=tochuc&task=table_linhvucbaocao&format=raw&tk_ten_lvbc='+tk_ten_lvbc+'&tk_trangthai_lvbc='+tk_trangthai_lvbc,function(){
				$.unblockUI();
			});
		});
		$('#btn_timkiem_linhvucbaocao').click();
		$('#btn_themmoi_linhvucbaocao').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=tochuc&task=themmoilinhvucbaocao&format=raw', function(){
	    	});
		});
	});
</script>