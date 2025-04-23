<?php 
	$ds_ttld = $this->ds_ttld;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách tình trạng lao động</div>
<table id="tbl_ttld" class="table table-striped table-bordered table-hover">
	<thead>
		<th style="text-align:center"><input type="checkbox" id="checkallttld"/><span class="lbl"></span></th>
		<th style="text-align: center">STT</th>
		<th style="text-align: center">Mã</th>
		<th style="text-align: center">Tên</th>
		<th style="text-align: center">Trạng thái</th>
		<th style="text-align: center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_ttld);$i++){ ?>
			<?php $stt=$i+1; ?>
			<tr>
				<td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idttld" value="<?php echo $ds_ttld[$i]['id'];?>"/><label class="lbl"></label></td>
				<td style="text-align: center"><?php echo $stt; ?></td>
				<td style="text-align: center"><?php echo $ds_ttld[$i]["ma"]; ?></td>
				<td style="text-align: center"><?php echo $ds_ttld[$i]["ten"]; ?></td>
				<td style="text-align: center">
					<?php
					if($ds_ttld[$i]['trangthai']==1){
                    	$check = '<i class="icon icon-check"></i>';
	                }
	                else{
	                    $check = '';
	                }
	                echo $check;
                	?>
                </td>
				<td style="text-align: center"><span class="btn btn-mini btn-primary" id="btn_hieuchinh_ttld" data-id="<?php echo $ds_ttld[$i]['id'] ?>"><i class="icon icon-edit"></i>Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_xoa_ttld" data-id="<?php echo $ds_ttld[$i]['id'] ?>"><i class="icon icon-trash"></i>Xóa</span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable5 = $('#tbl_ttld').dataTable();
		$('#checkallttld').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idttld").prop("checked",true);
            }else{
                $(".array_idttld").prop("checked",false);
            }
        });
	});
</script>