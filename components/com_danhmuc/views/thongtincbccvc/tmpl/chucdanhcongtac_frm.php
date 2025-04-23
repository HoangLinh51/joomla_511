<?php
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
$chucdanhcongtac = Core::loadAssocList('danhmuc_chucdanhcongtac','*','id!='.(int)$data['id'],'sapxep asc');
$ngach = Core::loadAssocList('cb_bac_heso','*', null , 'name asc');
$muctuongduong = Core::loadAssocList('grade_level','*','status=1','level asc');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="blue bigger" id="modal-title"><?php echo ($data['id'] > 0) ? 'Hiệu chỉnh' : 'Thêm mới' ?> Chức danh công tác</h4>
</div>
<div class="modal-body" style="min-height:300px;">
    <form class="form-horizontal" id="form_chucdanhcongtac" enctype="multipart/form-data">
        <?php echo JHtml::_('form.token'); ?>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="name">Tên chức danh <span style="color:red;">*</span></label>
                <div class="controls">
                    <input type="text" style="width:98%" id="name" name="frm[name]" value="<?php echo $data['name']; ?>" />
                    <input type="hidden" name="frm[id]" value="<?php echo $data['id']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="nangtu_chucdanh_id">Nâng từ chức danh</label>
                <div class="controls">
                    <select name="frm[nangtu_chucdanh_id]" id="nangtu_chucdanh_id" class="chosen" style="width:100%">
                        <option value="">-- Chọn Nâng từ chức danh --</option>
                        <?php for($i=0; $i<count($chucdanhcongtac); $i++){ $row= $chucdanhcongtac[$i];?>
                        <option value="<?php echo $row['id'];?>" <?php if($row['id']==$data['nangtu_chucdanh_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="ngach_id">Ngạch tương ứng <span style="color:red;">*</span></label>
                <div class="controls">
                    <select name="frm[ngach_id]" id="ngach_id" class="chosen" style="width:100%">
                        <option value="">-- Chọn Nâng từ chức danh --</option>
                        <?php for($i=0; $i<count($ngach); $i++){ $row= $ngach[$i];?>
                        <option value="<?php echo $row['id'];?>" <?php if($row['id']== $data['ngach_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:800px;">
            <div class="control-group">
                <label class="control-label" for="muctuongduong">Mức tương đương <span style="color:red;">*</span></label>
                <div class="controls">
                    <select name="frm[muctuongduong]" id="muctuongduong" class="chosen" style="width:100%">
                        <option value="">-- Chọn Mức tương đương --</option>
                        <?php for($i=0; $i<count($muctuongduong); $i++){ $row= $muctuongduong[$i];?>
                        <option value="<?php echo $row['id'];?>" <?php if($row['id']== $data['muctuongduong']) echo 'selected';?>><?php echo $row['name_grade'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="phantram">Phần trăm</label>
                <div class="controls">
                    <input type="text" id="phantram" name="frm[phantram]" autocomplete="off" value="<?php echo $data['phantram']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="sothanglandau">Số tháng lần đầu</label>
                <div class="controls">
                    <input type="text" id="sothanglandau" name="frm[sothanglandau]" autocomplete="off" value="<?php echo $data['sothanglandau']; ?>">
                </div>
            </div>
        </div>
        <div style="float:left;width:400px;">
            <div class="control-group">
                <label class="control-label" for="sothanglansau">Số tháng lần sau</label>
                <div class="controls">
                    <input type="text" id="sothanglansau" name="frm[sothanglansau]" autocomplete="off" value="<?php echo $data['sothanglansau']; ?>">
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
    <span class="btn btn-small btn-success" id="btn_chucdanhcongtac_luu"><i class="icon-save"></i> Lưu</span>
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
        $('#form_chucdanhcongtac').validate({
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
        
        $('#btn_chucdanhcongtac_luu').on('click', function() {
            $('#gritter-notice-wrapper').remove();
            if ($('#form_chucdanhcongtac').valid() == true) {
                $.blockUI();
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_danhmuc&controller=chucdanhcongtac&task=luu_chucdanhcongtac',
                    data: $('#form_chucdanhcongtac').serialize(),
                    success: function(data) {
                        if (data > 0) {
                            $('.modal').modal('hide');
                            danhsachchucdanhcongtac();
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