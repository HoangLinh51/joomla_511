<?php 
	$ds_relative = $this->ds_relative;
?>
	<table id="tbl_relative" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallrelative"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên quan hệ gia đình</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_relative);$i++){ 
				$stt = $i+1;
				if($ds_relative[$i]['status']==1){
					$trelativegthai='<i class="icon icon-check"></i>';
				}
				else{
					$trelativegthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idrelative" value="<?php echo $ds_relative[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_relative[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trelativegthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_relative" data-id="<?php echo $ds_relative[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_relative" data-id="<?php echo $ds_relative[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_relative').dataTable();
		$('#checkallrelative').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idrelative').prop('checked',true);
			}
			else{
				$('.array_idrelative').prop('checked',false);
			}
		});
	});
</script>