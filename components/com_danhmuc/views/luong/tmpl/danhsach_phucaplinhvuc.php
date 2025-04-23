<h2 class="row-fluid header smaller lighter">Phụ cấp lĩnh vực
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoiphucaplinhvuc">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaallphucaplinhvuc">Xóa</button>
    </div>
</h2>
<div class="row-fluid">
    <div id="acco-timkiemphucaplinhvuc" class="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a href="#collapseFive" data-parent="#acco-timkiemphucaplinhvuc" data-toggle="collapse" class="accordion-toggle collapsed">
                    Tìm kiếm
                </a>
            </div>
            <div class="accordion-body collapse" id="collapseFive" >
                <div class="accordion-inner">
                    <form class="form-horizontal">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Tên lĩnh vực phụ cấp:</label>
                                <div class="controls">
                                    <input type="text" name="tk_tenphucaplinhvuc" id="tk_tenphucaplinhvuc" placeholder="Nhập tên" value="">
                                </div>
                            </div>
                        </div>
                        <span name="btn_search_phucaplinhvuc" id="btn_search_phucaplinhvuc" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_phucaplinhvuc" style="margin-left:10px;"></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_phucaplinhvuc').on('click',function(){
            $('#table_phucaplinhvuc').load('index.php?option=com_danhmuc&view=luong&task=table_phucaplinhvuc&format=raw&ten='+$('#tk_tenphucaplinhvuc').val());
        });
        $('#btn_search_phucaplinhvuc').click();
        $('#btn_themmoiphucaplinhvuc').on('click',function(){
            $('#modal-title').html('Thêm mới phụ cấp lĩnh vực');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoiphucaplinhvuc&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phucaplinhvuc_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_phucaplinhvuc_luu','click',function(){
            if($('#form_phucaplinhvuc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phucaplinhvuc&task=themthongtinphucaplinhvuc',
                    data: $('#form_phucaplinhvuc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_phucaplinhvuc').click();
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
        $('body').delegate('#btn_delete_phucaplinhvuc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phucaplinhvuc&task=xoaphucaplinhvuc',
                    data: {id:id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_phucaplinhvuc').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('#btn_edit_phucaplinhvuc','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa phụ cấp lĩnh vực');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsuaphucaplinhvuc&format=raw&id='+id, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_phucaplinhvuc_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_phucaplinhvuc_update','click',function(){
            if($('#form_phucaplinhvuc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=phucaplinhvuc&task=chinhsuathongtinphucaplinhvuc',
                    data: $('#form_phucaplinhvuc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_phucaplinhvuc').click();
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
        $('body').delegate('#btn_xoaallphucaplinhvuc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var array_id=[];
                $('.array_idphucaplinhvuc:checked').each(function(){
                    array_id.push($(this).val());
                });
                $.ajax({
                    type: 'post',
                    url:  'index.php?option=com_danhmuc&controller=phucaplinhvuc&task=xoanhieuphucaplinhvuc',
                    data: {id:array_id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_phucaplinhvuc').click();
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