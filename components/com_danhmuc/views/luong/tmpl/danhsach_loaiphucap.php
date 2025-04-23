<h2 class="row-fluid header smaller lighter">Loại phụ cấp
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoiloaiphucap">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaallloaiphucap">Xóa</button>
    </div>
</h2>
<div class="row-fluid">
    <div id="acco-timkiemloaiphucap" class="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a href="#collapseFour" data-parent="#acco-timkiemloaiphucap" data-toggle="collapse" class="accordion-toggle collapsed">
                    Tìm kiếm
                </a>
            </div>
            <div class="accordion-body collapse" id="collapseFour" >
                <div class="accordion-inner">
                    <form class="form-horizontal">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Tên loại phụ cấp:</label>
                                <div class="controls">
                                    <input type="text" name="tk_tenloaiphucap" id="tk_tenloaiphucap" placeholder="Nhập tên" value="">
                                </div>
                            </div>
                        </div>
                        <span name="btn_search_loaiphucap" id="btn_search_loaiphucap" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_loaiphucap" style="margin-left:10px;"></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_loaiphucap').on('click',function(){
            $('#table_loaiphucap').load('index.php?option=com_danhmuc&view=luong&task=table_loaiphucap&format=raw&ten='+$('#tk_tenloaiphucap').val());
        });
        $('#btn_search_loaiphucap').click();
        $('#btn_themmoiloaiphucap').on('click',function(){
            $('#modal-title').html('Thêm mới loại phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoiloaiphucap&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_loaiphucap_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_loaiphucap_luu','click',function(){
            if($('#form_loaiphucap').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=loaiphucap&task=themthongtinloaiphucap',
                    data: $('#form_loaiphucap').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_loaiphucap').click();
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
        $('body').delegate('#btn_delete_loaiphucap','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=loaiphucap&task=xoaloaiphucap',
                    data: {id:id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_loaiphucap').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('#btn_edit_loaiphucap','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa loại phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsualoaiphucap&format=raw&id='+id, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_loaiphucap_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_loaiphucap_update','click',function(){
            if($('#form_loaiphucap').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=loaiphucap&task=chinhsuathongtinloaiphucap',
                    data: $('#form_loaiphucap').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_loaiphucap').click();
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
        $('body').delegate('#btn_xoaallloaiphucap','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var array_id=[];
                $('.array_idloaiphucap:checked').each(function(){
                    array_id.push($(this).val());
                });
                $.ajax({
                    type: 'post',
                    url:  'index.php?option=com_danhmuc&controller=loaiphucap&task=xoanhieuloaiphucap',
                    data: {id:array_id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_loaiphucap').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
    });
    
</script>