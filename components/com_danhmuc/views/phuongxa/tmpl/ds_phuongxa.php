<div id="ds_phuongxa">
    <h2 class="row-fluid header smaller lighter">Phường xã
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoiphuongxa">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallphuongxa">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelphuongxa">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemphuongxa" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseTwelve" data-parent="#acco-timkiemphuongxa" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseTwelve">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label">Tên phường xã:</label>
                                    <div class="controls">
                                        <input type="text" name="tk_tenphuongxa" id="tk_tenphuongxa" placeholder="Nhập tên" value="" style="width:140px">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">Tên thành phố:</label>
                                    <div class="controls">
                                        <select id="tkphuongxa_mathanhpho" name="tkphuongxa_mathanhpho">
                                            <option value="">Chọn thành phố</option>
                                            <?php
                                                $model = Core::model('Danhmuckieubao/Phuongxa');
                                                $ds_thanhpho = $model->getallthanhpho();
                                                    for($i=0;$i<count($ds_thanhpho);$i++){
                                            ?>
                                            <option value="<?php echo $ds_thanhpho[$i]['code'] ?>"><?php echo $ds_thanhpho[$i]['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">Tên quận huyện:</label>
                                    <div class="controls">
                                        <select id="tkphuongxa_maquanhuyen" name="tkphuongxa_maquanhuyen">
                                            <option value="">Chọn quận huyện</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <span name="btn_search_phuongxa" id="btn_search_phuongxa" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_phuongxa" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_phuongxa').on('click',function(){
            $.blockUI();
            $('#table_phuongxa').load('index.php?option=com_danhmuc&view=phuongxa&task=table_phuongxa&format=raw&ten='+$('#tk_tenphuongxa').val()+'&matp='+$('#tkphuongxa_mathanhpho').val()+'&maqh='+$('#tkphuongxa_maquanhuyen').val(), function(){
                $.unblockUI();
            });
        });
        $('#btn_search_phuongxa').click();
        $('#btn_themmoiphuongxa').on('click',function(){
            $('#modal-title').html('Thêm mới phường xã');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=phuongxa&task=themmoiphuongxa&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phuongxa_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_phuongxa_luu','click',function(){
            if($('#form_phuongxa').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phuongxa&task=themthongtinphuongxa',
                    data: $('#form_phuongxa').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_phuongxa').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }else{
                return false;
            }
        });
        $('body').delegate('#btn_xoa_phuongxa','click',function(){
            var id_phuongxa = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phuongxa&task=xoaphuongxa',
                    data: {id:id_phuongxa},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_phuongxa').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_phuongxa','click',function(){
            var id_phuongxa = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa phường xã');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=phuongxa&task=chinhsuaphuongxa&format=raw&id='+id_phuongxa, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phuongxa_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_phuongxa_update','click',function(){
            if($('#form_phuongxa').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=phuongxa&task=chinhsuathongtinphuongxa',
                    data:    $('#form_phuongxa').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_phuongxa').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
            else{
                return false;
            }
        });
        $('body').delegate('#btn_xoaallphuongxa','click',function(){
            var array_id = [];
            $(".array_idphuongxa:checked").each(function(){
                array_id.push($(this).val());
            });
            console.log(array_id);
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phuongxa&task=xoanhieuphuongxa',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_phuongxa').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#tkphuongxa_mathanhpho').on('change',function(){
            var city_id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'index.php?option=com_danhmuc&controller=phuongxa&task=findquanhuyenbythanhpho',
                data: {id:city_id},
                success: function(data){
                    var data1 = JSON.parse(data);
                    var str = '<option>Chọn Quận/huyện</option>';
                    for(i=0;i<data1.length;i++){ 
                        str+= '<option value="'+data1[i].code+'">'+data1[i].name+'</option>';
                    }
                    $('#tkphuongxa_maquanhuyen').html(str);  
                }
            });
        });
        $('#btn_xuatexcelphuongxa').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=phuongxa&task=xuatdsphuongxa';
        });
    });
</script>