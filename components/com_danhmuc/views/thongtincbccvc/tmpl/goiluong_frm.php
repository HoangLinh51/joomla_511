<?php
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
$ngach = Core::loadAssocList('cb_bac_heso','*', null , 'name asc');
$muctuongduong = Core::loadAssocList('grade_level','*','status=1','level asc');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($data['id'] > 0) ? 'Hiệu chỉnh' : 'Thêm mới' ?> Gói lương</h4>
</div>
<div class="modal-body" style="min-height:300px;">
    <form class="form-horizontal" id="form_goiluong" enctype="multipart/form-data">
        <?php echo JHtml::_('form.token'); ?>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="name">Tên <span style="color:red;">*</span></label>
                <div class="controls">
                    <input type="text" style="width:98%" id="name" name="frm[name]" value="<?php echo $data['name']; ?>" />
                    <input type="hidden" name="frm[id]" value="<?php echo $data['id']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="ngach_id">Ngạch lương thuộc gói</label>
                <div class="controls">
                    <select name="frm[ngach_id][]" id="ngach_id" class="chosen" multiple style="width:100%">
                        <option value="">-- Chọn Nâng từ chức danh --</option>
                        <?php for($i=0; $i<count($ngach); $i++){ $row= $ngach[$i];?>
                        <option value="<?php echo $row['id'];?>" <?php if($row['id']==$data['ngach_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="status">Trạng thái <span style="color:red;">*</span></label>
                <div class="controls">
                    <select name="frm[status]" id="status">
                        <option value="">--Chọn trạng thái--</option>
                        <option value="1" <?php echo $data['status'] == 1 ? 'selected' : '' ?>>Đang sử dụng</option>
                        <option value="0" <?php echo $data['status'] == 0 ? 'selected' : '' ?>>Không sử dụng</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <span class="btn btn-small btn-success" id="btn_goiluong_luu"><i class="icon-save"></i> Lưu</span>
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
        $('.chosen').chosen({
			search_contains: true
		});
        $('.date-picker').mask('99/99/9999');
        $.validator.setDefaults({
            ignore: ":hidden:not(.chosen)"
        });
        $('#form_goiluong').validate({
            rules: {
                "frm[name]": {
                    required: true
                },
                "frm[trangthai]": {
                    required: true
                },
                "frm[ngach_id]": {
                    required: true
                },
                "frm[muctuongduong]": {
                    required: true
                },
            },
            messages: {
                "frm[name]": {
                    required: 'Vui lòng nhập tên nhóm chỉ tiêu'
                },
                "frm[trangthai]": {
                    required: 'Vui lòng chọn trạng thái'
                },
                "frm[ngach_id]": {
                    required: 'Vui lòng chọn Ngạch tương ứng'
                },
                "frm[muctuongduong]": {
                    required: 'Vui lòng chọn Mức tương đương'
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
        
        $('#btn_goiluong_luu').on('click', function() {
            $('#gritter-notice-wrapper').remove();
            if ($('#form_goiluong').valid() == true) {
                $.blockUI();
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=goiluong&task=luu_goiluong',
                    data: $('#form_goiluong').serialize(),
                    success: function(data) {
                        if (data > 0) {
                            $('.modal').modal('hide');
                            danhsachgoiluong();
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