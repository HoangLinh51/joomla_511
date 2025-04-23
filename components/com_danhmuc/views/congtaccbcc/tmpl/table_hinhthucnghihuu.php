<?php 
	$ds_hinhthucnghihuu = $this->ds_hinhthucnghihuu;
?>
<div class="table-header" style="text-align:center;margin:1% 0 2% -3%">Danh sách hình thức nghỉ hưu</div>
<table id="tbl_hinhthucnghihuu" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallhinhthucnghihuu"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên hình thức nghỉ hưu</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_hinhthucnghihuu);$i++){ 
			$stt = $i+1;
			if($ds_hinhthucnghihuu[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idhinhthucnghihuu" value="<?php echo $ds_hinhthucnghihuu[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_hinhthucnghihuu[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="<?php echo $ds_hinhthucnghihuu[$i]['id']; ?>" id="btn_edit_hinhthucnghihuu">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" data-id="<?php echo $ds_hinhthucnghihuu[$i]['id']; ?>" id="btn_delete_hinhthucnghihuu">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_hinhthucnghihuu').dataTable();
		$('#checkallhinhthucnghihuu').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idhinhthucnghihuu').prop('checked',true);
			}
			else{
				$('.array_idhinhthucnghihuu').prop('checked',false);
			}
		});
	});
</script>