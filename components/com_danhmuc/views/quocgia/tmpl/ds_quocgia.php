<div id="ds_quocgia">
    <h2 class="row-fluid header smaller lighter">Quốc gia
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoiquocgia">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallquocgia">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelquocgia">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemquocgia" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseThirteen" data-parent="#acco-timkiemquocgia" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseThirteen">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenquocgia" id="tk_tenquocgia" placeholder="Nhập tên" value="">
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
                            <span name="btn_search_quocgia" id="btn_search_quocgia" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_quocgia" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_quocgia').on('click',function(){
            $('#table_quocgia').load('index.php?option=com_danhmuc&view=quocgia&task=table_quocgia&format=raw&ten='+$('#tk_tenquocgia').val());
        });
        $('#btn_search_quocgia').click();
        $('#btn_themmoiquocgia').on('click',function(){
            $('#modal-title').html('Thêm mới quốc gia');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=quocgia&task=themmoiquocgia&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_quocgia_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_quocgia_luu','click',function(){
            if($('#form_quocgia').valid()==true){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quocgia&task=themthongtinquocgia',
                    data: $('#form_quocgia').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quocgia').click();
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
        $('body').delegate('#btn_xoa_quocgia','click',function(){
            var id_quocgia = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quocgia&task=xoaquocgia',
                    data: {id:id_quocgia},
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quocgia').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            } 
        });
        $('body').delegate('#btn_hieuchinh_quocgia','click',function(){
            var id_quocgia = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa quốc gia');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=quocgia&task=chinhsuaquocgia&format=raw&id='+id_quocgia, function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_quocgia_update">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_quocgia_update','click',function(){
            if($('#form_quocgia').valid()== true){
                $.ajax({
                    type:    'post',
                    url:     'index.php?option=com_danhmuc&controller=quocgia&task=chinhsuathongtinquocgia',
                    data:    $('#form_quocgia').serialize(),
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_quocgia').click();
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
        $('body').delegate('#btn_xoaallquocgia','click',function(){
            var array_id = [];
            $(".array_idquocgia:checked").each(function(){
                array_id.push($(this).val());
            });
            console.log(array_id);
            if(confirm('Bạn có muốn xóa không?')){
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=quocgia&task=xoanhieuquocgia',
                    data: {id:array_id},
                    success: function(data){
                        if(data=='true'){
                            $('#btn_search_quocgia').click();
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công,Vui lòng liên hệ Quản trị viên');
                        }
                    }
                });
            }
        });
        $('#btn_xuatexcelquocgia').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=quocgia&task=xuatdsquocgia';
        });
    });
</script>