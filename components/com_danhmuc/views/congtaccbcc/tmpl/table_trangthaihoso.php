<?php 
	$ds_trangthaihoso = $this->ds_trangthaihoso;
?>
<div class="table-header" style="text-align:center;margin:1% 0 2% -3%">Danh sách trạng thái hồ sơ</div>
<table id="tbl_trangthaihoso" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkalltrangthaihoso"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên trạng thái hồ sơ</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_trangthaihoso);$i++){ 
			$stt = $i+1;
			if($ds_trangthaihoso[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idtrangthaihoso" value="<?php echo $ds_trangthaihoso[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_trangthaihoso[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="<?php echo $ds_trangthaihoso[$i]['id']; ?>" id="btn_edit_trangthaihoso">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" data-id="<?php echo $ds_trangthaihoso[$i]['id']; ?>" id="btn_delete_trangthaihoso">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_trangthaihoso').dataTable();
		$('#checkalltrangthaihoso').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idtrangthaihoso').prop('checked',true);
			}
			else{
				$('.array_idtrangthaihoso').prop('checked',false);
			}
		});
	});
</script>