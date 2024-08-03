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
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Cơ quan ban hành</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
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

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.input-mask-date').mask('99/99/9999');
        $('#form_quyetdinh').validate({     
            ignore: true,
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                
                if (errors) {
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
                        heading: 'Cảnh báo',
                        text: message + errors,
                        showHideTransition: 'fade',
                        position: 'top-right',
                        icon: 'error'
                    })
                    // loadNoticeBoardError('Thông báo', message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function (error, element) {
            },
            rules: {
                'qdlienquan_mahieu': {
                    required: true
                },
                'qdlienquan_ngaybanhanh': {
                    required: true
                },
                'qdlienquan_coquanbanhanh': {
                    required: true
                }
            },
            messages: {
                'qdlienquan_mahieu': {
                    required: "Vui lòng nhập số QĐ liên quan"
                },
                'qdlienquan_ngaybanhanh': {
                    required: "Vui lòng nhập ngày ban hành"
                },
                'qdlienquan_coquanbanhanh': {
                    required: "Vui lòng nhập cơ quan ban hành"
                }
            }
        })   

        $('.btn-saveqdlienquan').on('click', function(){
            var form = $('#form_quyetdinh');
            if(form.valid()){
                // Your code to save data
            }
            return false;
        })
       
    });
   
</script>