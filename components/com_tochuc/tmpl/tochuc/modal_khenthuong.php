<?php

use Joomla\CMS\Factory;
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
<form class="form-horizontal" id="frmQuaTrinh" name="frmQuaTrinh" method="post">
   

    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
    <input type="hidden" name="id" value="<?php echo $this->item['id']; ?>" id="quatrinh_id">
    <input type="hidden" name="vanban_id" value="<?php echo $this->item['vanban_id']; ?>" id="vanban_id">
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
                            <label for="cachthuc_id">Từ ngày đến ngày <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="kt_daterangepicker_2" name="name">                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Hình thức</label>
                            <div class="controls">
                                <?php
	                	            echo TochucHelper::selectBox($item->rew_code_kt, array('name'=>'rew_code_kt','hasEmpty'=>true), 'ins_dmkhenthuongkyluat', array('id','name'), array('status = 1','type="KT"')); 
                                ?>
                            </div>                          
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason_kt">Lý do <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="reason_kt" name="reason_kt">                                
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_date_kt">Ngày quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="approv_date_kt" name="approv_date_kt">                                

                            </div>                          
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason_kt">Số quyết định <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="reason_kt" name="reason_kt">                                
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_unit_kt">Cơ quan ra quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="approv_unit_kt" name="approv_unit_kt">                                

                            </div>                          
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approv_per_kt">Người ký <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control rounded-0" id="approv_per_kt" name="approv_per_kt">                                
                            </div> 
                        </div>
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
        

        $('#rew_code_kt').select2({
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