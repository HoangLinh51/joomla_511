<?php 
	$ds_awa = $this->ds_awa;
?>
	<table id="tbl_awa" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallawa"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên danh hiệu phong tặng</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_awa);$i++){ 
				$stt = $i+1;
				if($ds_awa[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idawa" value="<?php echo $ds_awa[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_awa[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_awa" data-id="<?php echo $ds_awa[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_awa" data-id="<?php echo $ds_awa[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_awa').dataTable();
		$('#checkallawa').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idawa').prop('checked',true);
			}
			else{
				$('.array_idawa').prop('checked',false);
			}
		});
	});
</script>