<?php
    $ds_kv      = $this->ds_kv;
    $ds_quanhuyen  = $this->ds_quanhuyen;
    $ds_phuongxa   = $this->ds_phuongxa;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách khu vực</div>
<table id="tbl_khuvuc" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align:center"><input type="checkbox" id="checkallkhuvuc"/><span class="lbl"></span></th>
            <th style="text-align:center">STT</th>
            <th style="text-align:center">Mã</th>
            <th style="width:100px;">Tên khu vực</th>
            <th style="text-align:center">Quận/huyện</th>
            <th style="text-align:center">Phường/xã</th>
            <th style="width:70px;">Trạng thái</th>
            <th style="text-align:center">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            for($i=0;$i<count($ds_kv);$i++){
                $stt = $i+1;
                echo    '<tr>                           
                            <td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idkhuvuc" value="'.$ds_kv[$i]['id'].'"/><label class="lbl"></label></td>
                            <td>'.$stt.'</td>    
                            <td style="text-align:center">'.$ds_kv[$i]['ma'].'</td>
                            <td>'.$ds_kv[$i]['ten'].'</td>
                        ';
                if($ds_kv[$i]['trangthai']==1){
                    $check = '<i class="icon icon-check"></i>';
                }
                else{
                    $check = '';
                }
                for($j=0;$j<count($ds_quanhuyen);$j++){
                    $id_quanhuyen = substr($ds_kv[$i]['comm_code'],0,5);
                    if($ds_quanhuyen[$j]['code']==$id_quanhuyen){
                        echo '<td style="text-align:center">'.$ds_quanhuyen[$j]['name'].'</td>';
                    }
                }
                for($j=0;$j<count($ds_phuongxa);$j++){
                    if($ds_kv[$i]['comm_code']==$ds_phuongxa[$j]['code']){
                        echo '<td style="text-align:center">'.$ds_phuongxa[$j]['name'].'</td>';
                    }
                }
                echo    '                           
                            <td style="text-align:center">'.$check.'</td>
                            <td style="text-align:center"><span data-id="'.$ds_kv[$i]['id'].'" class=" btn btn-mini btn-primary btn_hieuchinhkhuvuc"><i class="icon icon-edit"></i>Cập nhật </span> <span class="btn btn-mini btn-danger" id="btn_xoakhuvuc" data-id="'.$ds_kv[$i]['id'].'"><i class="icon icon-trash"></i> Xóa</span></td>
                        </tr>';
            }
        ?>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
        var oTable2 = $('#tbl_khuvuc').dataTable();
        $('#checkallkhuvuc').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idkhuvuc").prop("checked",true);
            }else{
                $(".array_idkhuvuc").prop("checked",false);
            }
        });
    });
</script>   