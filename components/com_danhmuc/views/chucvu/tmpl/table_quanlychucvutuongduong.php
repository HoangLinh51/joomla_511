<?php 
	$ds_cvtd = $this->ds_cvtd;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">Quản lý chức vụ tương đương</div>
<table id="tbl_cvtd" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallcvtd"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên chức vụ tương đương</th>
		<th style="text-align:center">Tên chức vụ tương đương 2</th>
		<th style="text-align:center">Tên chức vụ tương đương 3</th>
		<th style="text-align:center">Phân loại</th>
		<th style="text-align:center">Mức tương tương</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_cvtd);$i++){ ?>
			<?php 
				$stt = $i +1;
				if($ds_cvtd[$i]['type_org']==1){
					$type = 'Sở ban ngành';
				}
				else if($ds_cvtd[$i]['type_org']==2){
					$type = 'Quận huyện';
				}
				else{
					$type = 'Phường xã';
				}
				if($ds_cvtd[$i]['active']==1){
					$active = '<i class="icon icon-check"></i>';
				}
				else{
					$active = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idcvtd" value="<?php echo $ds_cvtd[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_cvtd[$i]['position']; ?></td>
				<td style="text-align:center"><?php echo $ds_cvtd[$i]['position2'];?></td>
				<td style="text-align:center"><?php echo $ds_cvtd[$i]['position3'];?></td>
				<td style="text-align:center"><?php echo $type;?></td>
				<td style="text-align:center"><?php echo $ds_cvtd[$i]['level']; ?></td>
				<td style="text-align:center"><?php echo $active;?></td>
				<td style="text-align:center">
					<span class="btn btn-mini btn-primary" id="btn_edit_cvtd" data-id="<?php echo $ds_cvtd[$i]['id']; ?>" style="font-size:11px">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" id="btn_xoa_cvtd" data-id="<?php echo $ds_cvtd[$i]['id']; ?>" style="font-size:11px;padding:0 28%">Xóa</span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_cvtd').dataTable();
		$('#checkallcvtd').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idcvtd').prop('checked',true);
			}
			else{
				$('.array_idcvtd').prop('checked',false);
			}
		});
	});
</script>