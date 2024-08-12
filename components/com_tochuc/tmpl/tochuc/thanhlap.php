<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

defined('_JEXEC') or die('Restricted access');
$user = Factory::getUser();
$user_id = $user->id;
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

                <h4>
                    <span class="span6" id="tochuc_current">Quản lý tổ chức
                        <small><i class="fa fa-angle-double-right"></i> </small>
                        <?php if ((int)$this->row->id == 0) { ?>
                            Thành lập mới
                        <?php } else { ?>
                            Hiệu chỉnh
                        <?php } ?>
                        <?php echo $this->row->name; ?>
                    </span>
                </h4>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning">Hành động</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="#" id="btnThanhlapSubmitAndContinue"><i class="fa fa-share-square"></i> Lưu và Tiếp tục</a>
                                <a class="dropdown-item" href="#" id="btnThanhlapSubmitAndNew"><i class="fas fa-save"></i> Lưu và Thêm mới</a>
                                <a class="dropdown-item" href="#" id="btnThanhlapSubmitAndClose"><i class="far fa-save"></i> Lưu và Đóng</a>

                            </div>
                        </div>
                        <a class="btn btn-small btn-info" href="<?php echo '/index.php?option=com_tochuc&view=tochuc&task=default&Itemid=' . $this->Itemid; ?>">
                            <i class="fa fa-undo"></i> Quay về</a>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="content" style="padding-bottom:1px;">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label" for="name">Chọn tổ chức thuộc về<span class="required">*</span></label>
                        <div class="controls">
                            <input type="hidden" value="<?php echo $this->row->parent_id; ?>" name="parent_id_content" id="parent_id_content">
                            <div class="input-group my-colorpicker2 colorpicker-element" data-colorpicker-id="2">
                                <input type="text" value="<?php echo Core::loadResult('ins_dept', array('name'), array('id = ' => $this->row->parent_id)); ?>" name="parent_name" id="parent_name" readonly="readonly" class="form-control rounded-0 validNameTochuc">
                                <div class="input-group-append">
                                    <span class="input-group-text" data-target="#tochuc-parent-tree_detail" data-toggle="collapse" aria-expanded="false"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                            <div class="collapse" id="tochuc-parent-tree_detail" >
                                <div id="tochuc-parent-tree">ưeqwewq</div>
                            </div>
                        </div>
                    </div>
                    <!-- <script>
                         $('#tochuc-parent-tree_detail1').on('expanded.lte.cardwidget');
                    </script> -->
                    <div class="col-md-6">
                        <label class="control-label" for="name">Loại<span class="required">*</span></label>
                        <div class="controls">
                            <?php 
                            	echo TochucHelper::selectBoxNotOptionNull($this->row->type, array('name'=>'type_content', 'class' => 'form-control rounded-0'), 'ins_type', array('id','name')); 
                            ?>
                            <!-- <select class="form-control rounded-0" style="width: 100%;" id="type_content" name="type_content" data-select2-id="1" tabindex="-1" aria-hidden="false">
                                <option selected="selected" value="1">Tổ chức</option>
                                <option value="0">Phòng</option>
                                <option value="3">Tổ chức hoạt động như phòng</option>
                                <option value="2">Vỏ chứa</option>
                            </select> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="box" id="content_form"></div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="modal_tochuc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div id="div_modal" class="modal-dialog modal-lg"></div>
</div> -->
<div class="modal fade file_qdlienquan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div id="div_qllienquan" class="modal-dialog modal-lg"></div>
</div>

