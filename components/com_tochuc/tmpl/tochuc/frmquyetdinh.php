<form class="form-horizontal" id="form_quyetdinh" method="post">
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
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // $('.input-mask-date').mask('99/99/9999');
        $('#form_quyetdinh').validate({
            ignore: [],
            errorPlacement: function(error, element) {},
            rules: {
                "mahieu": {
                    required: true,
                },
            },
            messages: {
                "mahieu": {
                    required: 'Nhập <b>Số Quyết định</b>',
                },
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'Kiểm tra lỗi sau:<br/>' : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            errors += "<br/>\u25CF " + validator.errorList[x].message;
                        }
                    }
                    loadNoticeBoardError('Thông báo', message + errors);
                }
                validator.focusInvalid();
            },
            submitHandler: function() {
                var formData = $("#form_quyetdinh").serialize();
                $.blockUI();
                $.ajax({
                    type: 'get',
                    url: '/index.php?option=com_tochuc&controller=tochuc&task=addquyetdinh&format=raw&' + formData,
                    success: function(data) {
                        var year = <?php echo date('Y'); ?>;
                        var xhtml = '';
                        xhtml += '<tr id="row' + data.vanban_id + '">';
                        xhtml += '<td><input type="hidden" name="ins_vanban_id[]" value="' + data.vanban_id + '"><input type="checkbox" class="ck_quyetdinhlienquan" value="' + data.vanban_id + '"><span class="lbl"></span></td>';
                        xhtml += '<td>' + data.mahieu + '</td>';
                        xhtml += '<td>' + data.ngaybanhanh + '</td>';
                        xhtml += '<td>' + data.coquan_banhanh + '</td>';
                        xhtml += '<td>';
                        if (data.idFile_quyetdinhkemtheo_attachment != null) {
                            var list_dinhkem = data.idFile_quyetdinhkemtheo_attachment;
                            var list_tenfile = data.tenfile;
                            console.log(list_dinhkem);
                            console.log(list_tenfile);
                            for (i = 0; i < list_dinhkem.length; i++) {
                                xhtml += '<a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' + year + '&code=' + list_dinhkem[i] + '">' + list_tenfile[i] + '</a><br/>';
                            }
                        }
                        xhtml += '</td>';
                        xhtml += '</tr>';
                        $('.modal').modal('hide');
                        $('#tbl_quyetdinhkemtheo').append(xhtml);
                        $.unblockUI();
                    }
                });
            }
        });
    });
</script>