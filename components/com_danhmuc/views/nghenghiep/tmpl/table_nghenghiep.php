<?php
    
    $ds_job = $this->ds_job;
?>
<div class="table-header" style="margin:10px 0 10px -10px;text-align:center;">Danh sách nghề nghiệp</div>
<table id="tbl_nghenghiep" class="table table-striped table-bordered table-hover display">
    <thead>
        <tr>
            <th style="text-align:center"><input type="checkbox" id="checkall"/><span class="lbl"></span></th>
            <th style="text-align:center">STT</th>
            <th style="text-align:center">Mã</th>
            <th style="width:100px;">Tên</th>
            <th style="width:70px;">Trạng thái</th>
            <th style="text-align:center">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            for($i=0;$i<count($ds_job);$i++){
                $stt    = $i+1;
                echo    '<tr>
                            <td style="text-align:center;padding-right:22px"><input type="checkbox" class="array_idnn" value="'.$ds_job[$i]['id'].'"/><label class="lbl"></label></td>
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
                            <td style="text-align:center"><span data-id="'.$ds_job[$i]['id'].'" class=" btn btn-mini btn-primary btn_hieuchinh"><i class="icon icon-edit"></i>Cập nhật </span> <span class="btn btn-mini btn-danger" id="btn_xoa" data-id="'.$ds_job[$i]['id'].'"><i class="icon icon-trash"></i> Xóa</span></td>
                        </tr>';
            }
        ?>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
        $('#tbl_nghenghiep').DataTable();     
        $('body').delegate('#btn_nghenghiep_update','click', function(){
            if($('#form_nghenghiep').valid()== true){
                $.ajax({
                    type:   'post',
                    data:   $('#form_nghenghiep').serialize(),
                    url :   'index.php?option=com_danhmuc&controller=nghenghiep&task=chinhsuathongtinnghenghiep',
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_nghenghiep').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                        }            
                    }
                });
            }
            else{
                return false;
            }
        });
        $('#checkall').on('click',function(){
            if($(this).is(':checked')){
                $(".array_idnn").prop("checked",true);
            }else{
                $(".array_idnn").prop("checked",false);
            }
        });
        $('body').delegate('#btn_xoaallnn','click',function(){
            var array_id = [];
            $(".array_idnn:checked").each(function(){
                array_id.push($(this).val());
            });
            if(array_id.length>0){
                if(confirm('Bạn có muốn xóa không ?')){
                    $.ajax({
                        type:   'post',
                        url:    'index.php?option=com_danhmuc&controller=nghenghiep&task=xoanhieunghenghiep',
                        data:   {id:array_id},
                        success: function(data){
                            if(data=='true'){
                                $('#btn_search_nghenghiep').click();
                                loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                            }
                            else{
                                loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                            }
                        }
                    });
                }
            };
        });
    });
</script>