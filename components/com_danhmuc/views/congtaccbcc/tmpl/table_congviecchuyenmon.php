<?php 
	defined('_JEXEC') or die('Restricted access');
	$ds_congviecchuyenmon = $this->ds_congviecchuyenmon;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">
	Danh sách công việc chuyên môn
</div>
<table id="tbl_congviecchuyenmon" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_congviecchuyenmon"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên công việc chuyên môn</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_congviecchuyenmon);$i++){ ?>
			<?php $stt = $i+1; ?>
			<?php 
				if($ds_congviecchuyenmon[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idcongviecchuyenmon" value="<?php echo $ds_congviecchuyenmon[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_congviecchuyenmon[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_congviecchuyenmon" data-id="<?php echo $ds_congviecchuyenmon[$i]['id']; ?>">Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_delete_congviecchuyenmon" data-id="<?php echo $ds_congviecchuyenmon[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_congviecchuyenmon').dataTable();
		$('#checkall_congviecchuyenmon').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcongviecchuyenmon').prop('checked',true);
			}
			else{
				$('.array_idcongviecchuyenmon').prop('checked',false);
			}
		});
	});
</script>