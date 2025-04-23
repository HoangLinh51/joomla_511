<?php
    defined('_JEXEC') or die ('Restricted access');
    $ds_loaiphucap = $this->ds_loaiphucap;
    $phucaplinhvuc_id = JRequest::getVar('id');
    if($phucaplinhvuc_id){
        $phucaplinhvuc    = $this->phucaplinhvuc;
    }
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_phucaplinhvuc" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Tên lĩnh vực<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="tenlinhvuc" id="tenlinhvuc" value="<?php if($phucaplinhvuc_id) echo $phucaplinhvuc['tenlinhvuc'] ?>">
            <input type="hidden"  id="form-field-1" id="id" name="id" value="<?php if($phucaplinhvuc_id) echo $phucaplinhvuc['id']; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Loại phụ cấp<span style="color:red">*</span></label>
        <div class="control">
            <select name="loaiphucap_id" id="loaiphucap_id" style="width:31%">
                <option value="">Chọn loại phụ cấp</option>
                <?php for($i=0;$i<count($ds_loaiphucap);$i++){ ?>
                <?php 
                    if($phucaplinhvuc_id){
                        if($ds_loaiphucap[$i]['id']==$phucaplinhvuc['loaiphucap_id']){
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
                    <option value="<?php echo $ds_loaiphucap[$i]['id']; ?>" <?php echo $select; ?>><?php echo $ds_loaiphucap[$i]['tenloaiphucap']; ?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Số năm tăng phụ cấp</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="sonamtangphucap" id="sonamtangphucap" value="<?php if($phucaplinhvuc_id) echo $phucaplinhvuc['sonamtangphucap'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Mức tăng phụ cấp</label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="muctangphucap" id="muctangphucap" value="<?php if($phucaplinhvuc_id) echo $phucaplinhvuc['muctangphucap'] ?>">
        </div>
    </div> 
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Trạng thái<span style="color:red">*</span></label>
        <div class="control">
            <label>
                <input name="status" value="1" type="radio" <?php if($phucaplinhvuc_id) echo ($phucaplinhvuc['status']==1)?'checked':'' ?> />
                <span class="lbl">Đang hoạt động</span>
            </label>
            <label>
                <input name="status" value="0" type="radio" <?php if($phucaplinhvuc_id) echo ($phucaplinhvuc['status']==0)?'checked':'' ?> />
                <span class="lbl">Không hoạt động</span>
            </label>
        </div>
    </div> 
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_phucaplinhvuc').validate({
            rules:{
                tenlinhvuc: {required: true},
                loaiphucap_id: {required: true},
                status: {required: true},
            },
            messages:{
                tenlinhvuc: {required:"Vui lòng nhập tên lĩnh vực"},
                loaiphucap_id:{required:"Vui lòng chọn loại phụ cấp"},
                status: {required:"Vui lòng chọn trạng thái"},
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

