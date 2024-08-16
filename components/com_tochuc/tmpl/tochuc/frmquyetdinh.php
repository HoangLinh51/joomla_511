<?php

use Joomla\CMS\Uri\Uri;

?>

<meta>
    <!-- <script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.valid.1.9.js" type="text/javascript"></script> -->
     
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
    <script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form class="form-horizontal" id="form_quyetdinh" name="form_quyetdinh" method="post">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới quyết định liên quan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Số QĐ liên quan</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Ngày ban hành</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control rounded-0" id="qdlienquan_ngaybanhanh" name="qdlienquan_ngaybanhanh" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Cơ quan ban hành</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_coquan" name="qdlienquan_coquan">
                        </div>
                        <input type="hidden" class="form-control rounded-0" id="attactment_qdlienquan_file" name="qdlienquan_file">
                        <?php echo Core::inputAttachmentOneFile('attactment_qdlienquan', null, 1, date('Y'), -1) ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
            </div>
        </div>
    </div>
</form>
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script> -->
<style>
   
.required {
    color: red;
}

a.dz-clickable{
    border-top: 3px !important ;
}      
a.dz-clickable:hover{
    border-top: 3px !important ;
} 
.card.card-outline-tabs .card-header a:hover{
    border-top: 3px !important ;
}   
</style>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#qdlienquan_ngaybanhanh').inputmask('dd/mm/yyyy', { 'placeholder': '__/__/____' });
        $('#form_quyetdinh').validate({     
            ignore: true,
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    $(this).addClass("is-invalid");
                    var message = errors == 1
                            ? 'Kiểm tra lỗi sau:<br/>'
                            : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            errors += "<br/>\u25CF " + validator.errorList[x].message;
                        }
                    }
                    $.toast({
                        heading: 'Thông báo',
                        text: message + errors,
                        showHideTransition: 'fade',
                        position: 'top-right',
                        icon: 'error'
                    })
                    // loadNoticeBoardError('Thông báo', message + errors);
                }else {
                    $(this).removeClass("is-invalid");
                }
                // validator.focusInvalid();
            },
            errorPlacement: function (error, element) {
            },
            rules: {
                'qdlienquan_mahieu': {
                    required: true
                },
                // 'qdlienquan_ngaybanhanh': {
                //     required: true
                // },
                'qdlienquan_coquanbanhanh': {
                    required: true
                }
            },
            messages: {
                'qdlienquan_mahieu': {
                    required: "Vui lòng nhập số QĐ liên quan"
                },
                // 'qdlienquan_ngaybanhanh': {
                //     required: "Vui lòng nhập ngày ban hành"
                // },
                'qdlienquan_coquanbanhanh': {
                    required: "Vui lòng nhập cơ quan ban hành"
                }
            },
            // errorElement: 'span',
            // errorPlacement: function (error, element) {
            //     error.addClass('invalid-feedback');
            //     element.closest('.form-group').append(error);
            // },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        })   

        $('.btn-saveqdlienquan').on('click', function(){
            var form = $('#form_quyetdinh');
            if(form.valid()){
                var formData = $("#form_quyetdinh").serialize();
                console.log(formData);
                $.blockUI();
                $.ajax({
                    type: 'get',
                    url: '/index.php?option=com_tochuc&view=tochuc&task=addquyetdinh&format=raw&'+formData,
                    success:function(data){
                        console.log(data);
                        var year=<?php echo date('Y');?>;
                        var xhtml='';
                        xhtml +='<tr id="row'+data.vanban_id+'">';
                        xhtml +='<td><input type="hidden" name="ins_vanban_id[]" value="'+data.vanban_id+'"><input type="checkbox" class="ck_quyetdinhlienquan" value="'+data.vanban_id+'"><span class="lbl"></span></td>';
                        xhtml +='<td>'+data.mahieu+'</td>';
                        xhtml +='<td>'+data.ngaybanhanh+'</td>';
                        xhtml +='<td>'+data.coquan_banhanh+'</td>';
                        xhtml +='<td>';
                        if(data.tenfile != null){
                            var list_dinhkem= data.code;
                            var list_tenfile= data.tenfile;
                            xhtml += '<a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year='+year+'&code='+list_dinhkem+'">'+list_tenfile+'</a><br/>';
                        }
                        xhtml +='</td>';
                        xhtml +='</tr>';
                        $('.file_qdlienquan').modal('hide');
                        $('.modal-backdrop').remove();
                        
                        $('#tbl_quyetdinhkemtheo').append(xhtml);
                        if(data.mahieu != ''){
                            $('#btn_xoa_qdlienquan').css('display','block')
                        }
                        $.unblockUI();
                    }
                });
            }
            return false;
        })
       
    });
   
</script>