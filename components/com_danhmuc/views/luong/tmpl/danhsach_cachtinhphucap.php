<h2 class="row-fluid header smaller lighter">Cách tính phụ cấp
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoictpc">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaallctpc">Xóa</button>
    </div>
</h2>
<div class="row-fluid">
    <div id="acco-timkiemctpc" class="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a href="#collapseThree" data-parent="#acco-timkiemctpc" data-toggle="collapse" class="accordion-toggle collapsed">
                    Tìm kiếm
                </a>
            </div>
            <div class="accordion-body collapse" id="collapseThree" >
                <div class="accordion-inner">
                    <form class="form-horizontal">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Tên cách tính phụ cấp:</label>
                                <div class="controls">
                                    <input type="text" name="tk_tenctpc" id="tk_tenctpc" placeholder="Nhập tên" value="">
                                </div>
                            </div>
                        </div>
                        <span name="btn_search_ctpc" id="btn_search_ctpc" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_cachtinhphucap" style="margin-left:10px;"></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_ctpc').on('click',function(){
            $('#table_cachtinhphucap').load('index.php?option=com_danhmuc&view=luong&task=table_cachtinhphucap&format=raw&ten='+$('#tk_tenctpc').val());
        });
        $('#btn_search_ctpc').click();
        $('#btn_themmoictpc').on('click',function(){
            $('#modal-title').html('Thêm mới cách tính phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoictpc&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_ctpc_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_ctpc_luu','click',function(){
            if($('#form_ctpc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=cachtinhphucap&task=themthongtinctpc',
                    data: $('#form_ctpc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_ctpc').click();
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
        $('body').delegate('#btn_delete_ctpc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=cachtinhphucap&task=xoactpc',
                    data: {id:id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_ctpc').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('#btn_edit_ctpc','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa đơn vị tính phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsuactpc&format=raw&id='+id, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_ctpc_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_ctpc_update','click',function(){
            if($('#form_ctpc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=cachtinhphucap&task=chinhsuathongtinctpc',
                    data: $('#form_ctpc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_ctpc').click();
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
        $('body').delegate('#btn_xoaallctpc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var array_id=[];
                $('.array_idctpc:checked').each(function(){
                    array_id.push($(this).val());
                });
                $.ajax({
                    type: 'post',
                    url:  'index.php?option=com_danhmuc&controller=cachtinhphucap&task=xoanhieuctpc',
                    data: {id:array_id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_ctpc').click();
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