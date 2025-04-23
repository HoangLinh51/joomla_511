<?php 
	$ds_nat = $this->ds_nat;
?>
	<table id="tbl_nat" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallnat"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên dân tộc</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_nat);$i++){ 
				$stt = $i+1;
				if($ds_nat[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idnat" value="<?php echo $ds_nat[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_nat[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_nat" data-id="<?php echo $ds_nat[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_nat" data-id="<?php echo $ds_nat[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_nat').dataTable();
		$('#checkallnat').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idnat').prop('checked',true);
			}
			else{
				$('.array_idnat').prop('checked',false);
			}
		});
	});
</script>