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
<form class="form-horizontal" id="frmQuaTrinhGiaouoc" name="frmQuaTrinhGiaouoc" method="post">
    <?php echo HTMLHelper::_('form.token'); ?>
    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
	<input type="hidden" name="id" value="<?php echo $item['id']; ?>" id="id">
    <div class="overlay" style="display: none;">
        <i class="fas fa-2x fa-sync fa-spin"></i>
    </div>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin quá trình giao ước thi đua</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="daidiencongdoan">Đại diện Công đoàn <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php echo $item['daidiencongdoan']; ?>" type="text" autocomplete="off" class="form-control rounded-0" id="daidiencongdoan" name="daidiencongdoan">                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="daidienchinhquyen">Đại diện chính quyền <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php echo $item['daidienchinhquyen']; ?>" type="text" autocomplete="off" class="form-control rounded-0" id="daidienchinhquyen" name="daidienchinhquyen">                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nam">Năm <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php echo $item['nam']; ?>" type="text" autocomplete="off" class="form-control rounded-0" id="nam" name="nam">                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="noidung">Nội dung giao ước thi đua <span class="required">*</span></label>
                            <div class="controls">
                                <textarea autocomplete="off" class="form-control rounded-0" id="noidung" name="noidung"><?php echo $item['noidung']; ?></textarea>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo Core::inputAttachmentOneFile('attactment_giaouoc', null, 1, date('Y'), -1) ?>
                            <?php
                            for ($i = 0, $n = count($this->files); $i < $n; $i++) {
                                $item = $this->files[$i];
                            ?>
                            <div class="dropzone dropzone-multi col-lg-8">
                                <div class="dropzone-items wm-200px">
                                    <div class="dropzone-item" id="div_<?php echo $item['code'] ?>">
                                        <!--begin::File-->
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                <span data-dz-name class="linkFile"><a target="_blank" href="index.php?option=com_core&controller=attachment&format=raw&task=download&year=<?php echo $this->year; ?>&code=<?php echo $item['code'] ?>"><?php echo $item['filename']; ?></a></span>
                                                <strong>(<span data-dz-size><?php echo $fileSizeMB ?>kb</span>)</strong>
                                            </div>
                                            <div class="dropzone-error" data-dz-errormessage></div>
                                        </div>
                                        <!--end::File-->

                                        <!--begin::Toolbar-->
                                        <div class="dropzone-toolbar">
                                            <span class="dropzone-delete" id="btn_remove_soqd" data-code="<?php echo $item['code'] ?>"  name="DELidfiledk<?php echo $this->idObject ?>[]" data-dz-remove><i class="fa fa-times"></i></span>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                </div>
                                <!--end::Items-->
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div> 
            </div>
            <input type="hidden" id="donvi_id" name="donvi_id" value="<?php echo $donvi_id;?>">
            <input type="hidden" id="alias" name="alias" value="giaouoc">
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit"  data-id="" class="btn btn-primary">Lưu</button>
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
    .modal{
        padding-right: 0px !important;
    }
</style>
<script type="text/javascript">
    
    jQuery(document).ready(function($) {

        $('#nam').datepicker({
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
            language: 'vi'
        })

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
            return $('#frmQuaTrinhGiaouoc label[for="'+id+'"]').text();
        };
        $('#frmQuaTrinhGiaouoc').validate({
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
                'daidiencongdoan': {
                    required: true
                },
                'daidienchinhquyen': {
                    required: true
                },
                'nam': {
                    required: true
                },
                'noidung': {
                    required: true
                }
            },
            messages: {
                'daidiencongdoan': {
                    required: "Vui lòng nhập"
                },
                'daidienchinhquyen': {
                    required: "Vui lòng nhập"
                },
                'nam': {
                    required: "Vui lòng nhập"
                },
                'noidung': {
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
                var frmQuaTrinh = $('#frmQuaTrinhGiaouoc').serialize();
                $.ajax({
					type: 'POST',
					url: 'index.php?option=com_tochuc&controller=tochuc&task=saveQuatrinhGiaouoc',
					data: {
						frmQuaTrinh: frmQuaTrinh,
						'<?php echo Session::getFormToken() ?>': 1
					},
                    beforeSend: function() {
                        $('.overlay').removeAttr('style');
                    },
					success: function(data) {
						if (data == true) {
                            loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công.');
							$.blockUI();
							jQuery.ajax({
								type: "GET",
								url: '<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&task=giaouocthidua&format=raw&id=<?php echo $donvi_id; ?>',
								success: function(data, textStatus, jqXHR) {
									$.unblockUI();
									$('#modal_tochuc').modal('hide');
									$('#giaouocthidua-quatrinh').html(data);
								}
							});
						} else loadNoticeBoardError('Thông báo', 'Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
					},
					error: function() {
                        loadNoticeBoardError('Thông báo', 'Vui lòng liên hệ quản trị viên!');
					}
				});
            }
        });

        //Xóa file

        $('#btn_remove_soqd').on('click', function() {
            var alias = $('#alias').val();
			if (!confirm('Bạn có chắc chắn xóa tập tin này?')) {
				return false;
			} else {
				var idFile = $(this).data('code');
                var alias = $('#alias').val();
				$.ajax({
					type: "POST",
					url: "<?php echo Uri::root(true) ?>/index.php?option=com_tochuc&controller=tochuc&task=deleteFileVanban",
					data: {
						idFile: idFile,
                        alias: alias
					},
					beforeSend: function() {
						$.blockUI();
					},
					success: function(data) {
						if (data == '1') {
							loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công.');
							$('#div_' + idFile).remove();
						} else {
							loadNoticeBoardError('Thông báo', 'Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
						}
						$.unblockUI();
					},
					error: function() {
						$.blockUI();
						loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
					}
				});
			}
		});


    });
</script>