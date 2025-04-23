<h2 class="row-fluid header smaller lighter">Đơn vị tính phụ cấp
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoidvtpc">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaalldvtpc">Xóa</button>
    </div>
</h2>
<div class="row-fluid">
    <div id="acco-timkiemdvtpc" class="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a href="#collapseTwo" data-parent="#acco-timkiemdvtpc" data-toggle="collapse" class="accordion-toggle collapsed">
                    Tìm kiếm
                </a>
            </div>
            <div class="accordion-body collapse" id="collapseTwo" >
                <div class="accordion-inner">
                    <form class="form-horizontal">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Tên đơn vị tính phụ cấp:</label>
                                <div class="controls">
                                    <input type="text" name="tk_tendvtpc" id="tk_tendvtpc" placeholder="Nhập tên" value="">
                                </div>
                            </div>
                        </div>
                        <span name="btn_search_dvtpc" id="btn_search_dvtpc" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_donvitinhphucap" style="margin-left:10px;"></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_dvtpc').on('click',function(){
            $('#table_donvitinhphucap').load('index.php?option=com_danhmuc&view=luong&task=table_donvitinhphucap&format=raw&ten='+$('#tk_tendvtpc').val());
        });
        $('#btn_search_dvtpc').click();
        $('#btn_themmoidvtpc').on('click',function(){
            $('#modal-title').html('Thêm mới đơn vị tính phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoidvtpc&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_dvtpc_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_dvtpc_luu','click',function(){
            if($('#form_dvtpc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=donvitinhphucap&task=themthongtindvtpc',
                    data: $('#form_dvtpc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_dvtpc').click();
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
        $('body').delegate('#btn_delete_dvtpc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=donvitinhphucap&task=xoadvtpc',
                    data: {id:id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_dvtpc').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('body').delegate('#btn_edit_dvtpc','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa đơn vị tính phụ cấp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsuadvtpc&format=raw&id='+id, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_dvtpc_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_dvtpc_update','click',function(){
            if($('#form_dvtpc').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=donvitinhphucap&task=chinhsuathongtindvtpc',
                    data: $('#form_dvtpc').serialize(),
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_dvtpc').click();
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
        $('body').delegate('#btn_xoaalldvtpc','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
                var array_id=[];
                $('.array_iddvtpc:checked').each(function(){
                    array_id.push($(this).val());
                });
                $.ajax({
                    type: 'post',
                    url:  'index.php?option=com_danhmuc&controller=donvitinhphucap&task=xoanhieudvtpc',
                    data: {id:array_id},
                    success:function(data){
                        if(data == 'true'){
                            $('#btn_search_dvtpc').click();
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