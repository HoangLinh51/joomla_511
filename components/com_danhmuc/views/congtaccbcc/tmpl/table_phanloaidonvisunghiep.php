<?php 
	defined('_JEXEC') or die('Restricted access');
	$ds_phanloaidonvisunghiep = $this->ds_phanloaidonvisunghiep;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">
	Danh sách phân loại đơn vị sự nghiệp
</div>
<table id="tbl_phanloaidonvisunghiep" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_phanloaidonvisunghiep"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên phân loại đơn vị sự nghiệp</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_phanloaidonvisunghiep);$i++){ ?>
			<?php $stt = $i+1; ?>
			<?php 
				if($ds_phanloaidonvisunghiep[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idphanloaidonvisunghiep" value="<?php echo $ds_phanloaidonvisunghiep[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_phanloaidonvisunghiep[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_phanloaidonvisunghiep" data-id="<?php echo $ds_phanloaidonvisunghiep[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_phanloaidonvisunghiep" data-id="<?php echo $ds_phanloaidonvisunghiep[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_phanloaidonvisunghiep').dataTable();
		$('#checkall_phanloaidonvisunghiep').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idphanloaidonvisunghiep').prop('checked',true);
			}
			else{
				$('.array_idphanloaidonvisunghiep').prop('checked',false);
			}
		});
	});
</script>