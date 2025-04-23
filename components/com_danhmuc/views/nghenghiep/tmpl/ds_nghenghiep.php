<div id="ds_nghenghiep">
    <h2 class="row-fluid header smaller lighter">Nghề nghiệp
    <div class="pull-right">
        <span class="btn btn-small btn-primary" id="btn_themmoinn">Thêm mới</span>
        <button class="btn btn-small btn-danger" id="btn_xoaallnn">Xóa</button>
        <span class="btn btn-small btn-success" id="btn_xuatexcelnn">Xuất excel</span>
    </div>
    </h2>
    <div class="row-fluid">
        <div id="acco-timkiemnn" class="accordion">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapseOne" data-parent="#acco-timkiemnn" data-toggle="collapse" class="accordion-toggle collapsed">
                        Tìm kiếm
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapseOne" >
                    <div class="accordion-inner">
                        <form class="form-horizontal">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Tên</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_tennghenghiep" id="tk_tennghenghiep" placeholder="Nhập tên" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" style="width: 60px;">Mã</label>
                                    <div class="controls" style="margin-left: 70px;">
                                        <input type="text" name="tk_manghenghiep" id="tk_manghenghiep" placeholder="Nhập mã" value="">
                                    </div>
                                </div>
                            </div>
                            <span name="btn_search_nghenghiep" id="btn_search_nghenghiep" class="btn btn-small btn-info" style="margin-left:40%">Tìm kiếm</span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="table_nghenghiep" style="margin-left:10px;"></div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#btn_search_nghenghiep').on('click', function(){
            let ten = $('#tk_tennghenghiep').val();
           $('#table_nghenghiep').load("index.php?option=com_danhmuc&view=nghenghiep&task=table_nghenghiep&format=raw&ten="+ten+"&ma="+$('#tk_manghenghiep').val());
           
        });
        $('#btn_search_nghenghiep').click();
        $('#accordion2').on('hide', function (e) {
            $(e.target).prev().children(0).addClass('collapsed');
        });
        $('#accordion2').on('hidden', function (e) {
            $(e.target).prev().children(0).addClass('collapsed');
        });
        $('#accordion2').on('show', function (e) {
            $(e.target).prev().children(0).removeClass('collapsed');
        });
        $('#accordion2').on('shown', function (e) {
            $(e.target).prev().children(0).removeClass('collapsed');
        });
        $('#btn_themmoinn').on('click',function(){
            $('#modal-title').html('Thêm mới nghề nghiệp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=nghenghiep&task=themmoinghenghiep&format=raw', function(){
                $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nghenghiep_luu">Áp dụng</button>');
                $('#modal-form').modal('show');

            });
        });
        $('body').delegate('.btn_hieuchinh','click',function(){
            var id = $(this).data('id');
            $('#modal-title').html('Chỉnh sửa nghề nghiệp');
            $('#modal-content').html('');
            $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=nghenghiep&task=chinhsuanghenghiep&format=raw&id='+id, function(){
            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nghenghiep_update">Áp dụng</button>');
            $('#modal-form').modal('show');

            });
        });
        $('body').delegate('#btn_xoa','click',function(){
            if(confirm('Bạn có muốn xóa không?')){
               result_id = $(this).data('id');
                $.ajax({
                   type:    'post',
                   data:    {id:result_id},
                   url:     'index.php?option=com_danhmuc&controller=nghenghiep&task=xoanghenghiep',
                   success:function(data){
                       if(data == 'true'){
                            $('#btn_search_nghenghiep').click();
                            //$('#modal-form').modal('hide');
                            loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
                        }
                        else{
                            loadNoticeBoardError('Thông báo','Xử lý không thành công, vui lòng liên hệ quản trị viên');
                        }    
                    }
                });
            }
        });
        
        $('body').delegate('#btn_nghenghiep_luu', 'click', function(){
            if($('#form_nghenghiep').valid()== true){
                $.ajax({
                    type:   'post',
                    data:   $('#form_nghenghiep').serialize(),
                    url :   'index.php?option=com_danhmuc&controller=nghenghiep&task=themthongtinnghenghiep',
                    success: function(data){
                        if(data == 'true'){
                            $('#btn_search_nghenghiep').click();
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
            }else{
                return false;
            }
        });
        $('body').delegate('#checkall','click',function(){
            if($(this).is(':checked')){
                $(".array_id").attr("checked",true);
            }else{
                $(".array_id").attr("checked",false);
            }
        });
        $('#btn_xuatexcelnn').on('click',function(){
             window.location.href = 'index.php?option=com_danhmuc&controller=nghenghiep&task=xuatdsnn';
                        return ;
        });
    });
</script>