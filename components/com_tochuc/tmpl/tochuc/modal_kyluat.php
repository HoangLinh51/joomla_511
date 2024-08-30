<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
$item = $this->item[0];
?>

<meta>

<script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/moment/moment.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/select2/js/select2.min.js" type="text/javascript"></script> -->
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form class="form-horizontal" id="frmQuaTrinhKyluat" name="frmQuaTrinhKyluat" method="post">

    <?php echo HTMLHelper::_('form.token'); ?>
    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
    <input type="hidden" name="id_kl" value="<?php echo $item->id_kl; ?>">
    <div class="overlay" style="display: none;">
        <i class="fas fa-2x fa-sync fa-spin"></i>
    </div>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin quá trình khen thưởng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="range_date_kl">Từ ngày đến ngày <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="kt_daterangepicker_2" name="range_date_kl">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason_kl">Hình thức</label>
                            <div class="controls">
                                <?php
                                echo TochucHelper::selectBox($item->rew_code_kl, array('name' => 'rew_code_kl', 'hasEmpty' => true), 'ins_dmkhenthuongkyluat', array('id', 'name'), array('status = 1', 'type="KL"'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason_kl">Lý do <span class="required">*</span></label>
                            <div class="input-group">
                                <input value="<?php echo $item->reason_kl ?>" type="text" autocomplete="off" class="form-control rounded-0" id="reason_kl" name="reason_kl">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_date_kl">Ngày quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php if(isset($item) && $item->approv_date_kl!= null) echo date('d/m/Y', strtotime($item->approv_date_kl));?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="approv_date_kl" name="approv_date_kl">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason_kl">Số quyết định <span class="required">*</span></label>
                            <div class="input-group">
                                <input value="<?php echo $item->approv_number_kl;?>" type="text" autocomplete="off" class="form-control rounded-0" id="approv_number_kl" name="approv_number_kl">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_unit_kl">Cơ quan ra quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php echo $item->approv_unit_kl;?>" type="text" autocomplete="off" class="form-control rounded-0" id="approv_unit_kl" name="approv_unit_kl">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_per_kl">Người ký <span class="required">*</span></label>
                            <div class="input-group">
                                <input value="<?php echo $item->approv_per_kl;?>" type="text" autocomplete="off" class="form-control rounded-0" id="approv_per_kl" name="approv_per_kl">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
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

    .modal {
        padding-right: 0px !important;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#kt_daterangepicker_2').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#kt_daterangepicker_2').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('#kt_daterangepicker_2').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('.datepicker').datepicker({
            autoclose: true,
            language: 'vi'
        });


        $('#rew_code_kl').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        })

        var getTextLabel = function(id){
            return $('#frmQuaTrinhKyluat label[for="'+id+'"]').text();
        };

        $('#frmQuaTrinhKyluat').validate({
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
                            errors += "<br/>\u25CF " + validator.errorList[x].message +' <b> '+ getTextLabel($(validator.errorList[x].element).attr("name")).replace(/\*/g, '')+'</b>' ;
                        }
                    }
                    loadNoticeBoardError('Thông báo', message + errors);
                } else {
                    $(this).removeClass("is-invalid");
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {},
            rules: {
                'qdlienquan_mahieu': {
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

                'qdlienquan_coquanbanhanh': {
                    required: "Vui lòng nhập cơ quan ban hành"
                }
            },
            highlight: function(element, errorClass, validClass) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('span.select2').find('.select2-selection').addClass('was-validated');
                } else {
                    $(element).addClass('was-validated');
                }
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('span.select2').find('.select2-selection').removeClass('was-validated');
                } else {
                    $(element).removeClass('was-validated');
                }
                $(element).removeClass('is-invalid');
            },
            submitHandler: function() {
                var frmQuaTrinhKyluat = $('#frmQuaTrinhKyluat').serialize();
                $.ajax({
                    type: 'POST',
                    url: 'index.php?option=com_tochuc&controller=tochuc&task=saveKyluat',
                    data: {
                        frmQuaTrinhKyluat: frmQuaTrinhKyluat,
                        '<?php echo Session::getFormToken() ?>': 1
                    },
                    beforeSend: function() {
                        $('.overlay').removeAttr('style');
                    },
                    success: function(data) {
                        if (data == true) {
                            
                            $.blockUI();
                            jQuery.ajax({
                                type: "GET",
                                url: '<?php echo Uri::base(true); ?>/index.php/component/tochuc?view=tochuc&task=khenthuongkyluat&format=raw&id=<?php echo $this->dept_id;?>',
                                success: function(data, textStatus, jqXHR) {
                                    $.unblockUI();
                                    $('#modal_tochuc').modal('hide');
                                    loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công.');
                                    $('#khenthuongkyluat-quatrinh').html(data);
                                }
                            });
                        } else loadNoticeBoardError('Thông báo', 'Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
                    },
                    error: function() {
                        loadNoticeBoardError('Thông báo', 'Vui lòng liên hệ quản trị viên!');
                    }
                });
            }
        })



    });
</script>