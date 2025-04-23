<?php 
	$ds_khoicoquan = $this->ds_khoicoquan;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:2%">Danh sách khối cơ quan</div>
<table id="tbl_khoicoquan" style="padding-left:1%" class="table table-striped table-bordered table-hover dataTable">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallkhoicoquan"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên khối cơ quan</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
	<?php 
		for($i=0;$i<count($ds_khoicoquan);$i++){
			$stt = $i+1;
			if($ds_khoicoquan[$i]['status']==1){
				$status = '<i class="icon icon-check"></i>';
			}
			else{
				$status = '';
			}
	?>
		<tr>
			<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idkhoicoquan" value="<?php echo $ds_khoicoquan[$i]['id']; ?>"><label class="lbl"></label></td>
			<td style="text-align:center"><?php echo $stt; ?></td>
			<td style="text-align:center"><?php echo $ds_khoicoquan[$i]['name']; ?></td>
			<td style="text-align:center"><?php echo $status; ?></td>
			<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_khoicoquan" data-id="<?php echo $ds_khoicoquan[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_khoicoquan" data-id="<?php echo $ds_khoicoquan[$i]['id']; ?>">Xóa</span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable1 = $('#tbl_khoicoquan').dataTable();
		$('#checkallkhoicoquan').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idkhoicoquan').prop('checked',true);
			}
			else{
				$('.array_idkhoicoquan').prop('checked',false);
			}
		});
		
	});
</script>