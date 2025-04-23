<?php
    defined('_JEXEC') or die ('Restricted access');
    $htdh_id = JRequest::getVar('id');
    if($htdh_id){
        $job    = $this->job;
    }
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form method="post" id="form_htdh">
    <?php echo JHtml::_( 'form.token' ); ?>
    <table>
        <tr>
            <td>Mã <span style="color:red">*</span></td>
            <td>
                <input type="text" id="mahtdh" name="mahtdh" value="<?php if($htdh_id) echo $job['ma']; ?>">
                <input type="hidden" name="idhtdh" value="<?php if($htdh_id) echo $job['id']; ?>" >
            </td>
        </tr>
        <tr>
            <td>Tên <span style="color:red">*</span></td>
            <td><input type="text" id="tenhtdh" name="tenhtdh" value="<?php if($htdh_id) echo $job['ten']; ?>"></td>
        </tr>
        <tr>
            <td>Trạng thái <span style="color:red">*</span></td>
            <td>
                <label>
                    <input type="radio" name="trangthai" <?php echo ($htdh_id && $job['trangthai']=='1')?'checked="checked"':''; ?> value="1" placeholder="1">
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="trangthai" <?php echo ($htdh_id && $job['trangthai']=='0')?'checked="checked"':''; ?> value="0"/><label class="lbl"></label>
                    <span class="lbl">Không hoạt động</span>
                </label>
            </td>
        </tr>
    </table>
    
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_htdh').validate({
            rules:{
                mahtdh: {required: true},
                tenhtdh: {required: true}
            },
            messages:{
                mahtdh: {required:"Vui lòng nhập mã"},
                tenhtdh: {required:"Vui lòng nhập tên"}
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