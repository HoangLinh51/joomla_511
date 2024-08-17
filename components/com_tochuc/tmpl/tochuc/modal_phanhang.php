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

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form class="form-horizontal" id="frmQuaTrinh" name="frmQuaTrinh" method="post">
    <?php echo HTMLHelper::_('form.token'); ?>
    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
	<input type="hidden" name="id" value="<?php echo $item['id']; ?>" id="id">
	<input type="hidden" id="donvi_id" name="donvi_id" value="<?php echo $donvi_id ?>">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin quá trình phân hạng đơn vị</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngaybatdau">Từ ngày<span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php if ($item['ngaybatdau'] != '' && $item['ngaybatdau'] != '0000-00-00') echo date('d/m/Y', strtotime($item['ngaybatdau'])); ?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="ngaybatdau" name="ngaybatdau">                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngayketthuc">Đến ngày</label>
                            <div class="controls">
                                <input value="<?php if ($item['ngayketthuc'] != '' && $item['ngayngayketthucqd'] != '0000-00-00') echo date('d/m/Y', strtotime($item['ngayketthuc'])); ?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="ngayketthuc" name="ngayketthuc">                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hinhthucphanhang_id">Hình thức</label>
                            <div class="controls">
                                <?php $hinhthuc = Core::loadAssocList('danhmuc_hinhthucphanhangdonvi', '*', 'trangthai=1'); ?>
                                <select class="form-control rounded-0 select2" name="hinhthucphanhang_id">
                                    <option value="">-- Chọn hình thức --</option>
                                    <?php for ($i = 0; $i < count($hinhthuc); $i++) { ?>
                                        <option value="<?php echo $hinhthuc[$i]['id'] ?>" <?php if ($hinhthuc[$i]['id'] == $item['hinhthucphanhang_id']) echo 'selected' ?>><?php echo $hinhthuc[$i]['ten'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>                          
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hangdonvisunghiep_id">Hạng <span class="required">*</span></label>
                            <div class="controls">
                                <?php $hang = Core::loadAssocList('danhmuc_hangdonvisunghiep', '*', 'trangthai=1'); ?>
                                <select class="form-control rounded-0 select2" name="hangdonvisunghiep_id">
                                    <option value="">-- Chọn hình thức --</option>
                                    <?php for ($i = 0; $i < count($hang); $i++) { ?>
                                        <option value="<?php echo $hang[$i]['id'] ?>" <?php if ($hang[$i]['id'] == $item['hangdonvisunghiep_id']) echo 'selected' ?>><?php echo $hang[$i]['ten'] ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ghichu">Ghi chú</label>
                            <div class="input-group">
                                <textarea type="text" autocomplete="off" class="form-control rounded-0" id="ghichu" name="ghichu"><?php echo $item['ghichu'] ?></textarea>                              
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="soqd">Số quyết định <span class="required">*</span></label>
                            <div class="input-group">
                                <input value="<?php echo $item['soqd']; ?>" type="text" autocomplete="off" class="form-control rounded-0" id="soqd" name="soqd">                                
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngayqd">Ngày quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php if ($item['ngayqd'] != '' && $item['ngayqd'] != '0000-00-00') echo date('d/m/Y', strtotime($item['ngayqd'])); ?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="ngayqd" name="ngayqd">                                

                            </div>                          
                        </div>              
                    </div>                 
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="coquanqd">Cơ quan ra quyết định <span class="required">*</span></label>
                            <div class="controls">
                                <input value="<?php echo $item['coquanqd']; ?>" type="text" autocomplete="off" class="form-control rounded-0" id="coquanqd" name="coquanqd">                                

                            </div>                          
                        </div>              
                    </div>
                </div>

                <div class="form-group">
                    <?php echo Core::inputAttachmentOneFile('attactment_phanhang', null, 1, date('Y'), -1) ?>     
                    <?php
                    for ($i = 0, $n = count($this->files); $i < $n; $i++) {
                        $item = $this->files[$i];
                    ?>
                    <div class="dropzone dropzone-multi col-lg-8">
                        <div class="dropzone-items wm-200px">
                            <div class="dropzone-item">
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
                                    <span class="dropzone-delete" onclick="removeFile()" data-code="<?php echo $item['code'] ?>"  name="DELidfiledk<?php echo $this->idObject ?>[]" data-dz-remove><i class="fa fa-times"></i></span>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                        </div>
                        <!--end::Items-->
                    </div>
	                <?php } ?>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" id="btnAddQuaTrinh" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
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
        

        $('#rew_code_kl').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        })
        var getTextLabel = function(id){
            return $('#frmQuaTrinh label[for="'+id+'"]').text();
        };
        $('#frmQuaTrinh').validate({
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
                'hinhthucphanhang_id': {
                    required: true
                },
                'ngaybatdau': {
                    required: true
                },
                'hangdonvisunghiep_id': {
                    required: true
                },
                'soqd': {
                    required: true
                },
                'ngayqd': {
                    required: true
                },
                'coquanqd': {
                    required: true
                }
            },
            messages: {
                'hinhthucphanhang_id': {
                    required: "Vui lòng nhập"
                },
                'ngaybatdau': {
                    required: "Vui lòng nhập"
                },
                'hangdonvisunghiep_id': {
                    required: "Vui lòng nhập"
                },
                'soqd': {
                    required: "Vui lòng nhập"
                },
                'ngayqd': {
                    required: "Vui lòng nhập"
                },
                'coquanqd': {
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
                var frmQuaTrinh = $('#frmQuaTrinh').serialize();
                $.ajax({
					type: 'POST',
					url: 'index.php?option=com_tochuc&controller=tochuc&task=savephanhangdonvi',
					data: {
						frmQuaTrinh: frmQuaTrinh,
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
							$.blockUI();
							jQuery.ajax({
								type: "GET",
								url: '?view=tochuc&task=phanhangdonvi&format=raw&id=<?php echo $donvi_id; ?>',
								success: function(data, textStatus, jqXHR) {
									$.unblockUI();
									$('#modal_tochuc').modal('hide');
									$('#phanhangdonvi-quatrinh').html(data);
								}
							});
						} else
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
					}
				});
            }
        });


        //Xóa file

        $('.btn_remove_soqd').on('click', function() {
			if (!confirm('Bạn có chắc chắn xóa tập tin này?')) {
				return false;
			} else {
				var idFile = $(this).data('code');
				$.ajax({
					type: "POST",
					url: "<?php echo Uri::root(true) ?>/index.php?option=com_tochuc&controller=tochuc&task=deletefilevanban",
					data: {
						idFile: idFile
					},
					beforeSend: function() {
						$.blockUI();
					},
					success: function(data) {
						if (data == '1') {
							loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công.');
							$('#li_' + idFile).remove();
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