<div id="ds_chuyennganhdaotao">
    <h2 class="row-fluid header smaller lighter">Chuyên ngành đào tạo
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoichuyennganhdaotao">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallchuyennganhdaotao">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelchuyennganhdaotao">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemchuyennganhdaotao" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseEight" data-parent="#acco-timkiemchuyennganhdaotao" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseEight">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenchuyennganhdaotao" id="tk_tenchuyennganhdaotao" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_machuyennganhdaotao" id="tk_machuyennganhdaotao" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_chuyennganhdaotao" id="btn_search_chuyennganhdaotao" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_chuyennganhdaotao" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_chuyennganhdaotao').on('click',function(){
            $('#table_chuyennganhdaotao').load('index.php?option=com_danhmuc&view=chuyennganhdaotao&task=table_chuyennganhdaotao&format=raw&ten='+$('#tk_tenchuyennganhdaotao').val()+'&ma='+$('#tk_machuyennganhdaotao').val());
        });
        $('#btn_search_chuyennganhdaotao').click();
        $('#btn_themmoichuyennganhdaotao').on('click',function(){
            $('#modal-title').html('Thêm mới chuyên ngành đào tạo');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=themmoichuyennganhdaotao&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_chuyennganhdaotao_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_chuyennganhdaotao_luu','click',function(){
            if($('#form_chuyennganhdaotao').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=themthongtinchuyennganhdaotao',
                    data: $('#form_chuyennganhdaotao').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_chuyennganhdaotao').click();
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
        $('body').delegate('#btn_xoa_chuyennganhdaotao','click',function(){
            var id_chuyennganhdaotao = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=xoachuyennganhdaotao',
                    data: {id:id_chuyennganhdaotao},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_chuyennganhdaotao').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_chuyennganhdaotao','click',function(){
            var id_chuyennganhdaotao = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa chuyên ngành đào tạo');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=chinhsuachuyennganhdaotao&format=raw&id='+id_chuyennganhdaotao, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_chuyennganhdaotao_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_chuyennganhdaotao_update','click',function(){
            if($('#form_chuyennganhdaotao').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=chinhsuathongtinchuyennganhdaotao',
                    data:    $('#form_chuyennganhdaotao').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_chuyennganhdaotao').click();
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
        $('#btn_xoaallchuyennganhdaotao').on('click',function(){
            var array_id = [];
            $(".array_idchuyennganhdaotao:checked").each(function(){
                array_id.push($(this).val());
            });
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=xoanhieuchuyennganhdaotao',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_chuyennganhdaotao').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcelchuyennganhdaotao').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=chuyennganhdaotao&task=xuatdscndt';
        });
    });
</script>