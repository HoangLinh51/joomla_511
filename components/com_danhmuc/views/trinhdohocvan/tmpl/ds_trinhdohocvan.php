<div id="ds_trinhdohocvan">
    <h2 class="row-fluid header smaller lighter">Trình độ học vấn
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoitdhv">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaalltdhv">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexceltdhv">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemhtdh" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseFour" data-parent="#acco-timkiemtrinhdohocvan" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseFour">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tentdhv" id="tk_tentdhv" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_matdhv" id="tk_matdhv" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_tdhv" id="btn_search_tdhv" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_trinhdohocvan" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_tdhv').on('click',function(){
           $('#table_trinhdohocvan').load('index.php?option=com_danhmuc&controller=trinhdohocvan&task=table_trinhdohocvan&format=raw&ten='+$('#tk_tentdhv').val()+'&ma='+$('#tk_matdhv').val()); 
        });
        $('#btn_search_tdhv').click();
        $('#btn_themmoitdhv').on('click',function(){
            $('#modal-title').html('Thêm mới trình độ học vấn');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=trinhdohocvan&task=themmoitrinhdohocvan&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trinhdohocvan_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_trinhdohocvan_luu','click',function(){
            if($('#form_trinhdohocvan').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=trinhdohocvan&task=themmoithongtintdhv',
                    data:    $('#form_trinhdohocvan').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_tdhv').click();
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
        $('body').delegate('#btn_xoa_tdhv','click',function(){
            var id_tdhv = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=trinhdohocvan&task=xoatdhv',
                    data:  {id:id_tdhv},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_tdhv').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('.btn_hieuchinh_tdhv','click',function(){
            var id_tdhv = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa trình độ học vấn');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=trinhdohocvan&task=chinhsuatrinhdohocvan&format=raw&id='+id_tdhv, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_trinhdohocvan_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_trinhdohocvan_update','click',function(){
            if($('#form_trinhdohocvan').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=trinhdohocvan&task=chinhsuathongtintdhv',
                    data:    $('#form_trinhdohocvan').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_tdhv').click();
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
        $('#btn_xoaalltdhv').on('click',function(){
            var array_id = [];
            $(".array_idtdhv:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=trinhdohocvan&task=xoanhieutdhv',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_tdhv').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexceltdhv').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=trinhdohocvan&task=xuatdstdhv';
        });
    });
</script>