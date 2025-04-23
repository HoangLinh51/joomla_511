<?php 
	$ds_quocgia = $this->ds_quocgia;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách quốc gia</div>
<table id="tbl_quocgia" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallquocgia"/><span class="lbl"></span></th>
		<th style="text-align: center">STT</th>
		<th style="text-align: center">Tên</th>
		<th style="text-align: center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_quocgia);$i++){ ?>
			<?php $stt=$i+1; ?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idquocgia" value="<?php echo $ds_quocgia[$i]['code'];?>"/><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align: center"><?php echo $ds_quocgia[$i]["name"]; ?></td>
				<td style="text-align: center"><span class="btn btn-mini btn-primary" id="btn_hieuchinh_quocgia" data-id="<?php echo $ds_quocgia[$i]['code'] ?>"><i class="icon icon-edit"></i>Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_xoa_quocgia" data-id="<?php echo $ds_quocgia[$i]['code'] ?>"><i class="icon icon-trash"></i>Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable5 = $('#tbl_quocgia').dataTable();
		$('#checkallquocgia').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idquocgia").prop("checked",true);
            }else{
                $(".array_idquocgia").prop("checked",false);
            }
        });
	});
</script>