<?php
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
$thidua_hinhthuc = Core::loadAssocList('danhmuc_thidua_hinhthuc','*','trangthai=1 and daxoa=0','sapxep asc');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($data['id'] > 0) ? 'Hiệu chỉnh' : 'Thêm mới' ?> Hình thức Khen thưởng, Kỷ luật</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" id="form_khenthuongkyluat" enctype="multipart/form-data">
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
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="type">Loại <span style="color:red;">*</span></label>
                <div class="controls">
                    <select name="frm[type]" id="type">
                        <option value="KT" <?php echo $data['type'] == "KT" ? 'selected' : '' ?>>Khen thưởng</option>
                        <option value="KL" <?php echo $data['type'] == "KL" ? 'selected' : '' ?>>Kỷ luât</option>
                        <option value="KLD" <?php echo $data['type'] == "KLD" ? 'selected' : '' ?>>Kỷ luật Đảng</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="hinhthuc_id">Hình thức khen thưởng</label>
                <div class="controls">
                    <select name="frm[hinhthuc_id]" id="hinhthuc_id">
                        <option value=''>-- Vui lòng chọn --</option>
                        <?php for($i=0; $i<count($thidua_hinhthuc); $i++){ $row=$thidua_hinhthuc[$i];?>
                        <option value="<?php echo $row['id']?>" <?php if($row['id']==$data['hinhthuc_id']) echo 'selected'?>><?php echo $row['ten']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="months_nangluongtruoc">Số tháng nâng lương trước hạn</label>
                <div class="controls">
                    <input type="text" style="width:98%" id="months_nangluongtruoc" name="frm[months_nangluongtruoc]" value="<?php echo $data['months_nangluongtruoc']; ?>" />
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="solantoidatrongnam">Số lần tối đa trong năm</label>
                <div class="controls">
                    <input type="text" style="width:98%" id="solantoidatrongnam" name="frm[solantoidatrongnam]" value="<?php echo $data['solantoidatrongnam']; ?>" />
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="ordering">Sắp xếp</label>
                <div class="controls">
                    <input type="text" id="ordering" name="frm[ordering]" value="<?php echo $data['ordering']; ?>" />
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
                        <option value="2" <?php echo $data['status'] == 2 ? 'selected' : '' ?>>Không sử dụng</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <span class="btn btn-small btn-success" id="btn_khenthuongkyluat_luu"><i class="icon-save"></i> Lưu</span>
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
        $('#form_khenthuongkyluat').validate({
            rules: {
                "frm[name]": {
                    required: true
                },
                "frm[trangthai]": {
                    required: true
                },
            },
            messages: {
                "frm[name]": {
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
        $('#btn_khenthuongkyluat_luu').on('click', function() {
            $('#gritter-notice-wrapper').remove();
            if ($('#form_khenthuongkyluat').valid() == true) {
                $.blockUI();
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=khenthuongkyluat&task=luu_khenthuongkyluat',
                    data: $('#form_khenthuongkyluat').serialize(),
                    success: function(data) {
                        if (data > 0) {
                            $('.modal').modal('hide');
                            danhsachkhenthuongkyluat();
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