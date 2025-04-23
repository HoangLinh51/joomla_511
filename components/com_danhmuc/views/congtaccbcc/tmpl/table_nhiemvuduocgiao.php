<?php 
	$ds_nhiemvuduocgiao = $this->ds_nhiemvuduocgiao;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:2%">Danh sách nhiệm vụ được giao</div>
<table id="tbl_nhiemvuduocgiao" style="padding-left:1%" class="table table-striped table-bordered table-hover dataTable">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallnhiemvuduocgiao"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên nhiệm vụ được giao</th>
		<th style="text-align:center">Mô tả</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
	<?php 
		for($i=0;$i<count($ds_nhiemvuduocgiao);$i++){
			$stt = $i+1;
			if($ds_nhiemvuduocgiao[$i]['trangthai']==1){
				$status = '<i class="icon icon-check"></i>';
			}
			else{
				$status = '';
			}
	?>
		<tr>
			<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idnhiemvuduocgiao" value="<?php echo $ds_nhiemvuduocgiao[$i]['id']; ?>"><label class="lbl"></label></td>
			<td style="text-align:center"><?php echo $stt; ?></td>
			<td style="text-align:center"><?php echo $ds_nhiemvuduocgiao[$i]['ten']; ?></td>
			<td style="text-align:center"><?php echo $ds_nhiemvuduocgiao[$i]['mota']; ?></td>
			<td style="text-align:center"><?php echo $status; ?></td>
			<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_nhiemvuduocgiao" data-id="<?php echo $ds_nhiemvuduocgiao[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_nhiemvuduocgiao" data-id="<?php echo $ds_nhiemvuduocgiao[$i]['id']; ?>">Xóa</span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable1 = $('#tbl_nhiemvuduocgiao').dataTable();
		$('#checkallnhiemvuduocgiao').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idnhiemvuduocgiao').prop('checked',true);
			}
			else{
				$('.array_idnhiemvuduocgiao').prop('checked',false);
			}
		});
		
	});
</script>