<?php 
	$ds_lydodinuocngoai = $this->ds_lydodinuocngoai;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">Danh sách lý do đi nước ngoài</div>
<table id="tbl_lydodinuocngoai" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_lydodinuocngoai"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên lý do đi nước ngoài</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_lydodinuocngoai);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_lydodinuocngoai[$i]['status']==1){
					$status = '<i class="icon icon-check"></i>';
				}
				else{
					$status = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idlydodinuocngoai" value="<?php echo $ds_lydodinuocngoai[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_lydodinuocngoai[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $status; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_lydodinuocngoai" data-id="<?php echo $ds_lydodinuocngoai[$i]['id']; ?>">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" id="btn_xoa_lydodinuocngoai" data-id="<?php echo $ds_lydodinuocngoai[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_lydodinuocngoai').dataTable();
		$('#checkall_lydodinuocngoai').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idlydodinuocngoai').prop('checked',true);
			}
			else{
				$('.array_idlydodinuocngoai').prop('checked',false);
			}
		});
	});
</script>