<h2 class="row-fluid header smaller lighter">Lương cơ sở
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoilcs">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaalllcs">Xóa</button>
    </div>
</h2>
<div class="row-fluid">
    <div id="acco-timkiemlcs" class="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a href="#collapseOne" data-parent="#acco-timkiemlcs" data-toggle="collapse" class="accordion-toggle collapsed">
                    Tìm kiếm
                </a>
            </div>
            <div class="accordion-body collapse" id="collapseOne" >
                <div class="accordion-inner">
                    <form class="form-horizontal">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Mức lương:</label>
                                <div class="controls">
                                    <input type="text" name="tk_mucluong" id="tk_mucluong" placeholder="Nhập tên" value="">
                                </div>
                            </div>
                        </div>
                        <span name="btn_search_mucluong" id="btn_search_mucluong" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_luongcoso" style="margin-left:10px;"></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_mucluong').on('click',function(){
            $mucluong = $('#tk_mucluong').val();
            $('#table_luongcoso').load('index.php?option=com_danhmuc&view=luong&task=table_luongcoso&format=raw&ten='+$mucluong);
        });
        $('#btn_search_mucluong').click();
        $('#btn_themmoilcs').on('click',function(){
            $('#modal-title').html('Thêm mới lương cơ sở');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoiluongcoso&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_luongcoso_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_luongcoso_luu','click',function(){
            if($('#form_luongcoso').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=luongcoso&task=themthongtinluongcoso',
                    data: $('#form_luongcoso').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_mucluong').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else if(data=='false'){
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, ngày áp dụng mới nằm trong khoảng thời gian áp dụng mức lương cũ');
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
        $('body').delegate('#btn_delete_luongcoso','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    type: 'post',
                    url:  'index.php?option=com_danhmuc&controller=luongcoso&task=xoathongtinluongcoso',
                    data: {id:id},
                    success:function(data){
                        if(data=='true'){
                            $('#btn_search_mucluong').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('#btn_edit_luongcoso','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa lương cơ sở');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsualuongcoso&format=raw&id='+id, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_luongcoso_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_luongcoso_update','click',function(){
            if($('#form_luongcoso').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=luongcoso&task=chinhsuathongtinluongcoso',
                    data: $('#form_luongcoso').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_mucluong').click();
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
        $('body').delegate('#btn_xoaalllcs','click',function(){
            var array_id = [];
            $(".array_idluongcoso:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=luongcoso&task=xoanhieuluongcoso',
                    data: {id:array_id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_mucluong').click();
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