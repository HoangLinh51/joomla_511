<div id="ds_quanhegiadinh">
    <h2 class="row-fluid header smaller lighter">Quan hệ gia đình
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoiquanhegiadinh">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallquanhegiadinh">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelquanhegiadinh">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemquanhegiadinh" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseTen" data-parent="#acco-timkiemquanhegiadinh" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseTen">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenquanhegiadinh" id="tk_tenquanhegiadinh" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_machuyennganhdaotao" id="tk_machuyennganhdaotao" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div> -->
                            <span name="btn_search_quanhegiadinh" id="btn_search_quanhegiadinh" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_quanhegiadinh" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_quanhegiadinh').on('click',function(){
            $('#table_quanhegiadinh').load('index.php?option=com_danhmuc&view=quanhegiadinh&task=table_quanhegiadinh&format=raw&ten='+$('#tk_tenquanhegiadinh').val());
        });
        $('#btn_search_quanhegiadinh').click();
        $('#btn_themmoiquanhegiadinh').on('click',function(){
            $('#modal-title').html('Thêm mới quan hệ gia đình');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=quanhegiadinh&task=themmoiquanhegiadinh&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_quanhegiadinh_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_quanhegiadinh_luu','click',function(){
            if($('#form_quanhegiadinh').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quanhegiadinh&task=themthongtinquanhegiadinh',
                    data: $('#form_quanhegiadinh').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quanhegiadinh').click();
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
        $('body').delegate('#btn_xoa_quanhegiadinh','click',function(){
            var id_quanhegiadinh = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quanhegiadinh&task=xoaquanhegiadinh',
                    data: {id:id_quanhegiadinh},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quanhegiadinh').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_quanhegiadinh','click',function(){
            var id_quanhegiadinh = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa quan hệ gia đình');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=quanhegiadinh&task=chinhsuaquanhegiadinh&format=raw&id='+id_quanhegiadinh, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_quanhegiadinh_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_quanhegiadinh_update','click',function(){
            if($('#form_quanhegiadinh').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=quanhegiadinh&task=chinhsuathongtinquanhegiadinh',
                    data:    $('#form_quanhegiadinh').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quanhegiadinh').click();
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
        $('body').delegate('#btn_xoaallquanhegiadinh','click',function(){
            var array_id = [];
            $(".array_idquanhegiadinh:checked").each(function(){
                array_id.push($(this).val());
            });
            console.log(array_id);
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quanhegiadinh&task=xoanhieuquanhegiadinh',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_quanhegiadinh').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcelquanhegiadinh').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=quanhegiadinh&task=xuatdsquanhegiadinh';
        });
    });
</script>