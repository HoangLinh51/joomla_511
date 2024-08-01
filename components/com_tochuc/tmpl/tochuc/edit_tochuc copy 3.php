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
                                        <?php 
                                            $tableInsDeptCachthuc = Core::table('Tochuc/InsDeptCachthuc');
                                            $type_created = $tableInsDeptCachthuc->findAllCachThucThanhLap();
                                            $options = array();
                                            $option[] = array('id'=>'','name'=>'');
                                            $options = array_merge($option,$type_created);
                                            echo HTMLHelper::_('select.genericlist',$options,'type_created', array('class'=>'form-control select2 select2-hidden-accessible', 'style'=>'width: 100%;'),'id','name','');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cơ quan ban hành</label>
                                        <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'vanban_created[coquan_banhanh_id]', array('class'=>'form-control select2 select2-hidden-accessible','data-placeholder'=>"Hãy chọn..."),'value','text',$this->vanban_created['coquan_banhanh_id']);?>
                                        <input type="hidden" name="vanban_created[id]" id="vanban_created_id" value="<?php echo $this->vanban_created['id'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cơ quan chủ quản</label>
                                        <?php echo HTMLHelper::_('select.genericlist',$this->arr_ins_created,'ins_created', array('class'=>'form-control select2 select2-hidden-accessible','data-placeholder'=>"Hãy chọn..."),'value','text',$this->row->ins_created);?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cấp đơn vị <span class="required">*</span></label>
                                        <input type="hidden" name="ins_cap" id="ins_cap" value="<?php echo $this->row->ins_cap; ?>">
                                        <div class="input-group date" id="" data-target-input="nearest">
                                            <input type="text" id="ins_cap_name" name="ins_cap_name" class="form-control rounded-0"  value="<?php echo Core::loadResult('ins_cap', array('name'), array('id = '=>(int)$this->row->ins_cap))?>" readonly="readonly">
                                            <!-- <div class="input-group-append rounded-0" data-target="#ins_cap_detail" data-toggle="collapse">
                                                <div class="input-group-text rounded-0"><i class="fa fa-search"></i></div>
                                            </div> -->
                                            <div class="input-group-append rounded-0" data-target="#ins_cap_detail" data-toggle="modal">
                                                <div class="input-group-text rounded-0"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                        <!-- <div id="ins_cap_detail" class="collapse">
                                            <div id="thanhlap-tochuc-ins_cap" class="tree">ss</div>
                                        </div> -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="ins_cap_detail" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Cấp đơn vị</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="thanhlap-tochuc-ins_cap" data-widget="treeview" class="tree"></div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        <button type="button" data-id="" class="btn btn-primary btn-choncapdonvi">Chọn</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                       
                                        <!-- <div class="input-append">
                                            <input type="text" id="ins_cap_name" name="ins_cap_name"  value="<?php echo Core::loadResult('ins_cap', array('name'), array('id = '=>(int)$this->row->ins_cap))?>" readonly="readonly">
                                            <a class="btn collapse-data-btn btn-small" data-toggle="collapse" href="#ins_cap_detail"><i class="icon-search"></i></a>
                                        </div>
                                        <div id="ins_cap_detail" class="collapse">
                                            <div id="thanhlap-tochuc-ins_cap" class="tree"></div>
                                        </div> -->
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
                                        <label>Ngày ban hành:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" data-target="#reservationdate" class="form-control datetimepicker-input rounded-0" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo Core::inputAttachment('attactment',null,1, date('Y'),-1);?>

                            <div id="actions" class="row"  style="display: none;">
                                <div class="col-lg-6">
                                    <!--begin::Form-->
                                    <form class="form" action="#" method="post">
                                        <!--begin::Input group-->
                                        <div class="form-group row">
                                            <!--begin::Label-->
                                            <!-- <label class="col-lg-2 col-form-label">Upload Files:</label> -->
                                            <!--end::Label-->

                                            <!--begin::Col-->
                                            <div class="col-lg-10">
                                                <!--begin::Dropzone-->
                                                <div class="dropzone dropzone-multi" id="kt_dropzonejs_example_3">
                                                    <!--begin::Controls-->
                                                    <div class="dropzone-panel mb-lg-0 mb-2">
                                                        <a class="dropzone-select btn btn-sm btn-primary me-2">Đính kèm quyết định</a>
                                                    </div>
                                                    <!--end::Controls-->

                                                    <!--begin::Items-->
                                                    <div class="dropzone-items wm-200px">
                                                        <div class="dropzone-item" style="display:none">
                                                            <!--begin::File-->
                                                            <div class="dropzone-file">
                                                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                                    <span data-dz-name>some_image_file_name.jpg</span>
                                                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                                                </div>

                                                                <div class="dropzone-error" data-dz-errormessage></div>
                                                            </div>
                                                            <!--end::File-->

                                                            <!--begin::Progress-->
                                                            <div class="dropzone-progress">
                                                                <div class="progress">
                                                                    <div
                                                                        class="progress-bar bg-primary"
                                                                        role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Progress-->

                                                            <!--begin::Toolbar-->
                                                            <div class="dropzone-toolbar">
                                                                <span class="dropzone-delete" data-dz-remove><i class="fa fa-times"></i></span>
                                                            </div>
                                                            <!--end::Toolbar-->
                                                        </div>
                                                    </div>
                                                    <!--end::Items-->
                                                </div>
                                                <!--end::Dropzone-->

                                                <!--begin::Hint-->
                                                <span class="form-text text-muted">Kích thước tệp tối đa là 1MB và số lượng tệp tối đa là 5.</span>
                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                    <!--end::Input group-->
                                    </form>
                                    <!--end::Form-->
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
    $('#type_created').select2({
        placeholder: "Hãy chọn...",
        allowClear: true
    });
    $('#vanban_createdcoquan_banhanh_id').select2({
        width : "100%"
    });
    $('#ins_created').select2({
        width : "100%"
    });
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

     //Date picker
     
    // $('#reservationdate').datetimepicker({
       
    //     format: 'L',
    //     language: 'vi'
       
    // });

    $('#reservationdate').datetimepicker({
        format: 'DD/MM/YYYY'      
    });

    // // set the dropzone container id
    // const id = "#kt_dropzonejs_example_3";
    // const dropzone = document.querySelector(id);

    // // set the preview element template
    // var previewNode = dropzone.querySelector(".dropzone-item");
    // previewNode.id = "";
    // var previewTemplate = previewNode.parentNode.innerHTML;
    // previewNode.parentNode.removeChild(previewNode);

    // var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
    //     url: "/index.php?option=com_tochuc&controller=tochuc&task=upload'); ?>", // Set the url for your upload script location
    //     parallelUploads: 20,
    //     maxFilesize: 1, // Max filesize in MB
    //     previewTemplate: previewTemplate,
    //     previewsContainer: id + " .dropzone-items", // Define the container to display the previews
    //     clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
    // });

    // myDropzone.on("addedfile", function (file) {
    //     // Hookup the start button
    //     const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
    //     dropzoneItems.forEach(dropzoneItem => {
    //         dropzoneItem.style.display = '';
    //     });
    // });

    // // Update the total progress bar
    // myDropzone.on("totaluploadprogress", function (progress) {
    //     const progressBars = dropzone.querySelectorAll('.progress-bar');
    //     progressBars.forEach(progressBar => {
    //         progressBar.style.width = progress + "%";
    //     });
    // });

    // myDropzone.on("sending", function (file) {
    //     // Show the total progress bar when upload starts
    //     const progressBars = dropzone.querySelectorAll('.progress-bar');
    //     progressBars.forEach(progressBar => {
    //         progressBar.style.opacity = "1";
    //     });
    // });

    // // Hide the total progress bar when nothing"s uploading anymore
    // myDropzone.on("complete", function (progress) {
    //     const progressBars = dropzone.querySelectorAll('.dz-complete');

    //     setTimeout(function () {
    //         progressBars.forEach(progressBar => {
    //             progressBar.querySelector('.progress-bar').style.opacity = "0";
    //             progressBar.querySelector('.progress').style.opacity = "0";
    //         });
    //     }, 300);
    // });

    $('#quyetdinhlienquan').on('change', function(){
        if(this.checked) {
            $('.div_quyetdinhlienquan').css('display','block');  // show the div
        } else {
            $('.div_quyetdinhlienquan').css('display','none');  // show the div
        }
    });
    
    var tree_data_ins_cap = <?php echo $this->tree_data_ins_cap; ?>;		
	var treeDataCapDonvi = new DataSourceTree({data: tree_data_ins_cap});	
    $('#thanhlap-tochuc-ins_cap').ace_tree({
		dataSource: treeDataCapDonvi,
		multiSelect:false,
		loadingHTML:'<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
		'open-icon' : 'icon-minus',
		'close-icon' : 'icon-plus',
		'selectable' : true,
		'selected-icon' : 'icon-ok',
		'unselected-icon' : 'icon-remove'
	});
    $('#thanhlap-tochuc-ins_cap').on('selected', function (evt, data) {
		if(typeof data.info[0] != "undefined"){
			$('#ins_cap').val(data.info[0].id);
			$('#ins_cap_name').val(data.info[0].name);
            $('.btn-choncapdonvi').attr('data-id',data.info[0].id)
		}
	});
	$('#thanhlap-tochuc-ins_cap').on('unselected', function (evt, data) {			
	    $('#ins_cap').val('');
		$('#ins_cap_name').val('');	
        $('.btn-choncapdonvi').attr('data-id','')
	});

    $('.btn-choncapdonvi').on('click', function() {
            console.log($(this).attr('data-id'))
			if($(this).attr('data-id') != ''){
                $('#ins_cap_detail').modal('hide');
            }else{
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Vui lòng chọn cấp đơn vị',
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'warning'
                })
                return false;
            }
			
		
       
    })



});
</script>
<style>
#ins_cap_detail{
    padding-right: 0px !important;
}   
.datetimepicker.dropdown-menu{
    left: 0 !important;
    top: 100% !important;
} 
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
.input-group-text:hover i{
    color: black;
}
.tree:after, .tree:before{
    box-sizing: unset !important;
}
.tree {
    padding-left: 9px;
    overflow-x: hidden;
    overflow-y: auto;
    position: relative;
}
.tree:before {
    display: inline-block;
    content: "";
    position: absolute;
    top: -20px;
    bottom: 16px;
    left: 0;
    border: 1px dotted #67b2dd;
    border-width: 0 0 0 1px;
    z-index: 1;
}
.tree .tree-folder {
    width: auto;
    min-height: 20px;
    cursor: pointer;
}
.tree .tree-folder .tree-folder-header {
    position: relative;
    height: 20px;
    line-height: 20px;
    box-sizing: content-box !important;
}
.tree .tree-folder .tree-folder-header:hover { background-color: #f0f7fc }
.tree .tree-folder .tree-folder-header .tree-folder-name, .tree .tree-item .tree-item-name {
    display: inline;
    z-index: 2;
}
.tree .tree-folder .tree-folder-header>[class*="icon-"]:first-child, .tree .tree-item>[class*="icon-"]:first-child {
    display: inline-block;
    position: relative;
    z-index: 2;
    top: -1px;
}
.tree .tree-folder .tree-folder-header .tree-folder-name { margin-left: 2px }
.tree .tree-folder .tree-folder-header>[class*="icon-"]:first-child { margin: -2px 0 0 -2px }
.tree .tree-folder:last-child:after {
    display: inline-block;
    content: "";
    position: absolute;
    z-index: 1;
    top: 15px;
    bottom: 0;
    left: -15px;
    border-left: 1px solid #FFF;
}
.tree .tree-folder .tree-folder-content {
    margin-left: 23px;
    position: relative;
}
.tree .tree-folder .tree-folder-content:before {
    display: inline-block;
    content: "";
    position: absolute;
    z-index: 1;
    top: -14px;
    bottom: 16px;
    left: -14px;
    border: 1px dotted #67b2dd;
    border-width: 0 0 0 1px;
}
.tree .tree-item {
    position: relative;
    height: 20px;
    line-height: 20px;
    cursor: pointer;
}
.tree .tree-item:hover { background-color: #f0f7fc }
.tree .tree-item .tree-item-name { margin-left: 3px }
.tree .tree-item .tree-item-name>[class*="icon-"]:first-child { margin-right: 3px }
.tree .tree-item>[class*="icon-"]:first-child { margin-top: -1px }
.tree .tree-folder, .tree .tree-item { position: relative }
.tree .tree-folder:before, .tree .tree-item:before {
    display: inline-block;
    content: "";
    position: absolute;
    top: 14px;
    left: -13px;
    width: 18px;
    height: 0;
    border-top: 1px dotted #67b2dd;
    z-index: 1;
}
.tree .tree-selected {
    background-color: rgba(98,168,209,0.1);
    color: #6398b0;
}
.tree .tree-selected:hover { background-color: rgba(98,168,209,0.1) }
.tree .tree-item, .tree .tree-folder { border: 1px solid #FFF }
.tree .tree-folder .tree-folder-header { border-radius: 0 }
.tree .tree-item, .tree .tree-folder .tree-folder-header {
    margin: 0;
    padding: 5px;
    color: #4d6878;
    box-sizing: content-box !important;
    /* padding-bottom: 15px; */
}
.tree .tree-item>[class*="icon-"]:first-child {
    color: #f9e8ce;
    width: 13px;
    height: 13px;
    line-height: 13px;
    font-size: 11px;
    text-align: center;
    /* border-radius: 3px; */
    background-color: #fafafa;
    border: 1px solid #8baebf;
    /* box-shadow: 0 1px 2px rgba(0,0,0,0.05); */
    margin-left: -2px;
}
.tree .tree-selected>[class*="icon-"]:first-child {
    background-color: #f9a021;
    border-color: #f9a021;
    color: #FFF;
}
.tree .icon-plus[class*="icon-"]:first-child, .tree .icon-minus[class*="icon-"]:first-child {
    border: 1px solid #DDD;
    vertical-align: middle;
    height: 13px;
    width: 13px;
    text-align: center;
    border: 1px solid #8baebf;
    line-height: 11px;
    background-color: #FFF;
    position: relative;
    z-index: 1;
}
.tree .icon-plus[class*="icon-"]:first-child:before {
    display: block;
    content: "+";
    font-family: "Open Sans";
    font-size: 16px;
    position: relative;
    z-index: 1;
}
.tree .icon-minus[class*="icon-"]:first-child:before {
    content: "";
    display: block;
    width: 7px;
    height: 0;
    border-top: 1px solid #4d6878;
    position: absolute;
    top: 5px;
    left: 2px;
}
.tree .tree-unselectable .tree-item>[class*="icon-"]:first-child {
    color: #5084a0;
    width: 13px;
    height: 13px;
    line-height: 13px;
    font-size: 10px;
    text-align: center;
    border-radius: 0;
    background-color: transparent;
    border: 0;
    box-shadow: none;
}
.tree [class*="icon-"][class*="-down"] { transform: rotate(-45deg) }
.tree .icon-spin { height: auto }
.tree .tree-loading { margin-left: 36px }
.tree img {
    display: inline;
    vertical-align: middle;
}
a.dz-clickable:hover{
    border-top: 3px solid transparent !important;
}
</style>