<div id="ds_khuvuc">
    <h2 class="row-fluid header smaller lighter">Khu vực
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoikv">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallkv">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelkv">Xuất excel</span>
    </div>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemhtdh" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseThree" data-parent="#acco-timkiemkhuvuc" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseThree">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenkhuvuc" id="tk_tenkhuvuc" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_makhuvuc" id="tk_makhuvuc" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_khuvuc" id="btn_search_khuvuc" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_khuvuc" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_khuvuc').on('click',function(){
            $('#table_khuvuc').load('index.php?option=com_danhmuc&controller=khuvuc&task=table_khuvuc&format=raw&ten='+$('#tk_tenkhuvuc').val()+'&ma='+$('#tk_makhuvuc').val());
        });
        $('#btn_search_khuvuc').click();
        $('#btn_themmoikv').on('click',function(){
            $('#modal-title').html('Thêm mới khu vực');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=khuvuc&task=themmoikhuvuc&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_khuvuc_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_khuvuc_luu','click',function(){
            if($('#form_khuvuc').valid()== true){
                $.ajax({
                    type: 'post',
                    url:'index.php?option=com_danhmuc&controller=khuvuc&task=themthongtinkhuvuc',
                    data: $('#form_khuvuc').serialize(),
                    success:function(data){
                        if(data=='true'){
                            $('#modal-form').modal('hide');
                            $('#btn_search_khuvuc').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                        }
                    }
                });
            }else{
                return false;
            }
        });
        $('body').delegate('#btn_xoakhuvuc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
               result_id = $(this).data('id');
                $.ajax({
                   type:    'post',
                   data:    {id:result_id},
                   url:     'index.php?option=com_danhmuc&controller=khuvuc&task=xoakhuvuc',
                   success:function(data){
                       if(data == 'true'){
                            $('#btn_search_khuvuc').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                        }    
                    }
                });
            }
        });
        $('body').delegate('.btn_hieuchinhkhuvuc','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa khu vực');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=khuvuc&task=chinhsuakhuvuc&format=raw&id='+id, function(){
            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_khuvuc_update">Áp dụng</button>');
            $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_khuvuc_update','click', function(){
            if($('#form_khuvuc').valid()== true){
                $.ajax({
                    type:   'post',
                    data:   $('#form_khuvuc').serialize(),
                    url :   'index.php?option=com_danhmuc&controller=khuvuc&task=chinhsuathongtinkhuvuc',
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_khuvuc').click();
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
        $('#btn_xoaallkv').on('click',function(){
            var array_id = [];
            $(".array_idkhuvuc:checked").each(function(){
                array_id.push($(this).val());
            });
            if(array_id.length>0){
                if(confirm('Bạn có muốn xóa không ?')){
                    $.ajax({
                        type:   'post',
                        url:    'index.php?option=com_danhmuc&controller=khuvuc&task=xoanhieukhuvuc',
                        data:   {id:array_id},
                        success: function(data){
                            if(data=='true'){
                                $('#btn_search_khuvuc').click();
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
        $('#btn_xuatexcelkv').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=khuvuc&task=xuatdskhuvuc';
                        return ;
        });
    });
</script>