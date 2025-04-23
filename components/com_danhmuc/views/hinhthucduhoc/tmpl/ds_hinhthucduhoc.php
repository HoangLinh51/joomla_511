<div id="ds_hinhthucduhoc">
    <h2 class="row-fluid header smaller lighter">Hình thức du học
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoihtdh">Thêm mới</span>
        <span class="btn btn-small btn-danger" id="btn_xoaallhtdh">Xóa</span>
        <span class="btn btn-small btn-success" id="btn_xuatexcelhtdh">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemhtdh" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseTwo" data-parent="#acco-timkiemhtdh" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseTwo">
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tenhinhthucduhoc" id="tk_tenhinhthucduhoc" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_mahinhthucduhoc" id="tk_mahinhthucduhoc" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_hinhthucduhoc" id="btn_search_hinhthucduhoc" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_hinhthucduhoc" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_hinhthucduhoc').on('click',function(){
            $('#table_hinhthucduhoc').load('index.php?option=com_danhmuc&controller=hinhthucduhoc&task=table_hinhthucduhoc&format=raw&ten='+$('#tk_tenhinhthucduhoc').val()+'&ma='+$('#tk_mahinhthucduhoc').val());
        });
        $('#btn_search_hinhthucduhoc').click();
        $('#btn_themmoihtdh').on('click',function(){
            $('#modal-title').html('Thêm mới hình thức du học');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=hinhthucduhoc&task=themmoihtdh&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_htdh_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_hieuchinhhtdh','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa hình thức du học');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=hinhthucduhoc&task=chinhsuahtdh&format=raw&id='+id, function(){
            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_htdh_update">Áp dụng</button>');
            $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_htdh_luu', 'click', function(){
            if($('#form_htdh').valid()== true){
                $.ajax({
                    type:   'post',
                    data:   $('#form_htdh').serialize(),
                    url :   'index.php?option=com_danhmuc&controller=hinhthucduhoc&task=themthongtinhinhthucduhoc',
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_hinhthucduhoc').click();
                            $('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                        }            
                    },
                    error:  function(){
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                    }
                });
            }
            else{
                return false;
            }
        });
        $('body').delegate('#btn_htdh_update','click', function(){
            if($('#form_htdh').valid()== true){
                $.ajax({
                    type:   'post',
                    data:   $('#form_htdh').serialize(),
                    url :   'index.php?option=com_danhmuc&controller=hinhthucduhoc&task=chinhsuathongtinhinhthucduhoc',
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_hinhthucduhoc').click();
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
        $('body').delegate('#btn_xoahtdh','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
               result_id = $(this).data('id');
                $.ajax({
                   type:    'post',
                   data:    {id:result_id},
                   url:     'index.php?option=com_danhmuc&controller=hinhthucduhoc&task=xoahinhthucduhoc',
                   success:function(data){
                       if(data == 'true'){
                            $('#btn_search_hinhthucduhoc').click();
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
        $('#btn_xoaallhtdh').on('click',function(){
            var array_id = [];
            $(".array_idhtdh:checked").each(function(){
                array_id.push($(this).val());
            });
            if(array_id.length>0){
                if(confirm('Bạn có muốn xóa không ?')){
                    $.ajax({
                        type:   'post',
                        url:    'index.php?option=com_danhmuc&controller=hinhthucduhoc&task=xoanhieuhinhthucduhoc',
                        data:   {id:array_id},
                        success: function(data){
                            if(data=='true'){
                                $('#btn_search_hinhthucduhoc').click();
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
        $('#btn_xuatexcelhtdh').on('click',function(){
            window.location.href = 'index.php?option=com_danhmuc&controller=hinhthucduhoc&task=xuatdshtdh';
                        return ;
        });
    });
</script>