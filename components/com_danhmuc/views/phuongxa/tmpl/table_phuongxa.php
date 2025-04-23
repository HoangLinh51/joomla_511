<?php 
    $ds_phuongxa = $this->ds_phuongxa;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách phường xã</div>
<table id="tbl_phuongxa" class="table table-striped table-bordered table-hover">
    <thead>
        <th style="text-align:center"><input type="checkbox" id="checkallphuongxa"/><span class="lbl"></span></th>
        <th style="text-align: center">STT</th>
        <th style="text-align: center">Tên</th>
        <th style="text-align: center">Trạng thái</th>
        <th style="text-align: center">Mức tương đương</th>
        <th style="text-align: center">Chức năng</th>
    </thead>
    <tbody>
        <?php for($i=0;$i<count($ds_phuongxa);$i++){ ?>
            <?php $stt=$i+1; ?>
            <tr>
                <td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idphuongxa" value="<?php echo $ds_phuongxa[$i]['code'];?>"/><label class="lbl"></label></td>
                <td style="text-align: center"><?php echo $stt; ?></td>
                <td><?php echo $ds_phuongxa[$i]["name"]; ?></td>
                <td style="text-align: center">
                    <?php
                        if($ds_phuongxa[$i]['status']==1){
                            $check = '<i class="icon icon-check"></i>';
                        }
                        else{
                            $check = '';
                        }
                        echo $check;
                    ?>
                </td>
                </td>
                <td style="text-align: center"><?php echo $ds_phuongxa[$i]["muctuongduong"] ?></td>
                <td style="text-align: center"><span class="btn btn-mini btn-primary" id="btn_hieuchinh_phuongxa" data-id="<?php echo $ds_phuongxa[$i]['code'] ?>"><i class="icon icon-edit"></i>Cập nhật</span> <span class="btn btn-mini btn-danger" id="btn_xoa_phuongxa" data-id="<?php echo $ds_phuongxa[$i]['code'] ?>"><i class="icon icon-trash"></i>Xóa</span></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
        var oTable5 = $('#tbl_phuongxa').dataTable();
        $('#checkallphuongxa').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idphuongxa").prop("checked",true);
            }else{
                $(".array_idphuongxa").prop("checked",false);
            }
        });
    });
</script>