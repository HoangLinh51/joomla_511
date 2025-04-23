<?php 
	$ds_thuhut = $this->ds_thuhut;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:2%">Danh sách thu hút</div>
<table id="tbl_thuhut" style="padding-left:1%" class="table table-striped table-bordered table-hover dataTable">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallthuhut"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên thu hút</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
	<?php 
		for($i=0;$i<count($ds_thuhut);$i++){
			$stt = $i+1;
			if($ds_thuhut[$i]['status']==1){
				$status = '<i class="icon icon-check"></i>';
			}
			else{
				$status = '';
			}
	?>
		<tr>
			<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idthuhut" value="<?php echo $ds_thuhut[$i]['id']; ?>"><label class="lbl"></label></td>
			<td style="text-align:center"><?php echo $stt; ?></td>
			<td style="text-align:center"><?php echo $ds_thuhut[$i]['name']; ?></td>
			<td style="text-align:center"><?php echo $status; ?></td>
			<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_thuhut" data-id="<?php echo $ds_thuhut[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_thuhut" data-id="<?php echo $ds_thuhut[$i]['id']; ?>">Xóa</span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable1 = $('#tbl_thuhut').dataTable();
		$('#checkallthuhut').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idthuhut').prop('checked',true);
			}
			else{
				$('.array_idthuhut').prop('checked',false);
			}
		});
		
	});
</script>