<?php

/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-08-07 09:14:13
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-08-27 15:33:22
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
                <?php //if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'edit', 'location' => 'site', 'non_action' => 'false'))) { ?>
                    <a href="<?php echo Uri::root(true);?>/index.php/component/tochuc/?view=tochuc&task=thanhlap&id=<?php echo $this->row->id; ?>" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Lưu</a>
                <?php //} ?>
            </div>
            <?php //if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'deletedept', 'location' => 'site', 'non_action' => 'false'))) { ?>
                <a id="btnQuayve" href="<?php echo Uri::root(true);?>/index.php/component/tochuc/?view=tochuc&task=default" class="btn btn-danger btn-delete"><i class="fa fa-undo"></i> Quay về</a>
            <?php //} ?>
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
                                <label class="control-label" for="name">Tên phòng <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="" name="name" id="name" class="form-control rounded-0 validNamePhong">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="control-label" for="s_name">Tên viết tắt <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="" name="s_name" id="s_name" class="form-control rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="control-label" for="s_name">Mã hiệu <span id="lbMahieu" class="required">*</span></label>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_checkmadonvi" checked="">
                                    <label for="is_checkmadonvi" id="label_madonvi" class="custom-control-label">Có/ Không cấp mã số tổ chứ</label>
                                </div>
                            </div>
                        </div>
                </fieldset>

                <fieldset>
                    <div>
                        <p class="lead mb-0">Thông tin thành lập</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                    <label for="type_created">Cách thức thành lập <span class="required">*</span></label>
                                    <?php
                                    $tableInsDeptCachthuc = Core::table('Tochuc/InsDeptCachthuc');
                                    $type_created = $tableInsDeptCachthuc->findAllCachThucThanhLap();
                                    $options = array();
                                    $option[] = array('id' => '', 'name' => '');
                                    $options = array_merge($option, $type_created);
                                    echo HTMLHelper::_('select.genericlist', $options, 'type_created', array('class' => 'form-control select2 select2-hidden-accessible', 'style' => 'width: 100%;'), 'id', 'name', '');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cơ quan ban hành</label>
                                    <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'vanban_created[coquan_banhanh_id]', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->vanban_created['coquan_banhanh_id']); ?>
                                    <input type="hidden" name="vanban_created[id]" id="vanban_created_id" value="<?php echo $this->vanban_created['id']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                    <label for="type_created" for="vanban_created_mahieu">Số quyết định</label>
                                    <div class="controls">
                                        <input type="text" value="" name="vanban_created[mahieu]" id="vanban_created_mahieu" class="form-control rounded-0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày ban hành</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control rounded-0" id="ngaybanhanh" name="vanban_created[ngaybanhanh]" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cơ quan chủ quản <span class="required">*</span></label>
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
    jQuery(document).ready(function($) {

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

        var toggleInputTrangthai = function(val){
            if(val == 1){			
                $(".trangthai").hide();
            }		
            else{
                $(".trangthai").show();
            }		
        };
        $('#active').change(function(){
            toggleInputTrangthai(this.value);
        });
        var initPage = function(){
            $('#type_created').val('<?php echo $this->row->type_created>0?$this->row->type_created:1;?>');
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
</style>