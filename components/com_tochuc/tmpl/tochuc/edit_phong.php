<?php

/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-08-07 09:14:13
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-08-10 10:33:08
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
    <input type="hidden" value="<?php echo $this->row->id; ?>" name="id" id="id">
    <input type="hidden" value="<?php echo $this->row->parent_id; ?>" name="parent_id" id="parent_id">
    <input type="hidden" value="<?php echo $this->row->type; ?>" name="type" id="type">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="myTab3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB1">Thông tin chung</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB2">Thông tin thêm</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Cấu hình báo cáo</a></li>
            </ul>
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
                                    <input type="text" value="<?php echo $this->row->name; ?>" name="name" id="name" class="form-control rounded-0 validNamePhong">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="control-label" for="s_name">Tên viết tắt <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="<?php echo $this->row->s_name; ?>" name="s_name" id="s_name" class="form-control rounded-0">
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
                                        <input type="text" value="<?php echo $this->row->s_name; ?>" name="vanban_created[mahieu]" id="vanban_created_mahieu" class="form-control rounded-0">
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
                                    <?php echo Core::inputAttachment('attactment_phong', null, 1, date('Y'), -1); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cơ quan chủ quản <span class="required">*</span></label>
                                    <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'ins_created', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->ins_created); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <!-- Thẻ 2 -->
            <div id="COM_TOCHUC_THANHLAP_TAB2" class="tab-pane">
                <fieldset class="input-tochuc">
                    <div class="">
                        <p class="lead mb-0">Thông tin thêm</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="ins_linhvuc">Lĩnh vực</label>
                                <div class="controls" style="display: grid;">
                                    <input type="hidden" id="ins_linhvuc" name="ins_linhvuc" />
                                    <div id="tree_linhvuc">
                                        <?php
                                        $inArray = Core::loadAssocList('cb_type_linhvuc', array('id', 'name', 'level', 'parent_id'), array('type=' => 1), 'lft');
                                        $tree = TochucHelper::buildTree($inArray);
                                        $jsTreeData = json_encode(TochucHelper::convertToJsTreeFormat($tree));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- Đóng Thẻ 2 -->

            <!-- Thẻ 3 -->
            <div id="COM_TOCHUC_THANHLAP_TAB3" class="tab-pane">
                <fieldset class="input-tochuc">
                    <div class="">
                        <p class="lead mb-0">Bổ sung đơn vị vừa tạo vào cấu hình báo cáo</p>
                    </div>
                    <div class="tab-custom-content">
                        <?php
                        $caybaocao = $this->caybaocao;
                        for ($i = 0; $i < count($caybaocao); $i++) {

                        ?>
                            <div class="form-group">
                                <div class="checkbox icheck-primary">
                                    <input name="report_group_code[]" type="checkbox" <?php echo $caybaocao[$i]['checked']; ?> value="<?php echo $caybaocao[$i]['report_group_code'] ?>" id="primary_<?php echo $i + 1 ?>" />
                                    <label for="primary_<?php echo $i + 1 ?>"><span class="lbl">&nbsp;&nbsp; <?php echo $caybaocao[$i]['name'] ?></span></label>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </fieldset>
            </div>
            <!-- Đóng Thẻ 3 -->
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

        var treeData = <?php echo $jsTreeData; ?>;
        jQuery('#tree_linhvuc').jstree({
            "plugins" : [
                "checkbox",
                "contextmenu",
                "types",
                "conditionalselect"
            ],
            'core': {
                'data': treeData
            },
            "checkbox": {
                "override_ui": false,
                "three_state": false,
            },
        }).on('loaded.jstree', function(){
        }).on('changed.jstree', function (e, data) {
            var selectedNodes = data.selected.join(',');
            $('#ins_linhvuc').val(selectedNodes);
        });

    }); // end document.ready
</script>