<?php 
	$ds_hinhthucthoiviecnghihuu = $this->ds_hinhthucthoiviecnghihuu;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">Danh sách hình thức thôi việc nghỉ hưu</div>
<table id="tbl_hinhthucthoiviecnghihuu" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_hinhthucthoiviecnghihuu"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên hình thức thôi việc nghỉ hưu</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_hinhthucthoiviecnghihuu);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_hinhthucthoiviecnghihuu[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idhinhthucthoiviecnghihuu" value="<?php echo $ds_hinhthucthoiviecnghihuu[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_hinhthucthoiviecnghihuu[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_hinhthucthoiviecnghihuu" data-id="<?php echo $ds_hinhthucthoiviecnghihuu[$i]['id']; ?>">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" id="btn_xoa_hinhthucthoiviecnghihuu" data-id="<?php echo $ds_hinhthucthoiviecnghihuu[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_hinhthucthoiviecnghihuu').dataTable();
		$('#checkall_hinhthucthoiviecnghihuu').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idhinhthucthoiviecnghihuu').prop('checked',true);
			}
			else{
				$('.array_idhinhthucthoiviecnghihuu').prop('checked',false);
			}
		});
	});
</script>