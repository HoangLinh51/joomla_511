<?php 
	defined('_JEXEC') or die('Restricted access');
	$ds_trangthaidonvi = $this->ds_trangthaidonvi;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">
	Danh sách trạng thái đơn vị
</div>
<table id="tbl_trangthaidonvi" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_trangthaidonvi"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên trạng thái đơn vị</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_trangthaidonvi);$i++){ ?>
			<?php $stt = $i+1; ?>
			<?php 
				if($ds_trangthaidonvi[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idtrangthaidonvi" value="<?php echo $ds_trangthaidonvi[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_trangthaidonvi[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_trangthaidonvi" data-id="<?php echo $ds_trangthaidonvi[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_trangthaidonvi" data-id="<?php echo $ds_trangthaidonvi[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_trangthaidonvi').dataTable();
		$('#checkall_trangthaidonvi').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idtrangthaidonvi').prop('checked',true);
			}
			else{
				$('.array_idtrangthaidonvi').prop('checked',false);
			}
		});
	});
</script>