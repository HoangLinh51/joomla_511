<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\Decentralization\Administrator\View\Actions\HtmlView;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>
<form class="form-horizontal row-fluid" name="frmThanhLap" id="frmThanhLap" method="post" action="" enctype="multipart/form-data">


    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="myTab3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB1">Thông tin chung</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB2">Thông tin thêm</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Cấu hình báo cáo</a></li>
            </ul>
            <div class="tab-content card-body">
                <div id="COM_TOCHUC_THANHLAP_TAB1" class="tab-pane active" style="">
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
                                <div class="col-md-6">
                                    <label>Cấp đơn vị <span class="required">*</span></label>
                                    <select id="capdonvi" class="form-control select2 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Alabama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                    </select>
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
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric">
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
                                    <label class="control-label" for="">Lĩnh vực</label>
                                    <div class="controls" style="display: grid;">
                                        <div id="html1">
                                            <?php
                                                $inArray = Core::loadAssocList('cb_type_linhvuc', array('id','name','level', 'parent_id'),array('type='=>2),'lft'); 
                                                // // var_dump($inArray);exit;  
                                                $tree = TochucHelper::buildTree($inArray);
                                                $jsTreeData = json_encode(TochucHelper::convertToJsTreeFormat($tree));

                                                // var_dump($tree);exit;
                                                //TochucHelper::printTree($tree);
                                                //echo TochucHelper::buildTreeHtml('','cb_type_linhvuc', array('id','name','level', 'parent_id'),'type=2','lft',$current_depth = 1); 
                                            ?>
                                        </div>   
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gói biên chế</label>
                                        <div class="">
                                        <?php
                                            $arrTemp = Core::loadAssocList('bc_goibienche', array("id as value","name AS text"),array('active = '=>1),'id');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goibienche', array('class'=>'goibienche','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goibienche);
                                        ?>                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gói chức vụ</label>
                                        <div class="">
                                        <?php								
                                            $arrTemp = Core::loadAssocList('cb_goichucvu', array("id as value","CONCAT(REPEAT('--',level), name, ' (',(select count(*) from cb_goichucvu_chucvu a where a.goichucvu_id = id), ')') AS text"),array('lft >'=>0,'status = '=>1),'lft');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goichucvu', array('class'=>'chzn-select','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goichucvu);
                                        ?>                                       
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gói lương</label>
                                        <div class="">
                                        <?php								
                                            $arrTemp = Core::loadAssocList('cb_goiluong', array("id as value","CONCAT(REPEAT('--',level), name) AS text"),array('lft >'=>0,'status = '=>1),'lft');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goiluong', array('class'=>'chzn-select','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goiluong);
                                        ?>                                      
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gói đào tạo</label>
                                        <div class="">
                                        <?php								
                                            $arrTemp = Core::loadAssocList('cb_goidaotaoboiduong', array("id as value","name AS text"),array('status = '=>1),'name');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goidaotao', array('class'=>'chzn-select','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goidaotao);
                                        ?>	                                      
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gói hình thức hưởng lương</label>
                                        <div class="">
                                        <?php								
                                            $arrTemp = Core::loadAssocList('cb_goihinhthuchuongluong', array("id as value","name AS text"),array('status = '=>1),'name');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goihinhthuchuongluong', array('class'=>'chzn-select','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goihinhthuchuongluong);
                                        ?>                                      
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gói vị trí việc làm</label>
                                        <div class="">
                                        <?php								
                                            $arrTemp = Core::loadAssocList('cb_goivitrivieclam', array("id as value","CONCAT(REPEAT('--',level), name) AS text"),array('lft >'=>0,'status = '=>1),'lft');
                                            $arrTemp = array_merge(array(array('value'=>'','text'=>'')),$arrTemp);
                                            echo HTMLHelper::_('select.genericlist',$arrTemp,'goivitrivieclam', array('class'=>'chzn-select','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->goivitrivieclam);
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
                            // for ($i = 0; $i < count($caybaocao); $i++) {
                            // ?>
                            // <div class="row-fluid">	
                            //     <div class="control-group">
                            //         <div class="controls">
                            //             <!-- <input type="hidden" name="chkrep_hc_name" value="0"> -->
                            //             <label>
                            //                 <input type="checkbox" name="report_group_code[]" <?php echo $caybaocao[$i]['checked']; ?> class="report_group_code" value="<?php echo $caybaocao[$i]['report_group_code']?>"><span class="lbl">&nbsp;&nbsp; <?php echo $caybaocao[$i]['name']?></span>
                            //             </label>
                            //         </div>
                            //     </div>
                            // </div>
                            <?php //} ?>
                        </div>
                    </fieldset>
                </div>
                <!-- Đóng Thẻ 3 -->


            </div>
        </div>
    </div>
    <input type="hidden" name="action_name" id="action_name" value="">
    <input type="hidden" name="is_valid_name" id="is_valid_name" value="">
    <input type="hidden" id="is_valid_code">
</form>
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
    // $('#goibienche').select2({
    //     width: "100%"
    // });

    $('#quyetdinhlienquan').on('change', function(){
        if(this.checked) {
            $('.div_quyetdinhlienquan').css('display','block');  // show the div
        } else {
            $('.div_quyetdinhlienquan').css('display','none');  // show the div
        }
    });
    var treeData = <?php echo $jsTreeData; ?>;
    jQuery('#html1').jstree({
        "plugins" : [
            "checkbox",
            "contextmenu",
            "types",
            "conditionalselect"
        ],
            'core': {
            'data': treeData
        }
    }).on('loaded.jstree', function(){
        // jQuery('#html1').jstree('open_all')
    });
});
</script>
<style>
.select2-container--default .select2-selection--single .select2-selection__arrow{
    height: calc(2.25rem + 2px) !important;
}
.select2-container .select2-selection--single{
    height: calc(2.25rem + 2px);
    border-radius:0px !important
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 33px !important;
    padding-left:0px !important
}
</style>