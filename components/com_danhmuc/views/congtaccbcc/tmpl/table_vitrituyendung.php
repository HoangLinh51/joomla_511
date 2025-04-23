<?php 
	$ds_vitrituyendung = $this->ds_vitrituyendung;
?>
<div class="table-header" style="text-align:center;margin:1% 0 2% -3%">Danh sách vị trí tuyển dụng</div>
<table id="tbl_vitrituyendung" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallvitrituyendung"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên vị trí tuyển dụng</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_vitrituyendung);$i++){ 
			$stt = $i+1;
			if($ds_vitrituyendung[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idvitrituyendung" value="<?php echo $ds_vitrituyendung[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_vitrituyendung[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="<?php echo $ds_vitrituyendung[$i]['id']; ?>" id="btn_edit_vitrituyendung">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" data-id="<?php echo $ds_vitrituyendung[$i]['id']; ?>" id="btn_delete_vitrituyendung">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_vitrituyendung').dataTable();
		$('#checkallvitrituyendung').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idvitrituyendung').prop('checked',true);
			}
			else{
				$('.array_idvitrituyendung').prop('checked',false);
			}
		});
	});
</script>