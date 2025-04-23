<?php 
	$ds_party_pos = $this->ds_party_pos;
?>
	<table id="tbl_party_pos" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallparty_pos"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên chức vụ Đảng</th>
			<th style="text-align:center">Cấp độ</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_party_pos);$i++){ 
				$stt = $i+1;
				if($ds_party_pos[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idparty_pos" value="<?php echo $ds_party_pos[$i]['code']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_party_pos[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $ds_party_pos[$i]['level']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_party_pos" data-id="<?php echo $ds_party_pos[$i]['code']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_party_pos" data-id="<?php echo $ds_party_pos[$i]['code']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_party_pos').dataTable();
		$('#checkallparty_pos').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idparty_pos').prop('checked',true);
			}
			else{
				$('.array_idparty_pos').prop('checked',false);
			}
		});
	});
</script>