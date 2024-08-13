<?php

/*****************************************************************************************************
 * @Author                : HueNN                                                                    *
 * @CreatedDate           : 2024-08-03 21:36:49                                                      *
 * @LastEditors           : HueNN                                                                    *
 * @LastEditDate          : 2024-08-03 21:36:49                                                      *
 * @FilePath              : Joomla_511_svn/components/com_tochuc_new/tmpl/tochuc/edit_tochuc.php     *
 * @CopyRight             : Dnict                                                                    *
 *****************************************************************************************************/

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Decentralization\Administrator\View\Actions\HtmlView;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>
<form class="form-horizontal row-fluid" name="frmThanhLap" id="frmThanhLap" method="POST" action="<?php echo Route::_('index.php?option=com_tochuc&controller=tochuc&task=savethanhlap')?>" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $this->row->id; ?>" name="id" id="id">
    <input type="hidden" value="<?php echo $this->row->type; ?>" name="type" id="type">
    <input type="hidden" value="<?php echo $this->row->parent_id; ?>" name="parent_id" id="parent_id">	
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
                                        <input class="custom-control-input" type="checkbox" id="is_checkmadonvi" checked="">
                                        <label for="is_checkmadonvi" id="label_madonvi" class="custom-control-label">Có/ Không cấp mã số tổ chứ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_madonvi">
                                <div class="col-md-12 form-group">
                                    <div class="controls ">
                                        <input class="form-control rounded-0" type="text" value="" name="madonvi" id="madonvi">
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
                                    <label class="control-label" for="website">Website tổ chức</label>
                                    <div class="controls">
                                        <input class="form-control rounded-0" type="text" value="" name="website" id="website">
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
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="phancaptochuc_id">Phân cấp tổ chức</label>
                                    <div class="controls">
                                        <?php 
                                            $options = array();
                                            $option[] = array('id' => '', 'ten' => '');
                                            $options = array_merge($option, $this->phancaptochuc);
                                            echo HTMLHelper::_('select.genericlist', $options, 'phancaptochuc_id', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'id', 'ten', $this->row->phancaptochuc_id); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="hangtochuc_id">Hạng tổ chức</label>
                                    <div class="controls">
                                        <?php
                                            $options = array();
                                            $option[] = array('id' => '', 'ten' => '');
                                            $options = array_merge($option, $this->hangtochuc); 
                                            echo HTMLHelper::_('select.genericlist', $options, 'hangtochuc_id', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'id', 'ten', $this->row->hangtochuc_id); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label" for="diachi">Địa chỉ <span class="required">*</span></label>
                                    <!-- <div class="controls">
                                        <input class="form-control rounded-0" type="text" value="" id="diachi" name="diachi">
                                    </div> -->
                                </div>
                                <div class="<?php echo ($this->row->tinhthanh_id == -2) ? "col-md-12" : 'col-md-4'; ?> form-group">
                                    <div class="controls">
                                        <?php echo TochucHelper::selectBox($this->row->tinhthanh_id, array('name' => 'cadc_code', 'class' => 'chzn-select',
											'data-placeholder' => 'Chọn tỉnh thành...'), 'city_code', array('code', 'name'), array('status = 1'), 'name COLLATE utf8_unicode_ci');
										?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group" <?php echo ($this->row->tinhthanh_id == -2) ? 'style="display:none;"' : ''; ?>>
                                    <div class="controls">
                                        <?php echo TochucHelper::selectBox($this->row->quanhuyen_id, array('name' => 'dist_placebirth', 'class' => 'chzn-select',
											'data-placeholder' => 'Chọn quận huyện...'), 'dist_code', array('code', 'name'), array('cadc_code = "' . $this->row->tinhthanh_id . '"'));
										?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group" <?php echo ($this->row->tinhthanh_id == -2) ? 'style="display:none;"' : ''; ?>>
                                    <div class="controls">
                                        <?php echo TochucHelper::selectBox($this->row->phuongxa_id, array('name' => 'comm_placebirth', 'class' => 'chzn-select',
										'data-placeholder' => 'Chọn phường xã...'), 'comm_code', array('code', 'name'), array('dc_code = "' . $this->row->quanhuyen_id . '"'));
										?>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <!-- <label class="control-label" for="diachi">Địa chỉ <span class="required">*</span></label> -->
                                    <div class="controls">
                                        <input class="form-control rounded-0" placeholder="Chi tiết" type="text" value="" id="diachi" name="diachi">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="loaihachtoan_id">Loại hạnh toán</label>
                                    <div class="controls">
                                        <?php 
                                            $options = array();
                                            $option[] = array('id' => '', 'ten' => '');
                                            $options = array_merge($option, $this->loaihachtoan);
                                            echo HTMLHelper::_('select.genericlist', $options, 'loaihachtoan_id', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'id', 'ten', $this->row->loaihachtoan_id); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="mucdotuchu_id">Mức độ tự chủ</label>
                                    <div class="controls">
                                        <?php 
                                            $options = array();
                                            $option[] = array('id' => '', 'ten' => '');
                                            $options = array_merge($option, $this->mucdotuchu);
                                            echo HTMLHelper::_('select.genericlist', $options, 'mucdotuchu_id', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'id', 'ten', $this->row->mucdotuchu_id); 
                                        ?>
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
                                        <label for="type_created">Cách thức thành lập</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cơ quan chủ quản</label>
                                        <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'ins_created', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->ins_created); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ins_cap_name">Cấp đơn vị <span class="required">*</span></label>
                                        <input type="hidden" name="ins_cap" id="ins_cap" value="<?php echo $this->row->ins_cap; ?>">
                                        <div class="input-group date" id="" data-target-input="nearest">
                                            <input type="text" id="ins_cap_name" name="ins_cap_name" class="form-control rounded-0" value="<?php echo Core::loadResult('ins_cap', array('name'), array('id = ' => (int)$this->row->ins_cap)) ?>" readonly="readonly">
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
                                                        <button type="button" data-id="" class="btn btn-primary btn-choncapdonvi" data-dismiss="modal">Chọn</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->

                                        <!-- <div class="input-append">
                                            <input type="text" id="ins_cap_name" name="ins_cap_name"  value="<?php echo Core::loadResult('ins_cap', array('name'), array('id = ' => (int)$this->row->ins_cap)) ?>" readonly="readonly">
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

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control rounded-0" id="ngaybanhanh" name="vanban_created[ngaybanhanh]" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                        </div>
                                        <!-- <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">                                       
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <?php echo Core::inputAttachment('attactment_tochuc', null, 1, date('Y'), -1); ?>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="vanban_created_mahieu">Các quyết định liên quan</label>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="quyetdinhlienquan">
                                        <label for="quyetdinhlienquan" class="custom-control-label">Có/ Không có quyết định liên quan</label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group div_quyetdinhlienquan" style="display: none;">
                                    <div class="d-flex justify-content-end align-items-center" style="height: 100%;">
                                        <div class="col-md-3" style="float: right;">
                                            <span id="btn_xoa_qdlienquan" style=" display: none;" class="btn btn-block btn-danger btn-sm">Xoá</span>
                                        </div>
                                        <div class="" style="text-align: right;">
                                            <span data-target=".file_qdlienquan" data-toggle="modal" id="btn_themmoi_qdlienquan" class="btn btn-primary btn-sm">Thêm mới</span>
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
                                    <label class="control-label" for="ins_linhvuc">Lĩnh vực</label>
                                    <div class="controls" style="display: grid;">
                                        <input type="hidden" id="ins_linhvuc" name="ins_linhvuc" />
                                        <div id="tree_linhvuc">
                                            <?php
                                            $inArray = Core::loadAssocList('cb_type_linhvuc', array('id', 'name', 'level', 'parent_id'), array('type=' => 2), 'lft');
                                            $tree = TochucHelper::buildTree($inArray);
                                            $jsTreeData = json_encode(TochucHelper::convertToJsTreeFormat($tree));

                                            //echo TochucHelper::createChk('ins_linhvuc[]', $inArray,$this->linhvuc); 
                                            // var_dump($tree);exit;
                                            //TochucHelper::printTree($tree);
                                            // echo TochucHelper::buildTreeHtml('','cb_type_linhvuc', array('id','name','level', 'parent_id'),'type=2','lft',$current_depth = 1); 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="goibienche">Gói biên chế</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('bc_goibienche', array("id as value", "name AS text"), array('active = ' => 1), 'id');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goibienche', array('class' => 'goibienche', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goibienche);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goichucvu">Gói chức vụ</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('cb_goichucvu', array("id as value", "CONCAT(REPEAT('--',level), name, ' (',(select count(*) from cb_goichucvu_chucvu a where a.goichucvu_id = id), ')') AS text"), array('lft >' => 0, 'status = ' => 1), 'lft');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goichucvu', array('class' => 'chzn-select', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goichucvu);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goiluong">Gói lương</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('cb_goiluong', array("id as value", "CONCAT(REPEAT('--',level), name) AS text"), array('lft >' => 0, 'status = ' => 1), 'lft');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goiluong', array('class' => 'chzn-select', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goiluong);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goidaotao">Gói đào tạo</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('cb_goidaotaoboiduong', array("id as value", "name AS text"), array('status = ' => 1), 'name');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goidaotao', array('class' => 'chzn-select', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goidaotao);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goihinhthuchuongluong">Gói hình thức hưởng lương</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('cb_goihinhthuchuongluong', array("id as value", "name AS text"), array('status = ' => 1), 'name');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goihinhthuchuongluong', array('class' => 'chzn-select', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goihinhthuchuongluong);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goivitrivieclam">Gói vị trí việc làm</label>
                                        <div class="">
                                            <?php
                                            $arrTemp = Core::loadAssocList('cb_goivitrivieclam', array("id as value", "CONCAT(REPEAT('--',level), name) AS text"), array('lft >' => 0, 'status = ' => 1), 'lft');
                                            $arrTemp = array_merge(array(array('value' => '', 'text' => '')), $arrTemp);
                                            echo HTMLHelper::_('select.genericlist', $arrTemp, 'goivitrivieclam', array('class' => 'chzn-select', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->goivitrivieclam);
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
                                    <input name="report_group_code[]" type="checkbox" <?php echo $caybaocao[$i]['checked']; ?> value="<?php echo $caybaocao[$i]['report_group_code'] ?>" id="primary_<?php echo $i+1 ?>" />
                                    <label for="primary_<?php echo $i+1 ?>"><span class="lbl">&nbsp;&nbsp; <?php echo $caybaocao[$i]['name'] ?></span></label>
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
    </div>
    <div class="clr"></div>
    <input type="hidden" name="task" value="savethanhlap" />
    <input type="hidden" name="action_name" id="action_name" value="">
    <input type="hidden" name="is_valid_name" id="is_valid_name" value="">
    <input type="hidden" id="is_valid_code">
    <?php echo HTMLHelper::_( 'form.token' ); ?> 
</form>

<!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script> -->


<script>
    jQuery(document).ready(function($) {


        $('.select2-container').addClass('form-control');
        $('#type_created').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
        });
        $('#vanban_createdcoquan_banhanh_id').select2({
            width: "100%"
        });
        $('#ins_created').select2({
            width: "100%"
        });
        $('#capdonvi').select2();
        $('#phancaptochuc_id').select2({
            width: "100%"
        });
        $('#hangtochuc_id').select2({
            width: "100%"
        });
        $('#cadc_code').select2({
            width: "100%"
        });
        $('#dist_placebirth').select2({
            width: "100%"
        });
        $('#comm_placebirth').select2({
            width: "100%"
        });

        $('#loaihachtoan_id').select2({
            width: "100%"
        });

        $('#mucdotuchu_id').select2({
            width: "100%"
        });
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

        var toggleInputTochuc = function(element){
            if(element.value == 1){
                $(".input-tochuc").show();
                $(".input-phong").hide();
            }		
            else if(element.value == 0){
                $(".input-phong").show();
                $(".input-tochuc").hide();
            }else{
                $(".input-phong,.input-tochuc").hide();
            }
        };
        var toggleInputTrangthai = function(val){
            if(val == 1){			
                $(".trangthai").hide();
            }		
            else{
                $(".trangthai").show();
            }		
        };

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
      
        var tree_data_ins_cap = <?php echo $this->tree_data_ins_cap; ?>;
        var treeDataCapDonvi = new DataSourceTree({
            data: tree_data_ins_cap
        });
        $('#thanhlap-tochuc-ins_cap').ace_tree({
            dataSource: treeDataCapDonvi,
            multiSelect: false,
            loadingHTML: '<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
            'open-icon': 'icon-minus',
            'close-icon': 'icon-plus',
            'selectable': true,
            'selected-icon': 'icon-ok',
            'unselected-icon': 'icon-remove'
        });
        $('#thanhlap-tochuc-ins_cap').on('selected', function(evt, data) {
            if (typeof data.info[0] != "undefined") {
                $('#ins_cap').val(data.info[0].id);
                $('#ins_cap_name').val(data.info[0].name);
                $('.btn-choncapdonvi').attr('data-id', data.info[0].id)
            }
        });
        $('#thanhlap-tochuc-ins_cap').on('unselected', function(evt, data) {
            $('#ins_cap').val('');
            $('#ins_cap_name').val('');
            $('.btn-choncapdonvi').attr('data-id', '')
        });

        $('.btn-choncapdonvi').on('click', function() {
            console.log($(this).attr('data-id'))
            if ($(this).attr('data-id') != '') {
                // $('#ins_cap_detail').modal('hide');
            } else {
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

        $('#ngaybanhanh').inputmask('dd/mm/yyyy', {
            'placeholder': '__/__/____'
        })


        // $('#reservationdate').datetimepicker({

        //    timepicker:false,
        //    format:'d.m.Y'
        // });


        $('#quyetdinhlienquan').on('change', function() {
            if (this.checked) {
                $('.div_quyetdinhlienquan').css('display', 'block'); // show the div
            } else {
                $('.div_quyetdinhlienquan').css('display', 'none'); // show the div
            }
        });

        $('#btn_themmoi_qdlienquan').on('click', function() {
            jQuery.blockUI();
            $('#div_qllienquan').load('/index.php?option=com_tochuc&view=tochuc&task=frmquyetdinh&format=raw', function() {
                jQuery.unblockUI();
            });
        });


        var row_qdlienquan = $('.div_quyetdinhlienquan > table').children('tr').length;

        $('#btn_xoa_quyetdinhlienquan').on('click', function() {
            var iddel = [];
            $(".ck_quyetdinhlienquan:checked").each(function() {
                iddel.push($(this).val());
            });
            if (iddel.length > 0) {
                if (confirm('BẠN CÓ CHẮC CHẮN XÓA?')) {
                    $.ajax({
                        type: 'POST',
                        url: '/index.php?option=com_tochuc&controller=tochuc&task=xoaQuyetdinhlienquan',
                        data: {
                            iddel: iddel
                        },
                        success: function(data) {
                            if (data == true) {
                                loadNoticeBoardSuccess('Thông báo', 'Thao tác thành công!');
                                $(".ck_quyetdinhlienquan:checked").each(function() {
                                    $('#row' + $(this).val()).remove();
                                });
                            } else loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
                        }
                    });
                }
            } else alert("Vui lòng chọn mục cần xóa!!");
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
                // "tie_selection": false, 
                // "real_checkboxes": true,
            },
        }).on('loaded.jstree', function(){
            // jQuery('#html1').jstree('open_all')
        }).on('changed.jstree', function (e, data) {
            var selectedNodes = data.selected.join(',');
            $('#ins_linhvuc').val(selectedNodes);
        });

       

        $('#is_checkmadonvi').on('click', function() {
            console.log("fdsfsd")
            if ($('#is_checkmadonvi').is(":checked")) {
                // $('.div_label_code').html('Mã số tổ chức <span class="required">*</span>');
                $('#div_madonvi').show();
            } else {
                // $('.div_label_code').html('Mã số tổ chức');
                $('#div_madonvi').hide();
            }
        });

        var getTextTab = function(elem){
            var el = $(elem).parents('.tab-pane');
            $('#frmThanhLap a[href="#'+el.attr("id")+'"]').css("color","red");
        };

        var getTextLabel = function(id){
            return $('#frmThanhLap label[for="'+id+'"]').text();
        };

        // $.validator.setDefaults({ ignore: '' });
        // $.validator.addMethod("required2", function(value, element) {
        //     var isTochuc = $("#active").val() !== "1";
        //     var val = value.replace(/^\s+|\s+$/g,"");//trim	 	
        //     if(isTochuc && (eval(val.length) == 0)){
        //         return false;
        //     }else{
        //         return true;
        //     }
        // }, "Trường này là bắt buộc");
        $.validator.addMethod("requireMadonvi", function(value, element) {
            return $('#is_checkmadonvi').is(':checked') ? $.trim(value).length > 0 : true;
        }, "This field is required.");
        $('#frmThanhLap').validate({
            ignore: true,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                $('#frmThanhLap a[data-toggle="tab"]').css("color", "");
                if (errors) {
                    $(this).addClass("is-invalid");
                    var message = errors == 1
                            ? 'Kiểm tra lỗi sau:<br/>'
                            : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            // errors += "<br/>\u25CF " + validator.errorList[x].message;
                            // errors += "<br/>\u25CF " + validator.errorList[x].message;
                            errors += "<br/>\u25CF " + validator.errorList[x].message +' <b> '+ getTextLabel($(validator.errorList[x].element).attr("name")).replace(/\*/g, '')+'</b>' ;
                            getTextTab($(validator.errorList[x].element));
                        }
                    }
                    $.toast({
                        heading: 'Thông báo',
                        text: message + errors,
                        showHideTransition: 'fade',
                        position: 'top-right',
                        hideAfter: false,
                        bgColor: '#a94442',
                        class: 'thanhlap ngx-toastr'
                        // icon: 'error'
                    })
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {
            },
            rules: {
                "name": {
                    required: true,
                },
                "s_name": {
                    required: true
                },
                "name_dieudong": {
                    required: true
                },
                "madonvi": {
                    requireMadonvi: true
                },
                "vanban_created[mahieu]": {	    
					required : function(){
						if($('.dropzone-filename').length > 0 || $('input[name="idFile-tochuc-attachment[]"]').length > 0){
							return true;
						}else{
							return false;
						}
					}
			    },
                "type": {
                    required: true
                },
                "parent_id": {
                    required: true
                },
                "type_created": {
                    required : function(){
                        var select2Container = $('#type_created').next('.select2-container');
                        if($('#type_created').val() == ''){
                            select2Container.addClass('was-validated');
                            return true;
                        }else{
                            return false;
                        }
                    }
                },
                "diachi": {
                    required: true
                },
                "goibienche": {
                    required: true
                },
                "ins_cap_name": {
                    required: function(){
                        if($('#ins_cap').val() == "" || $('#ins_cap').val() == null){
                            return true;
                        }else{
                            return false;
                        }
                    }
                },
                "goichucvu": {
                    required: true
                },
                "goidaotao": {
                    required: true
                },
                "goihinhthuchuongluong": {
                    required: true
                },
                "goiluong": {
                    required: true
                }
            },
            messages: {
                "name": {
                    required: "Vui lòng nhập"
                },
                "madonvi": {
                    requireMadonvi: "Vui lòng nhập <b>Mã đơn vị</b>"
                },
                "vanban_created[mahieu]": {	    
					required: "Vui lòng nhập <b>Số quyết định thành lập</b>"
			    },
                "s_name": {
                    required: "Vui lòng nhập "
                },
                "name_dieudong": {
                    required: "Vui lòng nhập "
                },
                "type": {
                    required: "Vui lòng nhập "
                },
                "parent_id": {
                    required: "Vui lòng nhập "
                },
                "type_created": {
                    required: "Vui lòng nhập "
                },
                "diachi": {
                    required: "Vui lòng nhập "
                },
                "goibienche": {
                    required: "Vui lòng nhập "
                },
                "ins_cap_name": {
                    required: "Vui lòng nhập "
                },
                "goichucvu": {
                    required: "Vui lòng nhập "
                },
                "goidaotao": {
                    required: "Vui lòng nhập "
                },
                "goihinhthuchuongluong": {
                    required: "Vui lòng nhập "
                },
                "goiluong": {
                    required: "Vui lòng nhập "
                }
            },
            highlight: function (element, errorClass, validClass) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('span.select2').find('.select2-selection').addClass('was-validated');
                } else {
                    $(element).addClass('was-validated');
                }    
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('span.select2').find('.select2-selection').removeClass('was-validated');
                } else {
                        $(element).removeClass('was-validated');
                }
                $(element).removeClass('is-invalid');
            }
        });

        $('#btnThanhlapSubmitAndClose').click(function(e) {
            e.preventDefault();
            const element = document.querySelector('.thanhlap');
            if (element) {
                element.remove();
            }
            $('#action_name').val('SAVEANDCLOSE');
            $('#parent_id').val($('#parent_id_content').val());
            if ($('#parent_id').val() == <?php echo (int)$this->row->id; ?>) {
                $.toast({
                    heading: 'Thông báo',
                    text: "Vui lòng chọn đúng Cây đơn vị cha",
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'error',
                    class: 'thanhlap ngx-toastr'

                })
                //return false;
                $.unblockUI();
            } else {
                var flag = $('#frmThanhLap').valid();
                if (flag == true) {
                    document.frmThanhLap.submit();
                }
            }
            return false;
        });
        $('#btnThanhlapSubmitAndNew').click(function(e){
            e.preventDefault();
            const element = document.querySelector('.thanhlap');
            if (element) {
                element.remove();
            }
            $('#action_name').val('SAVEANDNEW');
            $('#parent_id').val($('#parent_id_content').val());
                    if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
                        $.toast({
                        heading: 'Thông báo',
                        text: "Vui lòng chọn đúng Cây đơn vị cha",
                        showHideTransition: 'fade',
                        position: 'top-right',
                        icon: 'error',
                        class: 'thanhlap ngx-toastr'

                    })
                    //return false;
                    $.unblockUI();
                    }
                    else{
                        var flag = $('#frmThanhLap').valid();
                        if(flag == true){
                                document.frmThanhLap.submit();
                        }
                    }
            return false;
	    });
	$('#btnThanhlapSubmitAndContinue').click(function(e){
        e.preventDefault();
        const element = document.querySelector('.thanhlap');
        if (element) {
            element.remove();
        }
	 	$('#action_name').val('SAVEANDCONTINUE');
	 	$('#parent_id').val($('#parent_id_content').val());
                if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
                    $.toast({
                        heading: 'Thông báo',
                        text: "Vui lòng chọn đúng Cây đơn vị cha",
                        showHideTransition: 'fade',
                        position: 'top-right',
                        icon: 'error',
                        class: 'thanhlap ngx-toastr'

                    })
                    //return false;
                    $.unblockUI();
                }
                else{
                    var flag = $('#frmThanhLap').valid();
                    if(flag == true){
                            document.frmThanhLap.submit();
                    }
                }
		return false;
	});

        $('body').delegate('#cadc_code', 'change', function(){
            var token = '<?php echo Session::getFormToken(); ?>';

            if($('#cadc_code').val() == -2){
                $('.div_diachi_tochuc').hide();
                $('#dist_placebirth').val('');
                $('#dist_placebirth').trigger('chosen:updated');
                $('#comm_placebirth').val('');
                $('#comm_placebirth').trigger('chosen:updated');
                $('.div_diachi_khac').show();
            }else{
                $('.div_diachi_khac').hide();
                $('#diachi').val('');
                $('.div_diachi_tochuc').show();
                if($('#cadc_code').val() == ''){
                    $('#dist_placebirth').html('<option value=""></option>');
                    $('#dist_placebirth').trigger('chosen:updated');
                    $('#comm_placebirth').html('<option value=""></option>');
                    $('#comm_placebirth').trigger('chosen:updated');
                }else{
                    $.ajax({
                        type: 'POST',
                        url: 'index.php',
                        dataType: 'json',
                        data: { option: 'com_tochuc', controller: 'ajax', task : 'getQuanhuyen', tinhthanh_id : $('#cadc_code').val(), [token]: 1  },
                        success:function(data){
                            var str = '<option value=""></option>';
                            $.each(data,function(i,v){
                                str+= "<option value='"+v.code+"'>"+v.name+"</option>";
                            });
                            $('#dist_placebirth').html(str);
                            $('#dist_placebirth').trigger('chosen:updated');
                            $('#comm_placebirth').html('<option value=""></option>');
                            $('#comm_placebirth').trigger('chosen:updated');
                        }
                    });
                }
            }
        });
    $('body').delegate('#dist_placebirth', 'change', function(){
        if($(this).val() == ''){
            $('#comm_placebirth').html('<option value=""></option>');
            $('#comm_placebirth').trigger('chosen:updated');
        }else{
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: { option: 'com_tochuc', controller: 'ajax', task : 'getPhuongxa', quanhuyen_id : $('#dist_placebirth').val() },
                success:function(data){
                    var str = '<option value=""></option>';
                    $.each(data,function(i,v){
                        str+= "<option value='"+v.code+"'>"+v.name+"</option>";
                    });
                    $('#comm_placebirth').html(str);
                    $('#comm_placebirth').trigger('chosen:updated');
                }
            });
        }
    });
	$('body').delegate('#city_peraddress', 'change', function(){
		if($(this).val() == ''){
			$('#dist_peraddress').html('<option value=""></option>');
			$('#dist_peraddress').trigger('chosen:updated');
			$('#comm_peraddress').html('<option value=""></option>');
			$('#comm_peraddress').trigger('chosen:updated');
		}else{
    		$.ajax({
    			type: 'POST',
    			url: 'index.php',
    			data: { option: 'com_tochuc', controller: 'ajax', task : 'getQuanhuyen', tinhthanh_id : $('#city_peraddress').val() },
    			success:function(data){
    				var str = '<option value=""></option>';
    				$.each(data,function(i,v){
    					str+= "<option value='"+v.code+"'>"+v.name+"</option>";
    				});
    				$('#dist_peraddress').html(str);
    				$('#dist_peraddress').trigger('chosen:updated');
    				$('#comm_peraddress').html('<option value=""></option>');
    				$('#comm_peraddress').trigger('chosen:updated');
    			}
    		});
		}
	});
	$('body').delegate('#dist_peraddress', 'change', function(){
		if($(this).val() == ''){
			$('#comm_peraddress').html('<option value=""></option>');
			$('#comm_peraddress').trigger('chosen:updated');
		}else{
    		$.ajax({
    			type: 'POST',
    			url: 'index.php',
    			data: { option: 'com_hoso', controller: 'ajax', task : 'getPhuongxa', quanhuyen_id : $('#dist_peraddress').val() },
    			success:function(data){
    				var str = '<option value=""></option>';
    				$.each(data,function(i,v){
    					str+= "<option value='"+v.code+"'>"+v.name+"</option>";
    				});
    				$('#comm_peraddress').html(str);
    				$('#comm_peraddress').trigger('chosen:updated');
    			}
    		});
		}
	});


    });
