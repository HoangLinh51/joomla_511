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
                            <?php }?>
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
                                <a class="dropdown-item" href="index.php?option=com_tochuc&controller=tochuc&task=orderup&id=<?php echo $this->row->id; ?>"><i class="fa fa-share-square"></i> Lưu và Tiếp tục</a>
                                <a class="dropdown-item" href="index.php?option=com_tochuc&controller=tochuc&task=orderdown&id=<?php echo $this->row->id; ?>"><i class="fas fa-save"></i>  Lưu và Thêm mới</a>
                                <a class="dropdown-item" href="index.php?option=com_tochuc&controller=tochuc&task=orderdown&id=<?php echo $this->row->id; ?>"><i class="far fa-save"></i>  Lưu và Đóng</a>

                            </div>
                        </div>
                        <a class="btn btn-small btn-info" href="<?php echo '/index.php?option=com_tochuc&controller=tochuc&task=default&Itemid='.$this->Itemid; ?>">
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
                                <input type="text"  value="<?php echo Core::loadResult('ins_dept', array('name'), array('id = '=>$this->row->parent_id)); ?>" name="parent_name" id="parent_name" readonly="readonly" class="form-control rounded-0 validNameTochuc">
                                <div class="input-group-append">
                                    <span class="input-group-text" data-target="#tochuc-parent-tree_detail" data-toggle="collapse"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                            <div id="tochuc-parent-tree_detail" class="collapse">									
                                    <div id="tochuc-parent-tree"></div>			
                            </div>	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="name">Loại<span class="required">*</span></label>
                        <div class="controls">
                            <select class="form-control rounded-0" style="width: 100%;" id="type_content" name="type_content" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="1">Tổ chức</option>
                                <option value="0">Phòng</option>
                                <option value="3">Tổ chức hoạt động như phòng</option>
                                <option value="2">Vỏ chứa</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="myTab4">
                                <li class="nav-item"><a class="nav-link active" data-tab-url="" href="#info" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB1">Thông tin chung</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB2">Lịch sử tổ chức</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Biên chế</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Khen thưởng kỷ luật</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Giao ước thi đua</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Phân hạng đơn vị</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Quy định cấp phó</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane" id="tab_danhsachnangngachcc"></div>
                                    <div id="info" class="tab-pane active">
                                        <div class="">
                                            <!-- Bắt đầu HTML Thông tin tổ chức -->
                                            <fieldset>
                                                <div class="">
                                                    <p class="lead mb-0">Thông tin tổ chức</p>
                                                </div>
                                                <div class="tab-custom-content">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group" style="">
                                                            <label class="control-label" for="name">Tên tổ chức <span class="required">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" style="" value="" name="name" id="name" class="form-control rounded-0 validNameTochuc">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group" style="">
                                                            <label class="control-label" for="s_name">Tên viết tắt <span class="required">*</span></label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" name="s_name" id="s_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group" style="">
                                                            <label class="control-label" for="eng_name">Tên tiếng Anh</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="eng_name" name="eng_name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group" style="">
                                                            <label class="control-label" for="name_dieudong">Tên hiển thị điều động <span class="required">*</span></label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" style="" value="" name="name_dieudong" id="name_dieudong">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group" style="">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" checked="">
                                                                <label for="customCheckbox2" class="custom-control-label">Có/ Không cấp mã số tổ chứ</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12" data-select2-id="30">
                                                            <div class="form-group" data-select2-id="29">
                                                                <label>Loại đơn vị</label>
                                                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                    <option selected="selected" data-select2-id="3">Alabama</option>
                                                                    <option data-select2-id="35">Alaska</option>
                                                                    <option data-select2-id="36">California</option>
                                                                    <option data-select2-id="37">Delaware</option>
                                                                    <option data-select2-id="38">Tennessee</option>
                                                                    <option data-select2-id="39">Texas</option>
                                                                    <option data-select2-id="40">Washington</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="masothue">Mã số thuế</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" name="masothue" id="masothue">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="masotabmis">Mã số Tabmis</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="masotabmis" name="masotabmis">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="diachi">Địa chỉ <span class="required">*</span></label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" name="diachi" id="diachi">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="dienthoai">Điện thoại</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" name="dienthoai" id="dienthoai">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="email">Email</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="email" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="fax">Fax</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="fax" name="fax">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="date_created">Ngày thành lập</label>
                                                            <div class="controls">
                                                                <div class="input-append">
                                                                    <input class="input-small input-mask-date form-control rounded-0" type="text" value="" id="date_created" name="date_created">
                                                                    <span class="add-on">
                                                                        <i class="icon-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label" for="phucapdacthu">Phụ cấp đặc thù</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="phucapdacthu" name="phucapdacthu">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="control-label" for="website">Website tổ chức</label>
                                                            <div class="controls">
                                                                <input class="form-control rounded-0" type="text" value="" id="website" name="website">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="control-label" for="chucnang">Chức năng nhiệm vụ</label>
                                                            <div class="controls">
                                                                <textarea class="form-control rounded-0" name="chucnang"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        <!-- Kết thúc HTML Thông tin tổ chức -->
                                        <!-- Bắt đầu HTML Thông tin Đơn vị/ Phòng ban -->
                                        <fieldset>
                                            <div class="">
                                                <p class="lead mb-0">Thông tin thành lập</p>
                                            </div>
                                            <div class="tab-custom-content">
                                                <div class="row">
                                                    <div class="col-md-6" data-select2-id="30">
                                                        <div class="form-group" data-select2-id="29">
                                                            <label>Cách thức thành lập</label>
                                                            <select id="cachthucthanhlap" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                <option selected="selected" data-select2-id="3">Alabama</option>
                                                                <option data-select2-id="35">Alaska</option>
                                                                <option data-select2-id="36">California</option>
                                                                <option data-select2-id="37">Delaware</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Cơ quan ban hành</label>
                                                            <select id="coquanbanhanh" class="form-control select2 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                                                                <option selected="selected">Alabama</option>
                                                                <option>Alaska</option>
                                                                <option>California</option>
                                                                <option>Delaware</option>
                                                                <option>Tennessee</option>
                                                                <option>Texas</option>
                                                                <option>Washington</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Cơ quan chủ quản</label>
                                                            <select id="coquanchuquan" class="form-control select2 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                                                                    <option selected="selected">Alabama</option>
                                                                    <option>Alaska</option>
                                                                    <option>California</option>
                                                                    <option>Delaware</option>
                                                                    <option>Tennessee</option>
                                                                    <option>Texas</option>
                                                                    <option>Washington</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Cấp đơn vị <span class="required">*</span></label>
                                                            <select id="capdonvi" class="form-control select2 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                                                                    <option selected="selected">Alabama</option>
                                                                    <option>Alaska</option>
                                                                    <option>California</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="">Số Quyết định</label>
                                                        <div class="controls">
                                                            <input class="form-control rounded-0" type="text" value="" name="vanban_created[mahieu]" id="vanban_created_mahieu">
                                                            <ul class="files unstyled spaced"></ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Date masks:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control rounded-0" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group" style="">
                                                        <label class="control-label" for="vanban_created_mahieu">Các quyết định liên quan</label>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="quyetdinhlienquan">
                                                            <label for="quyetdinhlienquan" class="custom-control-label">Có/ Không có quyết định liên quan</label>
                                                        </div>
                                                    </div>
                        
                                                </div>

                                                <div id="actions" class="div_quyetdinhlienquan row"  style="display: none;">
                                                    <div class="col-lg-6">
                                                        <div class="btn-group w-100">
                                                            <span class="btn btn-success col fileinput-button dz-clickable">
                                                                <i class="fas fa-plus"></i>
                                                                <span>Add files</span>
                                                            </span>
                                                            <button type="reset" class="btn btn-warning col cancel">
                                                                <i class="fas fa-times-circle"></i>
                                                                <span>Cancel upload</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 d-flex align-items-center">
                                                        <div class="fileupload-process w-100">
                                                            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="opacity: 0;">
                                                                <div class="progress-bar progress-bar-success" style="width: 100%;" data-dz-uploadprogress=""></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="div_quyetdinhlienquan pull-right" style="display: none;">
                                                            <div class="controls">
                                                                <table style="width:100%" class="table table-striped table-bordered table-hover" id="tbl_quyetdinhkemtheo">
                                                                    <tr>
                                                                        <th style="width:1%">#</th>
                                                                        <th>Số QĐ</th>
                                                                        <th>Ngày ban hành</th>
                                                                        <th>Cơ quan ban hành</th>
                                                                        <th>Đính kèm</th>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <!-- Kết thúc HTML Thông tin Đơn vị/ Phòng ban -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_tochuc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width: 900px; left: 35%; display: none;">
	<div id="div_modal" class="modal-dialog modal-lg">
	</div>
