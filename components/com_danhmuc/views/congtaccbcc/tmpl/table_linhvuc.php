<?php 
	$ds_linhvuc = $this->ds_linhvuc;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:2%">Danh sách lĩnh vực</div>
<table id="tbl_linhvuc" style="padding-left:1%" class="table table-striped table-bordered table-hover dataTable">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkalllinhvuc"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên lĩnh vực</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
	<?php 
		for($i=0;$i<count($ds_linhvuc);$i++){
			$stt = $i+1;
			if($ds_linhvuc[$i]['status']==1){
				$status = '<i class="icon icon-check"></i>';
			}
			else{
				$status = '';
			}
	?>
		<tr>
			<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idlinhvuc" value="<?php echo $ds_linhvuc[$i]['id']; ?>"><label class="lbl"></label></td>
			<td style="text-align:center"><?php echo $stt; ?></td>
			<td style="text-align:center"><?php echo $ds_linhvuc[$i]['name']; ?></td>
			<td style="text-align:center"><?php echo $status; ?></td>
			<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_linhvuc" data-id="<?php echo $ds_linhvuc[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_linhvuc" data-id="<?php echo $ds_linhvuc[$i]['id']; ?>">Xóa</span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable1 = $('#tbl_linhvuc').dataTable();
		$('#checkalllinhvuc').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idlinhvuc').prop('checked',true);
			}
			else{
				$('.array_idlinhvuc').prop('checked',false);
			}
		});
		
	});
</script>