</script>
<style>
    #ins_cap_detail,
    #file_qdlienquan {
        padding-right: 0px !important;
    }

    .datetimepicker.dropdown-menu {
        left: 0 !important;
        top: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px) !important;
    }

    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px);
        border-radius: 0px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px !important;
        padding-left: 0px !important
    }

    .input-group-text:hover i {
        color: black;
    }

    .tree:after,
    .tree:before {
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

    .tree .tree-folder .tree-folder-header:hover {
        background-color: #f0f7fc
    }

    .tree .tree-folder .tree-folder-header .tree-folder-name,
    .tree .tree-item .tree-item-name {
        display: inline;
        z-index: 2;
    }

    .tree .tree-folder .tree-folder-header>[class*="icon-"]:first-child,
    .tree .tree-item>[class*="icon-"]:first-child {
        display: inline-block;
        position: relative;
        z-index: 2;
        top: -1px;
    }

    .tree .tree-folder .tree-folder-header .tree-folder-name {
        margin-left: 2px
    }

    .tree .tree-folder .tree-folder-header>[class*="icon-"]:first-child {
        margin: -2px 0 0 -2px
    }

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

    .tree .tree-item:hover {
        background-color: #f0f7fc
    }

    .tree .tree-item .tree-item-name {
        margin-left: 3px
    }

    .tree .tree-item .tree-item-name>[class*="icon-"]:first-child {
        margin-right: 3px
    }

    .tree .tree-item>[class*="icon-"]:first-child {
        margin-top: -1px
    }

    .tree .tree-folder,
    .tree .tree-item {
        position: relative
    }

    .tree .tree-folder:before,
    .tree .tree-item:before {
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
        background-color: rgba(98, 168, 209, 0.1);
        color: #6398b0;
    }

    .tree .tree-selected:hover {
        background-color: rgba(98, 168, 209, 0.1)
    }

    .tree .tree-item,
    .tree .tree-folder {
        border: 1px solid #FFF
    }

    .tree .tree-folder .tree-folder-header {
        border-radius: 0
    }

    .tree .tree-item,
    .tree .tree-folder .tree-folder-header {
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

    .tree .icon-plus[class*="icon-"]:first-child,
    .tree .icon-minus[class*="icon-"]:first-child {
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

    .tree [class*="icon-"][class*="-down"] {
        transform: rotate(-45deg)
    }

    .tree .icon-spin {
        height: auto
    }

    .tree .tree-loading {
        margin-left: 36px
    }

    .tree img {
        display: inline;
        vertical-align: middle;
    }

    a.dz-clickable:hover {
        border-top: 3px solid transparent !important;
    }

    .modal {
        padding: 0px !important;
    }
    .thanhlap.ngx-toastr{
        right: -20px;
    }
    #tree_linhvuc a{
        border-top: 0px solid transparent !important;
    }
    #tree_linhvuc a:hover{
        border-top: 0px solid transparent !important;
    }

    .was-validated {
            border-color: #dc3545 !important; /* Red border for error */
    }
    .select2-container .select2-selection--single.was-validated {
            border: 1px solid #dc3545; /* Red border for select2 */
    }
    /* .select2-container--default.was-validated{
        border: 1px solid #dc3545;
        padding-right: 2.25rem !important;
        background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e);
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    } */
</style>