<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;


$item = $this->item;

?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</meta>
<form id="frmGiaDinhVanHoa" name="frmGiaDinhVanHoa" method="post" action="index.php?option=com_dcxddt&controller=biensonha&task=saveBiensonha">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
            <?php echo ((int)$item[0]['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> biển số nhà
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary" style="font-size:18px;"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
            </span>
        </h2>
        <table class="table w-100" style="margin-bottom: 15px;" id="tblThongtin">
            <tbody>
                <tr>
                    <td colspan="6">
                        <h3 class="mb-0 fw-bold">Thông tin thôn/tổ</h3>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">
                        <div class="mb-3" style="margin-bottom: 0rem !important;">
                            <strong>Phường/Xã <span class="text-danger">*</span></strong>
                            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                <option value="" data-quanhuyen="" data-tinhthanh=""></option>
                                <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                                    <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected data-quanhuyen="<?php echo $this->phuongxa[0]['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $this->phuongxa[0]['tinhthanh_id']; ?>"><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
                                <?php } elseif (is_array($this->phuongxa)) { ?>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>" <?php echo ($item[0]['phuongxa_id'] == $px['id']) ? 'selected' : ''; ?> data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="phuongxa_id"></label>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3" style="margin-bottom: 0rem !important;">
                            <strong>Thôn/Tổ <span class="text-danger">*</span></strong>
                            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                                <option value=""></option>
                                <?php if (is_array($this->thonto) && count($this->thonto) > 0) { ?>
                                    <?php foreach ($this->thonto as $tt) { ?>
                                        <option value="<?php echo $tt['id']; ?>" <?php echo ($item[0]['thonto_id'] === $tt['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tt['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="thonto_id"></label>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3" style="margin-bottom: 0rem !important;">
                            <strong>Tuyến đường <span class="text-danger">*</span></strong>
                            <select id="tuyenduong" name="tuyenduong" class="custom-select" data-placeholder="Chọn tuyến đường">
                                <option value=""></option>
                                <?php if (is_array($this->tenduong) && count($this->tenduong) > 0) { ?>
                                    <?php foreach ($this->tenduong as $tt) { ?>
                                        <option value="<?php echo $tt['id']; ?>" <?php echo ($item[0]['duong_id'] === $tt['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tt['tenduong']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="tuyenduong"></label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 style="padding-left:15px;" class="mb-0 fw-bold">Thông tin số nhà
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themthanhvien" data-toggle="modal" data-target="#modalThongTinSoNha"><i class="fas fa-plus"></i> Thêm số nhà</button>
            </span>
        </h3>
        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center" rowspan="2" style="width: 80px;">STT</th>
                        <th class="align-middle text-center" rowspan="2">Thông tin sở hữu</th>
                        <th class="align-middle text-center" rowspan="2">Số nhà</th>
                        <th class="align-middle text-center" rowspan="2">Tờ bản đồ</th>
                        <th class="align-middle text-center" rowspan="2">Thửa đất</th>
                        <th class="align-middle text-center" rowspan="2">Hình thức cấp</th>
                        <th class="align-middle text-center" rowspan="2">Lý do thay đổi</th>
                        <th class="align-middle text-center" rowspan="2">Ghi chú</th>
                        <th class="align-middle text-center" rowspan="2">Tọa độ</th>
                        <th class="align-middle text-center" rowspan="2" style="width: 150px;">Chức năng</th>
                    </tr>
                </thead>
                <tbody id="tbodyDanhSach">
                    <?php if (is_array($item) && count($item) > 0) { ?>
                        <?php foreach ($item as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle">
                                    <a href="#" class="edit-nhankhau" data-index="<?php echo $index; ?>" style="color: blue;">
                                        <?php if (!empty($nk['tentochuc'])): ?>
                                            <strong>Tên tổ chức:</strong> <?php echo htmlspecialchars($nk['tentochuc']); ?>
                                        <?php else: ?>
                                            <strong>Họ tên:</strong> <?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>
                                        <?php endif; ?>
                                    </a><br>
                                    <?php if (!empty($nk['tentochuc'])): ?>
                                        <strong>Điện thoại:</strong> <?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?><br>
                                        <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?>
                                    <?php else: ?>
                                        <strong>CCCD:</strong> <?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?><br>
                                        <strong>Điện thoại:</strong> <?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?><br>
                                        <strong>Ngày sinh:</strong> <?php echo htmlspecialchars($nk['n_namsinh'] ?? ''); ?><br>
                                        <strong>Giới tính:</strong> <?php echo htmlspecialchars($nk['tengioitinh'] ?? ''); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle"><?php echo ($nk['sonha']); ?></td>
                                <td class="align-middle"><?php echo ($nk['tobandoso']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['thuadatso'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['tenhinhthuc'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['lydothaydoi'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['toado1'] . '-' . $nk['toado2'] ?? ''); ?></td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="nhankhau_id[]" value="<?php echo $nk['nhankhau_id'] ?? ''; ?>" />
                                    <input type="hidden" name="hoten[]" value="<?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_so[]" value="<?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai[]" value="<?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?>" />
                                    <input type="hidden" name="ngaysinh[]" value="<?php echo htmlspecialchars($nk['n_namsinh'] ?? ''); ?>" />
                                    <input type="hidden" name="gioitinh_id[]" value="<?php echo htmlspecialchars($nk['n_gioitinh_id'] ?? ''); ?>" />
                                    <input type="hidden" name="diachi[]" value="<?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="thuadat[]" value="<?php echo htmlspecialchars($nk['thuadatso'] ?? ''); ?>" />
                                    <input type="hidden" name="tentochuc[]" value="<?php echo $nk['tentochuc'] ?? ''; ?>" />
                                    <input type="hidden" name="diachi_tochuc[]" value="<?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai_tochuc[]" value="<?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?>" />

                                    <input type="hidden" name="sonha[]" value="<?php echo $nk['sonha'] ?? ''; ?>" />
                                    <input type="hidden" name="tobando[]" value="<?php echo $nk['tobandoso'] ?? ''; ?>" />
                                    <input type="hidden" name="hinhthuccap[]" value="<?php echo htmlspecialchars($nk['hinhthuccap_id'] ?? ''); ?>" />
                                    <input type="hidden" name="lydothaydoi[]" value="<?php echo htmlspecialchars($nk['lydothaydoi'] ?? ''); ?>" />
                                    <input type="hidden" name="ghichu[]" value="<?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?>" />
                                    <input type="hidden" name="toado1[]" value="<?php echo htmlspecialchars($nk['toado1'] ?? ''); ?>" />
                                    <input type="hidden" name="toado2[]" value="<?php echo htmlspecialchars($nk['toado2'] ?? ''); ?>" />
                                    <input type="hidden" name="id_sonha2[]" value="<?php echo (int)($nk['id_sonha2'] ?? '0'); ?>" />
                                    <input type="hidden" name="loaisohuu[]" value="<?php echo (int)($nk['is_loai'] ?? '0'); ?>" />
                                    <input type="hidden" name="phuongxa_id[]" value="<?php echo (int)($nk['phuongxa_id'] ?? '0'); ?>" />
                                    <input type="hidden" name="thonto_id[]" value="<?php echo (int)($nk['thonto_id'] ?? '0'); ?>" />

                                    <span class="btn btn-sm btn-danger btn_xoa" data-xuly="<?php echo $nk['id_sonha2'] ?? ''; ?>"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="no-data">
                            <td colspan="10" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="biensonha" value="<?php echo (int)$item[0]['giadinhvanhoa_id']; ?>">

    </div>
</form>

<!-- Modal thông tin thành viên -->
<div class="modal fade" id="modalThongTinSoNha" tabindex="-1" role="dialog" aria-labelledby="modalThongtinsonhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalThongtinsonhaLabel">Thêm thông tin số nhà</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalBiensonha">
                    <input type="hidden" id="modal_edit_index" value="">
                    <input type="hidden" id="modal_nhankhau_id" name="modal_nhankhau_id" value="">
                    <div class="mb-3">
                        <label class="form-label">Loại sở hữu<span class="text-danger">*</span></label>
                        <select id="modal_loaisohuu" name="modal_loaisohuu" class="custom-select" data-placeholder="Chọn loại sở hữu" required>
                            <option value=""></option>

                            <option value="1">Cá nhân</option>
                            <option value="2">Tổ chức</option>
                        </select>
                        <label class="error_modal" for="modal_loaisohuu"></label>
                    </div>
                    <!-- Form tổ chức -->
                    <div id="organization_fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên tổ chức <span class="text-danger">*</span></label>
                                    <input type="text" id="tentochuc" name="tentochuc" class="form-control" placeholder="Nhập tên tổ chức">
                                    <label class="error_modal" for="tentochuc"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_dienthoai_tochuc" name="modal_dienthoai_tochuc" class="form-control" placeholder="Nhập số điện thoại">
                                    <label class="error_modal" for="modal_dienthoai_tochuc"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3" style=" margin-bottom: 1rem !important;">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" id="modal_diachi_tochuc" name="modal_diachi_tochuc" class="form-control" placeholder="Nhập địa chỉ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form cá nhân -->
                    <div id="individual_fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Tìm kiếm thành viên <input type="checkbox" id="modal_search_toggle" checked></label>
                        </div>
                        <div id="search_fields">
                            <div class="mb-3">
                                <label class="form-label">Chọn thành viên <span class="text-danger">*</span></label>
                                <select id="modal_nhankhau_search" name="modal_nhankhau_search" class="custom-select" data-placeholder="Chọn thành viên"></select>
                                <label class="error_modal" for="modal_nhankhau_search"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_hoten" name="modal_hoten" class="form-control" placeholder="Nhập họ tên">
                                    <label class="error_modal" for="modal_hoten"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">CCCD <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_cccd_so" name="modal_cccd_so" class="form-control" placeholder="Nhập CCCD" disabled>
                                    <label class="error_modal" for="modal_cccd_so"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Điện thoại</label>
                                    <input type="text" id="modal_dienthoai" name="modal_dienthoai" class="form-control" placeholder="Nhập điện thoại" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                                    <select id="modal_gioitinh_id" name="modal_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính" disabled>
                                        <option value=""></option>
                                        <?php if (is_array($this->gioitinh) && count($this->gioitinh) > 0) { ?>
                                            <?php foreach ($this->gioitinh as $gt) { ?>
                                                <option value="<?php echo $gt['id']; ?>" data-text="<?php echo htmlspecialchars($gt['tengioitinh']); ?>">
                                                    <?php echo htmlspecialchars($gt['tengioitinh']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu giới tính</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_gioitinh_id"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_ngaysinh" name="modal_ngaysinh" class="form-control date-picker" placeholder="Nhập ngày sinh" disabled>
                                    <label class="error_modal" for="modal_ngaysinh"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_diachi" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ" disabled>
                                    <label class="error_modal" for="modal_diachi"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form chung -->
                    <div id="common_fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                    <select id="modal_phuongxa_id" name="modal_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã" disabled>
                                        <option value=""></option>
                                        <?php if (is_array($this->phuongxa) && count($this->phuongxa) > 0) { ?>
                                            <?php foreach ($this->phuongxa as $px) { ?>
                                                <option value="<?php echo $px['id']; ?>" data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>">
                                                    <?php echo htmlspecialchars($px['tenkhuvuc']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_phuongxa_id"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thôn/Tổ <span class="text-danger">*</span></label>
                                    <select id="modal_thonto_id" name="modal_thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ" disabled>
                                        <option value=""></option>
                                        <?php if (is_array($this->thonto) && count($this->thonto) > 0) { ?>
                                            <?php foreach ($this->thonto as $tt) { ?>
                                                <option value="<?php echo $tt['id']; ?>">
                                                    <?php echo htmlspecialchars($tt['tenkhuvuc']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_thonto_id"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số nhà <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_sonha" name="modal_sonha" class="form-control" placeholder="Nhập số nhà">
                                    <label class="error_modal" for="modal_sonha"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tờ bản đồ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_tobando" name="modal_tobando" class="form-control" placeholder="Nhập tờ bản đồ" required>
                                    <label class="error_modal" for="modal_tobando"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thửa đất</label>
                                    <input type="text" id="modal_thuadat" name="modal_thuadat" class="form-control" placeholder="Nhập thửa đất">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hình thức cấp <span class="text-danger">*</span></label>
                                    <select id="modal_hinhthuccap" name="modal_hinhthuccap" class="custom-select" data-placeholder="Chọn hình thức cấp" required>
                                        <option value=""></option>
                                        <?php if (is_array($this->hinhthuccap) && count($this->hinhthuccap) > 0) { ?>
                                            <?php foreach ($this->hinhthuccap as $htc) { ?>
                                                <option value="<?php echo $htc['id']; ?>" data-text="<?php echo htmlspecialchars($htc['tenhinhthuc']); ?>">
                                                    <?php echo htmlspecialchars($htc['tenhinhthuc']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu hình thức cấp</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_hinhthuccap"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3" style="margin-bottom: 1rem !important;">
                                    <label class="form-label">Tọa độ 1</label>
                                    <input type="text" id="modal_toado1" name="modal_toado1" class="form-control" placeholder="Nhập tọa độ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tọa độ 2</label>
                                    <input type="text" id="modal_toado2" name="modal_toado2" class="form-control" placeholder="Nhập tọa độ">
                                </div>
                            </div>
                            <div class="col-md-12" id="lydo_container" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Lý do thay đổi <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_lydothaydoi" name="modal_lydothaydoi" class="form-control" placeholder="Nhập lý do thay đổi">
                                    <label class="error_modal" for="modal_lydothaydoi"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <input type="text" id="modal_ghichu" name="modal_ghichu" class="form-control" placeholder="Nhập ghi chú">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="modal_sonha_id" name="modal_sonha_id" value="">
                <button type="button" class="btn btn-primary" id="btn_luu_nhankhau"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Hàm hiển thị thông báo
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const selectElements = $('#thonto_id, #tuyenduong');
        selectElements.select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });


        $('select.custom-select').on('change.select2 blur', function() {
            $(this).closest('form').validate().element(this);
        });
        $('select.custom-select').on('select2:close', function() {
            $(this).trigger('blur'); // Kích hoạt blur để validate
        });

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
            }).appendTo('body');
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
        }

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

        function updateSTT() {
            $('#tblDanhsach tbody tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
                $(this).find('.edit-nhankhau').data('index', index);
            });
        }

        function initializeModalSelect2() {
            $('#modalThongTinSoNha select.custom-select').not('#modal_nhankhau_search').each(function() {
                initSelect2($(this), {
                    width: '100%',
                    allowClear: true,
                    placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                    dropdownParent: $('#modalThongTinSoNha')
                });
            });
        }
        let isRedirecting = false;
        let isChecking = false;

        const REDIRECT_KEY = 'hasRedirectedBSN';

        const currentPath = window.location.pathname;
        const currentSearch = window.location.search;
        const isCorrectPage =
            (currentPath === '/index.php/component/dcxddt/' || currentPath === '/index.php') &&
            currentSearch.includes('view=biensonha') &&
            currentSearch.includes('task=add_bsn');

        if (isCorrectPage && sessionStorage.getItem(REDIRECT_KEY) !== '1') {
            function handleChange(e) {

                if (isChecking) {
                    return;
                }

                const phuongxa_id = $('#phuongxa_id').val();
                const thonto_id = $('#thonto_id').val();
                const tuyenduong = $('#tuyenduong').val();

                if (!phuongxa_id) {
                    showToast('Vui lòng chọn xã/phường trước!', false);
                    return;
                }

                if (thonto_id && tuyenduong) {
                    isChecking = true;
                    $('#btn_luu_nhankhau').prop('disabled', true);
                    selectElements.prop('disabled', true);

                    $.ajax({
                        url: 'index.php?option=com_dcxddt&controller=biensonha&task=checkBienSoNha',
                        type: 'POST',
                        data: {
                            thonto_id: thonto_id,
                            tuyenduong: tuyenduong,
                            [Joomla.getOptions('csrf.token')]: 1
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            // Thay showToast bằng loading indicator (nếu cần)
                            $('#tblDanhsach tbody').html('<tr><td colspan="10" class="text-center">Đang kiểm tra...</td></tr>');
                        },
                        success: function(response) {
                            isChecking = false;
                            $('#btn_luu_nhankhau').prop('disabled', false);
                            selectElements.prop('disabled', false);

                            if (response.success && response.data && response.data.length > 0) {
                                const bsn_id = response.data[0].id; // Lấy a.id từ response.data
                                sessionStorage.setItem(REDIRECT_KEY, '1');
                                showToast('Tuyến đường đã được cấp số nhà. Đang chuyển hướng .....', false);

                                setTimeout(function() {
                                    const redirectUrl = `index.php?option=com_dcxddt&view=biensonha&task=edit_bsn&bsn_id=${bsn_id}`;
                                    window.location.assign(redirectUrl);
                                }, 2000);
                            } 
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            isChecking = false;
                            $('#btn_luu_nhankhau').prop('disabled', false);
                            selectElements.prop('disabled', false);
                            let errorMessage = 'Lỗi khi kiểm tra Biển số nhà!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showToast(errorMessage, false);
                        }
                    });
                } 
            }

            // Ngăn sự kiện change trùng lặp
            selectElements.off('change').on('change', debounce(handleChange, 500));

            // Kiểm tra khi tải trang, nhưng chỉ gọi nếu cần
            if ($('#thonto_id').val() && $('#tuyenduong').val()) {
                // Đảm bảo chỉ gọi một lần
                setTimeout(() => {
                    if (!isChecking) {
                        debounce(handleChange, 500)({
                            target: $('#thonto_id')[0]
                        });
                    }
                }, 100);
            }
        } else if (sessionStorage.getItem(REDIRECT_KEY) === '1') {
            sessionStorage.removeItem(REDIRECT_KEY);
        }

        initSelect2($('#phuongxa_id, #thonto_id, #tuyenduong, #modal_nhankhau_search'), {
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });

        $('#btn_themthanhvien').on('click', function(e) {
            e.preventDefault();
            const selectedThontoId = $('#thonto_id').val();
            const selectedNam = $('#tuyenduong').val();

            if (!selectedThontoId || !selectedNam) {
                showToast('Vui lòng chọn Phường/Xã, Thôn/Tổ và tuyến đường', false);
                return false;
            }

            $('#modalThongtinsonhaLabel').text('Thêm danh hiệu');
            $('#modal_edit_index').val('');
            $('#frmModalBiensonha')[0].reset();
            initializeModalSelect2();

            const selectedPhuongxaId = $('#phuongxa_id').val();
            $('#modal_phuongxa_id').val(selectedPhuongxaId).prop('disabled', true);
            $('#modal_thonto_id').html($('#thonto_id').html());
            $('#modal_thonto_id').val(selectedThontoId).prop('disabled', true);

            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            // $('#modal_loaisohuu').val('').trigger('change'); // Reset loại sở hữu

            $('#modal_search_toggle').prop('checked', true).trigger('change');
            $('#modalThongTinSoNha').modal('show');
        });
        $('#modal_search_toggle').on('change', function() {
            const isChecked = $(this).is(':checked');
            const loaisohuu = $('#modal_loaisohuu').val();

            $('#search_fields').toggle(isChecked);
            $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id, #modal_ngaysinh').prop('disabled', isChecked);
            $('#modal_nhankhau_search').prop('required', isChecked);

            if (isChecked) {
                const thonto_id = $('#thonto_id').val();
                const tuyenduong = $('#tuyenduong').val();
                if (!thonto_id || !tuyenduong) {
                    showToast('Vui lòng chọn Thôn/Tổ và Tuyến đường trước khi tìm kiếm', false);
                    $(this).prop('checked', false);
                    $('#search_fields').hide();
                    return;
                }

                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');

                initSelect2($('#modal_nhankhau_search'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                    dropdownParent: $('#modalThongTinSoNha'),
                    minimumInputLength: 2,
                    ajax: {
                        url: 'index.php?option=com_dcxddt&controller=biensonha&task=getThanhVienGiaDinhVanHoa',
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            const data = {
                                search: params.term,
                                thonto_id: thonto_id,
                                tuyenduong: tuyenduong,
                                [Joomla.getOptions('csrf.token')]: 1
                            };
                            return data;
                        },
                        processResults: function(data) {
                            if (!data || !Array.isArray(data)) {
                                showToast('Không tìm thấy dữ liệu thành viên!', false);
                                return {
                                    results: []
                                };
                            }
                            const results = data.map(v => ({
                                id: v.nhankhau_id,
                                text: `${v.hoten || ''} - CCCD: ${v.cccd_so || ''} - Ngày sinh: ${v.ngaysinh || ''} - Địa chỉ: ${v.diachi || ''}`,
                                data: {
                                    hoten: v.hoten || '',
                                    cccd_so: v.cccd_so || '',
                                    dienthoai: v.dienthoai || '',
                                    diachi: v.diachi || '',
                                    ngaysinh: v.ngaysinh || '',
                                    gioitinh_id: v.gioitinh_id || '',
                                    gioitinh_text: v.tengioitinh || '',
                                    nhankhau_id: v.nhankhau_id || ''
                                }
                            }));
                            return {
                                results
                            };
                        },
                        error: function(xhr, status, error) {
                            console.error('Search AJAX error:', status, error, xhr.responseText);
                            // showToast('Lỗi khi tìm kiếm thành viên!', false);
                            return {
                                results: []
                            };
                        }
                    }
                });
            } else {
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
            }
        });
        $('#modal_loaisohuu').on('change', function() {
            const loaisohuu = $(this).val();
            $('#organization_fields').toggle(loaisohuu === '2');
            $('#individual_fields').toggle(loaisohuu === '1');
            $('#search_fields').toggle(loaisohuu === '1' && $('#modal_search_toggle').is(':checked'));

            // Cập nhật trạng thái bắt buộc cho các trường
            $('#tentochuc, #modal_dienthoai_tochuc').prop('required', loaisohuu === '2');
            $('#modal_hoten, #modal_cccd_so, #modal_gioitinh_id, #modal_ngaysinh, #modal_diachi').prop('required', loaisohuu === '1' && !$('#modal_search_toggle').is(':checked'));
            $('#modal_nhankhau_search').prop('required', loaisohuu === '1' && $('#modal_search_toggle').is(':checked'));

            // Reset các trường khi chuyển đổi
            if (loaisohuu === '2') {
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh, #modal_nhankhau_id').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_nhankhau_search').val('').trigger('change.select2');
            } else if (loaisohuu === '1') {
                $('#tentochuc, #modal_dienthoai_tochuc, #modal_diachi_tochuc').val('');
            }
        });

        $('#modal_nhankhau_search').on('change', function() {
            const selectedData = $(this).select2('data')[0];
            if (selectedData && selectedData.id && selectedData.data) {
                $('#modal_hoten').val(selectedData.data.hoten || '');
                $('#modal_nhankhau_id').val(selectedData.data.nhankhau_id || '');
                $('#modal_cccd_so').val(selectedData.data.cccd_so || '');
                $('#modal_dienthoai').val(selectedData.data.dienthoai || '');
                $('#modal_diachi').val(selectedData.data.diachi || '');
                $('#modal_ngaysinh').val(selectedData.data.ngaysinh || '');
                $('#modal_gioitinh_id').val(selectedData.data.gioitinh_id || '').trigger('change.select2');
            } else {
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh, #modal_nhankhau_id').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
            }
        });

        $('#btn_luu_nhankhau').on('click', function() {
            const $form = $('#frmModalBiensonha');
            const loaisohuu = $('#modal_loaisohuu').val();
            const isSearch = $('#modal_search_toggle').is(':checked');
            const editIndex = $('#modal_edit_index').val();
            const isEditing = editIndex !== '';
            if ($form.valid()) {
                const formData = $form.serializeArray();

                // Kiểm tra các trường bắt buộc
                if (loaisohuu === '2') {
                    if (!$('#tentochuc').val() || !$('#modal_dienthoai_tochuc').val()) {
                        showToast('Vui lòng điền đầy đủ tên tổ chức và số điện thoại', false);
                        return false;
                    }
                } else if (loaisohuu === '1') {
                    if (isSearch && !$('#modal_nhankhau_search').val()) {
                        showToast('Vui lòng chọn một thành viên', false);
                        return false;
                    }
                    if (!isSearch && (!$('#modal_hoten').val() || !$('#modal_cccd_so').val() || !$('#modal_gioitinh_id').val() || !$('#modal_ngaysinh').val() || !$('#modal_diachi').val())) {
                        showToast('Vui lòng điền đầy đủ thông tin cá nhân', false);
                        return false;
                    }
                } else {
                    showToast('Vui lòng chọn loại sở hữu', false);
                    return false;
                }

                const data = {
                    sonha_id: $('#modal_sonha_id').val() || '',
                    loaisohuu: loaisohuu,
                    tentochuc: loaisohuu === '2' ? $('#tentochuc').val() : '',
                    dienthoai_tochuc: loaisohuu === '2' ? $('#modal_dienthoai_tochuc').val() : '',
                    diachi_tochuc: loaisohuu === '2' ? $('#modal_diachi_tochuc').val() : '',
                    nhankhau_id: loaisohuu === '1' ? $('#modal_nhankhau_id').val() : '',
                    hoten: loaisohuu === '1' ? $('#modal_hoten').val() : '',
                    cccd_so: loaisohuu === '1' ? $('#modal_cccd_so').val() : '',
                    dienthoai: loaisohuu === '1' ? $('#modal_dienthoai').val() : '',
                    gioitinh_id: loaisohuu === '1' ? $('#modal_gioitinh_id').val() : '',
                    gioitinh_text: loaisohuu === '1' ? ($('#modal_gioitinh_id option:selected').data('text') || $('#modal_gioitinh_id option:selected').text()) : '',
                    ngaysinh: loaisohuu === '1' ? $('#modal_ngaysinh').val() : '',
                    diachi: loaisohuu === '1' ? $('#modal_diachi').val() : '',
                    phuongxa_id: $('#modal_phuongxa_id').val(),
                    thonto_id: $('#modal_thonto_id').val(),
                    sonha: $('#modal_sonha').val(),
                    tobando: $('#modal_tobando').val(),
                    thuadat: $('#modal_thuadat').val(),
                    hinhthuccap: $('#modal_hinhthuccap').val(),
                    hinhthuccap_text: $('#modal_hinhthuccap option:selected').data('text') || $('#modal_hinhthuccap option:selected').text(),
                    toado1: $('#modal_toado1').val(),
                    toado2: $('#modal_toado2').val(),
                    lydothaydoi: $('#modal_hinhthuccap').val() === '5' ? $('#modal_lydothaydoi').val() : '',
                    ghichu: $('#modal_ghichu').val()
                };

                // --- Phần kiểm tra lý do thay đổi của bạn giữ nguyên ---
                // ...

                // Tạo HTML cho bảng
                const $tbody = $('#tbodyDanhSach'); // <-- Dùng biến để code sạch hơn
                const stt = isEditing ? parseInt($($tbody.find('tr')[editIndex]).find('.stt').text()) : $tbody.find('tr:not(.no-data)').length + 1;
                const infoText = data.loaisohuu === '2' ?
                    `<a href="#" class="edit-nhankhau" data-index="${isEditing ? editIndex : $tbody.find('tr').length}" style="color: blue;">
            <strong>Tên tổ chức:</strong> ${data.tentochuc}
        </a><br>
        <strong>Điện thoại:</strong> ${data.dienthoai_tochuc}<br>
        <strong>Địa chỉ:</strong> ${data.diachi_tochuc}` :
                    `<a href="#" class="edit-nhankhau" data-index="${isEditing ? editIndex : $tbody.find('tr').length}" style="color: blue;">
            <strong>Họ tên:</strong> ${data.hoten}
        </a><br>
        <strong>CCCD:</strong> ${data.cccd_so}<br>
        <strong>Điện thoại:</strong> ${data.dienthoai}<br>
        <strong>Giới tính:</strong> ${data.gioitinh_text}<br>
        <strong>Ngày sinh:</strong> ${data.ngaysinh}`;

                const html = `
    <tr>
        <td class="align-middle text-center stt">${stt}</td>
        <td class="align-middle">${infoText}</td>
        <td class="align-middle">${data.sonha}</td>
        <td class="align-middle">${data.tobando}</td>
        <td class="align-middle">${data.thuadat}</td>
        <td class="align-middle">${data.hinhthuccap_text}</td>
        <td class="align-middle">${data.lydothaydoi}</td>
        <td class="align-middle">${data.ghichu}</td>
        <td class="align-middle">${data.toado1} - ${data.toado2}</td>
        <td class="align-middle text-center">
            <input type="hidden" name="id_sonha2[]" value="${data.sonha_id}" />
            <input type="hidden" name="loaisohuu[]" value="${data.loaisohuu}" />
            <input type="hidden" name="tentochuc[]" value="${data.tentochuc}" />
            <input type="hidden" name="dienthoai_tochuc[]" value="${data.dienthoai_tochuc}" />
            <input type="hidden" name="diachi_tochuc[]" value="${data.diachi_tochuc}" />
            <input type="hidden" name="nhankhau_id[]" value="${data.nhankhau_id}" />
            <input type="hidden" name="hoten[]" value="${data.hoten}" />
            <input type="hidden" name="cccd_so[]" value="${data.cccd_so}" />
            <input type="hidden" name="dienthoai[]" value="${data.dienthoai}" />
            <input type="hidden" name="gioitinh_id[]" value="${data.gioitinh_id}" />
            <input type="hidden" name="ngaysinh[]" value="${data.ngaysinh}" />
            <input type="hidden" name="diachi[]" value="${data.diachi}" />
            <input type="hidden" name="phuongxa_id[]" value="${data.phuongxa_id}" />
            <input type="hidden" name="thonto_id[]" value="${data.thonto_id}" />
            <input type="hidden" name="sonha[]" value="${data.sonha}" />
            <input type="hidden" name="tobando[]" value="${data.tobando}" />
            <input type="hidden" name="thuadat[]" value="${data.thuadat}" />
            <input type="hidden" name="hinhthuccap[]" value="${data.hinhthuccap}" />
            <input type="hidden" name="toado1[]" value="${data.toado1}" />
            <input type="hidden" name="toado2[]" value="${data.toado2}" />
            <input type="hidden" name="lydothaydoi[]" value="${data.lydothaydoi}" />
            <input type="hidden" name="ghichu[]" value="${data.ghichu}" />
            <span class="btn btn-sm btn-danger btn_xoa" data-xuly=""><i class="fas fa-trash-alt"></i></span>
        </td>
    </tr>`;

                // Thêm hoặc cập nhật hàng trong bảng
                $tbody.find('tr:has(td[colspan])').remove();

                if (isEditing) {
                    $($tbody.find('tr')[editIndex]).replaceWith(html); // <-- ĐÃ SỬA SELECTOR
                    showToast('Cập nhật thông tin số nhà thành công', true);
                } else {
                    $tbody.append(html); // <-- ĐÃ SỬA SELECTOR
                    showToast('Thêm thông tin số nhà thành công', true);
                }

                // Cập nhật STT và đóng modal
                if (typeof updateSTT === 'function') {
                    updateSTT();
                }
                $('#modalThongTinSoNha').modal('hide');
                $('#frmModalBiensonha')[0].reset();
                resetModal();
            } else {
                showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
            }
        });
        $('body').on('click', '.edit-nhankhau', function(e) {
            e.preventDefault();
            const index = $(this).data('index');
            const $row = $(this).closest('tr');

            const data = {
                sonha_id: $row.find('input[name="id_sonha2[]"]').val() || '',
                loaisohuu: $row.find('input[name="loaisohuu[]"]').val() || '',
                tentochuc: $row.find('input[name="tentochuc[]"]').val() || '',
                dienthoai_tochuc: $row.find('input[name="dienthoai_tochuc[]"]').val() || '',
                diachi_tochuc: $row.find('input[name="diachi_tochuc[]"]').val() || '',
                nhankhau_id: $row.find('input[name="nhankhau_id[]"]').val() || '',
                hoten: $row.find('input[name="hoten[]"]').val() || '',
                cccd_so: $row.find('input[name="cccd_so[]"]').val() || '',
                dienthoai: $row.find('input[name="dienthoai[]"]').val() || '',
                gioitinh_id: $row.find('input[name="gioitinh_id[]"]').val() || '',
                ngaysinh: $row.find('input[name="ngaysinh[]"]').val() || '',
                diachi: $row.find('input[name="diachi[]"]').val() || '',
                phuongxa_id: $row.find('input[name="phuongxa_id[]"]').val() || $('#phuongxa_id').val(),
                thonto_id: $row.find('input[name="thonto_id[]"]').val() || $('#thonto_id').val(),
                sonha: $row.find('input[name="sonha[]"]').val() || '',
                tobando: $row.find('input[name="tobando[]"]').val() || '',
                thuadat: $row.find('input[name="thuadat[]"]').val() || '',
                hinhthuccap: $row.find('input[name="hinhthuccap[]"]').val() || '',
                toado1: $row.find('input[name="toado1[]"]').val() || '',
                toado2: $row.find('input[name="toado2[]"]').val() || '',
                lydothaydoi: $row.find('input[name="lydothaydoi[]"]').val() || '',
                ghichu: $row.find('input[name="ghichu[]"]').val() || ''
            };

            $('#modalThongtinsonhaLabel').text('Chỉnh sửa thông tin số nhà');
            $('#modal_edit_index').val(index);
            resetModal(); // Đảm bảo modal được reset trước khi điền dữ liệu

            $('#modal_phuongxa_id').val(data.phuongxa_id).prop('disabled', true);
            $('#modal_thonto_id').val(data.thonto_id).prop('disabled', true);
            $('#modal_loaisohuu').val(data.loaisohuu).trigger('change');

            if (data.loaisohuu === '2') {
                $('#tentochuc').val(data.tentochuc);
                $('#modal_dienthoai_tochuc').val(data.dienthoai_tochuc);
                $('#modal_diachi_tochuc').val(data.diachi_tochuc);
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh, #modal_nhankhau_id').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_nhankhau_search').val('').trigger('change.select2');
            } else if (data.loaisohuu === '1') {
                const isSearch = data.nhankhau_id && data.hoten;
                $('#modal_search_toggle').prop('checked', isSearch).trigger('change');
                $('#modal_nhankhau_id').val(data.nhankhau_id);
                $('#modal_hoten').val(data.hoten);
                $('#modal_cccd_so').val(data.cccd_so);
                $('#modal_dienthoai').val(data.dienthoai);
                $('#modal_diachi').val(data.diachi);
                $('#modal_ngaysinh').val(data.ngaysinh);
                $('#modal_gioitinh_id').val(data.gioitinh_id).trigger('change.select2');

                if (isSearch) {
                    const selectedOption = {
                        id: data.nhankhau_id,
                        text: `${data.hoten} - CCCD: ${data.cccd_so} - Địa chỉ: ${data.diachi}`,
                        data: {
                            nhankhau_id: data.nhankhau_id,
                            hoten: data.hoten,
                            cccd_so: data.cccd_so,
                            dienthoai: data.dienthoai,
                            diachi: data.diachi,
                            ngaysinh: data.ngaysinh,
                            gioitinh_id: data.gioitinh_id,
                            gioitinh_text: $row.find('td:nth-child(2)').find('strong:contains("Giới tính")').next().text().trim() || ''
                        }
                    };
                    $('#modal_nhankhau_search').html(`<option value="${selectedOption.id}">${selectedOption.text}</option>`);
                    $('#modal_nhankhau_search').data('select2-data', selectedOption).val(selectedOption.id).trigger('change.select2');
                }
            }

            $('#modal_sonha_id').val(data.sonha_id);
            $('#modal_sonha').val(data.sonha);
            $('#modal_tobando').val(data.tobando);
            $('#modal_thuadat').val(data.thuadat);
            $('#modal_hinhthuccap').val(data.hinhthuccap).trigger('change.select2');
            $('#modal_toado1').val(data.toado1);
            $('#modal_toado2').val(data.toado2);
            $('#modal_lydothaydoi').val(data.lydothaydoi);
            $('#modal_ghichu').val(data.ghichu);
            $('#lydo_container').toggle(data.hinhthuccap === '5');
            $('#modal_lydothaydoi').prop('required', data.hinhthuccap === '5');

            $('#modalThongTinSoNha').modal('show');
        });

        // Xử lý hiển thị lý do thay đổi khi chọn hình thức cấp
        $('#modal_hinhthuccap').on('change', function() {
            const isCapLai = $(this).val() === '5';
            $('#lydo_container').toggle(isCapLai);
            $('#modal_lydothaydoi').prop('required', isCapLai);
        });

        $('body').on('click', '.btn_xoa', function() {
            var $row = $(this).closest('tr');
            var sonha_id = $(this).data('xuly');
            bootbox.confirm({
                title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                message: '<span class="text-danger" style="font-size:24px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
                buttons: {
                    confirm: {
                        label: '<i class="fas fa-check"></i> Đồng ý',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: '<i class="fas fa-times"></i> Không',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result) {
                        if (sonha_id) {
                            $.post('index.php', {
                                option: 'com_dcxddt',
                                controller: 'biensonha',
                                task: 'delSonha',
                                sonha_id: sonha_id,
                                [Joomla.getOptions('csrf.token')]: 1
                            }, function(data) {
                                var response = typeof data === 'string' ? JSON.parse(data) : data;
                                if (response.success) {
                                    $row.remove();
                                    updateSTT();
                                    showToast(response.message || 'Đã xóa thành viên thành công!', true);
                                } else {
                                    showToast(response.message || 'Lỗi khi xóa thành viên!', false);
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                console.error('Lỗi AJAX khi xóa:', textStatus, errorThrown);
                                showToast('Lỗi kết nối server!', false);
                            });
                        } else {
                            $row.remove();
                            updateSTT();
                            showToast('Đã xóa thành viên khỏi danh sách!', true);
                        }
                    }
                }
            });
        });

        if ($.fn.validate) {
            $('#frmModalBiensonha').validate({
                ignore: ':hidden, [disabled]', // Bỏ qua các trường ẩn và disabled
                errorPlacement: function(error, element) {
                    error.addClass('error_modal');
                    error.appendTo(element.closest('.mb-3'));
                },
                rules: {
                    modal_nhankhau_search: {
                        required: function() {
                            return $('#modal_search_toggle').is(':checked');
                        }
                    },

                    modal_hoten: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        },
                        regex: /^[^~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]*$/
                    },
                    modal_cccd_so: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        }
                    },
                    modal_gioitinh_id: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        }
                    },
                    modal_diachi: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        }
                    },
                    modal_ngaysinh: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        }
                    },
                    modal_sonha: {
                        required: true
                    },
                    modal_tobando: {
                        required: true
                    },
                    modal_hinhthuccap: {
                        required: true
                    },
                    // modal_lydothaydoi: {
                    //     required: true
                    // }
                },
                messages: {
                    // modal_loaisohuu: 'Chọn loại sở hữu',
                    modal_nhankhau_search: 'Chọn thành viên',
                    modal_hoten: {
                        required: 'Nhập họ tên',
                        regex: 'Họ tên không được chứa ký tự đặc biệt'
                    },
                    modal_cccd_so: 'Nhập số CCCD',
                    modal_gioitinh_id: 'Chọn giới tính',
                    modal_diachi: 'Nhập địa chỉ',
                    modal_ngaysinh: 'Nhập ngày sinh',
                    modal_sonha: 'Nhập số nhà',
                    modal_tobando: 'Nhập Tờ bản đồ',
                    modal_hinhthuccap: 'Chọn hình thức cấp',
                    // modal_lydothaydoi: 'Nhập lý do',

                }
            });

            $.validator.addMethod('regex', function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, 'Họ tên không được chứa ký tự đặc biệt.');
        }
        if ($.fn.validate) {

            $('#frmGiaDinhVanHoa').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    error.addClass('error_modal');
                    error.appendTo(element.closest('.mb-3'));
                },
                success: function(label) {
                    label.remove(); // Xóa thông báo lỗi khi valid
                },
                rules: {
                    phuongxa_id: {
                        required: true
                    },
                    thonto_id: {
                        required: true
                    },
                    tuyenduong: {
                        required: true,

                    }
                },
                messages: {
                    phuongxa_id: 'Chọn Phường/Xã',
                    thonto_id: 'Chọn Thôn/Tổ',
                    tuyenduong: 'Vui lòng chọn tuyến đường',


                }

            });
        }
        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            language: 'vi',
            autoclose: true
        });

        $('#phuongxa_id').on('change', function() {
            var $phuongxa_id = $(this);
            var $thonto_id = $('#thonto_id');
            var phuongxa_val = $phuongxa_id.val();

            if ($thonto_id.data('select2')) {
                $thonto_id.select2('destroy');
            }
            $thonto_id.prop('disabled', true).html('<option value=""></option>');

            if (phuongxa_val === '') {
                initSelect2($thonto_id, {
                    width: '100%',
                    allowClear: true,
                    placeholder: $thonto_id.data('placeholder')
                });
                $thonto_id.prop('disabled', false);
            } else {
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: {
                        option: 'com_vptk',
                        controller: 'vptk',
                        task: 'getKhuvucByIdCha',
                        cha_id: phuongxa_val,
                        [Joomla.getOptions('csrf.token')]: 1
                    },
                    beforeSend: function() {
                        $thonto_id.siblings('.select2-container').append('<span class="select2-loading">Đang tải...</span>');
                    },
                    success: function(data) {
                        var options = '<option value=""></option>';
                        if (data && data.length > 0) {
                            $.each(data, function(i, v) {
                                options += '<option value="' + v.id + '"' + (v.id === "<?php echo $item['thonto_id']; ?>" ? ' selected' : '') + '>' + v.tenkhuvuc + '</option>';
                            });
                        }
                        $thonto_id.html(options).prop('disabled', false);
                        initSelect2($thonto_id, {
                            width: '100%',
                            allowClear: true,
                            placeholder: $thonto_id.data('placeholder')
                        });
                        $thonto_id.val("<?php echo $item[0]['thonto_id']; ?>").trigger('change');
                    },
                    error: function() {
                        showToast('Lỗi khi tải danh sách Thôn/Tổ', false);
                        initSelect2($thonto_id, {
                            width: '100%',
                            allowClear: true,
                            placeholder: $thonto_id.data('placeholder')
                        });
                        $thonto_id.prop('disabled', false);
                    },
                    complete: function() {
                        $thonto_id.siblings('.select2-container').find('.select2-loading').remove();
                    }
                });
            }
        });

        function resetModal() {
            $('#frmModalBiensonha').trigger('reset');
            // $('#frmModalBiensonha select').each(function() {
            //     if ($(this).data('select2')) {
            //         $(this).select2('destroy');
            //     }
            //     if ($(this).attr('id') !== 'modal_dat' && $(this).attr('id') !== 'modal_gioitinh_id') {
            //         $(this).val('').html('<option value=""></option>');
            //     }
            // });
            $('#modal_loaisohuu').val('1').trigger('change');
            if ($('#frmModalBiensonha').data('validator')) {
                $('#frmModalBiensonha').validate().resetForm();
            }

            $('#frmModalBiensonha .error_modal').remove();

            $('#modal_search_toggle').prop('checked', true);
            $('#search_fields').show();
            $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id, #modal_ngaysinh').prop('disabled', true);
            $('#modal_nhankhau_id').val('');
            // Đảm bảo modal_dat có các option
            if ($('#modal_dat option').length === 0) {
                $('#modal_dat').html(`
                <option value=""></option>
                <option value="1">Đạt</option>
                <option value="2">Không đạt</option>
            `);
            }

            initializeModalSelect2();

            initSelect2($('#modal_nhankhau_search'), {
                width: '100%',
                allowClear: true,
                placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                dropdownParent: $('#modalThongTinSoNha'),
                minimumInputLength: 2,
                ajax: {
                    url: 'index.php?option=com_dcxddt&controller=biensonha&task=getThanhVienGiaDinhVanHoa',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            thonto_id: $('#thonto_id').val(),
                            tuyenduong: $('#tuyenduong').val(),
                            [Joomla.getOptions('csrf.token')]: 1
                        };
                    },
                    processResults: function(data) {
                        const results = (data || []).map(v => {
                            return {
                                id: v.nhankhau_id,
                                text: `${v.hoten || ''} - CCCD: ${v.cccd_so || ''} - Ngày sinh: ${v.ngaysinh || ''} - Địa chỉ: ${v.diachi || ''}`,
                                data: {
                                    hoten: v.hoten,
                                    cccd_so: v.cccd_so,
                                    dienthoai: v.dienthoai,
                                    diachi: v.diachi,
                                    gioitinh_id: v.gioitinh_id || '',
                                    gioitinh_text: v.tengioitinh || '',
                                    nhankhau_id: v.nhankhau_id
                                }
                            };
                        });
                        return {
                            results
                        };
                    },
                    cache: true
                }
            });

            const selectedPhuongxaId = $('#phuongxa_id').val();
            const selectedThontoId = $('#thonto_id').val();
            $('#modal_phuongxa_id').html($('#phuongxa_id').html()).val(selectedPhuongxaId).prop('disabled', true);
            $('#modal_thonto_id').html($('#thonto_id').html()).val(selectedThontoId).prop('disabled', true);

            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            $('#modal_dat').val('2').trigger('change.select2');
        }

        $('.btn-secondary').on('click', function() {
            $('#frmModalBiensonha').trigger('reset');
            $('#frmModalBiensonha').validate().resetForm();
            $('#frmModalBiensonha .error_modal').remove();
            // Đảm bảo modal_dat có các option
            // if ($('#modal_dat option').length === 0) {
            //     $('#modal_dat').html(`
            //     <option value=""></option>
            //     <option value="1">Đạt</option>
            //     <option value="2">Không đạt</option>
            // `);
            // }
            // $('#modal_dat').val('2').trigger('change.select2');
        });

        $('#modalThongTinSoNha').on('hidden.bs.modal', function() {
            resetModal();
        });

        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/dcxddt/?view=biensonha&task=default';
        });

        $('#phuongxa_id').trigger('change');
    });