</div>
<script>
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
	

        $('#quyetdinhlienquan').on('change', function(){
            if(this.checked) {
                $('.div_quyetdinhlienquan').css('display','block');  // show the div
            } else {
                $('.div_quyetdinhlienquan').css('display','none');  // show the div
            }
        });
        var root_id = <?php echo ($this->row->id)?$this->row->id:0;?>;
        var parent_id = <?php echo ($this->row->parent_id)?$this->row->parent_id:0;?>;
        console.log()
        $('#tochuc-parent-tree').jstree({
                "core":{		  		
                    "data":<?php echo TochucHelper::getOneNodeJsTree((int) Core::getManageUnit($user_id, 'com_tochuc', 'tochuc', 'thanhlap'));?>,				  			
                    "data" : {
					    'url': 'index.php?option=com_tochuc&view=treeview&format=raw&task=treetochuc',
                        'data': function(node) {	
                            console.log(node);
                            return {
                                'checked' : root_id,
                                "parent_id": parent_id,
                                "id" :  node['li_attr'] ? node['li_attr']['id'].replace("node_", "") : root_id,
                            };  
                        }
                    }
                },	
                "checkbox":{
                    "override_ui":false,
                    "two_state":true
                },
                'types': {
                    "valid_children" : [ "root" ],
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
                    "disabled" : {
					    "check_node" : false, 
					    "uncheck_node" : false 
                    },
                    "default" : {
						"valid_children" : [ "default" ]
					},
                    "default" : { 
                        "check_node" : function (node) {
                        $('#tochuc-parent-tree').jstree('uncheck_all');
                            return true;
                        },
                        "uncheck_node" : function (node) {
                            return true;
                        }
                    }
                    
                },
                "themes": {
                        "responsive": true
                },
                "plugins": ["themes", "json_data", "ui","types", "state","cookies", "checkbox"] 
            }).bind("open_node.jstree", function (e, data) {	
                if (data.node.type === 'root') {
                    data.instance.set_icon(data.node, 'fa fa-folder-open text-warning');
                }
            }).bind("close_node.jstree", function (e, data) {
                if (data.node.type === 'root') {
                    data.instance.set_icon(data.node, 'fa fa-folder text-warning');
                }
            }).bind("loaded.jstree", function (event, data) {
                var curr_id = $('#parent_id_content').val();
                $.jstree.reference('#tochuc-parent-tree').check_node(curr_id);
            }).bind("select_node.jstree", function (event, data) {
                data.instance.toggle_node(data.node);
                // var id = data.node.id;
                // dept_id = id;		
                // var selectedNodes = data.selected;
        });

        var buildForm = function(type_id){
			var url = 'index.php?option=com_tochuc&controller=tochuc&task=edittochuc&format=raw';
			var parent_id = <?php echo (int)$this->row->parent_id;?>;
			// var htmlLoading = '<i class="icon-spinner icon-spin blue bigger-125"></i>';
			if(type_id == '1'){
				url='<?php echo Uri::root(true)?>/index.php?option=com_tochuc&controller=tochuc&task=edittochuc&format=raw&type='+type_id;	
			}else if(type_id == '0'){
				url='<?php echo Uri::root(true)?>/index.php?option=com_tochuc&controller=tochuc&task=editphong&format=raw&type='+type_id+'&parent_id='+parent_id;	
			}
			else if(type_id == '2'){
				url='<?php echo Uri::root(true)?>/index.php?option=com_tochuc&controller=tochuc&task=editvochua&format=raw&type='+type_id;	
			}
			else{
				url='<?php echo Uri::root(true)?>/index.php?option=com_tochuc&controller=tochuc&task=edittochuc&format=raw&type='+type_id;	
			}
			jQuery.ajax({
				  type: "GET",
				  url: url,
				  data:{"id":<?php echo (int)$this->id;?>},
				  beforeSend: function(){
					  // $.blockUI();
					  $('#content_form').empty();
					},
				  success: function (data,textStatus,jqXHR){
					  $.unblockUI();
					  $('#content_form').html(data);
				  }
			});	
		}
		$('#type_content').change(function(event){
			event.preventDefault();
			var that = $(this);
			//console.log(that.val());
			buildForm(that.val());
		});
		buildForm($('#type_content').val());

	});
</script>
<style>
.dropdown-item:focus, .dropdown-item:hover {
    color: #16181b;
    text-decoration: none;
    background-color: #e2f1ff;
}    
</style>
<style>
.select2-container--default .select2-selection--single .select2-selection__arrow{
    height: calc(2.25rem + 2px) !important;
}
.select2-container .select2-selection--single{
    height: calc(2.25rem + 2px);
    border-radius:0px !important
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 27px !important;
    padding-left:0px !important
}
</style>