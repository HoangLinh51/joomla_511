<?php
    defined('_JEXEC') or die ('Restricted access');
    $nghenghiep_id = JRequest::getVar('id');
    if($nghenghiep_id){
        $job    = $this->job;
    }
    //echo $job[0]['ma'];die
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_nghenghiep" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <table>
        <tr>
            <td>Mã <span style="color:red">*</span></td>
            <td>
                <input type="text" name="ma" id="ma" value="<?php if($nghenghiep_id) echo $job['ma'] ?>">
                <input type="hidden" name="id" value="<?php if($nghenghiep_id) echo $job['id']; ?>">
            </td>
        </tr>
        <tr>
            <td>Tên <span style="color:red">*</span></td>
            <td><input type="text" id="ten" name="ten" value="<?php if($nghenghiep_id) echo $job['ten']; ?>"/></td>
        </tr>
        <tr>
            <td>Trạng thái <span style="color:red">*</span></td>
            <td>
                <label>
                    <input type="radio" name="trangthai"  <?php echo ($nghenghiep_id && $job['trangthai']=='1')?'checked="checked"':''; ?> value="1" placeholder="1">
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="trangthai" <?php echo ($nghenghiep_id && $job['trangthai']=='0')?'checked="checked"':''; ?> value="0">
                    <span class="lbl">Không hoạt động</span>
                </label>
                
            </td>
        </tr>
    </table>
    
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_nghenghiep').validate({
            rules:{
                ma: {required: true},
                ten: {required: true}
            },
            messages:{
                ma: {required:"Vui lòng nhập mã"},
                ten: {required:"Vui lòng nhập tên"}
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