</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }

    #frmModalBiensonha {
        margin-bottom: 0.5px !important;
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

    #modalThongTinSoNha .mb-3 {
        margin-bottom: 0rem !important;
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

    /* CSS cụ thể cho #modalThongTinSoNha */
    #modalThongTinSoNha .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        word-break: break-word;
    }

    #modalThongTinSoNha .select2-container .select2-selection--single {
        height: 38px;
    }

    #modalThongTinSoNha .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    #modalThongTinSoNha .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    #modalThongTinSoNha {
        overflow-x: hidden;
    }



    #modalThongTinSoNha .form-control,
    #modalThongTinSoNha .custom-select,
    #modalThongTinSoNha .select2-container .select2-selection--single {
        height: 38px;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        box-sizing: border-box;
    }

    #modalThongTinSoNha .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
        /* Đồng bộ với chiều cao */
        padding-left: 0.75rem;
    }

    #modalThongTinSoNha .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        right: 0.75rem;
    }

    #frmModalBiensonha {
        margin-bottom: 0.5px !important;
    }

    #modalThongTinSoNha .modal-dialog {
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

    #modalThongTinSoNha.show .modal-dialog {
        transform: translateX(0);
    }

    #modalThongTinSoNha.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    #modalThongTinSoNha.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    #modalThongTinSoNha .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #modalThongTinSoNha .error_modal {
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
</style>