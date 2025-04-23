<?php 
	$ds_country = $this->ds_country;
?>
	<table id="tbl_country" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallcountry"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên quốc gia</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_country);$i++){ 
				$stt = $i+1;
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idcountry" value="<?php echo $ds_country[$i]['code']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_country[$i]['name']; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_country" data-id="<?php echo $ds_country[$i]['code']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_country" data-id="<?php echo $ds_country[$i]['code']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_country').dataTable();
		$('#checkallcountry').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcountry').prop('checked',true);
			}
			else{
				$('.array_idcountry').prop('checked',false);
			}
		});
	});
</script>