<?php 
	defined('_JEXEC') or die('Restricted access');
	$ds_binhbauphanloaicbcc = $this->ds_binhbauphanloaicbcc;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">
	Danh sách bình bầu phân loại cbcc
</div>
<table id="tbl_binhbauphanloaicbcc" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_binhbauphanloaicbcc"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên bình bầu phân loại cbcc</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_binhbauphanloaicbcc);$i++){ ?>
			<?php $stt = $i+1; ?>
			<?php 
				if($ds_binhbauphanloaicbcc[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idbinhbauphanloaicbcc" value="<?php echo $ds_binhbauphanloaicbcc[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_binhbauphanloaicbcc[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_binhbauphanloaicbcc" data-id="<?php echo $ds_binhbauphanloaicbcc[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_binhbauphanloaicbcc" data-id="<?php echo $ds_binhbauphanloaicbcc[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_binhbauphanloaicbcc').dataTable();
		$('#checkall_binhbauphanloaicbcc').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idbinhbauphanloaicbcc').prop('checked',true);
			}
			else{
				$('.array_idbinhbauphanloaicbcc').prop('checked',false);
			}
		});
	});
</script>