<?php 
	$ds_rel = $this->ds_rel;
?>
	<table id="tbl_rel" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallrel"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên tôn giáo</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_rel);$i++){ 
				$stt = $i+1;
				if($ds_rel[$i]['status']==1){
					$trelgthai='<i class="icon icon-check"></i>';
				}
				else{
					$trelgthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idrel" value="<?php echo $ds_rel[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_rel[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trelgthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_rel" data-id="<?php echo $ds_rel[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_rel" data-id="<?php echo $ds_rel[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_rel').dataTable();
		$('#checkallrel').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idrel').prop('checked',true);
			}
			else{
				$('.array_idrel').prop('checked',false);
			}
		});
	});
</script>