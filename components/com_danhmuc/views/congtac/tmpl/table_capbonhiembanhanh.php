<?php 
	$ds_capbonhiembanhanh = $this->ds_capbonhiembanhanh;
?>
<div class="table-header" style="text-align:center;margin-left:-3%">Danh sách cấp bổ nhiệm / ban hành</div>
<table id="tbl_capbonhiembanhanh" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_capbonhiembanhanh"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên cấp bổ nhiệm / ban hành</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_capbonhiembanhanh);$i++){ 
			$stt = $i+1;
			if($ds_capbonhiembanhanh[$i]['trangthai']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idcapbonhiembanhanh" value="<?php echo $ds_capbonhiembanhanh[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_capbonhiembanhanh[$i]['ten']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_capbonhiembanhanh" data-id="<?php echo $ds_capbonhiembanhanh[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_capbonhiembanhanh" data-id="<?php echo $ds_capbonhiembanhanh[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10= $('#tbl_capbonhiembanhanh').dataTable();
		$('#checkall_capbonhiembanhanh').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcapbonhiembanhanh').prop('checked',true);
			}
			else{
				$('.array_idcapbonhiembanhanh').prop('checked',false);
			}
		});
	});
</script>