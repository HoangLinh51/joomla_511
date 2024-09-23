<?php

/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-08-07 09:14:13
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-09-23 16:09:13
 * @ Description:
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>
<form class="form-horizontal row-fluid" name="frmThanhLap" id="frmThanhLap" method="post" action="<?php echo Route::_('index.php?option=com_tochuc&controller=tochuc&task=savethanhlap') ?>" enctype="multipart/form-data">
    <input type="hidden" value="" name="id" id="id">
    <input type="hidden" value="" name="parent_id" id="parent_id">
    <input type="hidden" value="" name="type" id="type">
    <div class="">
        <div class="card-header">
            <h3 class="card-title" style="vertical-align: middle;padding-top: 10px;">Nghiệp vụ đổi tên</h3>
            <div class="card-tools" style="margin: unset;">
                <div class="btn-group" id="">
                    <?php //if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'edit', 'location' => 'site', 'non_action' => 'false'))) { 
                    ?>
                    <a href="<?php echo Uri::root(true); ?>/index.php/component/tochuc/?view=tochuc&task=thanhlap&id=<?php echo $this->row->id; ?>" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Lưu</a>
                    <?php //} 
                    ?>
                </div>
                <?php //if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'deletedept', 'location' => 'site', 'non_action' => 'false'))) { 
                ?>
                <a id="btnQuayve" href="<?php echo Uri::root(true); ?>/index.php/component/tochuc/?view=tochuc&task=default" class="btn btn-danger btn-back"><i class="fa fa-undo"></i> Quay về</a>
                <?php //} 
                ?>
            </div>
        </div>

        <div class="tab-content card-body">
            <div id="COM_TOCHUC_THANHLAP_TAB1" class="tab-pane active" style="min-width:1000px;">
                <fieldset>
                    <div>
                        <p class="lead mb-0">Thông tin chung</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="name">Tên phòng cũ <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="" readonly name="name" id="name" class="form-control rounded-0 validNamePhong">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="control-label" for="s_name">Tên phòng mới <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="" name="s_name" id="s_name" class="form-control rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group div_upload">
                                    <label for="vanban_created_mahieu">Số quyết định <span class="required">*</span></label>
                                    <div class="form-group input-group div_upload">
                                        <input type="text" class="form-control rounded-0" id="vanban_created_mahieu" name="vanban_created[mahieu]">
                                        <span class="input-group-btn">
                                            <input type="file" name="files" id="fileupload_quatrinh" />
                                            <label class="btn btn-primary btn-flat" for="fileupload_quatrinh">Chọn tệp</label>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày quyết định <span class="required">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control rounded-0" id="ngaybanhanh" name="vanban_created[ngaybanhanh]" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" class="fileupload_quatrinh_list dropzone dropzone-multi row">
                            <div class="dropzone-items col-md-6">
                                <div class="dropzone-item">
                                    <!--begin::File-->
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename" id="fileupload_quatrinh_list" title="some_image_file_name.jpg"></div>
                                        <div class="dropzone-error" data-dz-errormessage></div>
                                    </div>
                                    <!--end::File-->


                                    <!--begin::Toolbar-->
                                    <!-- <div class="dropzone-toolbar">
                                        <span class="dropzone-delete" data-dz-remove><i class="fa fa-times"></i></span>
                                    </div> -->
                                    <!--end::Toolbar-->
                                </div>
                            </div>
                        </div>
                        
                       <!--  <div style="display: none;" class="fileupload_quatrinh_list dropzone dropzone-multi row">
                            <div class="dropzone-items col-md-6">
                                <div class="dropzone-item">
                                    <div id="fileupload_quatrinh_list" class="dropzone-file"></div>
                                </div>
                            </div>
                        </div> -->
                        <!--   <div class="row" data-select2-id="30">
                            <div class="col-md-6">
                                <div class="<?php //echo $this->iddiv; 
                                            ?> dropzone dropzone-multi col-lg-8"></div>
                                <?php //echo Core::inputAttachmentOneFile('attactment_doiten', null, 1, date('Y'), -1) 
                                ?>
                            </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-6" data-select2-id="30">
                            <div class="form-group" data-select2-id="29">
                                <label for="type_created" for="vanban_created_mahieu">Cơ quan ra quyết định <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="" name="vanban_created[mahieu]" id="vanban_created_mahieu" class="form-control rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày hiệu lực <span class="required">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control rounded-0" id="ngaybanhanh" name="vanban_created[ngaybanhanh]" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <div class="controls">
                                    <textarea type="text" value="" name="vanban_created[mahieu]" id="vanban_created_mahieu" class="form-control rounded-0"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </fieldset>

            </div>


        </div>

    </div>


    <input type="hidden" name="action_name" id="action_name" value="">
    <input type="hidden" name="is_valid_name" id="is_valid_name" value="">
    <input type="hidden" id="is_valid_code">
    <?php echo HtmlHelper::_('form.token'); ?>

