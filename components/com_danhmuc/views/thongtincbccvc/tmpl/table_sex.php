<?php 
	$ds_sex = $this->ds_sex;
?>
	<table id="tbl_sex" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallsex"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên giới tính</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_sex);$i++){ 
				$stt = $i+1;
				if($ds_sex[$i]['status']==1){
					$tsexgthai='<i class="icon icon-check"></i>';
				}
				else{
					$tsexgthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idsex" value="<?php echo $ds_sex[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_sex[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $tsexgthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_sex" data-id="<?php echo $ds_sex[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_sex" data-id="<?php echo $ds_sex[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_sex').dataTable();
		$('#checkallsex').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idsex').prop('checked',true);
			}
			else{
				$('.array_idsex').prop('checked',false);
			}
		});
	});
</script>