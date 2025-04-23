<?php 
	$ds_cyu = $this->ds_cyu;
?>
	<table id="tbl_cyu" class="table table-striped table-bordered table-hover dataTable">
		<thead>
			<th style="text-align:center;"><input type="checkbox" id="checkallcyu"><label class="lbl"></label></th>
			<th style="text-align:center">STT</th>
			<th style="text-align:center">Tên chức vụ Đoàn</th>
			<th style="text-align:center">Cấp độ</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center">Chức năng</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($ds_cyu);$i++){ 
				$stt = $i+1;
				if($ds_cyu[$i]['status']==1){
					$trangthai='<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" class="array_idcyu" value="<?php echo $ds_cyu[$i]['id']; ?>"><label class="lbl"></label></td>
					<td style="text-align:center"><?php echo $stt; ?></td>
					<td style="text-align:center"><?php echo $ds_cyu[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $ds_cyu[$i]['level']; ?></td>
					<td style="text-align:center"><?php echo $trangthai; ?></td>
					<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_cyu" data-id="<?php echo $ds_cyu[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span> <span class="btn btn-mini btn-danger" id="btn_delete_cyu" data-id="<?php echo $ds_cyu[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		// var oTable = $('#tbl_cyu').dataTable();
		$('#checkallcyu').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcyu').prop('checked',true);
			}
			else{
				$('.array_idcyu').prop('checked',false);
			}
		});
	});
</script>