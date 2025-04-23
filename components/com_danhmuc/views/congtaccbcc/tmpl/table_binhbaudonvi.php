<?php 
	$ds_binhbaudonvi = $this->ds_binhbaudonvi;
?>
<div class="table-header" style="text-align:center;margin:1% 0 2% -3%">Danh sách bình bầu đơn vị</div>
<table id="tbl_binhbaudonvi" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallbbdv"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên bình bầu đơn vị</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_binhbaudonvi);$i++){ 
			$stt = $i+1;
			if($ds_binhbaudonvi[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idbbdv" value="<?php echo $ds_binhbaudonvi[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_binhbaudonvi[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="<?php echo $ds_binhbaudonvi[$i]['id']; ?>" id="btn_edit_bbdv">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" data-id="<?php echo $ds_binhbaudonvi[$i]['id']; ?>" id="btn_delete_bbdv">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_binhbaudonvi').dataTable();
		$('#checkallbbdv').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idbbdv').prop('checked',true);
			}
			else{
				$('.array_idbbdv').prop('checked',false);
			}
		});
	});
</script>