<script>
    var DataSourceTree = function(options) {
	    this._data 	= options.data;
	    this._delay = options.delay;
    }
    DataSourceTree.prototype.data = function(options, callback) {
        var self = this;
        var $data = null;

        if(!("name" in options) && !("type" in options)){
            $data = this._data;//the root tree
            callback({ data: $data });
            return;
        }
        else if("type" in options && options.type == "folder") {
            if("additionalParameters" in options && "children" in options.additionalParameters)
                $data = options.additionalParameters.children;
            else $data = {}//no data
        }
        
        if($data != null)//this setTimeout is only for mimicking some random delay
            setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 50) + 100);
        //if($data != null) callback({ data: $data });
    };
    jQuery(document).ready(function($) {
        $('#cachthucthanhlap').select2();
        $('#coquanbanhanh').select2();
        $('#coquanchuquan').select2();
        $('#capdonvi').select2();
        $('#goibienche').select2({
            width: "100%"
        });
        $('#goichucvu').select2({
            width: "100%"
        });
        $('#goiluong').select2({
            width: "100%"
        });
        $('#goidaotao').select2({
            width: "100%"
        });
        $('#goihinhthuchuongluong').select2({
            width: "100%"
        });
        $('#goivitrivieclam').select2({
            width: "100%"
        });


        $('#quyetdinhlienquan').on('change', function() {
            if (this.checked) {
                $('.div_quyetdinhlienquan').css('display', 'block'); // show the div
            } else {
                $('.div_quyetdinhlienquan').css('display', 'none'); // show the div
            }
        });
        var root_id = <?php echo ($this->row->id) ? $this->row->id : 0; ?>;
        var parent_id = <?php echo ($this->row->parent_id) ? $this->row->parent_id : 0; ?>;


        $('#tochuc-parent-tree').jstree({
            "plugins": ["themes", "json_data","checkbox", "ui","types", "wholerow"],
            "core": {
                "data": <?php echo TochucHelper::getOneNodeJsTree((int) Core::getManageUnit($user_id, 'com_tochuc', 'tochuc', 'thanhlap')); ?>,
                "data": {
                    'url': 'index.php?option=com_tochuc&view=treeview&format=raw&task=treetochuc',
                    'data': function(node) {
                        return {
                            'checked': root_id,
                            "parent_id": parent_id,
                            "id": node['li_attr'] ? node['li_attr']['id'].replace("node_", "") : root_id,
                        };
                    }
                },
                check_callback: false
            },
            "checkbox": {
                "override_ui": false,
                "three_state": false,
                "tie_selection": false, 
                "real_checkboxes": true,
                'whole_node': false,
                'multiple': false,
            },
           
            'types': {
                "valid_children": ["root"],
                'root': {
                    'icon': 'fa fa-folder text-warning',
                    'valid_children': ['folder']
                },
                'folder': {
                    'icon': 'fa fa-folder text-primary',
                    'valid_children': ['file']
                },
                'file': {
                    'icon': 'fa fa-file',
                    'valid_children': []
                },
                "default": {
                    "valid_children": ["default"]
                },
                "disabled": {
                    "select_node": false,
                    "check_node": false,
                    "uncheck_node": false
                },
                "default": {
                    "check_node": function(node) {
                        $('#tochuc-parent-tree').jstree('uncheck_all');
                        return true;
                    },
                    "uncheck_node": function(node) {
                        return true;
                    }
                }

            } 
        }).bind("open_node.jstree", function(e, data) {
            if (data.node.type === 'root') {
                data.instance.set_icon(data.node, 'fa fa-folder-open text-warning');
            }
        }).bind("close_node.jstree", function(e, data) {
            if (data.node.type === 'root') {
                data.instance.set_icon(data.node, 'fa fa-folder text-warning');
            }
        }).bind("loaded.jstree", function(e, data) {
            var curr_id = $('#parent_id_content').val();
            $.jstree.reference('#tochuc-parent-tree').check_node("#node"+curr_id+"");
        }).bind("select_node.jstree", function (e, data) {

        }).bind("check_node.jstree", function(e, data) {
            
            var node_id = data.node.id.replace('node_','');
            var selectedNodes = $("#tochuc-parent-tree").jstree().get_checked();
            
			$('#parent_id_content').val(node_id);
            $('#parent_id_content').val(node_id);
            
            if (selectedNodes.length > 1) {
                $("#tochuc-parent-tree").jstree().uncheck_node(selectedNodes[0]);
            }
            $('#parent_name').val($.trim(data.node.text));
            if ($('#type_content').val() == '0') {
                $('#ins_created').val(node_id);
                $("#ins_created").trigger("chosen:updated");

            } else if ($('#type_content').val() == '1' || $('#type_content').val() == '3') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Uri::root(true) ?>/index.php?option=com_tochuc&controller=tochuc&task=generateMaxCodeTochuc",
                    success: function(data) {
                        $('#code').val(data);
                    }
                });
            }
            var showlist = data.node.li_attr.showlist;
          
            // Phòng
            if (showlist == '1' && $('#type_content').val() == '0') {
                console.log(showlist);
                $.ajax({
                    type: "POST",
                    url: "<?php echo Uri::root(true) ?>/index.php?option=com_tochuc&controller=tochuc&task=generateCodeTochucNew",
                    data: {
                        node_id: node_id
                    },
                    success: function(data) {
                        $('#code').val(data);
                    }
                });
            } else {
                $('#code').val('');
            }
            
        }).bind("uncheck_node.jstree", function(e, data) {
            var node_id = data.node.id;
            $('#parent_id_content').val('');
            $('#parent_name').val('');
            if ($('#type_content').val() == '0') {
                $('#code').val('');
                $('#ins_created').val(999999999);
                $("#ins_created").trigger("chosen:updated");
            }
        });
        

        var buildForm = function(type_id) {
            // Base URL for the AJAX request
            var baseUrl = '<?php echo Uri::root(true) ?>/index.php?option=com_tochuc&view=tochuc&format=raw';
            
            // Parent ID from PHP
            var parent_id = <?php echo (int)$this->row->parent_id; ?>;
            
            // Determine the URL based on the type_id
			var url = 'index.php?option=com_tochuc&view=tochuc&task=edit_tochuc&format=raw';
            switch (type_id) {
                case '1':
                    url = baseUrl + '&task=edit_tochuc&type=' + type_id;
                    break;
                case '0':
                    url = baseUrl + '&task=edit_phong&type=' + type_id + '&parent_id=' + parent_id;
                    break;
                case '2':
                    url = baseUrl + '&task=edit_vochua&type=' + type_id;
                    break;
                default:
                    url = baseUrl + '&task=edit_tochuc&type=' + type_id;
                    break;
            }
            
            // AJAX request
            jQuery.ajax({
                type: "GET",
                url: url,
                data: {
                    "id": <?php echo (int)$this->id; ?>
                },
                beforeSend: function() {
                    // Show loading indicator
                    // Pace.start();
                    $('#content_form').empty();
                    $('#content_form').html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
                },
                success: function(data, textStatus, jqXHR) {
                    // Update the content with the response
                    $('#content_form').html(data);
                    // Pace.stop();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle errors
                    $('#content_form').html('<p>Error loading form. Please try again later.</p>');
                    Pace.stop();
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            });
        };

        // Initialize form based on the current value
        buildForm($('#type_content').val());

        // Update form when type_content changes
        $('#type_content').change(function() {
            buildForm($(this).val());
        });

       

    });
</script>
<style>
    #tochuc-parent-tree{
        /* height: 280px; */
        overflow: auto;
        scrollbar-width: thin !important; 
    }
    .dropdown-item:focus,
    .dropdown-item:hover {
        color: #16181b;
        text-decoration: none;
        background-color: #e2f1ff;
    }
</style>
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px) !important;
    }

    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px);
        border-radius: 0px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 27px !important;
        padding-left: 0px !important
    }
    #tochuc-parent-tree a{
        display: inline;
        /* line-height: 16px;
        height: 16px; */
        color: black !important;
        text-decoration: none;
        /* padding: 1px 2px;
        margin: 0; */
	    white-space: normal !important;
	    scrollbar-width: thin !important; 
    } 
</style>