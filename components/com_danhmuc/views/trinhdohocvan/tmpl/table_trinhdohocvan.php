<?php 
	$ds_tdhv = $this->ds_tdhv;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách trình độ học vấn</div>
<table id="tbl_trinhdohocvan" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align:center"><input type="checkbox" id="checkalltdhv"/><span class="lbl"></span></th>
            <th style="text-align:center">STT</th>
            <th style="text-align:center">Mã</th>
            <th style="width:150px;">Tên</th>
            <th style="width:70px;">Trạng thái</th>
            <th style="text-align:center">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            for($i=0;$i<count($ds_tdhv);$i++){
                $stt    = $i+1;
                echo    '<tr>
                            <td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idtdhv" value="'.$ds_tdhv[$i]['id'].'"/><label class="lbl"></label></td>
                            <td style="text-align:center">'.$stt.'</td>
                            <td style="text-align:center">'.$ds_tdhv[$i]['ma'].'</td>
                            <td>'.$ds_tdhv[$i]['ten'].'</td>
                        ';
                if($ds_tdhv[$i]['trangthai']==1){
                    $check = '<i class="icon icon-check"></i>';
                }
                else{
                    $check = '';
                }
                echo    '
                            <td style="text-align:center">'.$check.'</td>
                            <td style="text-align:center"><span data-id="'.$ds_tdhv[$i]['id'].'" class=" btn btn-mini btn-primary btn_hieuchinh_tdhv"><i class="icon icon-edit"></i>Cập nhật </span> <span class="btn btn-mini btn-danger" id="btn_xoa_tdhv" data-id="'.$ds_tdhv[$i]['id'].'"><i class="icon icon-trash"></i> Xóa</span></td>
                        </tr>';
            }
        ?>
    </tbody>
</table>
<script>
	jQuery(document).ready(function($){
		var oTable3 = $('#tbl_trinhdohocvan').dataTable();
        $('#checkalltdhv').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idtdhv").prop("checked",true);
            }else{
                $(".array_idtdhv").prop("checked",false);
            }
        });
	});
</script>