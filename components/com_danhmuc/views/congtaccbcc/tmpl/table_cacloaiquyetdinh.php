<?php 
	$ds_cacloaiquyetdinh = $this->ds_cacloaiquyetdinh;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">Danh sách các loại quyết định</div>
<table id="tbl_cacloaiquyetdinh" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallcacloaiquyetdinh"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên loại quyết định</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_cacloaiquyetdinh);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_cacloaiquyetdinh[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idcacloaiquyetdinh" value="<?php echo $ds_cacloaiquyetdinh[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_cacloaiquyetdinh[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_cacloaiquyetdinh" data-id="<?php echo $ds_cacloaiquyetdinh[$i]['id']; ?>">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" id="btn_xoa_cacloaiquyetdinh" data-id="<?php echo $ds_cacloaiquyetdinh[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_cacloaiquyetdinh').dataTable();
		$('#checkallcacloaiquyetdinh').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcacloaiquyetdinh').prop('checked',true);
			}
			else{
				$('.array_idcacloaiquyetdinh').prop('checked',false);
			}
		});
	});
</script>