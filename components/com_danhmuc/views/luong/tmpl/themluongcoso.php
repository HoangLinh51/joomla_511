<?php
    defined('_JEXEC') or die ('Restricted access');
    $luongcoso_id = JRequest::getVar('id');
    if($luongcoso_id){
        $luongcoso    = $this->luongcoso;
        $thoidiemapdung = substr($luongcoso['thoidiemapdung'],0,10);
        $thoidiemapdung_time = substr($luongcoso['thoidiemapdung'],11);
        $thoidiemhetapdung = substr($luongcoso['thoidiemhetapdung'],0,10);
        $thoidiemhetapdung_time = substr($luongcoso['thoidiemhetapdung'],11);
        $ngaytao = substr($luongcoso['ngaytao'],0,10);
        $ngaytao_time = substr($luongcoso['ngaytao'],11);
        $ngaysua = substr($luongcoso['ngaysua'],0,10);
        $ngaysua_time = substr($luongcoso['ngaysua'],11);
    }
    //echo $job[0]['ma'];die
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_luongcoso" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-1">Mức lương<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-1" name="mucluong" id="mucluong" value="<?php if($luongcoso_id) echo $luongcoso['mucluong'] ?>">
            <input type="hidden"  id="form-field-1" name="id" value="<?php if($luongcoso_id) echo $luongcoso['id']; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-2">Thời điểm áp dụng<span style="color:red">*</span></label>
        <div class="control">
            <input class="span3 date-picker" name="thoidiemapdung" id="form-field-2" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" value="<?php if($luongcoso_id) echo $thoidiemapdung ?>" />
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
            <div class="input-append bootstrap-timepicker">
                <input id="timepicker1" name="thoidiemapdung_time" type="text" class="input-small" value="<?php if($luongcoso_id) echo $thoidiemapdung_time ?>" />
                <span class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-3">Thời điểm hết áp dụng<span style="color:red">*</span></label>
        <div class="control">
            <input class="span3 date-picker" name="thoidiemhetapdung" id="form-field-3" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" value="<?php if($luongcoso_id) echo $thoidiemhetapdung ?>" />
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
            <div class="input-append bootstrap-timepicker">
                <input id="timepicker2" name="thoidiemhetapdung_time" type="text" class="input-small" value="<?php if($luongcoso_id) echo $thoidiemhetapdung_time ?>"/>
                <span class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-4">Ngày tạo<span style="color:red">*</span></label>
        <div class="control">
            <input class="span3 date-picker"  name="ngaytao" id="form-field-4" id="id-date-picker-3" type="text" data-date-format="yyyy-mm-dd" value="<?php if($luongcoso_id) echo $ngaytao ?>" />
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
            <div class="input-append bootstrap-timepicker">
                <input id="timepicker3" name="ngaytao_time" type="text" class="input-small" value="<?php if($luongcoso_id) echo $ngaytao_time ?>" />
                <span class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-5">Người tạo<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" name="nguoitao" id="form-field-5" value="<?php if($luongcoso_id) echo $luongcoso['nguoitao'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-6">Ngày sửa<span style="color:red">*</span></label>
        <div class="control">
            <input class="span3 date-picker" name="ngaysua" id="form-field-6" id="id-date-picker-4" type="text" data-date-format="yyyy-mm-dd" value="<?php if($luongcoso_id) echo $ngaysua ?>"/>
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
            <div class="input-append bootstrap-timepicker">
                <input id="timepicker4" name="ngaysua_time" type="text" class="input-small" value="<?php if($luongcoso_id) echo $ngaysua_time ?>"/>
                <span class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="margin-right:20%" for="form-field-7">Người sửa<span style="color:red">*</span></label>
        <div class="control">
            <input type="text" class="span3" id="form-field-7" name="nguoisua" value="<?php if($luongcoso_id) echo $luongcoso['nguoisua'] ?>">
        </div>
    </div>   
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_luongcoso').validate({
            rules:{
                mucluong: {required: true, number:true},
                thoidiemapdung: {required: true},
                thoidiemapdung_time: {required: true},
                ngaytao: {required: true},
                ngaytao_time: {required: true},
                nguoitao: {required: true},
                ngaysua: {required: true},
                ngaysua_time: {required: true},
                nguoisua: {required: true},
            },
            messages:{
                mucluong: {required:"Vui lòng nhập mức lương",number:"Vui lòng nhập số"},
                thoidiemapdung: {required:"Vui lòng nhập thời điểm áp dụng"},
                thoidiemapdung_time: {required:"Vui lòng chọn thời gian áp dụng"},
                ngaytao: {required: "Vui lòng nhập ngày tạo"},
                ngaytao_time: {required:"Vui lòng chọn thời gian ngày tạo"},
                nguoitao: {required: "Vui lòng nhập người tạo"},
                ngaysua: {required: "Vui lòng nhập ngày sửa"},
                ngaysua_time: {required:"Vui lòng chọn thời gian ngày sửa"},
                nguoisua: {required: "Vui lòng nhập người sửa"}
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
        $('.date-picker').datepicker().next().on(ace.click_event, function(){
            $(this).prev().focus();
        }); 
        $('#timepicker1').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
        $('#timepicker2').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
        $('#timepicker3').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
        $('#timepicker4').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });  
    });
</script>

