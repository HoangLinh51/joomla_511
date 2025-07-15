<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$item = $this->item;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formNguoiCoCong" name="formNguoiCoCong" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=nguoicocong&task=saveNguoicocong'); ?>">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between border-bottom mb-3" style="margin-bottom: 1rem !important;">
            <h2 class="text-primary mb-3" style="padding: 10px 10px 10px 0px;">
                <?php echo ((int)$item[0]['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> người có công
            </h2>
            <span>
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
            </span>
        </div>
        <input type="hidden" name="id_nguoicocong" value="<?php echo htmlspecialchars($item[0]['doituonghuong']); ?>">

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item[0]['id']); ?>">
        <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($item[0][0]['nhankhau_id']); ?>">

        <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
            <h5 style="margin: 0">Thông tin cá nhân</h5>
            <div class="d-flex align-items-center" style="gap:5px">
                <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo htmlspecialchars($item[0]['nhankhau_id']) ? 'checked' : ''; ?>>
                <small>Chọn người lao động từ danh sách nhân khẩu</small>
            </div>
        </div>
        <div id="select-container" style="display: <?php echo htmlspecialchars($item[0]['nhankhau_id']) ? 'block' : 'none'; ?>;" class="mb-3">
            <label for="select_top" class="form-label fw-bold">Tìm nhân khẩu</label>
            <select id="select_top" name="select_top" class="custom-select">
                <option value="">-- Chọn --</option>
                <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
                    <option value="<?php echo $tv['id']; ?>" <?php echo htmlspecialchars($item[0]['nhankhau_id']) == $tv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tv['hoten']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-4 mb-2">
                <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($item[0]['n_hoten']); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="select_gioitinh_id" class="form-label fw-bold">Giới tính</label>
                <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="<?php echo htmlspecialchars($item[0]['n_gioitinh_id']); ?>">
                <select id="select_gioitinh_id" name="select_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
                    <option value=""></option>
                    <?php foreach ($this->gioitinh as $gt) { ?>
                        <option value="<?php echo $gt['id']; ?>" <?php echo $item[0]['n_gioitinh_id'] == $gt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($gt['tengioitinh']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label for="cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
                <input id="cccd" type="text" name="cccd" class="form-control" value="<?php echo htmlspecialchars($item[0]['n_cccd']); ?>" placeholder="Nhập CCCD/CMND">
            </div>
            <div class="col-md-4 mb-2">
                <label for="namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
                <input type="hidden" id="input_namsinh" name="input_namsinh" value="<?php echo htmlspecialchars($item[0]['ngaysinh']); ?>">
                <div class="input-group">
                    <input type="text" id="select_namsinh" name="select_namsinh" class="form-control namsinh" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($item[0]['ngaysinh']); ?>">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="dienthoai" class="form-label fw-bold">Điện thoại</label>
                <input id="dienthoai" type="text" name="dienthoai" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($item[0]['n_dienthoai']); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="select_dantoc_id" class="form-label fw-bold">Dân tộc</label>
                <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="<?php echo htmlspecialchars($item[0]['n_dantoc_id']); ?>">
                <select id="select_dantoc_id" name="select_dantoc_id" class="custom-select" data-placeholder="Chọn dân tộc">
                    <option value=""></option>
                    <?php foreach ($this->dantoc as $dt) { ?>
                        <option value="<?php echo $dt['id']; ?>" <?php echo $item['n_dantoc_id'] == $dt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dt['tendantoc']); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="select_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
                <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="<?php echo htmlspecialchars($item[0]['n_phuongxa_id']); ?>">
                <select id="select_phuongxa_id" name="select_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                    <option value=""></option>
                    <?php if (is_array($this->phuongxa)) { ?>
                        <?php foreach ($this->phuongxa as $px) { ?>
                            <option value="<?php echo $px['id']; ?>" <?php echo $item[0]['n_phuongxa_id'] == $px['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="select_thonto_id" class="form-label fw-bold">Thôn tổ</label>
                <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="<?php echo htmlspecialchars($item[0]['n_thonto_id']); ?>">
                <select id="select_thonto_id" name="select_thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
                <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($item[0]['n_diachi']); ?>">
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-4">Thông tin người nhận</h5>
        <div class="row g-3 mb-4">

            <div class="col-md-4 mb-2">
                <label for="namsinh" class="form-label fw-bold">Họ tên người nhận</label>
                <div class="input-group">
                    <input type="text" id="nguoinhangiup" name="nguoinhangiup" class="form-control" placeholder="Nhập họ tên người nhận" value="<?php echo htmlspecialchars($item[0]['tennguoinhan']); ?>">
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="sotaikhoan" class="form-label fw-bold">Số tài khoản ngân hàng</label>
                <input id="sotaikhoan" type="text" name="sotaikhoan" class="form-control" placeholder="Nhập số tài khoản ngân hàng" value="<?php echo htmlspecialchars($item[0]['sotaikhoan']); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="dienthoai" class="form-label fw-bold">Ngân hàng</label>
                <select id="nganhang_id" name="nganhang_id" class="custom-select" data-placeholder="Chọn ngân hàng">
                    <option value=""></option>
                    <?php foreach ($this->nganhang as $nh) { ?>
                        <option value="<?php echo $nh['id']; ?>" <?php echo $item[0]['nganhang_id'] == $nh['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nh['ten']); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>



        <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h5 class="">Thông tin hưởng chính sách</h5>
            <!-- <button class="btn btn-success btn_themchinhsach">Thêm chính sách</button> -->
            <button type="button" class="btn btn-success" id="btn_themchinhsach" data-toggle="modal" data-target="#modalTroCap"><i class="fas fa-plus"></i> Thêm chính sách</button>

        </div>
        <div class="row g-3 mb-4">
            <table class="table table-striped table-bordered" style="height: 150px; overflow-y: auto;">
                <thead class="table-primary text-white">
                    <tr>
                        <th>STT</th>
                        <th>Hình thức hưởng</th>
                        <th>Loại đối tượng</th>
                        <th>Thực nhận</th> <!--trợ cấp và phụ cấp -->
                        <th>Ngày hưởng</th>
                        <th>Trạng thái</th>
                        <th>Loại ưu đãi</th>
                        <th>Chức năng</th>

                    </tr>
                </thead>
                <tbody class="dsThongtintrocap">

                    <?php if (is_array($item) && count($item) > 0) { ?>
                        <?php foreach ($item as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle">
                                    <?php
                                    // Kiểm tra giá trị của is_hinhthuc và hiển thị văn bản tương ứng
                                    switch ($nk['is_hinhthuc']) {
                                        case 1:
                                            echo 'Hàng tháng';
                                            break;
                                        case 2:
                                            echo 'Một lần';
                                            break;
                                        default:
                                            echo 'Không xác định'; // Giá trị khác không được xác định
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="align-middle"><?php echo ($nk['tenncc']); ?></td>
                                <td class="align-middle"><strong>Trợ cấp:</strong><?php echo htmlspecialchars($nk['trocap'] ?? ''); ?><br>
                                    <strong>Phụ cấp:</strong> <?php echo $nk['phucap']; ?>

                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['ngayhuong2'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['trangthai'] ?? ''); ?></td>

                                <td class="align-middle">
                                    <?php
                                    // Kiểm tra xem có tendungcu hay không
                                    if (!empty($nk['tendungcu'])) {
                                        // Nếu có, hiển thị tendungcu
                                        echo htmlspecialchars($nk['tendungcu']);
                                    } else {
                                        // Nếu không có, hiển thị tenuudai
                                        echo htmlspecialchars($nk['tenuudai'] ?? '');
                                    }
                                    ?>
                                </td>
                                <td class="align-middle text-center" style="min-width:100px">
                                    <input type="hidden" name="trocap_id[]" value="<?php echo htmlspecialchars($nk['id_trocap'] ?? ''); ?>" />
                                    <input type="hidden" name="ma_hotro[]" value="<?php echo htmlspecialchars($nk['maht'] ?? ''); ?>" />
                                    <input type="hidden" name="is_hinhthuc[]" value="<?php echo htmlspecialchars($nk['is_hinhthuc'] ?? ''); ?>" />
                                    <input type="hidden" name="dmnguoicocong_id[]" value="<?php echo htmlspecialchars($nk['dmnguoicocong_id'] ?? ''); ?>" />
                                    <input type="hidden" name="trocap[]" value="<?php echo htmlspecialchars($nk['trocap'] ?? ''); ?>" />
                                    <input type="hidden" name="phucap[]" value="<?php echo htmlspecialchars($nk['phucap'] ?? ''); ?>" />
                                    <input type="hidden" name="dmtyle_id[]" value="<?php echo htmlspecialchars($nk['dmtyle_id'] ?? ''); ?>" />
                                    <input type="hidden" name="ngayhuong[]" value="<?php echo htmlspecialchars($nk['ngayhuong2'] ?? ''); ?>" />
                                    <input type="hidden" name="uudai_id[]" value="<?php echo htmlspecialchars($nk['uudai_id'] ?? ''); ?>" />
                                    <input type="hidden" name="noidunguudai[]" value="<?php echo htmlspecialchars($nk['noidunguudai'] ?? ''); ?>" />
                                    <input type="hidden" name="loaidungcu_id[]" value="<?php echo htmlspecialchars($nk['loaidungcu_id'] ?? ''); ?>" />
                                    <input type="hidden" name="ngayuudai[]" value="<?php echo htmlspecialchars($nk['ngayuudai'] ?? ''); ?>" />
                                    <input type="hidden" name="id_uudai[]" value="<?php echo htmlspecialchars($nk['id_uudai'] ?? ''); ?>" />
                                    <input type="hidden" name="id_huongncc[]" value="<?php echo htmlspecialchars($nk['id_huongncc'] ?? ''); ?>" />
                                    <input type="hidden" name="trangthai_id[]" value="<?php echo htmlspecialchars($nk['trangthai_id'] ?? ''); ?>" />

                                    <span class="btn btn-sm btn-warning btn_edit_trocap" title="Sửa chính sách này">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="btn btn-sm btn-danger btn_xoa_trocap" title="Xóa chính sách này" data-trocap-id="<?php echo htmlspecialchars($nk['id_huongncc'] ?? ''); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="no-data">
                            <td colspan="13" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>
<!-- Modal thông tin hưởng bảo trợ -->
<div class="modal fade" id="modalTroCap" tabindex="-1" role="dialog" aria-labelledby="modalTroCapLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTroCapLabel">Thêm thông tin trợ cấp</h5>
                <button type="button" class="btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalTroCap">
                    <div id="trocap_fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hình thức hưởng <span class="text-danger">*</span></label>
                                    <select id="modal_hinhthuchuong" name="modal_hinhthuchuong" class="custom-select" data-placeholder="Chọn hình thức hưởng" required>
                                        <option value=""></option>
                                        <option value="1">Hàng tháng</option>
                                        <option value="2">Một lần</option>
                                    </select>
                                    <label class="error_modal" for="modal_ma_hotro"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Đối tượng hưởng <span class="text-danger">*</span></label>
                                    <select id="modal_doituonghuong" name="modal_doituonghuong" class="custom-select" data-placeholder="Chọn đối tượng hưởng" required>
                                        <option value="">Chọn đối tượng hưởng</option>
                                    </select>
                                    <label class="error_modal" for="modal_doituonghuong"></label>
                                </div>
                            </div>
                            <div class="col-md-6" id="container_tyle">
                                <div class="mb-3">
                                    <label class="form-label">Tỷ lệ <span class="text-danger">*</span></label>
                                    <select id="modal_tyle" name="modal_tyle" class="custom-select" data-placeholder="Chọn tỷ lệ">
                                        <option value=""></option>
                                    </select>
                                    <label class="error_modal" for="modal_tyle"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trợ cấp <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_trocap" name="modal_trocap" class="form-control" placeholder="Nhập trợ cấp">

                                    <label class="error_modal" for="modal_trocap"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phụ cấp <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_phucap" name="modal_phucap" class="form-control" placeholder="Phụ cấp">
                                    <label class="error_modal" for="modal_phucap"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày hưởng </label>
                                    <input type="text" id="modal_ngayhuong" name="modal_ngayhuong" class="form-control date-picker" placeholder="Nhập ngày hưởng">
                                    <label class="error_modal" for="modal_ngayhuong"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái hưởng <span class="text-danger">*</span></label>
                                    <select id="modal_trang_thai" name="modal_trang_thai" class="custom-select" data-placeholder="Chọn trạng thái">
                                        <option value=""></option>
                                        <?php if (is_array($this->tinhtrang) && count($this->tinhtrang) > 0) { ?>
                                            <?php foreach ($this->tinhtrang as $ldt) { ?>
                                                <option value="<?php echo $ldt['id']; ?>" data-text="<?php echo htmlspecialchars($ldt['ten']); ?>">
                                                    <?php echo htmlspecialchars($ldt['ten']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu trạng thái</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_trang_thai"></label>
                                </div>
                            </div>
                            <h5 class="border-bottom pb-2 mb-4">Thông tin ưu đãi</h5>
                            <div class="row g-3 mb-4">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Loại ưu đãi</label>
                                        <select id="modal_loaiuudai" name="modal_loaiuudai" class="custom-select" data-placeholder="Chọn loại ưu dãi">
                                            <option value=""></option>
                                            <?php if (is_array($this->uudai) && count($this->uudai) > 0) { ?>
                                                <?php foreach ($this->uudai as $ud) { ?>
                                                    <option value="<?php echo $ud['id']; ?>" data-text="<?php echo htmlspecialchars($ud['ten']); ?>">
                                                        <?php echo htmlspecialchars($ud['ten']); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">Không có dữ liệu trạng thái</option>
                                            <?php } ?>
                                        </select>
                                        <label class="error_modal" for="modal_loaiuudai"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung ưu đãi </label>
                                        <input type="text" id="modal_noidunguudai" name="modal_noidunguudai" class="form-control" placeholder="Nhập nội dung ưu đãi">
                                        <label class="error_modal" for="modal_noidunguudai"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Trợ cấp</label>
                                        <input type="text" id="modal_trocapuudai" name="modal_trocapuudai" class="form-control" placeholder="Nhập trợ cấp">
                                        <label class="error_modal" for="modal_trocapuudai"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày ưu đãi </label>
                                        <input type="text" id="modal_ngayuudai" name="modal_ngayuudai" class="form-control date-picker" placeholder="Nhập ngày ưu đãi">
                                        <label class="error_modal" for="modal_ngayuudai"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên dụng cụ</label>
                                        <select id="modal_dungcu" name="modal_dungcu" class="custom-select" data-placeholder="Chọn dụng cụ">
                                            <option value=""></option>
                                            <?php if (is_array($this->dungcu) && count($this->dungcu) > 0) { ?>
                                                <?php foreach ($this->dungcu as $dc) { ?>
                                                    <option value="<?php echo $dc['id']; ?>" data-text="<?php echo htmlspecialchars($dc['tendungcu']); ?>">
                                                        <?php echo htmlspecialchars($dc['ten']); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">Không có dữ liệu trạng thái</option>
                                            <?php } ?>
                                        </select>
                                        <label class="error_modal" for="modal_dungcu"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Niên hạn</label>
                                        <input type="text" id="modal_nienhan" name="modal_nienhan" class="form-control date-picker" placeholder="Nhập niên hạn">
                                        <label class="error_modal" for="modal_nienhan"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Trợ cấp </label>
                                        <input type="text" id="modal_trocapdungcu" name="modal_trocapdungcu" class="form-control" placeholder="Nhập">
                                        <label class="error_modal" for="modal_trocapdungcu"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="modal_trocap_id" name="modal_trocap_id" value="">
                    <input type="hidden" id="modal_id_uudai" name="modal_id_uudai" value="">

                    <input type="hidden" id="modal_edit_index" name="modal_edit_index" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
                <input type="hidden" id="modal_trocap_id" name="modal_trocap_id" value="">
                <input type="hidden" id="modal_id_uudai" name="modal_id_uudai" value="">

                <button type="button" class="btn btn-primary" id="btn_luu_trocap"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const $hinhThucHuong = $('#modal_hinhthuchuong');
        const $doiTuongHuong = $('#modal_doituonghuong');
        const $selectTyle = $('#modal_tyle');
        const $inputTroCap = $('#modal_trocap');
        const $inputPhuCap = $('#modal_phucap');
        const $allControls = $selectTyle.add($inputTroCap).add($inputPhuCap);
        const $loaiUuDai = $('#modal_loaiuudai');
        const $noiDungUuDai = $('#modal_noidunguudai');
        const $ngayUuDai = $('#modal_ngayuudai');
        const $trocapUuDai = $('#modal_trocapuudai');
        const $dungCu = $('#modal_dungcu');
        const $nienHan = $('#modal_nienhan');
        const $trocapDungCu = $('#modal_trocapdungcu');
        const $uudaiFields = $noiDungUuDai.add($trocapUuDai);
        const $dungcuFields = $dungCu.add($nienHan).add($trocapDungCu);

        function showToast(message, isSuccess = true) {
            const toast = $('<div></div>').text(message).css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                background: isSuccess ? '#28a745' : '#dc3545',
                color: '#fff',
                padding: '10px 20px',
                borderRadius: '5px',
                boxShadow: '0 0 10px rgba(0,0,0,0.3)',
                zIndex: 9999,
                transition: 'opacity 0.5s'
            }).appendTo('body').fadeIn();
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
        }

        function formatCurrency(value) {
            if (!value) return '';
            if (typeof value === 'string' && value.match(/[\.,]/)) {
                return value;
            }
            const num = parseFloat(value.toString().replace(/[^\d]/g, ''));
            return isNaN(num) ? '' : num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function resetInputFields() {
            $inputTroCap.val('');
            $inputPhuCap.val('');
            $selectTyle.html('<option value=""></option>').val(null).trigger('change');
            $allControls.prop('disabled', true);
            $uudaiFields.val('').prop('disabled', false);
            $uudaiFields.closest('.col-md-6').show();
            $dungcuFields.val('').prop('disabled', true);
            $dungCu.html('<option value="">Chọn dụng cụ</option>').val(null).trigger('change');
            $dungcuFields.closest('.col-md-6').hide();
            $nienHan.prop('readonly', false);
            $trocapDungCu.prop('readonly', false);
        }

        let doiTuongDataStore = {};

        function cleanNumberString(str) {
            if (typeof str === 'string') {
                return str.replace(/,/g, '');
            }
            return str;
        }

        $hinhThucHuong.change(function() {
            const hinhThucHuong = $(this).val();
            doiTuongDataStore = {};
            $doiTuongHuong.html('<option value="">Chọn đối tượng hưởng</option>').trigger('change');

            if (!hinhThucHuong) {
                return;
            }

            $.ajax({
                url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDoiTuongHuong',
                type: 'GET',
                data: {
                    hinh_thuc: hinhThucHuong
                },
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">Chọn đối tượng hưởng</option>';
                    if (Array.isArray(response) && response.length > 0) {
                        $.each(response, function(index, item) {
                            const formattedItem = {
                                ...item,
                                trocap: formatCurrency(item.trocap),
                                phucap: formatCurrency(item.phucap),
                                trocap2: formatCurrency(item.trocap2)
                            };
                            options += `<option value="${item.id}">${item.ten}</option>`;
                            doiTuongDataStore[item.id] = formattedItem;
                        });
                    } else {
                        options += '<option value="">Không có dữ liệu</option>';
                    }
                    $doiTuongHuong.html(options);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        });

        $doiTuongHuong.change(function() {
            resetInputFields();
            const selectedId = $(this).val();
            if (!selectedId) return;

            const data = doiTuongDataStore[selectedId];
            if (!data) return;

            const hinhThucHuong = $hinhThucHuong.val();

            if (hinhThucHuong === '1') {
                if (data.is_check == 0) {
                    $inputTroCap.prop('disabled', true).val(formatCurrency(data.trocap));
                    $inputPhuCap.prop('disabled', true).val(formatCurrency(data.phucap));
                } else {
                    $selectTyle.prop('disabled', false);
                    $.ajax({
                        url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDMTyle',
                        type: 'GET',
                        data: {
                            tyle_id: selectedId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (Array.isArray(response) && response.length > 0) {
                                let options = '<option value=""></option>';
                                $.each(response, function(index, item) {
                                    options += `<option value="${item.tyle}" data-trocap2="${item.trocap2}">${item.tyle}% (${item.trocap2})</option>`;
                                });
                                $selectTyle.html(options).trigger('change');

                                if (response.length === 1) {
                                    $selectTyle.val(response[0].tyle).trigger('change');
                                    $inputTroCap.val(response[0].trocap2);
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    });
                }
            } else if (hinhThucHuong === '2') {
                $inputTroCap.prop('disabled', true).val(formatCurrency(data.trocap));
            }
        });

        $selectTyle.change(function() {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                const trocap2 = selectedOption.data('trocap2');
                $inputTroCap.val(trocap2);
            } else {
                // $inputTroCap.val('');
            }
        });

        $loaiUuDai.change(function() {
            const loaiUuDaiId = $(this).val();
            $uudaiFields.val('').prop('disabled', false);
            $dungcuFields.val('').prop('disabled', true);
            $dungCu.html('<option value="">Chọn dụng cụ</option>').val(null).trigger('change');

            if (loaiUuDaiId === '3') {
                $uudaiFields.closest('.col-md-6').hide();
                $dungcuFields.closest('.col-md-6').show();
                $dungCu.prop('disabled', false);
                $.ajax({
                    url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDMdungcu',
                    type: 'GET',
                    data: {
                        uudai_id: loaiUuDaiId
                    },
                    dataType: 'json',
                    success: function(response) {
                        let options = '<option value="">Chọn dụng cụ</option>';
                        if (Array.isArray(response) && response.length > 0) {
                            $.each(response, function(index, item) {
                                options += `<option value="${item.id}" data-nienhan="${item.nienhan}" data-muccap="${item.muccap}">${item.tendungcu}</option>`;
                            });
                        } else {
                            options += '<option value="">Không có dữ liệu</option>';
                        }
                        $dungCu.html(options).trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        showToast('Lỗi khi tải danh mục dụng cụ', false);
                    }
                });
            } else {
                $uudaiFields.closest('.col-md-6').show();
                $dungcuFields.closest('.col-md-6').hide();
            }
        });

        $dungCu.change(function() {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                const nienhan = selectedOption.data('nienhan');
                const muccap = selectedOption.data('muccap');
                $nienHan.val(nienhan).prop('readonly', true);
                $trocapDungCu.val(formatCurrency(muccap)).prop('readonly', true);
            } else {
                $nienHan.val('').prop('readonly', false);
                $trocapDungCu.val('').prop('readonly', false);
            }
        });

        resetInputFields();

        function initSelect2($element, options) {
            if ($element.length && $.fn.select2) {
                if ($element.data('select2')) {
                    try {
                        $element.select2('destroy');
                    } catch (e) {
                        console.warn('Lỗi khi hủy Select2:', e);
                    }
                }
                $element.select2($.extend({
                    width: '100%',
                    allowClear: true,
                    placeholder: function() {
                        return $(this).data('placeholder') || 'Chọn một tùy chọn';
                    },
                    minimumResultsForSearch: 0
                }, options));
            }
        }

        function initializeModalSelect2() {
            $('#modalTroCap select.custom-select').not('#modal_nhankhau_search').each(function() {
                initSelect2($(this), {
                    width: '100%',
                    allowClear: true,
                    placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                    dropdownParent: $('#modalTroCap')
                });
            });
        }

        $('#modalTroCap .date-picker').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy'
        });

        if ($.fn.validate) {
            $('#frmModalTroCap').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    error.addClass('error_modal');
                    error.appendTo(element.closest('.mb-3'));
                },
                success: function(label) {
                    console.log('Validate success for:', label.prev().attr('id'));
                    label.remove();
                },
                rules: {
                    modal_ma_hotro: {
                        required: true
                    },
                    modal_bien_dong: {
                        required: true
                    },
                    modal_chinh_sach: {
                        required: true
                    },
                    modal_loai_doi_tuong: {
                        required: true
                    },
                    modal_he_so: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    modal_muc_tien_chuan: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    modal_thuc_nhan: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    modal_huong_tu_ngay: {
                        required: true
                    },
                    modal_trang_thai: {
                        required: true
                    }
                },
                messages: {
                    modal_ma_hotro: 'Vui lòng nhập mã hỗ trợ',
                    modal_bien_dong: 'Vui lòng chọn biến động',
                    modal_chinh_sach: 'Vui lòng chọn chính sách',
                    modal_loai_doi_tuong: 'Vui lòng chọn loại đối tượng',
                    modal_he_so: {
                        required: 'Vui lòng nhập hệ số',
                        number: 'Hệ số phải là số',
                        min: 'Hệ số phải lớn hơn hoặc bằng 0'
                    },
                    modal_muc_tien_chuan: {
                        required: 'Vui lòng chọn loại đối tượng để có mức tiền chuẩn',
                        number: 'Mức tiền chuẩn phải là số',
                        min: 'Mức tiền chuẩn phải lớn hơn hoặc bằng 0'
                    },
                    modal_thuc_nhan: {
                        required: 'Vui lòng nhập hệ số để tính số tiền thực nhận',
                        number: 'Số tiền thực nhận phải là số',
                        min: 'Số tiền thực nhận phải lớn hơn hoặc bằng 0'
                    },
                    modal_huong_tu_ngay: 'Vui lòng nhập ngày bắt đầu hưởng',
                    modal_trang_thai: 'Vui lòng chọn trạng thái'
                }
            });
        }

        $('#modalTroCap').on('change.select2', '#modal_loai_doi_tuong', function(e) {
            const $form = $('#frmModalTroCap');
            const selectedData = $(this).select2('data');
            let sotien = '';

            if (selectedData && selectedData.length > 0 && selectedData[0].element) {
                const originalOption = selectedData[0].element;
                sotien = $(originalOption).data('sotien');
            }

            console.log('Loại đối tượng selected. Lấy "sotien" từ data attribute:', sotien);
            sotien = cleanNumberString(sotien);

            if (sotien !== undefined && sotien !== '' && !isNaN(parseFloat(sotien))) {
                const sotienValue = parseFloat(sotien);
                $('#modal_muc_tien_chuan').val(sotienValue.toFixed(0));
                $('#modal_thuc_nhan').prop('readonly', true);
            } else {
                $('#modal_muc_tien_chuan').val('');
                $('#modal_thuc_nhan').val('').prop('readonly', false);
                console.warn('sotien không hợp lệ:', sotien);
            }

            if ($form.validate) {
                $form.validate().element(this);
                $form.validate().element('#modal_muc_tien_chuan');
            }

            const he_so = parseFloat($('#modal_he_so').val());
            if (sotien && !isNaN(sotien) && !isNaN(he_so)) {
                const thuc_nhan = he_so * parseFloat(sotien);
                $('#modal_thuc_nhan').val(thuc_nhan.toFixed(0));
                if ($form.validate) {
                    $form.validate().element('#modal_thuc_nhan');
                }
            } else {
                $('#modal_thuc_nhan').val('');
            }
        });

        function initializeModalPlugins() {
            $('#modalTroCap select.custom-select').each(function() {
                initSelect2($(this), {});
            });
            $('#modalTroCap .date-picker:not(.hasDatepicker)').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'dd/mm/yyyy'
            }).addClass('hasDatepicker');
        }

        $('#modal_he_so').on('input change', function() {
            const $form = $('#frmModalTroCap');
            const he_so = parseFloat($(this).val());
            let muc_tien_chuan = $('#modal_muc_tien_chuan').val();
            muc_tien_chuan = cleanNumberString(muc_tien_chuan);
            console.log('Hệ số:', he_so, 'Mức tiền chuẩn (cleaned):', muc_tien_chuan);

            if (!isNaN(he_so) && !isNaN(parseFloat(muc_tien_chuan))) {
                const thuc_nhan = he_so * parseFloat(muc_tien_chuan);
                $('#modal_thuc_nhan').val(thuc_nhan.toFixed(0));
            } else {
                $('#modal_thuc_nhan').val('');
            }

            if ($form.validate) {
                $form.validate().element(this);
                $form.validate().element('#modal_thuc_nhan');
            }
        });

        $('#modal_bien_dong, #modal_chinh_sach, #modal_trang_thai').on('change.select2', function() {
            const $form = $('#frmModalTroCap');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });

        $('#modal_ma_hotro, #modal_so_quyet_dinh, #modal_ngay_quyet_dinh, #modal_huong_tu_ngay').on('change input', function() {
            const $form = $('#frmModalTroCap');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });

        function updateTroCapSTT() {
            $('.dsThongtintrocap tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
            });
        }
        $('.dsThongtintrocap').on('click', '.btn_edit_trocap', function() {
            const $row = $(this).closest('tr');

            const data = {
                id_huongncc: $row.find('[name="id_huongncc[]"]').val() || '',
                id_uudai: $row.find('[name="id_uudai[]"]').val() || '',
                is_hinhthuc: $row.find('[name="is_hinhthuc[]"]').val() || '',
                dmnguoicocong_id: $row.find('[name="dmnguoicocong_id[]"]').val() || '',
                trangthai_id: $row.find('[name="trangthai_id[]"]').val() || '',
                trocap: $row.find('[name="trocap[]"]').val() || '',
                phucap: $row.find('[name="phucap[]"]').val() || '',
                dmtyle_id: $row.find('[name="dmtyle_id[]"]').val() || '',
                loai_uudai: $row.find('[name="uudai_id[]"]').val() || '',
                noidung_uudai: $row.find('[name="noidunguudai[]"]').val() || '',
                trocap_uudai: $row.find('[name="trocapuudai[]"]').val() || '',
                loaidungcu_id: $row.find('[name="loaidungcu_id[]"]').val() || '',
                nienhan: $row.find('[name="nienhan[]"]').val() || '',
                trocap_dungcu: $row.find('[name="trocapdungcu[]"]').val() || '',
                ngay_uudai: $row.find('[name="ngayuudai[]"]').val() || '',
                ngay_huong: $row.find('[name="ngayhuong[]"]').val() || ''
            };

            console.log('Dữ liệu từ row:', data); // Debug dữ liệu từ row

            $('#modalTroCapLabel').text('Chỉnh sửa thông tin trợ cấp');
            $('#frmModalTroCap')[0].reset();
            resetInputFields();
            initializeModalPlugins();

            // Điền dữ liệu cơ bản
            $('#modal_trocap_id').val(data.id_huongncc);
            $('#modal_id_uudai').val(data.id_uudai);
            $('#modal_edit_index').val($row.index());
            $('#modal_trocap').val(formatCurrency(data.trocap));
            $('#modal_phucap').val(formatCurrency(data.phucap));
            $('#modal_ngayhuong').val(data.ngay_huong);
            $('#modal_ngayuudai').val(data.ngay_uudai);
            $('#modal_noidunguudai').val(data.noidung_uudai);
            $('#modal_trocapuudai').val(formatCurrency(data.trocap_uudai));
            $('#modal_nienhan').val(data.nienhan);
            $('#modal_trocapdungcu').val(formatCurrency(data.trocap_dungcu));
            $('#modal_trang_thai').val(data.trangthai_id).trigger('change.select2');
            setTimeout(() => {

                if (data.loai_uudai) {
                    $('#modal_loaiuudai').val(data.loai_uudai).trigger('change');
                    setTimeout(() => {
                        if (data.loai_uudai === '3' && data.loaidungcu_id) {
                            $('#modal_dungcu').val(data.loaidungcu_id).trigger('change');
                        }
                    }, 300);
                }
            }, 300);
            // Sử dụng Promise để đồng bộ hóa AJAX
            $.when(
                $.ajax({
                    url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDoiTuongHuong',
                    type: 'GET',
                    data: {
                        hinh_thuc: data.is_hinhthuc
                    },
                    dataType: 'json'
                })
            ).then(response => {
                let options = '<option value="">Chọn đối tượng hưởng</option>';
                if (Array.isArray(response) && response.length > 0) {
                    $.each(response, function(index, item) {
                        const formattedItem = {
                            ...item,
                            trocap: formatCurrency(item.trocap),
                            phucap: formatCurrency(item.phucap),
                            trocap2: formatCurrency(item.trocap2)
                        };
                        options += `<option value="${item.id}">${item.ten}</option>`;
                        doiTuongDataStore[item.id] = formattedItem;
                    });
                } else {
                    options += '<option value="">Không có dữ liệu</option>';
                }
                $doiTuongHuong.html(options).val(data.dmnguoicocong_id).trigger('change.select2');
                console.log('Giá trị modal_doituonghuong sau khi gán:', $doiTuongHuong.val());

                // Đợi loadDMTyle
                if (data.is_hinhthuc === '1' && doiTuongDataStore[data.dmnguoicocong_id]?.is_check == 1) {
                    return $.ajax({
                        url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDMTyle',
                        type: 'GET',
                        data: {
                            tyle_id: data.dmnguoicocong_id
                        },
                        dataType: 'json'
                    });
                }
                return $.Deferred().resolve([]); // Trả về Promise rỗng nếu không cần loadDMTyle
            }).then(response => {
                if (response.length > 0) {
                    let options = '<option value=""></option>';
                    $.each(response, function(index, item) {
                        options += `<option value="${item.tyle}" data-trocap2="${item.trocap2}">${item.tyle}% (${item.trocap2})</option>`;
                    });
                    $selectTyle.html(options).val(data.dmtyle_id).trigger('change.select2');
                    console.log('Giá trị modal_tyle sau khi gán:', $selectTyle.val());
                    if (!$selectTyle.val()) {
                        console.warn('Không gán được giá trị cho modal_tyle:', data.dmtyle_id);
                        showToast('Cảnh báo: Tỷ lệ không hợp lệ, vui lòng kiểm tra.', false);
                    }
                }

                // Điền các trường ưu đãi
                if (data.loai_uudai) {
                    $('#modal_loaiuudai').val(data.loai_uudai).trigger('change.select2');
                    if (data.loai_uudai === '3' && data.loaidungcu_id && data.loaidungcu_id !== 'undefined') {
                        return $.ajax({
                            url: 'index.php?option=com_vhytgd&controller=nguoicocong&task=loadDMdungcu',
                            type: 'GET',
                            data: {
                                uudai_id: data.loai_uudai
                            },
                            dataType: 'json'
                        }).then(response => {
                            let options = '<option value="">Chọn dụng cụ</option>';
                            if (Array.isArray(response) && response.length > 0) {
                                $.each(response, function(index, item) {
                                    options += `<option value="${item.id}" data-nienhan="${item.nienhan}" data-muccap="${item.muccap}">${item.tendungcu}</option>`;
                                });
                            } else {
                                options += '<option value="">Không có dữ liệu</option>';
                            }
                            $dungCu.html(options).val(data.loaidungcu_id).trigger('change.select2');
                            console.log('Giá trị modal_dungcu sau khi gán:', $dungCu.val());
                        });
                    }
                }
            }).always(() => {
                $('#modal_hinhthuchuong').val(data.is_hinhthuc).trigger('change.select2');
                $('#modalTroCap').modal('show');
            });
        });

        $('#btn_luu_trocap').on('click', function() {
            const $form = $('#frmModalTroCap');
            if ($form.valid()) {
                const formData = $form.serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                });
                const trocap = $('#modal_trocap').val();
                const phucap = $('#modal_phucap').val();
                // Explicitly include readonly fields
                data.modal_trocap = $('#modal_trocap').val() || '';
                data.modal_phucap = $('#modal_phucap').val() || '';
                data.modal_dungcu = $('#modal_dungcu').val() || '';


                data.modal_nienhan = $('#modal_nienhan').val() || '';
                data.modal_trocapdungcu = $('#modal_trocapdungcu').val() || '';
                data.modal_trocapdungcu = $('#modal_trocapdungcu').val() || '';

                const thuc_nhan = `${trocap || ''} ${phucap || ''}`.trim(); // Sử dụng trim() để loại bỏ khoảng trắng thừa
                data.modal_thuc_nhan = thuc_nhan;
                const editIndex = parseInt($('#modal_edit_index').val());
                console.log('editIndex:', editIndex);
                console.log('Dữ liệu trợ cấp:', data);

                const hinh_thuc_huong_text = $('#modal_hinhthuchuong option:selected').data('text') || $('#modal_hinhthuchuong option:selected').text() || '';
                const doi_tuong_huong_text = $('#modal_doituonghuong option:selected').data('text') || $('#modal_doituonghuong option:selected').text() || '';
                const trang_thai_text = $('#modal_trang_thai option:selected').data('text') || $('#modal_trang_thai option:selected').text() || '';
                const loai_uudai_text = $('#modal_loaiuudai option:selected').data('text') || $('#modal_loaiuudai option:selected').text() || '';
                const dungcu_text = $('#modal_dungcu option:selected').data('text') || $('#modal_dungcu option:selected').text() || '';

                let uu_dai_info = '';
                if (data.modal_loaiuudai === '3') {
                    uu_dai_info = `Tên dụng cụ: ${dungcu_text}<br>Niên hạn: ${data.modal_nienhan || ''}<br>Trợ cấp dụng cụ: ${data.modal_trocapdungcu || ''}`;
                } else {
                    uu_dai_info = `Nội dung ưu đãi: ${data.modal_noidunguudai || ''}<br>Trợ cấp ưu đãi: ${data.modal_trocapuudai || ''}`;
                }

                const html = `
                <tr>
                    <td class="align-middle text-center stt"></td>
                    <td class="align-middle">${hinh_thuc_huong_text}</td>
                    <td class="align-middle">${doi_tuong_huong_text}</td>
                     <td class="align-middle"><strong>Trợ cấp:</strong>${trocap}<br>
                    <strong>Phụ cấp:</strong> ${phucap}

                    </td>
                    <td class="align-middle">${data.modal_ngayhuong || ''}</td>
                    <td class="align-middle">${trang_thai_text}</td>
                    <td class="align-middle">${loai_uudai_text}<br>${uu_dai_info}</td>
                    <td class="align-middle text-center" style="min-width:100px">
                        <input type="hidden" name="id_huongncc[]" value="${data.modal_trocap_id || ''}" />
                        <input type="hidden" name="id_uudai[]" value="${data.modal_id_uudai || ''}" />

                        <input type="hidden" name="is_hinhthuc[]" value="${data.modal_hinhthuchuong || ''}" />
                        <input type="hidden" name="dmnguoicocong_id[]" value="${data.modal_doituonghuong || ''}" />
                        <input type="hidden" name="trangthai_id[]" value="${data.modal_trang_thai || ''}" />
                        <input type="hidden" name="ngayhuong[]" value="${data.modal_ngayhuong || ''}" />

                        <input type="hidden" name="trocap[]" value="${data.modal_trocap || ''}" />
                        <input type="hidden" name="trocapdungcu[]" value="${data.modal_trocapdungcu || ''}" />

                        <input type="hidden" name="phucap[]" value="${data.modal_phucap || ''}" />
                        <input type="hidden" name="dmtyle_id[]" value="${data.modal_tyle || ''}" />
                        <input type="hidden" name="uudai_id[]" value="${data.modal_loaiuudai || ''}" />
                        <input type="hidden" name="noidunguudai[]" value="${data.modal_noidunguudai || ''}" />
                        <input type="hidden" name="trocap_uudai[]" value="${data.modal_trocapuudai || ''}" />
                        <input type="hidden" name="loaidungcu_id[]" value="${data.modal_dungcu || ''}" />
                        <input type="hidden" name="ngayuudai[]" value="${data.modal_ngayuudai || ''}" />
                        <span class="btn btn-sm btn-warning btn_edit_trocap" data-trocap-id="${data.modal_trocap_id || ''}"><i class="fas fa-edit"></i></span>
                        <span class="btn btn-sm btn-danger btn_xoa_trocap" data-trocap-id="${data.modal_trocap_id || ''}"><i class="fas fa-trash-alt"></i></span>
                    </td>
                </tr>`;
                if ($('.dsThongtintrocap .no-data').length) {
                    $('.dsThongtintrocap .no-data').remove();
                }
                if (!isNaN(editIndex) && editIndex >= 0 && $('.dsThongtintrocap tr').eq(editIndex).length) {
                    $('.dsThongtintrocap tr').eq(editIndex).replaceWith(html);
                    showToast('Cập nhật thông tin trợ cấp thành công', true);
                } else {
                    $('.dsThongtintrocap').append(html);
                    showToast('Thêm thông tin trợ cấp thành công', true);
                }

                $('#modal_edit_index').val('');
                updateTroCapSTT();
                $('#modalTroCap').modal('hide');
            } else {
                showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
            }
        });

        $('.dsThongtintrocap').on('click', '.btn_xoa_trocap', async function() {
            const $row = $(this).closest('tr');
            const trocap_id = $(this).data('trocap-id');
            console.log('Xóa thông tin trợ cấp:', trocap_id);

            if (!confirm('Bạn có chắc chắn muốn xóa thông tin trợ cấp này?')) {
                return;
            }

            try {
                const response = await $.post('index.php', {
                    option: 'com_vhytgd',
                    controller: 'nguoicocong',
                    task: 'delThongtinhuongcs',
                    trocap_id: trocap_id
                }, null, 'json');

                if (response.success) {
                    $row.remove();
                    updateTroCapSTT();
                    showToast('Xóa thông tin trợ cấp thành công', true);
                    if ($('.dsThongtintrocap tr').length === 0) {
                        $('.dsThongtintrocap').html('<tr class="no-data"><td colspan="8" class="text-center">Không có dữ liệu</td></tr>');
                    }
                } else {
                    showToast('Xóa thông tin trợ cấp thất bại: ' + (response.message || 'Lỗi không xác định'), false);
                }
            } catch (error) {
                console.error('Delete error:', error);
                showToast('Lỗi khi xóa thông tin trợ cấp', false);
            }
        });

        $('#btn_themchinhsach').on('click', function(e) {
            e.preventDefault();
            $('#modalTroCapLabel').text('Thêm thông tin trợ cấp');
            $('#frmModalTroCap')[0].reset();
            $('#modal_trocap_id').val('');
            $('#modal_edit_index').val('');
            $('#modal_muc_tien_chuan').val('').prop('readonly', true);
            $('#modal_thuc_nhan').val('').prop('readonly', true);
            resetInputFields();
            initializeModalSelect2();
            $('#modalTroCap').modal('show');
        });
    });
</script>

<script>
    const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
    const item = <?php echo json_encode($item); ?>;
    const detailphuongxa_id = <?= json_encode($this->item[0]['n_phuongxa_id'] ?? 0) ?>;
    const detailthonto_id = <?= json_encode($this->item[0]['n_thonto_id'] ?? 0) ?>;
    let isEditMode = <?php echo ((int)$item[0]['id'] > 0) ? 'true' : 'false'; ?>;
    let isFetchingFromSelect = false;

    $(document).ready(function() {
        $('#btn_quaylai').click(() => {
            window.location.href = '<?php echo Route::_('/index.php/component/vhytgd/?view=nguoicocong&task=default'); ?>';
        });

        $('.namsinh').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy',
        });
        $('.ngaydangky').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy',
        });

        function formatDateToDMY(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            if (isNaN(date)) return '';
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // gán giá trị n_namsinh vào input
        if (item && item.n_namsinh) {
            const formattedDate = formatDateToDMY(item.n_namsinh);
            $('#select_namsinh').val(formattedDate);
            $('#input_namsinh').val(formattedDate);
        }

        // khởi tạo select 2 
        const initSelect2 = (selector, width = '100%') => {
            $(selector).select2({
                placeholder: $(selector).data('placeholder') || 'Chọn',
                allowClear: true,
                width,
            });
        };
        ['#select_dantoc_id', '#select_gioitinh_id', '#select_tongiao_id', '#select_phuongxa_id',
            '#select_thonto_id', '#doituonguutien_id', '#doituong_id', '#vithe_id', '#nghenghiep_id',
            '#phuongxagioithieu_id', '#trinhdohocvan_id', '#nganhang_id'
        ].forEach(selector => {
            initSelect2(selector);
        });

        // khởi tạo select 2 cho chọn người lao động
        function initializeSelect2() {
            $('#select_top').select2({
                placeholder: 'Chọn nhân khẩu',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: 'index.php?option=com_vhytgd&task=nguoicocong.timkiem_nhankhau&format=json',
                    dataType: 'json',
                    delay: 150,
                    data: function(params) {
                        return {
                            keyword: params.term || '',
                            page: params.page || 1,
                            phuongxa_id: phuongxa_id.map(item => item.id)
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items ? data.items.map(item => ({
                                id: item.id,
                                text: `${item.hoten} - CCCD: ${item.cccd_so || ''} - Ngày sinh: ${item.ngaysinh || ''} - Địa chỉ: ${item.diachi || ''}`,
                                ...item
                            })) : [],
                            pagination: {
                                more: data.has_more || false
                            }
                        };
                    },
                    error: function(xhr, status, error) {
                        showToast('Lỗi khi tải danh sách nhân khẩu', false);
                    },
                    cache: true
                },
                minimumInputLength: 0,
                templateResult: data => data.loading ? data.text : $('<div>' + data.text + '</div>'),
                templateSelection: data => data.text || 'Chọn thành viên'
            });
        }

        // hàm để đặt disabled cho các field 
        function toggleFormFields(isChecked) {
            const textFields = ['#hoten', '#cccd', '#dienthoai', '#diachi'];
            const selectFields = ['#select_gioitinh_id', '#select_namsinh', '#select_dantoc_id', '#select_tongiao_id', '#select_phuongxa_id', '#select_thonto_id'];

            $('#select-container').toggle(isChecked);
            textFields.forEach(selector => $(selector).prop('readonly', isChecked));
            selectFields.forEach(selector => $(selector).prop('disabled', isChecked));
            if (isChecked) {
                $('body').find('.btn-themnhanthan').hide()
                initializeSelect2();
            } else {
                $('#nhankhau_id').val('');
                if ($.fn.select2 && $('#select_top').data('select2')) {
                    $('#select_top').val('').select2('destroy');
                } else {
                    $('#select_top').val('');
                }
            }
        }

        // lấy thôn tổ theo phường xã cung cấp
        async function fetchThonTo(phuongxa_id, element = '#select_thonto_id', thontoSelect = null) {
            if (!phuongxa_id) {
                $(element).html('<option value=""></option>').trigger('change');
                return;
            }

            try {
                const response = await $.post('index.php', {
                    option: 'com_vhytgd',
                    controller: 'nguoicocong',
                    task: 'getThonTobyPhuongxa',
                    phuongxa_id: phuongxa_id
                }, null, 'json');
                let options = '<option value=""></option>';
                response.forEach(thonto => {
                    const selected = thonto.id == thontoSelect ? ' selected' : '';
                    options += `<option value="${thonto.id}"${selected}>${thonto.tenkhuvuc}</option>`;

                });
                $(element).html(options).trigger('change');
            } catch (error) {
                showToast('Lỗi khi tải danh sách thôn/tổ', false);
                $(element).html('<option value=""></option>').trigger('change');
            }
        }

        async function initializePhuongXaAndThonTo() {
            if (phuongxa_id.length === 1 && !isEditMode) {
                const singlePhuongXaId = phuongxa_id[0].id;
                $('#select_phuongxa_id').val(singlePhuongXaId).trigger('change');
                await fetchThonTo(singlePhuongXaId, '#select_thonto_id');
            } else if (isEditMode && detailphuongxa_id) {
                $('#select_phuongxa_id').val(detailphuongxa_id).trigger('change');
                await fetchThonTo(detailphuongxa_id, '#select_thonto_id', detailthonto_id);
            }
        }

        // select nhân khẩu theo laodongdetail (nếu có)
        async function fetchNhanKhauTheoLaoDongDetail() {
            if (item && item[0] && item[0].nhankhau_id) {
                console.log('Fetching nhankhau_id:', item[0].nhankhau_id);
                try {
                    const nhankhauResponse = await $.post('index.php', {
                        option: 'com_vhytgd',
                        task: 'nguoicocong.timkiem_nhankhau',
                        format: 'json',
                        nhankhau_id: item[0].nhankhau_id,
                    }, null, 'json');
                    console.log('nhankhauResponse:', nhankhauResponse);
                    if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
                        const nhankhau = nhankhauResponse.items.find(nk => nk.id === item[0].nhankhau_id) || nhankhauResponse.items[0];
                        if (nhankhau) {
                            const optionText = `${nhankhau.hoten} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${nhankhau.ngaysinh || ''} - Địa chỉ: ${nhankhau.diachi || ''}`;
                            const newOption = new Option(optionText, nhankhau.id, true, true);
                            $('#select_top').append(newOption);
                            initSelect2('#select_top'); // Khởi tạo lại Select2
                            $('#select_top').val(nhankhau.id).trigger('change.select2');
                            console.log('select_top set to:', nhankhau.id, optionText);
                            $('#select_top').trigger({
                                type: 'select2:select',
                                params: {
                                    data: {
                                        id: nhankhau.id,
                                        hoten: nhankhau.hoten,
                                        cccd_so: nhankhau.cccd_so,
                                        ngaysinh: nhankhau.ngaysinh,
                                        dienthoai: nhankhau.dienthoai,
                                        dantoc_id: nhankhau.dantoc_id,
                                        gioitinh_id: nhankhau.gioitinh_id,
                                        phuongxa_id: nhankhau.phuongxa_id,
                                        thonto_id: nhankhau.thonto_id,
                                        diachi: nhankhau.diachi
                                    }
                                }
                            });
                        } else {
                            console.warn('Không tìm thấy nhân khẩu với nhankhau_id:', item[0].nhankhau_id);
                            showToast('Không tìm thấy nhân khẩu phù hợp', false);
                            $('#checkbox_toggle').prop('checked', false).trigger('change');
                        }
                    } else {
                        // console.warn('Không có dữ liệu nhân khẩu từ API');
                        // showToast('Không tìm thấy thông tin nhân khẩu', false);
                        $('#checkbox_toggle').prop('checked', false).trigger('change');
                    }
                } catch (error) {
                    console.error('Fetch nhankhau error:', error);
                    showToast('Lỗi khi tải thông tin nhân khẩu', false);
                    $('#checkbox_toggle').prop('checked', false).trigger('change');
                }
            } else {
                console.warn('Không có nhankhau_id trong item:', item);
            }
        }

        // Initialize form state
        toggleFormFields($('#checkbox_toggle').is(':checked'));
        initializePhuongXaAndThonTo();
        fetchNhanKhauTheoLaoDongDetail();

        // kiểm tra checkbox toggle
        $('#checkbox_toggle').change(function() {
            toggleFormFields($(this).is(':checked'));
        });

        // check datunglamviec 
        $('#datunglamviec').on('change', function() {
            const is_lamviec = $(this).val();
            $('.thoigianlamviec_container').toggle(is_lamviec === '1').toggleClass('d-flex flex-column', is_lamviec === '1');
            if (is_lamviec !== '1') {
                $('#thoigianlamviec').val('').trigger('change');
            }
        });

        // thay đổi phường xã -> gọi hàm fetchthonto để lấy thôn tổ theo phường xã mới
        $('#select_phuongxa_id').on('change', function() {
            if (!isFetchingFromSelect) {
                fetchThonTo($(this).val(), '#select_thonto_id');
            }
        });

        // chọn select từ danh sách nhân khẩu
        $('#select_top').on('select2:select', async function(e) {
            const data = e.params.data;
            // gán dữ liệu đã chọn từ danh sách nhân khẩu vào trong form
            $('#nhankhau_id').val(data.id || '');
            $('#hoten').val(data.hoten || '');
            $('#input_gioitinh_id').val(data.gioitinh_id || '');
            $('#select_gioitinh_id').val(data.gioitinh_id || '').trigger('change');
            $('#cccd').val(data.cccd_so || '');

            $('#input_namsinh').val(data.ngaysinh);
            $('#select_namsinh').val(data.ngaysinh);
            $('#dienthoai').val(data.dienthoai || '');
            $('#input_dantoc_id').val(data.dantoc_id || '');
            $('#select_dantoc_id').val(data.dantoc_id || '').trigger('change');
            $('#input_tongiao_id').val(data.tongiao_id || '');
            $('#select_tongiao_id').val(data.tongiao_id || '').trigger('change');
            isFetchingFromSelect = true;
            $('#input_phuongxa_id').val(data.phuongxa_id || '');
            $('#select_phuongxa_id').val(data.phuongxa_id || '').trigger('change');
            await fetchThonTo(data.phuongxa_id, '#select_thonto_id', data.thonto_id);
            isFetchingFromSelect = false;
            $('#diachi').val(data.diachi || '');
            $('#input_thonto_id').val(data.thonto_id || '');
            $('#select_thonto_id').val(data.thonto_id || '').trigger('change');
        });

        // Sửa ID form cho khớp
        $('#formNguoiCoCong').validate({
            ignore: [],
            rules: {
                select_top: {
                    required: function() {
                        return $('#checkbox_toggle').is(':checked');
                    }
                },
                hoten: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    }
                },
                cccd: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    }
                },
                select_namsinh: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    },
                },
                select_phuongxa_id: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    }
                },
                select_gioitinh_id: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    }
                }

            },
            messages: {
                select_top: 'Vui lòng chọn nhân khẩu',
                hoten: 'Vui lòng nhập họ và tên',
                cccd: 'Vui lòng nhập CCCD/CMND',
                select_namsinh: 'Vui lòng chọn năm sinh',
                select_phuongxa_id: 'Vui lòng chọn phường/xã',
                select_gioitinh_id: 'Vui lòng chọn giới tính',
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('custom-select')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.closest('.input-group').length) {
                    error.insertAfter(element.closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // submit form chính
        // $('#formNguoiCoCong').on('submit', function(e) {
        //     e.preventDefault();
        //     if (!$(this).valid()) {
        //         showToast('Vui lòng nhập đầy đủ thông tin', false);
        //         return;
        //     }

        //     const formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: function(response) {
        //             const isSuccess = response.success ?? true;
        //             showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
        //             if (isSuccess) {
        //                 setTimeout(() => location.href = "/index.php/component/vhytgd/?view=nguoicocong&task=default", 500);
        //             }
        //         },
        //         error: function(xhr) {
        //             console.error('Submit error:', xhr.responseText);
        //             showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
        //         }
        //     });
        // });

        const showToast = (message, isSuccess = true) => {
            const toast = $('<div></div>')
                .text(message)
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    background: isSuccess ? '#28a745' : '#dc3545',
                    color: '#fff',
                    padding: '10px 20px',
                    borderRadius: '5px',
                    boxShadow: '0 0 10px rgba(0,0,0,0.3)',
                    zIndex: 9999,
                    transition: 'opacity 0.5s'
                })
                .appendTo('body');
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 3000);
        };
    });
