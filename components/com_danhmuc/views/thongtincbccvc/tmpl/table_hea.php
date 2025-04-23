<?php 
	$ds_hea = $this->ds_hea;
?>
	<table id="tbl_hea" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallhea"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên sức khỏe</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_hea);$i++){ 
				$stt = $i+1;
				if($ds_hea[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idhea" value="<?php echo $ds_hea[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_hea[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_hea" data-id="<?php echo $ds_hea[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_hea" data-id="<?php echo $ds_hea[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_hea').dataTable();
		$('#checkallhea').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idhea').prop('checked',true);
			}
			else{
				$('.array_idhea').prop('checked',false);
			}
		});
	});
</script>