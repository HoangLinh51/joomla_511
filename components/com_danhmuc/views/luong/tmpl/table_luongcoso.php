<?php 
	$ds_luongcoso = $this->ds_luongcoso;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách lương cơ sở</div>
<table id="tbl_luongcoso" class="table table-striped table-bordered table-hover display">
	<thead>
		<th style="width:3%;text-align:center"><input type="checkbox" id="checkallluongcoso"><label class="lbl"></label></th>
		<th style="width:1%;text-align:center">STT</th>
		<th style="width:6%;text-align:center">Mức lương</th>
		<th style="width:20%;text-align:center">Thời điểm áp dụng</th>
		<th style="width:15%;text-align:center">Thời điểm hết áp dụng</th>
		<th style="width:15%;text-align:center">Ngày tạo</th>
		<th style="width:5%;text-align:center">Người tạo</th>
		<th style="width:15%;text-align:center">Ngày sửa</th>
		<th style="width:5%;text-align:center">Người sửa</th>
		<th style="width:15%;text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_luongcoso);$i++){ 
			$stt = $i+1;
		?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" value="<?php echo $ds_luongcoso[$i]['id'] ?>" class="array_idluongcoso"><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['mucluong'] ?></td>
				<td style="text-align:center"><?php echo  $ds_luongcoso[$i]['thoidiemapdung'] ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['thoidiemhetapdung'] ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['ngaytao'] ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['nguoitao'] ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['ngaysua'] ?></td>
				<td style="text-align:center"><?php echo $ds_luongcoso[$i]['nguoisua'] ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_luongcoso" data-id="<?php echo $ds_luongcoso[$i]["id"]; ?>">Cập nhật</span> 
				<span class="btn btn-mini btn-danger" id="btn_delete_luongcoso" data-id="<?php echo $ds_luongcoso[$i]["id"]; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10 = $('#tbl_luongcoso').dataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Xuất danh sách lương cơ sở ra file excel',
                    action: function (e, dt, node, config) {
                        window.location.href = 'index.php?option=com_danhmuc&controller=luongcoso&task=xuatdsluongcoso';
                        return ;
                    }
                }
            ]
		});
		$('#checkallluongcoso').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idluongcoso").prop("checked",true);
            }else{
                $(".array_idluongcoso").prop("checked",false);
            }
        });
	});
</script>