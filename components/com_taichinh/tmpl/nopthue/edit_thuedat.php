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

<form id="formNopThueDat" name="formNopThueDat" method="post" action="<?php echo Route::_('index.php?option=com_taichinh&controller=nopthue&task=saveNopThueDat'); ?>">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between border-bottom mb-3" style="margin-bottom: 1rem !important;">
            <h2 class="text-primary mb-3" style="padding: 10px 10px 10px 0px;">
                <?php echo ((int)$item[0]['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> nộp thuế sử dụng đất
            </h2>
            <span>
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
            </span>
        </div>
        <input type="hidden" name="id_thuedat" value="<?php echo htmlspecialchars($item[0]['id']); ?>">

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item[0]['id']); ?>">
        <input type="hidden" name="nhanhokhau_id" id="nhanhokhau_id" value="<?php echo htmlspecialchars($item[0][0]['nhanhokhau_id']); ?>">

        <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
            <h5 style="margin: 0">Thông tin cá nhân</h5>
            <div class="d-flex align-items-center" style="gap:5px">
                <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo htmlspecialchars($item[0]['nhanhokhau_id']) ? 'checked' : ''; ?>>
                <small>Chọn người lao động từ danh sách nhân khẩu</small>
            </div>
        </div>
        <div id="select-container" style="display: <?php echo htmlspecialchars($item[0]['nhanhokhau_id']) ? 'block' : 'none'; ?>;margin-bottom: 1rem !important" class="mb-3">
            <label for="select_top" class="form-label fw-bold">Tìm nhân khẩu</label>
            <select id="select_top" name="select_top" class="custom-select">
                <option value="">-- Chọn --</option>
                <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
                    <option value="<?php echo $tv['id']; ?>" <?php echo htmlspecialchars($item[0]['nhanhokhau_id']) == $tv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tv['hoten']); ?></option>
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

        <h5 class="border-bottom pb-2 mb-4">Thông tin khác</h5>
        <div class="row g-3 mb-4">

            <div class="col-md-4 mb-2">
                <label for="namsinh" class="form-label fw-bold">Mã số thuế</label>
                <div class="input-group">
                    <input type="text" id="masothue" name="masothue" class="form-control" placeholder="Nhập mã số thuế" value="<?php echo htmlspecialchars($item[0]['masothue']); ?>">
                </div>
            </div>
        </div>
        <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h5 class="">Thông tin nộp thuế</h5>
            <!-- <button class="btn btn-success btn_themnopthue">Thêm chính sách</button> -->
            <button type="button" class="btn btn-success" id="btn_themnopthue" data-toggle="modal" data-target="#modalNopThueDat"><i class="fas fa-plus"></i> Thêm mới</button>

        </div>
        <div class="row g-3 mb-4">
            <table class="table table-striped table-bordered" style="height: 150px; overflow-y: auto;">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Mã phi nông nghiệp</th>
                        <th>Địa chỉ thửa đất</th>
                        <th>Giấy chứng nhận</th>
                        <th>Thông Tin Thửa Đất</th>
                        <th>Diện tích</th>
                        <th>Mục đích sử dụng</th>
                        <th>Miễn giảm thuế</th>
                        <th>Tổng tiền nộp</th>
                        <th>Tình trạng</th>
                        <th>Ghi chú</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody class="dsThongtinnopthue">
                    <?php if (is_array($item) && count($item) > 0) { ?>
                        <?php foreach ($item as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['maphinongnghiep'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['diachi'] ?? ''); ?></td>
                                <td class="align-middle">
                                    <strong>Số giấy chứng nhận:</strong> <?php echo htmlspecialchars($nk['sogcn'] ?? ''); ?><br>
                                    <strong>Ngày chứng nhận:</strong> <?php echo htmlspecialchars($nk['ngaycn'] ?? ''); ?>
                                </td>
                                <td class="align-middle"> <strong>Tờ bản đồ:</strong> <?php echo htmlspecialchars($nk['tobando'] ?? ''); ?> <br>
                                    <strong>Thửa đất:</strong> <?php echo htmlspecialchars($nk['thuadat'] ?? ''); ?>

                                </td>
                                <td class="align-middle"> <strong>Diện tích có GCN:</strong><?php echo htmlspecialchars($nk['dientich_gcn'] ?? ''); ?><br>
                                    <strong>Diện tích chưa có GCN:</strong><?php echo htmlspecialchars($nk['dientich_ccn'] ?? ''); ?><br>
                                    <strong>Diện tích sử dụng:</strong><?php echo htmlspecialchars($nk['dientich_sd'] ?? ''); ?><br>

                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['tenmucdich'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['sotienmiengiam'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['tongtiennop'] ?? ''); ?></td>
                                <td class="align-middle">
                                    <?php echo $nk['tinhtrang'] == 1 ? 'Chưa nộp' : ($nk['tinhtrang'] == 2 ? 'Đã nộp' : ''); ?>
                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?></td>

                                <td class="align-middle text-center" style="min-width:100px">
                                    <input type="hidden" name="chitiet_id[]" value="<?php echo htmlspecialchars($nk['chitiet_id'] ?? ''); ?>" />
                                    <input type="hidden" name="maphinongnghiep[]" value="<?php echo htmlspecialchars($nk['maphinongnghiep'] ?? ''); ?>" />
                                    <input type="hidden" name="sogiaychungnhan[]" value="<?php echo htmlspecialchars($nk['sogcn'] ?? ''); ?>" />
                                    <input type="hidden" name="diachi[]" value="<?php echo htmlspecialchars($nk['diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="ngaycap[]" value="<?php echo htmlspecialchars($nk['ngaycn'] ?? ''); ?>" />
                                    <input type="hidden" name="tobando[]" value="<?php echo htmlspecialchars($nk['tobando'] ?? ''); ?>" />
                                    <input type="hidden" name="thuadat[]" value="<?php echo htmlspecialchars($nk['thuadat'] ?? ''); ?>" />
                                    <input type="hidden" name="dientichcogcn[]" value="<?php echo htmlspecialchars($nk['dientich_gcn'] ?? ''); ?>" />
                                    <input type="hidden" name="dientichchuacogcn[]" value="<?php echo htmlspecialchars($nk['dientich_ccn'] ?? ''); ?>" />
                                    <input type="hidden" name="dientichsd[]" value="<?php echo htmlspecialchars($nk['dientich_sd'] ?? ''); ?>" />
                                    <input type="hidden" name="mucdichsudung[]" value="<?php echo htmlspecialchars($nk['mucdichsudung_id'] ?? ''); ?>" />
                                    <input type="hidden" name="tenduong[]" value="<?php echo htmlspecialchars($nk['tenduong_id'] ?? ''); ?>" />
                                    <input type="hidden" name="miengiamthue[]" value="<?php echo htmlspecialchars($nk['sotienmiengiam'] ?? ''); ?>" />
                                    <input type="hidden" name="tongtien[]" value="<?php echo htmlspecialchars($nk['tongtiennop'] ?? ''); ?>" />
                                    <input type="hidden" name="tinhtrang[]" value="<?php echo htmlspecialchars($nk['tinhtrang'] ?? ''); ?>" />
                                    <input type="hidden" name="ghichu[]" value="<?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?>" />
                                    <span class="btn btn-sm btn-warning btn_edit_trocap" title="Sửa thông tin này">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="btn btn-sm btn-danger btn_xoa_trocap" title="Xóa thông tin này" data-trocap-id="<?php echo htmlspecialchars($nk['chitiet_id'] ?? ''); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="no-data">
                            <td colspan="12" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>
<!-- Modal thông tin hưởng bảo trợ -->
<div class="modal fade" id="modalNopThueDat" tabindex="-1" role="dialog" aria-labelledby="modalNopthuedatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNopthuedatLabel">Thêm thông nộp thuế đất</h5>
                <button type="button" class="btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalNopThueDat">
                    <div id="trocap_fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã phi nông nghiệp <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_maphinongnghiep" name="modal_maphinongnghiep" class="form-control" placeholder="Nhập mã phi nông nghiệp">

                                    <label class="error_modal" for="modal_maphinongnghiep"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số giấy chứng nhận<span class="text-danger">*</span></label>
                                    <input type="text" id="modal_sogiaychungnhan" name="modal_sogiaychungnhan" class="form-control" placeholder="Nhập số giấy chứng nhận">
                                    <label class="error_modal" for="modal_sogiaychungnhan"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_diachi" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ">
                                    <label class="error_modal" for="modal_diachi"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày cấp <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_ngaycap" name="modal_ngaycap" class="form-control date-picker" placeholder="../../....">

                                    <label class="error_modal" for="modal_ngaycap"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tờ bản đồ<span class="text-danger">*</span></label>
                                    <input type="text" id="modal_tobando" name="modal_tobando" class="form-control" placeholder="Nhập tờ bản đồ">
                                    <label class="error_modal" for="modal_tobando"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thửa đất<span class="text-danger">*</span></label>
                                    <input type="text" id="modal_thuadat" name="modal_thuadat" class="form-control" placeholder="Nhập thửa đất">
                                    <label class="error_modal" for="modal_thuadat"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Diện tích đã có GCN</label>
                                    <input type="text" id="modal_dientichcogcn" name="modal_dientichcogcn" class="form-control" placeholder="Nhập diện tích">
                                    <label class="error_modal" for="modal_dientichcogcn"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Diện tích chưa có GCN</label>
                                    <input type="text" id="modal_dientichchuacogcn" name="modal_dientichchuacogcn" class="form-control" placeholder="Nhập diện tích">
                                    <label class="error_modal" for="modal_dientichchuacogcn"></label>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mục đích sử dụng<span class="text-danger">*</span></label>
                                    <select id="modal_mucdichsudung" name="modal_mucdichsudung" class="custom-select" data-placeholder="Chọn mục đích sử dụng">
                                        <option value=""></option>
                                        <?php if (is_array($this->mucdich) && count($this->mucdich) > 0) { ?>
                                            <?php foreach ($this->mucdich as $md) { ?>
                                                <option value="<?php echo $md['id']; ?>" data-text="<?php echo htmlspecialchars($md['tenmucdich']); ?>">
                                                    <?php echo htmlspecialchars($md['tenmucdich']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu trạng thái</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_mucdichsudung"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên đường<span class="text-danger">*</span></label>
                                    <select id="modal_tenduong" name="modal_tenduong" class="custom-select" data-placeholder="Chọn tên đường">
                                        <option value=""></option>
                                        <?php if (is_array($this->tenduong) && count($this->tenduong) > 0) { ?>
                                            <?php foreach ($this->tenduong as $md) { ?>
                                                <option value="<?php echo $md['id']; ?>" data-text="<?php echo htmlspecialchars($md['tenduong']); ?>">
                                                    <?php echo htmlspecialchars($md['tenduong']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu trạng thái</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_tenduong"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Diện tích sử dụng thực tế<span class="text-danger">*</span></label>
                                    <input type="text" id="modal_dientichsd" name="modal_dientichsd" class="form-control" placeholder="Nhập diện tích">
                                    <label class="error_modal" for="modal_dientichsd"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Miễn giảm thuế</label>
                                    <input type="text" id="modal_miengiamthue" name="modal_miengiamthue" class="form-control" placeholder="Nhập miễn giảm thuế">
                                    <label class="error_modal" for="modal_miengiamthue"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tổng tiền phải nộp<span class="text-danger">*</span></label>
                                    <input type="text" id="modal_tongtien" name="modal_tongtien" class="form-control" placeholder="Nhập tổng tiền phải nộp">
                                    <label class="error_modal" for="modal_tongtien"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tình trạng<span class="text-danger">*</span></label>
                                    <select id="modal_tinhtang" name="modal_tinhtang" class="custom-select" data-placeholder="Chọn tình trạng">
                                        <option value=""></option>
                                        <option value="1">Chưa nộp</option>
                                        <option value="2">Đã nộp</option>
                                    </select>
                                    <label class="error_modal" for="modal_dientichsd"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</span></label>
                                    <input type="text" id="modal_ghichu" name="modal_ghichu" class="form-control" placeholder="Ghi chú">
                                    <label class="error_modal" for="modal_ghichu"></label>
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
            $('#modalNopThueDat select.custom-select').not('#modal_nhankhau_search').each(function() {
                initSelect2($(this), {
                    width: '100%',
                    allowClear: true,
                    placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                    dropdownParent: $('#modalNopThueDat')
                });
            });
        }

        $('#modalNopThueDat .date-picker').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy'
        });

        if ($.fn.validate) {
            $('#frmModalNopThueDat').validate({
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
                    modal_maphinongnghiep: {
                        required: true
                    },
                    modal_sogiaychungnhan: {
                        required: true
                    },
                    modal_diachi: {
                        required: true
                    },
                    modal_ngaycap: {
                        required: true
                    },
                    modal_tobando: {
                        required: true,
                        number: true,

                    },
                    modal_thuadat: {
                        required: true,

                    },
                    modal_mucdichsudung: {
                        required: true,

                    },
                    modal_dientichsd: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    modal_tongtien: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    modal_tinhtang: {
                        required: true
                    }
                },
                messages: {
                    modal_maphinongnghiep: 'Vui lòng nhập mã phi nông nghiệp',
                    modal_sogiaychungnhan: 'Vui lòng số giấy chứng nhận',
                    modal_diachi: 'Vui lòng nhập địa chỉ',
                    modal_ngaycap: 'Vui lòng ngày cấp',
                    modal_tobando: {
                        required: 'Vui lòng nhập tờ bản đồ',
                    },
                    modal_thuadat: {
                        required: 'Vui lòng nhập thử đất',

                    },
                    modal_mucdichsudung: {
                        required: 'Vui lòng chọn mục đích sử dụng',
                    },
                    modal_dientichsd: {
                        required: 'Vui lòng nhập diện tích sử dụng',
                        number: 'Diện tích sử dụng phải là số',
                        min: 'Diện tích sử dụng phải lớn hơn hoặc bằng 0'
                    },
                    modal_tongtien: {
                        required: 'Vui lòng nhập tổng tiền phải nộp',
                        number: 'Số tiền tổng phải là số',
                        min: 'Số tiền tổng phải lớn hơn hoặc bằng 0'
                    },
                    modal_tinhtang: 'Vui lòng chọn tình trạng'
                }
            });
        }

        $('#modalNopThueDat').on('change.select2', '#modal_loai_doi_tuong', function(e) {
            const $form = $('#frmModalNopThueDat');
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
            $('#modalNopThueDat select.custom-select').each(function() {
                initSelect2($(this), {});
            });
            $('#modalNopThueDat .date-picker:not(.hasDatepicker)').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'dd/mm/yyyy'
            }).addClass('hasDatepicker');
        }

        $('#modal_he_so').on('input change', function() {
            const $form = $('#frmModalNopThueDat');
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
            const $form = $('#frmModalNopThueDat');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });

        $('#modal_ma_hotro, #modal_so_quyet_dinh, #modal_ngay_quyet_dinh, #modal_huong_tu_ngay').on('change input', function() {
            const $form = $('#frmModalNopThueDat');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });

        function updateTroCapSTT() {
            $('.dsThongtinnopthue tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
            });
        }
        $('.dsThongtinnopthue').on('click', '.btn_edit_trocap', function() {
            const $row = $(this).closest('tr');

            // Collect data from the table row
            const data = {
                chitiet_id: $row.find('[name="chitiet_id[]"]').val() || '',
                maphinongnghiep: $row.find('[name="maphinongnghiep[]"]').val() || '',
                sogiaychungnhan: $row.find('[name="sogiaychungnhan[]"]').val() || '',
                diachi: $row.find('[name="diachi[]"]').val() || '',
                ngaycap: $row.find('[name="ngaycap[]"]').val() || '',
                tobando: $row.find('[name="tobando[]"]').val() || '',
                thuadat: $row.find('[name="thuadat[]"]').val() || '',
                dientichcogcn: $row.find('[name="dientichcogcn[]"]').val() || '',
                dientichchuacogcn: $row.find('[name="dientichchuacogcn[]"]').val() || '',
                dientichsd: $row.find('[name="dientichsd[]"]').val() || '',
                mucdichsudung: $row.find('[name="mucdichsudung[]"]').val() || '',
                tenduong: $row.find('[name="tenduong[]"]').val() || '',
                miengiamthue: $row.find('[name="miengiamthue[]"]').val() || '',
                tongtien: $row.find('[name="tongtien[]"]').val() || '',
                tinhtrang: $row.find('[name="tinhtrang[]"]').val() || '',
                ghichu: $row.find('[name="ghichu[]"]').val() || ''
            };

            console.log('Dữ liệu từ row:', data); // Debug row data

            // Set modal title and reset form
            $('#modalNopthuedatLabel').text('Chỉnh sửa thông tin nộp thuế đất');
            $('#frmModalNopThueDat')[0].reset();
            resetInputFields();
            initializeModalPlugins();

            // Populate modal fields
            $('#modal_trocap_id').val(data.chitiet_id);
            $('#modal_maphinongnghiep').val(data.maphinongnghiep);
            $('#modal_sogiaychungnhan').val(data.sogiaychungnhan);
            $('#modal_diachi').val(data.diachi);
            $('#modal_ngaycap').val(data.ngaycap);
            $('#modal_tobando').val(data.tobando);
            $('#modal_thuadat').val(data.thuadat);
            $('#modal_dientichcogcn').val(data.dientichcogcn);
            $('#modal_dientichchuacogcn').val(data.dientichchuacogcn);
            $('#modal_dientichsd').val(data.dientichsd);
            $('#modal_mucdichsudung').val(data.mucdichsudung).trigger('change.select2');
            $('#modal_tenduong').val(data.tenduong).trigger('change.select2');
            $('#modal_miengiamthue').val(data.miengiamthue);
            $('#modal_tongtien').val(formatCurrency(data.tongtien));
            $('#modal_tinhtang').val(data.tinhtrang).trigger('change.select2');
            $('#modal_ghichu').val(data.ghichu);
            $('#modal_edit_index').val($row.index());

            // Show the modal
            $('#modalNopThueDat').modal('show');
        });

        // Handle save button click
        $('#btn_luu_trocap').on('click', function() {
            const $form = $('#frmModalNopThueDat');
            if ($form.valid()) {
                const formData = $form.serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                });

                // Explicitly include all fields
                data.modal_trocap_id = $('#modal_trocap_id').val() || '';
                data.modal_maphinongnghiep = $('#modal_maphinongnghiep').val() || '';
                data.modal_sogiaychungnhan = $('#modal_sogiaychungnhan').val() || '';
                data.modal_diachi = $('#modal_diachi').val() || '';
                data.modal_ngaycap = $('#modal_ngaycap').val() || '';
                data.modal_tobando = $('#modal_tobando').val() || '';
                data.modal_thuadat = $('#modal_thuadat').val() || '';
                data.modal_dientichcogcn = $('#modal_dientichcogcn').val() || '';
                data.modal_dientichchuacogcn = $('#modal_dientichchuacogcn').val() || '';
                data.modal_dientichsd = $('#modal_dientichsd').val() || '';
                data.modal_mucdichsudung = $('#modal_mucdichsudung').val() || '';
                data.modal_tenduong = $('#modal_tenduong').val() || '';
                data.modal_miengiamthue = $('#modal_miengiamthue').val() || '';
                data.modal_tongtien = $('#modal_tongtien').val() || '';
                data.modal_tinhtang = $('#modal_tinhtang').val() || '';
                data.modal_ghichu = $('#modal_ghichu').val() || '';


                const editIndex = parseInt($('#modal_edit_index').val());
                console.log('editIndex:', editIndex);
                console.log('Dữ liệu nộp thuế:', data);

                // Get text for select fields
                const mucdichsudung_text = $('#modal_mucdichsudung option:selected').text() || '';
                const tenduong_text = $('#modal_tenduong option:selected').text() || '';
                const tinhtrang_text = $('#modal_tinhtang option:selected').text() || '';

                // Generate table row HTML
                const html = `
            <tr>
                <td class="align-middle text-center stt"></td>
                <td class="align-middle">${data.modal_maphinongnghiep}</td>
                <td class="align-middle">${data.modal_diachi}</td>
                <td class="align-middle"><strong>Số giấy chứng nhận: </strong>${data.modal_sogiaychungnhan}<br><strong>Ngày chứng nhận: </strong>${data.modal_ngaycap}</td>
                <td class="align-middle"><strong>Tờ bản đồ: </strong>${data.modal_tobando}<br><strong>Thửa đất: </strong>${data.modal_thuadat}</td>
                <td class="align-middle"><strong>Diện tích có GCN: </strong>${data.modal_dientichcogcn}<br><strong>Diện tích chưa có GCN: </strong>${data.modal_dientichchuacogcn}<br><strong>Diện tích sử dụng:</strong>${data.modal_dientichsd}</td>
                <td class="align-middle">${mucdichsudung_text}</td>
                <td class="align-middle">${data.modal_miengiamthue}</td>
                <td class="align-middle">${formatCurrency(data.modal_tongtien)}</td>
                <td class="align-middle">${tinhtrang_text}</td>
                <td class="align-middle">${data.modal_ghichu}</td>

                <td class="align-middle text-center" style="min-width:100px">
                    <input type="hidden" name="chitiet_id[]" value="${data.modal_trocap_id}" />
                    <input type="hidden" name="maphinongnghiep[]" value="${data.modal_maphinongnghiep}" />
                    <input type="hidden" name="sogiaychungnhan[]" value="${data.modal_sogiaychungnhan}" />
                    <input type="hidden" name="diachi[]" value="${data.modal_diachi}" />
                    <input type="hidden" name="ngaycap[]" value="${data.modal_ngaycap}" />
                    <input type="hidden" name="tobando[]" value="${data.modal_tobando}" />
                    <input type="hidden" name="thuadat[]" value="${data.modal_thuadat}" />
                    <input type="hidden" name="dientichcogcn[]" value="${data.modal_dientichcogcn}" />
                    <input type="hidden" name="dientichchuacogcn[]" value="${data.modal_dientichchuacogcn}" />
                    <input type="hidden" name="dientichsd[]" value="${data.modal_dientichsd}" />
                    <input type="hidden" name="mucdichsudung[]" value="${data.modal_mucdichsudung}" />
                    <input type="hidden" name="tenduong[]" value="${data.modal_tenduong}" />
                    <input type="hidden" name="miengiamthue[]" value="${data.modal_miengiamthue}" />
                    <input type="hidden" name="tongtien[]" value="${data.modal_tongtien}" />
                    <input type="hidden" name="tinhtrang[]" value="${data.modal_tinhtang}" />
                    <input type="hidden" name="ghichu[]" value="${data.modal_ghichu}" />
                    <span class="btn btn-sm btn-warning btn_edit_trocap" data-trocap-id="${data.modal_trocap_id}"><i class="fas fa-edit"></i></span>
                    <span class="btn btn-sm btn-danger btn_xoa_trocap" data-trocap-id="${data.modal_trocap_id}"><i class="fas fa-trash-alt"></i></span>
                </td>
            </tr>`;

                // Update or append table row
                if ($('.dsThongtinnopthue .no-data').length) {
                    $('.dsThongtinnopthue .no-data').remove();
                }
                if (!isNaN(editIndex) && editIndex >= 0 && $('.dsThongtinnopthue tr').eq(editIndex).length) {
                    $('.dsThongtinnopthue tr').eq(editIndex).replaceWith(html);
                    showToast('Cập nhật thông tin nộp thuế đất thành công', true);
                } else {
                    $('.dsThongtinnopthue').append(html);
                    showToast('Thêm thông tin nộp thuế đất thành công', true);
                }

                $('#modal_edit_index').val('');
                updateTroCapSTT(); // Update row numbering
                $('#modalNopThueDat').modal('hide');
            } else {
                showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
            }
        });

        // Utility functions (assumed to exist)
        function formatCurrency(value) {
            return value ? parseFloat(value).toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }) : '';
        }



        $('.dsThongtinnopthue').on('click', '.btn_xoa_trocap', async function() {
            const $row = $(this).closest('tr');
            const nopthue_id = $(this).data('trocap-id');
            console.log('Xóa thông tin trợ cấp:', nopthue_id);

            if (!confirm('Bạn có chắc chắn muốn xóa thông tin trợ cấp này?')) {
                return;
            }

            try {
                const response = await $.post('index.php', {
                    option: 'com_taichinh',
                    controller: 'nopthue',
                    task: 'delThongtinnopthue',
                    nopthue_id: nopthue_id
                }, null, 'json');

                if (response.success) {
                    $row.remove();
                    updateTroCapSTT();
                    showToast('Xóa thông tin trợ cấp thành công', true);
                    if ($('.dsThongtinnopthue tr').length === 0) {
                        $('.dsThongtinnopthue').html('<tr class="no-data"><td colspan="8" class="text-center">Không có dữ liệu</td></tr>');
                    }
                } else {
                    showToast('Xóa thông tin trợ cấp thất bại: ' + (response.message || 'Lỗi không xác định'), false);
                }
            } catch (error) {
                console.error('Delete error:', error);
                showToast('Lỗi khi xóa thông tin trợ cấp', false);
            }
        });

        $('#btn_themnopthue').on('click', function(e) {
            e.preventDefault();
            $('#modalNopthuedatLabel').text('Thêm thông tin nộp thuế');
            $('#frmModalNopThueDat')[0].reset();
            $('#modal_trocap_id').val('');
            $('#modal_edit_index').val('');
            $('#modal_muc_tien_chuan').val('').prop('readonly', true);
            $('#modal_thuc_nhan').val('').prop('readonly', true);
            resetInputFields();
            initializeModalSelect2();
            $('#modalNopThueDat').modal('show');
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
            window.location.href = '<?php echo Route::_('/index.php/component/taichinh/?view=nopthue&task=default'); ?>';
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
                $('#nhanhokhau_id').val('');
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
            if (item && item[0] && item[0].nhanhokhau_id) {
                console.log('Fetching nhanhokhau_id:', item[0].nhanhokhau_id);
                try {
                    const nhankhauResponse = await $.post('index.php', {
                        option: 'com_vhytgd',
                        task: 'nguoicocong.timkiem_nhankhau',
                        format: 'json',
                        nhankhau_id: item[0].nhanhokhau_id,
                    }, null, 'json');
                    console.log('nhankhauResponse:', nhankhauResponse);
                    if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
                        const nhankhau = nhankhauResponse.items.find(nk => nk.id === item[0].nhanhokhau_id) || nhankhauResponse.items[0];
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
                            console.warn('Không tìm thấy nhân khẩu với nhanhokhau_id:', item[0].nhanhokhau_id);
                            showToast('Không tìm thấy nhân khẩu phù hợp', false);
                            $('#checkbox_toggle').prop('checked', false).trigger('change');
                        }
                    } else {
                        console.warn('Không có dữ liệu nhân khẩu từ API');
                        showToast('Không tìm thấy thông tin nhân khẩu', false);
                        $('#checkbox_toggle').prop('checked', false).trigger('change');
                    }
                } catch (error) {
                    console.error('Fetch nhankhau error:', error);
                    showToast('Lỗi khi tải thông tin nhân khẩu', false);
                    $('#checkbox_toggle').prop('checked', false).trigger('change');
                }
            } else {
                console.warn('Không có nhanhokhau_id trong item:', item);
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
            if (!isEditMode) {
                try {
                    const response = await $.post('index.php', {
                        option: 'com_taichinh',
                        controller: 'nopthue',
                        task: 'checkNhankhau',
                        nhankhau_id: data.id,
                    }, null, 'json');

                    if (response.exists) {
                        showToast('Nhân khẩu này đã có trong danh sách đăng ký', false);
                        $('#select_top').val('').trigger('change');
                        return;
                    }
                } catch (error) {
                    console.error('Check nhankhau error:', error);
                    showToast('Lỗi khi kiểm tra trạng thái nhân khẩu', false);
                    return;
                }
            }
            // gán dữ liệu đã chọn từ danh sách nhân khẩu vào trong form
            $('#nhanhokhau_id').val(data.id || '');
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
        $('#formNopThueDat').validate({
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
                },
                masothue: {
                    required: true,
                }

            },
            messages: {
                select_top: 'Vui lòng chọn nhân khẩu',
                hoten: 'Vui lòng nhập họ và tên',
                cccd: 'Vui lòng nhập CCCD/CMND',
                select_namsinh: 'Vui lòng chọn năm sinh',
                select_phuongxa_id: 'Vui lòng chọn phường/xã',
                select_gioitinh_id: 'Vui lòng chọn giới tính',
                masothue: 'Vui nhập mã số thuế',

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
        // $('#formNopThueDat').on('submit', function(e) {
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

    /* CSS cụ thể cho #modalNopThueDat */
    #modalNopThueDat .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        word-break: break-word;
    }

    #modalNopThueDat .select2-container .select2-selection--single {
        height: 38px;
    }

    #modalNopThueDat .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    #modalNopThueDat .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    #modalNopThueDat {
        overflow-x: hidden;
    }

    #modalNopThueDat .modal-dialog {
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

    #modalNopThueDat.show .modal-dialog {
        transform: translateX(0);
    }

    #modalNopThueDat.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    #modalNopThueDat.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    #modalNopThueDat .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #modalNopThueDat .error_modal {
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