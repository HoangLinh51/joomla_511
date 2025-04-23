<?php 
	$ds_loaiphucap 	= $this->ds_loaiphucap;
	$ds_donvitinh	= $this->ds_donvitinh;
	$ds_cachtinh	= $this->ds_cachtinh;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách loại phụ cấp</div>
<table id="tbl_loaiphucap" class="table table-striped table-bordered table-hover display">
	<thead>
		<th style="width:3%;text-align:center"><input type="checkbox" id="checkallloaiphucap"><label class="lbl"></label></th>
		<th style="width:2%;text-align:center">STT</th>
		<th style="width:20%;text-align:center">Tên</th>
		<th style="width:5%;text-align:center">Đơn vị tính</th>
		<th style="width:5%;text-align:center">Cách tính</th>
		<th style="width:5%;text-align:center">Giá trị mặc định</th>
		<th style="width:5%;text-align:center">Có lĩnh vực</th>
		<th style="width:5%;text-align:center">Có ngày nâng phụ cấp</th>
		<th style="width:10%;text-align:center">Key</th>
		<th style="width:5%;text-align:center">Số năm tăng phụ cấp</th>
		<th style="width:5%;text-align:center">Mức tăng phụ cấp</th>
		<th style="width:5%;text-align:center">Trạng thái</th>
		<th style="width:20%;text-align:center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_loaiphucap);$i++){ 
			$stt = $i+1;
			if($ds_loaiphucap[$i]['trangthaisudung']==1){
				$trangthai = '<i class="icon icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" value="<?php echo $ds_loaiphucap[$i]['id'] ?>" class="array_idloaiphucap"><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['tenloaiphucap'] ?></td>
				<?php 
					for($j=0;$j<count($ds_donvitinh);$j++){
						if($ds_donvitinh[$j]['id']==$ds_loaiphucap[$i]['donvitinh']){
							echo '<td style="text-align:center">'.$ds_donvitinh[$j]['ten'].'</td>';
						}
					}
				?>
				<?php 
					for($j=0;$j<count($ds_cachtinh);$j++){
						if($ds_cachtinh[$j]['id']==$ds_loaiphucap[$i]['cachtinh']){
							echo '<td style="text-align:center">'.$ds_cachtinh[$j]['ten'].'</td>';
						}
					}
				?>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['giatrimacdinh'] ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['colinhvuc'] ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['congaynangtieptheo'] ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['key'] ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['sonamtangphucap'] ?></td>
				<td style="text-align:center"><?php echo $ds_loaiphucap[$i]['muctangphucap'] ?></td>
				<td style="text-align:center"><?php echo  $trangthai ?></td>
				<td style="text-align:center"><span class="btn btn-mini btn-primary" id="btn_edit_loaiphucap" data-id="<?php echo $ds_loaiphucap[$i]["id"]; ?>">Cập nhật</span> 
				<span class="btn btn-mini btn-danger" style="padding:0 27%;margin-top:5%" id="btn_delete_loaiphucap" data-id="<?php echo $ds_loaiphucap[$i]["id"]; ?>">Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable10 = $('#tbl_loaiphucap').dataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Xuất danh sách loại phụ cấp ra file excel',
                    action: function (e, dt, node, config) {
                        window.location.href = 'index.php?option=com_danhmuc&controller=loaiphucap&task=xuatdsloaiphucap';
                        return ;
                    }
                }
            ]
		});
		$('#checkallloaiphucap').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idloaiphucap").prop("checked",true);
            }else{
                $(".array_idloaiphucap").prop("checked",false);
            }
        });
	});
</script>