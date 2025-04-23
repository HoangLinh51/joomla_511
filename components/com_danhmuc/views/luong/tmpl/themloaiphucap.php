<?php
    defined('_JEXEC') or die ('Restricted access');
    $ds_donvitinh = $this->ds_donvitinh;
    $ds_cachtinh = $this->ds_cachtinh;
    $loaiphucap_id = JRequest::getVar('id');
    if($loaiphucap_id){
        $loaiphucap    = $this->loaiphucap;
    }
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_loaiphucap" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Tên loại phụ cấp<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="tenloaiphucap" id="tenloaiphucap" value="<?php if($loaiphucap_id) echo $loaiphucap['tenloaiphucap'] ?>">
            <input type="hidden"  id="form-field-1" id="id" name="id" value="<?php if($loaiphucap_id) echo $loaiphucap['id']; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Đơn vị tính<span style="color:red">*</span></label>
        <div class="control">
            <select name="donvitinh" id="donvitinh" style="width:31%">
                <option value="">Chọn đơn vị tính</option>
                <?php for($i=0;$i<count($ds_donvitinh);$i++){ ?>
                <?php 
                    if($loaiphucap_id){
                        if($ds_donvitinh[$i]['id']==$loaiphucap['donvitinh']){
                            $select = 'selected';
                        }
                        else{
                            $select = '';
                        }
                    } 
                    else{
                        $select = '';
                    }
                ?>
                    <option value="<?php echo $ds_donvitinh[$i]['id']; ?>" <?php echo $select; ?>><?php echo $ds_donvitinh[$i]['ten']; ?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Cách tính<span style="color:red">*</span></label>
        <div class="control">
            <select name="cachtinh" id="cachtinh" style="width:31%">
                <option value="">Chọn cách tính</option>
                <?php for($i=0;$i<count($ds_cachtinh);$i++){ ?>
                <?php 
                    if($loaiphucap_id){
                        if($ds_cachtinh[$i]['id']==$loaiphucap['cachtinh']){
                            $select = 'selected';
                        }
                        else{
                            $select = '';
                        }
                    } 
                    else{
                        $select = '';
                    }
                ?>
                    <option value="<?php echo $ds_cachtinh[$i]['id']; ?>" <?php echo $select; ?>><?php echo $ds_cachtinh[$i]['ten']; ?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Giá trị mặc định<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="giatrimacdinh" id="giatrimacdinh" value="<?php if($loaiphucap_id) echo $loaiphucap['giatrimacdinh'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Có lĩnh vực</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="colinhvuc" id="colinhvuc" value="<?php if($loaiphucap_id) echo $loaiphucap['colinhvuc'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Có ngày nâng tiếp theo</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="congaynangtieptheo" id="congaynangtieptheo" value="<?php if($loaiphucap_id) echo $loaiphucap['congaynangtieptheo'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Theo chức vụ<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="theochucvu" id="theochucvu" value="<?php if($loaiphucap_id) echo $loaiphucap['theochucvu'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Trạng thái<span style="color:red">*</span></label>
        <div class="control">
            <label>
                <input name="trangthaisudung" value="1" type="radio" <?php if($loaiphucap_id) echo ($loaiphucap['trangthaisudung']==1)?'checked':'' ?> />
                <span class="lbl">Đang hoạt động</span>
            </label>
            <label>
                <input name="trangthaisudung" value="0" type="radio" <?php if($loaiphucap_id) echo ($loaiphucap['trangthaisudung']==0)?'checked':'' ?> />
                <span class="lbl">Không hoạt động</span>
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Key<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="key" id="key" value="<?php if($loaiphucap_id) echo $loaiphucap['key'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Số năm tăng phụ cấp</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="sonamtangphucap" id="sonamtangphucap" value="<?php if($loaiphucap_id) echo $loaiphucap['sonamtangphucap'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Mức tăng phụ cấp</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="muctangphucap" id="muctangphucap" value="<?php if($loaiphucap_id) echo $loaiphucap['muctangphucap'] ?>">
        </div>
    </div>      
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_loaiphucap').validate({
            rules:{
                tenloaiphucap: {required: true},
                donvitinh: {required: true},
                cachtinh: {required: true},
                giatrimacdinh: {required: true},
                theochucvu: {required: true},
                key: {required: true},
                trangthaisudung: {required: true},
            },
            messages:{
                tenloaiphucap: {required:"Vui lòng nhập tên"},
                donvitinh:{required:"Vui lòng chọn đơn vị tính"},
                cachtinh:{required:"Vui lòng chọn cách tính"},
                giatrimacdinh: {required:"Vui lòng nhập giá trị mặc định"},
                theochucvu: {required:"Vui lòng nhập theo chức vụ"},
                key: {required:"Vui lòng nhập key"},
                trangthaisudung: {required:"Vui lòng chọn trạng thái"},
            },
            invalidHandler: function (event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                        var message = errors == 1
                        ? 'Kiểm tra lỗi sau:<br/>'
                        : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errors = "";
                        if (validator.errorList.length > 0) {
                            for (x=0;x<validator.errorList.length;x++) {
                                    errors += "<br/>\u25CF " + validator.errorList[x].message;
                            }
                        }
                        loadNoticeBoardError('Thông báo',message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {
            }
        });
    });
</script>

