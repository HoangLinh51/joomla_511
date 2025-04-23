<?php 
	$ds_cost = $this->ds_cost;
?>
	<table id="tbl_cost" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallcost"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên nguồn kinh phí</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_cost);$i++){ 
				$stt = $i+1;
				if($ds_cost[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idcost" value="<?php echo $ds_cost[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_cost[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_cost" data-id="<?php echo $ds_cost[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_cost" data-id="<?php echo $ds_cost[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_cost').dataTable();
		$('#checkallcost').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcost').prop('checked',true);
			}
			else{
				$('.array_idcost').prop('checked',false);
			}
		});
	});
</script>