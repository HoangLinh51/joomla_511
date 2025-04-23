<?php
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($data['id'] > 0) ? 'Hiệu chỉnh' : 'Thêm mới' ?> Hình thức thi đua</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" id="form_hinhthucthidua" enctype="multipart/form-data">
        <?php echo JHtml::_('form.token'); ?>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="ten">Tên <span style="color:red;">*</span></label>
                <div class="controls">
                    <input type="text" style="width:98%" id="ten" name="frm[ten]" value="<?php echo $data['ten']; ?>" />
                    <input type="hidden" name="frm[id]" value="<?php echo $data['id']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="sapxep">Sắp xếp</label>
                <div class="controls">
                    <input type="text" id="sapxep" name="frm[sapxep]" autocomplete="off" value="<?php echo $data['sapxep']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="trangthai">Trạng thái <span style="color:red;">*</span></label>
                <div class="controls">
                    <select name="frm[trangthai]" id="trangthai">
                        <option value="">--Chọn trạng thái--</option>
                        <option value="1" <?php echo $data['trangthai'] == 1 ? 'selected' : '' ?>>Đang sử dụng</option>
                        <option value="2" <?php echo $data['trangthai'] == 2 ? 'selected' : '' ?>>Không sử dụng</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <span class="btn btn-small btn-success" id="btn_hinhthucthidua_luu"><i class="icon-save"></i> Lưu</span>
    <button class="btn btn-small btn-danger" data-dismiss="modal"><i class="icon-reply"></i> Quay lại</button>
</div>
<script>
    jQuery(document).ready(function($) {
        $('.date-picker').datepicker({
            format: 'dd/mm/yyyy',
            autoClose: true
        }).on('changeDate', function(ev) {
            $(this).datepicker('hide');
        });
        $('.date-picker').mask('99/99/9999');
        $('#form_hinhthucthidua').validate({
            rules: {
                "frm[ten]": {
                    required: true
                },
                "frm[trangthai]": {
                    required: true
                },
            },
            messages: {
                "frm[ten]": {
                    required: 'Vui lòng nhập tên'
                },
                "frm[trangthai]": {
                    required: 'Vui lòng chọn trạng thái'
                },
            },
            invalidHandler: function(event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ?
                        'Kiểm tra lỗi sau:<br/>' :
                        'Phát hiện ' + errors + ' lỗi sau:<br/>';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            errors += "<br/>\u25CF " + validator.errorList[x].message;
                        }
                    }
                    loadNoticeBoardError('Thông báo', message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {}
        });
        $('#btn_hinhthucthidua_luu').on('click', function() {
            $('#gritter-notice-wrapper').remove();
            if ($('#form_hinhthucthidua').valid() == true) {
                $.blockUI();
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=hinhthucthidua&task=luu_hinhthucthidua',
                    data: $('#form_hinhthucthidua').serialize(),
                    success: function(data) {
                        if (data > 0) {
                            $('.modal').modal('hide');
                            danhsachhinhthucthidua();
                            loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công');
                            $.unblockUI();
                        } else {
                            loadNoticeBoardError('Thông báo', 'Xử lý thất bại, vui lòng liên hệ Quản trị viên');
                            $.unblockUI();
                        }
                    },
                    error: function() {
                        loadNoticeBoardError('Thông báo', 'Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
                        $.unblockUI();
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>