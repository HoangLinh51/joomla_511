<?php 
    $ds_job = $this->ds_job;
?>
<div class="table-header" style="margin:10px 0 10px -10px;;text-align:center;">Danh sách hình thức du học</div>
<table id="tbl_hinhthucduhoc" class="table table-striped table-bordered table-hover">
    <thead>
        <th style="text-align:center"><input type="checkbox" id="checkallhtdh"/><label class="lbl"></label></th>
        <th style="text-align:center">STT</th>
        <th style="text-align:center">Mã</th>
        <th style="text-align:center;width:160px">Tên</th>
        <th style="text-align:center;width:70px">Trạng thái</th>
        <th style="text-align:center">Chức năng</th>
    </thead>
    <tbody>
        <?php 
            for($i=0;$i<count($ds_job);$i++){
                $stt    = $i+1;
                echo    '<tr>
                            <td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idhtdh" value="'.$ds_job[$i]['id'].'" /><label class="lbl"></label></td>
                            <td style="text-align:center">'.$stt.'</td>
                            <td style="text-align:center">'.$ds_job[$i]['ma'].'</td>
                            <td>'.$ds_job[$i]['ten'].'</td>
                        ';
                if($ds_job[$i]['trangthai']==1){
                    $check = '<i class="icon icon-check"></i>';
                }
                else{
                    $check = '';
                }
                echo    '
                            <td style="text-align:center">'.$check.'</td>
                            <td style="text-align:center"><span class="btn btn-mini btn-primary" data-id="'.$ds_job[$i]['id'].'" id="btn_hieuchinhhtdh"><i class="icon icon-edit"></i>Cập nhật </span>  <span class="btn btn-mini btn-danger" id="btn_xoahtdh" data-id="'.$ds_job[$i]['id'].'"><i class="icon icon-trash"></i> Xóa</span></td>
                        </tr>';
            }
        ?>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
        var oTable = $('#tbl_hinhthucduhoc').dataTable();
        
        $('#checkallhtdh').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idhtdh").prop("checked",true);
            }else{
                $(".array_idhtdh").prop("checked",false);
            }
        });
        
    });
    
            
</script>