</form>
<script type="text/javascript">
    function deleteFileById(id,url){
        if(confirm('Bạn có muốn xóa không?')){
            jQuery.ajax({
                type: "DELETE",
                url: url,
                success: function (data,textStatus,jqXHR){
                        var element = document.getElementById('file_'+id);
                        var element_class = document.getElementsByClassName('fileupload_quatrinh_list');
                        for (var i = 0; i < element_class.length; i++) {
                            element_class[i].style.display = 'none';
                        }
                        element.parentNode.removeChild(element);
                }
            });
        }
        return false;
    }
    jQuery(document).ready(function($) {
        $('#fileupload_quatrinh').fileupload({
            url: '<?php echo Uri::root(true) ?>/uploader/index.php',
            dataType: 'json',
            formData: {
                created_by: '<?php echo $user->id; ?>'
            },
            done: function(e, data) {
                $.each(data.result.files, function(index, file) {
                    console.log(file.id)
                    if (file.id > 0) {

                        $('.fileupload_quatrinh_list').removeAttr('style');
                        $('.fileupload_quatrinh_list').css('margin-bottom', '1rem');
                        $('#fileupload_quatrinh_list').html('<li id="file_' + file.id + '" ><input type="hidden" name="fileupload_id[]" value="' + file.id + '"><a href="' + file.url + '" target="_blank">' + file.filename + '</a><a style="float: right;vertical-align: middle;padding-top: 5px;" onclick="deleteFileById('+file.id+',\''+file.deleteUrl+'\')" class="dropzone-toolbar" href="javascript:void(0);"><i class="fa fa-times"></i></a></li>');
                        // $('#fileupload_quatrinh_list').html('<li id="file_' + file.id + '" ><input type="hidden" name="fileupload_id[]" value="' + file.id + '"><a onclick="deleteFileById(' + file.id + ',\'' + file.deleteUrl + '\')" href="javascript:void(0);"></a> <a href="' + file.url + '" target="_blank">' + file.filename + '</a>');
                        // <div style="float:right;" class="dropzone-toolbar"><span class="dropzone-delete" data-dz-remove><a onclick="deleteFileById(' + file.id + ',\'' + file.deleteUrl + '\')" href="javascript:void(0);"></a> <i class="fa fa-times"></i></span></div>
                        $('#fileupload_quatrinh_list').css('margin-top', '0px');
                        $('.div_upload').css('margin-bottom', '0px');
                    }
                });
            }
        });
        $('#type_created').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        $('#vanban_createdcoquan_banhanh_id').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        $('#ins_created').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        var toggleInputTrangthai = function(val) {
            if (val == 1) {
                $(".trangthai").hide();
            } else {
                $(".trangthai").show();
            }
        };
        $('#active').change(function() {
            toggleInputTrangthai(this.value);
        });
        var initPage = function() {
            $('#type_created').val('<?php echo $this->row->type_created > 0 ? $this->row->type_created : 1; ?>');
            toggleInputTrangthai($('#active').val());
            $('#btnThanhlapSubmitAndClose').unbind('click');
            $('#btnThanhlapSubmitAndNew').unbind('click');
        };
        initPage();



    }); // end document.ready
</script>
<style type="text/css">
    .required {
        color: red;
    }

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

    #fileupload_quatrinh_list>li {
        list-style: none !important;
    }
</style>