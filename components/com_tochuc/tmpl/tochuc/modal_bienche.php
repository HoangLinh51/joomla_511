<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
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
<form class="form-horizontal" id="frmQuaTrinhBienche" name="frmQuaTrinhBienche" method="post">

    <?php echo HTMLHelper::_('form.token'); ?>
    <input type="hidden" name="dept_id" value="<?php echo $this->dept_id; ?>">
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" id="quatrinh_id">
    <input type="hidden" name="vanban_id" value="<?php echo $this->item->vanban_id; ?>" id="vanban_id">
    <div class="overlay" style="display: none;">
        <i class="fas fa-2x fa-sync fa-spin"></i>
    </div>
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
                                <input type="text" autocomplete="off" class="form-control rounded-0" name="nam" id="nam" value="<?php echo $this->item->nam ?>" />
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
                            <?php 
                            $k=0;
                            for ($i = 0; $i < count($this->hinhthuc_bienche); $i++) {
                                $htbienche = $this->hinhthuc_bienche[$i];
                            ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bienche"><?php echo $htbienche['name'];?></label>
                                    <div class="input-group">
                                        <input type="hidden" name="hinhthuc[]" value="<?php echo $htbienche['id'];?>" >
                                        <input value="<?php echo (int)$htbienche['bienche'] ?>" type="text" autocomplete="off" class="form-control rounded-0" id="bienche" name="bienche[]">
                                    </div>
                                </div>
                            </div>

                            <?php
                             
                            } 
                            ?>
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
                                        <input value="<?php echo (int)$htbienche['quyetdinh_so'] ?>" type="text" autocomplete="off" class="form-control rounded-0" id="quyetdinh_so" name="quyetdinh_so">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quyetdinh_ngay">Ngày quyết định</label>
                                    <div class="input-group">
                                        <input value="<?php if($this->item->quyetdinh_ngay != '') echo date('d/m/Y', strtotime($this->item->quyetdinh_ngay )) ?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="quyetdinh_ngay" name="quyetdinh_ngay">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hieuluc_ngay">Ngày hiệu lực</label>
                                    <div class="input-group">
                                        <input value="<?php if($this->item->hieuluc_ngay != '') echo date('d/m/Y', strtotime($this->item->hieuluc_ngay )) ?>" type="text" autocomplete="off" class="form-control rounded-0 datepicker" id="hieuluc_ngay" name="hieuluc_ngay">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo Core::inputAttachmentOneFile('attactment_bienche', null, 1, date('Y'), -1) ?>
                            <?php
                            for ($i = 0, $n = count($this->files); $i < $n; $i++) {
                                $item = $this->files[$i];
                                $file =  $item['folder'].'/'.$item['code'];
		                        $fileSizeMB = round( filesize($file) / 1024, 2);
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ghichu">Ghi chú</label>
                                    <div class="input-group">
                                        <textarea  autocomplete="off" class="form-control rounded-0" id="ghichu" name="ghichu"><?php echo $this->item->ghichu  ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
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
    .modal{
        padding-right: 0px !important;
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
        $('#frmQuaTrinhBienche').validate({
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
                            const label = getTextLabel($(error.element).attr("name")).replace(/\*/g, '');
                            errors += "<br/>\u25CF " + validator.errorList[x].message + `<b>${label}</b>`;
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
			  'nam':{
				  required: true,
			  },
			  'nghiepvu_id':{
				  required: true 
			  },
			  'quyetdinh_ngay': {
		    	  required: true,
		      },
		      'bienche[]':{
				  required: true,
				  number: true
			  },
		    }, 
            messages: {
                'nam': {
					required: "Vui lòng nhập",
				},
				'nghiepvu_id': {
					required: "Vui lòng chọn",
				},
				'quyetdinh_ngay': {
					required: "Vui lòng nhập",
				},
				'bienche[]': {
					required: "Vui lòng nhập",
					number: "Biên chế phải nhập số",
				},
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(){
			    var frmQuaTrinhBienche=$('#frmQuaTrinhBienche').serialize();
			$.ajax({
				type: 'POST',
	  			url: '<?php echo Uri::base(true);?>/index.php?option=com_tochuc&controller=tochuc&task=savegiaobienche&format=raw',
	  			data: {frmQuaTrinhBienche : frmQuaTrinhBienche, '<?php echo Session::getFormToken()?>': 1},
	  			success:function(data){
		  			if (data == true){
		  				
		  				$.blockUI();
		  				jQuery.ajax({
			  				  type: "GET",
			  				  url: 'index.php?option=com_tochuc&view=tochuc&task=giaobienche&format=raw&Itemid=<?php echo $this->Itemid;?>&id=<?php echo $this->dept_id;?>',	
				  				success: function (data,textStatus,jqXHR){
					  				$.unblockUI();
					  				$('#modal_tochuc').modal('hide');
                                    loadNoticeBoardSuccess('Thông báo', 'Thao tác thành công!');
					  				$('#bienche-quatrinh').html(data);
					  			  }
					  		});
			  		}
		  			else loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
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