<?php 
	$ds_thuocdienquanly = $this->ds_thuocdienquanly;
?>
<div class="table-header" style="text-align:center;margin-left:-2%;margin-bottom:1%">Danh sách thuộc diện quản lý</div>
<table id="tbl_thuocdienquanly" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkall_thuocdienquanly"><label class="lbl"></label></th>
		<th style="text-align:center">Stt</th>
		<th style="text-align:center">Tên thuộc diện quản lý</th>
		<th style="text-align:center">Trạng thái</th>
		<th style="text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_thuocdienquanly);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_thuocdienquanly[$i]['trangthai']==1){
					$trangthai = '<i class="icon icon-check"></i>';
				}
				else{
					$trangthai = '';
				}
			?>
			<tr>
				<td style="text-align:center;padding-right:2%"><input type="checkbox" class="array_idthuocdienquanly" value="<?php echo $ds_thuocdienquanly[$i]['id']; ?>"><label class="lbl"></label></td>
				<td style="text-align:center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_thuocdienquanly[$i]['name']; ?></td>
				<td style="text-align:center"><?php echo $trangthai; ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_thuocdienquanly" data-id="<?php echo $ds_thuocdienquanly[$i]['id']; ?>">Cập nhật</span> 
					<span class="btn btn-mini btn-danger" id="btn_xoa_thuocdienquanly" data-id="<?php echo $ds_thuocdienquanly[$i]['id']; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_thuocdienquanly').dataTable();
		$('#checkall_thuocdienquanly').on('click',function(){
			if($(this).is(':checked')){
				$('.array_idthuocdienquanly').prop('checked',true);
			}
			else{
				$('.array_idthuocdienquanly').prop('checked',false);
			}
		});
	});
</script>