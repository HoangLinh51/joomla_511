<?php 
	$ds_doituongquanly = $this->ds_doituongquanly;
?>
<div class="table-header" style="text-align:center;margin:1% 0 2% -3%">Danh sách đối tượng quản lý</div>
<table id="tbl_doituongquanly" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkalldoituongquanly"><label class="lbl"></label></th>
		<th style="text-align:center">STT</th>
		<th style="text-align:center">Tên đối tượng quản lý</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_doituongquanly);$i++){ 
			$stt = $i+1;
			if($ds_doituongquanly[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_iddoituongquanly" value="<?php echo $ds_doituongquanly[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_doituongquanly[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="<?php echo $ds_doituongquanly[$i]['id']; ?>" id="btn_edit_doituongquanly">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" data-id="<?php echo $ds_doituongquanly[$i]['id']; ?>" id="btn_delete_doituongquanly">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_doituongquanly').dataTable();
		$('#checkalldoituongquanly').on('click',function(){
			if($(this).is(':checked')){
				$('.array_iddoituongquanly').prop('checked',true);
			}
			else{
				$('.array_iddoituongquanly').prop('checked',false);
			}
		});
	});
</script>