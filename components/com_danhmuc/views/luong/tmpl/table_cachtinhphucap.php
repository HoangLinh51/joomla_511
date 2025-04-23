<?php 
	$ds_ctpc = $this->ds_ctpc;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách cách tính phụ cấp</div>
<table id="tbl_ctpc" class="table table-striped table-bordered table-hover display">
	<thead>
		<th style="width:3%;text-align:center"><input type="checkbox" id="checkallctpc"><label class="lbl"></label></th>
		<th style="width:2%;text-align:center">STT</th>
		<th style="width:40%;text-align:center">Tên</th>
		<th style="width:5%;text-align:center">Trạng thái</th>
		<th style="width:10%;text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_ctpc);$i++){ 
			$stt = $i+1;
			if($ds_ctpc[$i]['trangthai']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" value="<?php echo $ds_ctpc[$i]['id'] ?>" class="array_idctpc"><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_ctpc[$i]['ten'] ?></td>
				<td style="text-align:center"><?php echo  $trangthai ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_ctpc" data-id="<?php echo $ds_ctpc[$i]["id"]; ?>">Cập nhật</span> 
				<span class="btn btn-mini btn-danger" id="btn_delete_ctpc" data-id="<?php echo $ds_ctpc[$i]["id"]; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10 = $('#tbl_ctpc').dataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Xuất danh sách cách tính phụ cấp ra file excel',
                    action: function (e, dt, node, config) {
                        window.location.href = 'index.php?option=com_danhmuc&controller=cachtinhphucap&task=xuatdsctpc';
                        return ;
                    }
                }
            ]
		});
		$('#checkallctpc').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idctpc").prop("checked",true);
            }else{
                $(".array_idctpc").prop("checked",false);
            }
        });
	});
</script>