</script>

<style>
    .card-body {
        padding: 2.5rem;
        font-size: 15px;
    }

    .input-group-text {
        border-radius: 0px 4px 4px 0px;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }

    .error {
        color: #dc3545;
        font-size: 12px;
        margin: 0px;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #007b8b;
        color: #fff
    }


    .table#tblThongtin td.align-middle {
        width: 33.33%;
        padding: .75rem 0rem .75rem .75rem;
    }

    .modal-backdrop {
        display: none;
    }

    .table#tblThongtin .form-control,
    .table#tblThongtin .custom-select,
    .table#tblThongtin .input-group {
        width: 100% !important;
        box-sizing: border-box;
    }

    .table#tblThongtin .input-group .form-control {
        flex: 1;
    }

    .status-verified {
        color: green;
    }

    .status-unverified {
        color: red;
    }

    .hideOpt {
        display: none !important;
    }

    /* CSS cụ thể cho #modalTroCap */
    #modalTroCap .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        word-break: break-word;
    }

    #modalTroCap .select2-container .select2-selection--single {
        height: 38px;
    }

    #modalTroCap .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    #modalTroCap .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    #modalTroCap {
        overflow-x: hidden;
    }

    #modalTroCap .modal-dialog {
        max-width: 1200px;
        min-width: 300px;
        width: 1000px;
        margin-left: auto;
        margin-right: 0;
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
        transform: translateX(100%);
        transition: transform 0.5s ease-in-out;
    }

    #modalTroCap.show .modal-dialog {
        transform: translateX(0);
    }

    #modalTroCap.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    #modalTroCap.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    #modalTroCap .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #modalTroCap .error_modal {
        margin-bottom: 0px;
        margin-top: 0;
        font-size: 12px;
        color: red;
    }

    .error_modal {
        margin-bottom: 0px;
        margin-top: 0;
        font-size: 12px;
        color: red;
    }

    /* CSS riêng cho modal thông báo xóa của Bootbox (nếu cần) */
    .custom-bootbox .modal-dialog {
        max-width: 500px;
        /* Kích thước mặc định cho Bootbox */
        margin: 1.75rem auto;
        /* Căn giữa */
        transform: none !important;
        /* Vô hiệu hóa transform */
        transition: none !important;
        /* Vô hiệu hóa transition */
    }

    .custom-bootbox .modal-content {
        border-radius: 4px;
        /* Góc bo mặc định */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        /* Hiệu ứng bóng nhẹ */
    }

    .custom-bootbox .modal-body {
        padding: 15px;
        /* Padding mặc định của Bootbox */
        word-break: normal;
        /* Giữ giao diện mặc định */
    }

    /* CSS cho bảng tableFixHead (không liên quan đến modal) */
    table.tableFixHead {
        border-collapse: collapse;
        max-width: 800px;
        overflow-x: scroll;
        display: block;
    }

    table.tableFixHead thead {
        background-color: #027be3;
    }

    table.tableFixHead thead,
    table.tableFixHead tbody {
        display: block;
    }

    table.tableFixHead tbody {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 250px;
    }

    td.stt,
    th.stt {
        min-width: 50px;
        max-width: 80px;
    }

    td.hoten,
    th.hoten {
        min-width: 250px;
        max-width: 300px;
    }

    td.diachi,
    th.diachi {
        min-width: 150px;
        max-width: 200px;
    }

    td.tieuchigdvanhoa,
    th.tieuchigdvanhoa {
        min-width: 200px;
        max-width: 250px;
    }

    td.thongtinchucdanh,
    th.thongtinchucdanh {
        min-width: 200px;
        max-width: 250px;
    }

    td.tinhtrang,
    th.tinhtrang {
        min-width: 100px;
        max-width: 150px;
    }

    td.lydo,
    th.lydo {
        min-width: 100px;
        max-width: 200px;
    }

    td.chucnang,
    th.chucnang {
        min-width: 100px;
        max-width: 150px;
    }

    .mb-3 {
        margin-bottom: 0rem !important;
    }
</style>