<div id="ds_nganhnghe">
    <h2 class="row-fluid header smaller lighter">Lý do ở nước ngoài
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoilydoonuocngoai">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaalllydoonuocngoai">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcellydoonuocngoai">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemlydoonuocngoai" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseSeven" data-parent="#acco-timkiemlydoonuocngoai" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseSeven">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenlydoonuocngoai" id="tk_tenlydoonuocngoai" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_malydoonuocngoai" id="tk_malydoonuocngoai" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_lydoonuocngoai" id="btn_search_lydoonuocngoai" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_lydoonuocngoai" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_lydoonuocngoai').on('click',function(){
            $('#table_lydoonuocngoai').load('index.php?option=com_danhmuc&view=lydoonuocngoai&task=table_lydoonuocngoai&format=raw&ten='+$('#tk_tenlydoonuocngoai').val()+'&ma='+$('#tk_malydoonuocngoai').val());
        });
        $('#btn_search_lydoonuocngoai').click();
        $('#btn_themmoilydoonuocngoai').on('click',function(){
            $('#modal-title').html('Thêm mới lý do ở nước ngoài');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=lydoonuocngoai&task=themmoilydoonuocngoai&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_lydoonuocngoai_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_lydoonuocngoai_luu','click',function(){
            if($('#form_lydoonuocngoai').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=lydoonuocngoai&task=themthongtinlydoonuocngoai',
                    data: $('#form_lydoonuocngoai').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_lydoonuocngoai').click();
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
        $('body').delegate('#btn_xoa_lydoonuocngoai','click',function(){
            var id_lydoonuocngoai = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=lydoonuocngoai&task=xoalydoonuocngoai',
                    data: {id:id_lydoonuocngoai},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_lydoonuocngoai').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_lydoonuocngoai','click',function(){
            var id_lydoonuocngoai = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa lý do ở nước ngoài');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=lydoonuocngoai&task=chinhsualydoonuocngoai&format=raw&id='+id_lydoonuocngoai, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_lydoonuocngoai_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_lydoonuocngoai_update','click',function(){
            if($('#form_lydoonuocngoai').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=lydoonuocngoai&task=chinhsuathongtinlydoonuocngoai',
                    data:    $('#form_lydoonuocngoai').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_lydoonuocngoai').click();
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
        $('#btn_xoaalllydoonuocngoai').on('click',function(){
            var array_id = [];
            $(".array_idlydoonuocngoai:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=lydoonuocngoai&task=xoanhieulydoonuocngoai',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_lydoonuocngoai').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcellydoonuocngoai').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=lydoonuocngoai&task=xuatdslydoonuocngoai';
        });
    });
</script>