<?php 
	$ds_phucaplinhvuc 	= $this->ds_phucaplinhvuc;
	$ds_loaiphucap	= $this->ds_loaiphucap;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách phụ cấp lĩnh vực</div>
<table id="tbl_phucaplinhvuc" class="table table-striped table-bordered table-hover display">
	<thead>
		<th style="width:3%;text-align:center"><input type="checkbox" id="checkallphucaplinhvuc"><label class="lbl"></label></th>
		<th style="width:2%;text-align:center">STT</th>
		<th style="width:15%;text-align:center">Tên lĩnh vực</th>
		<th style="width:15%;text-align:center">Loại phụ cấp</th>
		<th style="width:20%;text-align:center">Số năm tăng phụ cấp</th>
		<th style="width:15%;text-align:center">Mức tăng phụ cấp</th>
		<th style="width:10%;text-align:center">Trạng thái</th>
		<th style="width:20%;text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_phucaplinhvuc);$i++){ 
			$stt = $i+1;
			if($ds_phucaplinhvuc[$i]['status']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" value="<?php echo $ds_phucaplinhvuc[$i]['id'] ?>" class="array_idphucaplinhvuc"><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_phucaplinhvuc[$i]['tenlinhvuc'] ?></td>
				<?php 
					for($j=0;$j<count($ds_loaiphucap);$j++){
						if($ds_loaiphucap[$j]['id']==$ds_phucaplinhvuc[$i]['loaiphucap_id']){
							echo '<td style="text-align:center">'.$ds_loaiphucap[$j]['tenloaiphucap'].'</td>';
						}
					}
				?>
				<td style="text-align:center"><?php echo $ds_phucaplinhvuc[$i]['sonamtangphucap'] ?></td>
				<td style="text-align:center"><?php echo $ds_phucaplinhvuc[$i]['muctangphucap'] ?></td>
				<td style="text-align:center"><?php echo  $trangthai ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_phucaplinhvuc" data-id="<?php echo $ds_phucaplinhvuc[$i]["id"]; ?>">Cập nhật</span> 
				<span class="btn btn-mini btn-danger" id="btn_delete_phucaplinhvuc" data-id="<?php echo $ds_phucaplinhvuc[$i]["id"]; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10 = $('#tbl_phucaplinhvuc').dataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Xuất danh sách phụ cấp lĩnh vực ra file excel',
                    action: function (e, dt, node, config) {
                        window.location.href = 'index.php?option=com_danhmuc&controller=phucaplinhvuc&task=xuatdsphucaplinhvuc';
                        return ;
                    }
                }
            ]
		});
		$('#checkallphucaplinhvuc').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idphucaplinhvuc").prop("checked",true);
            }else{
                $(".array_idphucaplinhvuc").prop("checked",false);
            }
        });
	});
</script>