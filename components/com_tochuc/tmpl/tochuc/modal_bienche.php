<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
$item = $this->item;
?>

<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/select2/js/select2.min.js" type="text/javascript"></script> -->
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form class="form-horizontal" id="frmQuaTrinh" name="frmQuaTrinh" method="post">


    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" id="quatrinh_id">
    <input type="hidden" name="vanban_id" value="<?php echo $this->item->vanban_id; ?>" id="vanban_id">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin biên chế</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nghiepvu_id">Nghiệp vụ <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                echo TochucHelper::selectBox($this->item->nghiepvu_id, array('name' => 'nghiepvu_id', 'hasEmpty' => true), 'ins_nghiepvu_bienche', array('id', 'nghiepvubienche'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nam">Năm <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0" name="nam" id="nam" value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <fieldset>
                    <div>
                        <p class="lead mb-0">Số lượng biên chế</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bienche">Biến chế hành chính</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0" id="bienche" name="bienche[]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bienche">Hợp đồng theo NĐ 68 (giao chỉ tiêu)</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0" id="bienche" name="bienche[]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bienche">Tập sự (Công chức)</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0" id="bienche" name="bienche[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div>
                        <p class="lead mb-0">Văn bản kèm theo</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quyetdinh_so">Nghị quyết</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0" id="quyetdinh_so" name="naquyetdinh_some">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quyetdinh_ngay">Ngày quyết định</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="quyetdinh_ngay" name="quyetdinh_ngay">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hieuluc_ngay">Ngày hiệu lực</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="hieuluc_ngay" name="hieuluc_ngay">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo Core::inputAttachmentOneFile('attactment_history', null, 1, date('Y'), -1) ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hieuluc_ngay">Ghi chú</label>
                                    <div class="input-group">
                                        <textarea  autocomplete="off" class="form-control rounded-0" id="hieuluc_ngay" name="hieuluc_ngay"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
            </div>
        </div>
    </div>
    
</form>
<style>
    .required {
        color: red;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.10rem + 2px) !important;
    }

    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px);
        border-radius: 0px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        padding-left: 0px !important
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#datepicker_qd').datepicker({
            autoclose: true,
            language: 'vi'
        });
        $('#datepicker_hl').datepicker({
            autoclose: true,
            language: 'vi'
        });

        $('#nam').datepicker({
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
            language: 'vi'
        })

        $('.datepicker').datepicker({
            language: 'vi'
        })

        $('#nghiepvu_id').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        })
        // $('#qdlienquan_ngaybanhanh').inputmask('dd/mm/yyyy', { 'placeholder': '__/__/____' });
        $('#form_quyetdinh').validate({
            ignore: true,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    $(this).addClass("is-invalid");
                    var message = errors == 1 ?
                        'Kiểm tra lỗi sau:<br/>' :
                        'Phát hiện ' + errors + ' lỗi sau:<br/>';
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
                } else {
                    $(this).removeClass("is-invalid");
                }
                // validator.focusInvalid();
            },
            errorPlacement: function(error, element) {},
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
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        })

        $('.btn-saveqdlienquan').on('click', function() {
            var form = $('#form_quyetdinh');
            if (form.valid()) {
                var formData = $("#form_quyetdinh").serialize();
                console.log(formData);
                $.blockUI();
                $.ajax({
                    type: 'get',
                    url: '/index.php?option=com_tochuc&view=tochuc&task=addquyetdinh&format=raw&' + formData,
                    success: function(data) {
                        console.log(data);
                        var year = <?php echo date('Y'); ?>;
                        var xhtml = '';
                        xhtml += '<tr id="row' + data.vanban_id + '">';
                        xhtml += '<td><input type="hidden" name="ins_vanban_id[]" value="' + data.vanban_id + '"><input type="checkbox" class="ck_quyetdinhlienquan" value="' + data.vanban_id + '"><span class="lbl"></span></td>';
                        xhtml += '<td>' + data.mahieu + '</td>';
                        xhtml += '<td>' + data.ngaybanhanh + '</td>';
                        xhtml += '<td>' + data.coquan_banhanh + '</td>';
                        xhtml += '<td>';
                        if (data.tenfile != null) {
                            var list_dinhkem = data.code;
                            var list_tenfile = data.tenfile;
                            xhtml += '<a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' + year + '&code=' + list_dinhkem + '">' + list_tenfile + '</a><br/>';
                        }
                        xhtml += '</td>';
                        xhtml += '</tr>';
                        $('.file_qdlienquan').modal('hide');
                        $('.modal-backdrop').remove();

                        $('#tbl_quyetdinhkemtheo').append(xhtml);
                        if (data.mahieu != '') {
                            $('#btn_xoa_qdlienquan').css('display', 'block')
                        }
                        $.unblockUI();
                    }
                });
            }
            return false;
        })

    });
</script>