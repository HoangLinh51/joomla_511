<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
$item = $this->data;
$donvi_id = $this->donvi_id;
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
<form enctype="multipart/form-data" class="form-horizontal" id="frmQuydinhcappho" name="frmQuydinhcappho" method="post">
	<input type="hidden" name="id" value="<?php echo $item['id']; ?>" id="id">
	<input type="hidden" id="donvi_id" name="donvi_id" value="<?php echo $donvi_id ?>">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Quy định số lượng cấp phó</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nam">Năm <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control rounded-0 datepicker" value="<?php echo $item['nam'] ?>" id="nam" name="nam">                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Hình thức <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                    $hinhthuc = array(
                                        0=>array('id'=>1, 'ten'=>'Quy định cấp phó'),
                                        1=>array('id'=>2, 'ten'=>'Bổ sung cấp phó'),
                                    );
                                ?>
                                <select class="form-control rounded-0 select2" name="hinhthuc_id">
                                    <option value="">-- Chọn hình thức --</option>
                                    <?php for ($i = 0; $i < count($hinhthuc); $i++) { ?>
                                        <option value="<?php echo $hinhthuc[$i]['id'] ?>" <?php if ($hinhthuc[$i]['id'] == $item['hinhthuc_id']) echo 'selected' ?>><?php echo $hinhthuc[$i]['ten'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>                          
                        </div>              
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="soluong">Số lượng cấp phó <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control rounded-0" value="<?php echo $item['soluong'] ?>" id="soluong" name="soluong">                                
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ghichu">Ghi chú </label>
                            <div class="input-group">
                                <textarea type="text" autocomplete="off" class="form-control rounded-0" id="ghichu" name="ghichu"><?php echo $item['ghichu'] ?></textarea>                                
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit"  id="btnAddQuaTrinh" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
            </div>
        </div>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
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
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
            language: 'vi'
        });
        
       
        $('#frmQuydinhcappho').validate({
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
                    $.toast({
                        heading: 'Thông báo',
                        text: message + errors,
                        showHideTransition: 'fade',
                        position: 'top-right',
                        icon: 'error'
                    })
                } else {
                    $(this).removeClass("is-invalid");
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {},
            rules: {
                'nam': {
                    required: true
                },
                'hinhthuc_id': {
                    required: true
                },
                'soluong': {
                    required: true
                }
            },
            messages: {
                'nam': {
                    required: "Vui lòng nhập"
                },
                'hinhthuc_id': {
                    required: "Vui lòng nhập"
                },
                'soluong': {
                    required: "Vui lòng nhập"
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function() {
                var frmQuydinhcappho = $('#frmQuydinhcappho').serialize();
                $.ajax({
					type: 'POST',
					url: 'index.php?option=com_tochuc&controller=tochuc&task=savequydinhcappho',
					data: {
						frmQuydinhcappho: frmQuydinhcappho,
						'<?php echo Session::getFormToken() ?>': 1
					},
					success: function(data) {
						if (data == true) {
                            $.toast({
                                heading: 'Thông báo',
                                text: "Thao tác thành công!",
                                showHideTransition: 'fade',
                                position: 'top-right',
                                icon: 'success'
                            });
							// loadNoticeBoardSuccess('Thông báo', 'Thao tác thành công!');
							$.blockUI();
							jQuery.ajax({
								type: "GET",
								url: '?view=tochuc&task=quydinhcappho&format=raw&id=<?php echo $donvi_id; ?>',
								success: function(data, textStatus, jqXHR) {
									$.unblockUI();
									$('#modal_tochuc').modal('hide');
									$('#quydinhcappho-quatrinh').html(data);
								}
							});
						} else //loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
                            $.toast({
                                heading: 'Thông báo',
                                text: "Có lỗi xảy ra, vui lòng liên hệ quản trị viên!",
                                showHideTransition: 'fade',
                                position: 'top-right',
                                icon: 'error'
                            });
					},
					error: function() {
						$.blockUI();
                        $.toast({
                            heading: 'Thông báo',
                            text: "Có lỗi xảy ra, vui lòng liên hệ quản trị viên!",
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'error'
                        });
						// loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
					}
				});
            }
        });


    });
</script>