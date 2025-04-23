<?php
    defined('_JEXEC') or die ('Restricted access');
    $ctpc_id = JRequest::getVar('id');
    if($ctpc_id){
        $ctpc    = $this->ctpc;
    }
    //echo $job[0]['ma'];die
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_ctpc" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Tên<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="ten" id="ten" value="<?php if($ctpc_id) echo $ctpc['ten'] ?>">
            <input type="hidden"  id="form-field-1" name="id" value="<?php if($ctpc_id) echo $ctpc['id']; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Trạng thái<span style="color:red">*</span></label>
        <div class="control">
            <label>
                <input name="trangthai" value="1" type="radio" <?php if($ctpc_id) echo ($ctpc['trangthai']==1)?'checked':'' ?> />
                <span class="lbl">Đang hoạt động</span>
            </label>
            <label>
                <input name="trangthai" value="0" type="radio" <?php if($ctpc_id) echo ($ctpc['trangthai']==0)?'checked':'' ?> />
                <span class="lbl">Không hoạt động</span>
            </label>
        </div>
    </div>      
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_ctpc').validate({
            rules:{
                ten: {required: true},
                trangthai: {required: true},
            },
            messages:{
                ten: {required:"Vui lòng nhập tên"},
                trangthai: {required:"Vui lòng chọn trạng thái"},
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

