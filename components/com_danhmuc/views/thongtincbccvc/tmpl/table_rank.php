<?php 
	$ds_rank = $this->ds_rank;
?>
	<table id="tbl_rank" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallrank"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên cấp bậc lực lượng vũ trang</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_rank);$i++){ 
				$stt = $i+1;
				if($ds_rank[$i]['status']==1){
					$trankgthai='<i class="icon icon-check"></i>';
				}
				else{
					$trankgthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idrank" value="<?php echo $ds_rank[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_rank[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trankgthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_rank" data-id="<?php echo $ds_rank[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_rank" data-id="<?php echo $ds_rank[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_rank').dataTable();
		$('#checkallrank').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idrank').prop('checked',true);
			}
			else{
				$('.array_idrank').prop('checked',false);
			}
		});
	});
</script>