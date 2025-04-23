<div id="ds_nganhnghe">
    <h2 class="row-fluid header smaller lighter">Ngành nghề
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoinganhnghe">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallnganhnghe">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelnganhnghe">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemnganhnghe" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseSix" data-parent="#acco-timkiemnganhnghe" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseSix">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tennganhnghe" id="tk_tennganhnghe" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_manganhnghe" id="tk_manganhnghe" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_nganhnghe" id="btn_search_nganhnghe" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_nganhnghe" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_nganhnghe').on('click',function(){
            $('#table_nganhnghe').load('index.php?option=com_danhmuc&controller=nganhnghe&task=table_nganhnghe&format=raw&ten='+$('#tk_tennganhnghe').val()+'&ma='+$('#tk_manganhnghe').val());
        });
        $('#btn_search_nganhnghe').click();
        $('#btn_themmoinganhnghe').on('click',function(){
            $('#modal-title').html('Thêm mới ngành nghề');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=nganhnghe&task=themmoinganhnghe&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nganhnghe_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_nganhnghe_luu','click',function(){
            if($('#form_nganhnghe').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=nganhnghe&task=themthongtinnganhnghe',
                    data: $('#form_nganhnghe').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_nganhnghe').click();
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
        $('body').delegate('#btn_xoa_nganhnghe','click',function(){
            var id_nganhnghe = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=nganhnghe&task=xoanganhnghe',
                    data: {id:id_nganhnghe},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_nganhnghe').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_nganhnghe','click',function(){
            var id_nganhnghe = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa ngành nghề');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=nganhnghe&task=chinhsuanganhnghe&format=raw&id='+id_nganhnghe, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nganhnghe_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_nganhnghe_update','click',function(){
            if($('#form_nganhnghe').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=nganhnghe&task=chinhsuathongtinnganhnghe',
                    data:    $('#form_nganhnghe').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_nganhnghe').click();
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
        $('#btn_xoaallnganhnghe').on('click',function(){
            var array_id = [];
            $(".array_idnganhnghe:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=nganhnghe&task=xoanhieunganhnghe',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_nganhnghe').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcelnganhnghe').on('click',function(){
             window.location.href = 'index.php?option=com_danhmuc&controller=nganhnghe&task=xuatdsnganhnghe';
        });
    });
</script>