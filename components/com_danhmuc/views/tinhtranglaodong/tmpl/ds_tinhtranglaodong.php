<div id="ds_tinhtranglaodong">
    <h2 class="row-fluid header smaller lighter">Tình trạng lao động
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoittld">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallttld">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelttld">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemttld" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseFive" data-parent="#acco-timkiemttld" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseFive">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenttld" id="tk_tenttld" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_mattld" id="tk_mattld" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_ttld" id="btn_search_ttld" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_tinhtranglaodong" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_ttld').on('click',function(){
            $('#table_tinhtranglaodong').load('index.php?option=com_danhmuc&view=tinhtranglaodong&task=table_tinhtranglaodong&format=raw&ten='+$('#tk_tenttld').val()+'&ma='+$('#tk_mattld').val());
        });
        $('#btn_search_ttld').click();
        $('#btn_themmoittld').on('click',function(){
            $('#modal-title').html('Thêm mới tình trạng lao động');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=tinhtranglaodong&task=themmoitinhtranglaodong&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_tinhtranglaodong_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_tinhtranglaodong_luu','click',function(){
            if($('#form_ttld').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=tinhtranglaodong&task=themthongtinttld',
                    data: $('#form_ttld').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_ttld').click();
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
        $('body').delegate('#btn_xoa_ttld','click',function(){
            var id_ttld = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=tinhtranglaodong&task=xoattld',
                    data: {id:id_ttld},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_ttld').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_ttld','click',function(){
            var id_ttld = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa tình trạng lao động');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=tinhtranglaodong&task=chinhsuatinhtranglaodong&format=raw&id='+id_ttld, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_tinhtranglaodong_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_tinhtranglaodong_update','click',function(){
            if($('#form_ttld').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=tinhtranglaodong&task=chinhsuathongtinttld',
                    data:    $('#form_ttld').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_ttld').click();
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
        $('#btn_xoaallttld').on('click',function(){
            var array_id = [];
            $(".array_idttld:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=tinhtranglaodong&task=xoanhieuttld',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_ttld').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcelttld').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=tinhtranglaodong&task=xuatdsttld';
        });
    });
</script>