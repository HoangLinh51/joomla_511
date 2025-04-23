<?php 
	$ds_dvtpc = $this->ds_dvtpc;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách đơn vị tính phụ cấp</div>
<table id="tbl_dvtpc" class="table table-striped table-bordered table-hover display">
	<thead>
		<th style="width:3%;text-align:center"><input type="checkbox" id="checkalldvtpc"><label class="lbl"></label></th>
		<th style="width:1%;text-align:center">STT</th>
		<th style="width:6%;text-align:center">Tên</th>
		<th style="width:15%;text-align:center">Trạng thái</th>
		<th style="width:15%;text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dvtpc);$i++){ 
			$stt = $i+1;
			if($ds_dvtpc[$i]['trangthai']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" value="<?php echo $ds_dvtpc[$i]['id'] ?>" class="array_iddvtpc"><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_dvtpc[$i]['ten'] ?></td>
				<td style="text-align:center"><?php echo  $trangthai ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_dvtpc" data-id="<?php echo $ds_dvtpc[$i]["id"]; ?>">Cập nhật</span> 
				<span class="btn btn-mini btn-danger" id="btn_delete_dvtpc" data-id="<?php echo $ds_dvtpc[$i]["id"]; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10 = $('#tbl_dvtpc').dataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Xuất danh sách đơn vị tính phụ cấp ra file excel',
                    action: function (e, dt, node, config) {
                        window.location.href = 'index.php?option=com_danhmuc&controller=donvitinhphucap&task=xuatdsdvtpc';
                        return ;
                    }
                }
            ]
		});
		$('#checkalldvtpc').on('click',function(){
            if($(this).is(':checked')){
                $(".array_iddvtpc").prop("checked",true);
            }else{
                $(".array_iddvtpc").prop("checked",false);
            }
        });
	});
</script>