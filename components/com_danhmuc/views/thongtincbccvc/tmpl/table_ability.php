<?php 
	$ds_ability = $this->ds_ability;
?>
	<table id="tbl_ability" class="table table-striped table-bordered table-hover">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallability"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên năng lực sở trường</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_ability);$i++){ 
				$stt = $i+1;
				if($ds_ability[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idability" value="<?php echo $ds_ability[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_ability[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_ability" data-id="<?php echo $ds_ability[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_ability" data-id="<?php echo $ds_ability[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_ability').dataTable();
		$('#checkallability').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idability').prop('checked',true);
			}
			else{
				$('.array_idability').prop('checked',false);
			}
		});
	});
</script>