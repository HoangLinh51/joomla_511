<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;

$item = $this->item;
$nhankhau = $item['nhankhau'];
?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/select2/js/select2.min.js" type="text/javascript"></script> -->
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</meta>
<form id="frmNhanhokhau" name="frmNhanhokhau" method="post" action="index.php?option=com_vptk&controller=vptk&task=saveNhanhokhau">
    <div class="container-fluid px-3">
        <h2 class="mb-0 text-primary" style="line-height:2">
            <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin nhân, hộ khẩu
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>

            </span>
        </h2>
        <table class="table w-100" style="margin-bottom: 15px;" id="tblThongtin">
            <tbody>
                <tr>
                    <td colspan="6">
                        <h3 class="mb-0 fw-bold">Thông tin hộ khẩu</h3>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Số hộ khẩu</strong>
                            <input type="text" id="hokhau_so" name="hokhau_so" value="<?php echo htmlspecialchars($item['hokhau_so']); ?>" class="form-control" placeholder="Nhập số hộ khẩu">
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Ngày cấp</strong>
                            <div class="input-group">
                                <input type="text" id="hokhau_ngaycap" autocomplete="off" name="hokhau_ngaycap" class="form-control date-picker" value="<?php echo htmlspecialchars($item['hokhau_ngaycap']); ?>" placeholder="dd/mm/yyyy">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Cơ quan cấp</strong>
                            <input type="text" id="hokhau_coquancap" name="hokhau_coquancap" value="<?php echo htmlspecialchars($item['hokhau_coquancap']); ?>" class="form-control" placeholder="Nhập cơ quan cấp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Phường/Xã <span class="text-danger">*</span></strong>
                            <input type="hidden" id="tinhthanh_id" name="tinhthanh_id" value="<?php echo htmlspecialchars($item['tinhthanh_id']); ?>" />
                            <input type="hidden" id="quanhuyen_id" name="quanhuyen_id" value="<?php echo htmlspecialchars($item['quanhuyen_id']); ?>" />
                            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                <option value="" data-quanhuyen="" data-tinhthanh=""></option>
                                <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                                    <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected data-quanhuyen="<?php echo $this->phuongxa[0]['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $this->phuongxa[0]['tinhthanh_id']; ?>"><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
                                <?php } elseif (is_array($this->phuongxa)) { ?>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>" <?php echo ($item['phuongxa_id'] == $px['id']) ? 'selected' : ''; ?> data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="phuongxa_id"></label>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Thôn/Tổ <span class="text-danger">*</span></strong>
                            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                                <option value=""></option>
                                <?php if (is_array($this->thonto) && count($this->thonto) > 0) { ?>
                                    <?php foreach ($this->thonto as $tt) { ?>
                                        <option value="<?php echo $tt['id']; ?>" <?php echo ($item['thonto_id'] === $tt['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tt['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="thonto_id"></label>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Số nhà/Đường <span class="text-danger">*</span></strong>
                            <input type="text" id="diachi" name="diachi" value="<?php echo htmlspecialchars($item['diachi']); ?>" class="form-control" placeholder="Nhập số nhà, tên đường">
                            <label class="error_modal" for="diachi"></label>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <h3 style="padding-left:15px ;" class="mb-0 fw-bold">Thông tin nhân khẩu

            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themnhankhau" data-bs-toggle="modal" data-bs-target="#modalNhankhau"><i class="fas fa-plus"></i> Thêm nhân khẩu</button>
            </span>
        </h3>
        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center" rowspan="2" style="width: 80px;">STT</th>
                        <th class="align-middle text-center quanhe" rowspan="2">Quan hệ với<br>chủ hộ</th>
                        <th class="align-middle text-center hoten" rowspan="2">Thông tin cá nhân</th>
                        <th class="align-middle text-center cccd" rowspan="2">CMND/CCCD</th>
                        <th class="align-middle text-center thongtinkhac" rowspan="2">Thông tin khác</th>
                        <th class="align-middle text-center noihientai" rowspan="2">Thường trú/Tạm trú</th>
                        <th class="align-middle text-center noio_truoc" rowspan="2">Nơi ở trước khi chuyển đến</th>
                        <th class="align-middle text-center lydo" rowspan="2">Lý do xóa đăng ký thường trú</th>
                        <th class="align-middle text-center lydo" rowspan="2">Tình trạng</th>
                        <th class="align-middle text-center chucnang" rowspan="2" style="width: 150px;">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($nhankhau) && count($nhankhau) > 0) { ?>
                        <?php foreach ($nhankhau as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle quanhe"><?php echo htmlspecialchars($nk['quanhe'] ?? ''); ?></td>
                                <td class="align-middle hoten" style="cursor: pointer;">
                                    <a href="#" class="edit-nhankhau" data-index="<?php echo $index; ?>" style=" color: blue;">
                                        <strong>Họ tên:</strong> <?php echo htmlspecialchars($nk['hoten'] ?? ''); ?>
                                    </a><br>
                                    <strong>Ngày sinh:</strong> <?php echo htmlspecialchars($nk['ngaysinh'] ?? ''); ?><br>
                                    <strong>Điện thoại:</strong> <?php echo htmlspecialchars($nk['dienthoai'] ?? ''); ?><br>
                                    <strong>Giới tính:</strong> <?php echo htmlspecialchars($nk['gioitinh'] ?? ''); ?>
                                </td>
                                <td class="align-middle cccd">
                                    <strong>Số:</strong> <?php echo htmlspecialchars($nk['cccd_so'] ?? ''); ?><br>
                                    <strong>Ngày cấp:</strong> <?php echo htmlspecialchars($nk['cccd_ngaycap'] ?? ''); ?><br>
                                    <strong>Nơi cấp:</strong> <?php echo htmlspecialchars($nk['cccd_coquancap'] ?? ''); ?>
                                </td>
                                <td class="align-middle thongtinkhac">
                                    <strong>Dân tộc:</strong> <?php echo htmlspecialchars($nk['dantoc'] ?? ''); ?><br>
                                    <strong>Tôn giáo:</strong> <?php echo htmlspecialchars($nk['tentongiao'] ?? ''); ?><br>
                                    <strong>Trình độ:</strong> <?php echo htmlspecialchars($nk['tentrinhdohocvan'] ?? ''); ?><br>
                                    <strong>Nghề nghiệp:</strong> <?php echo htmlspecialchars($nk['tennghenghiep'] ?? ''); ?><br>
                                    <strong>Quốc tịch:</strong> <?php echo htmlspecialchars($nk['tenquoctich'] ?? 'Chưa xác định'); ?><br>
                                    <strong>Nhóm máu:</strong> <?php echo htmlspecialchars($nk['name'] ?? 'Chưa xác định'); ?><br>
                                    <strong>Quan hệ hôn nhân:</strong> <?php echo htmlspecialchars($nk['qhhonnhan'] ?? 'Chưa xác định'); ?>
                                </td>
                                <td class="align-middle noihientai">
                                    <?php echo htmlspecialchars($nk['is_tamtru'] == 0 ? 'Thường trú' : 'Tạm trú'); ?>
                                </td>
                                <td class="align-middle noio_truoc">
                                    <?php
                                    if ($nk['is_tamtru'] == 1) {
                                        $thuongtrucu = [
                                            htmlspecialchars($nk['thuongtrucu_diachi'] ?? ''),
                                            htmlspecialchars($nk['phuongxa'] ?? ''),
                                            htmlspecialchars($nk['tinhthanh'] ?? '')
                                        ];

                                        $diachi = implode(', ', array_filter($thuongtrucu));
                                        echo $diachi ? $diachi : 'Không có ';
                                    } else {
                                        echo 'Không có ';
                                    }
                                    ?>
                                </td>

                                <td class="align-middle lydo"><?php echo htmlspecialchars($nk['tenlydo'] ?? ''); ?></td>
                                <td class="align-middle noihientai <?php echo $nk['trangthaihoso'] == 0 ? 'status-unverified' : 'status-verified'; ?>">
                                    <?php echo htmlspecialchars($nk['trangthaihoso'] == 0 ? 'Chưa xác thực' : 'Đã xác thực'); ?>
                                </td>
                                <td class="align-middle text-center chucnang">
                                    <input type="hidden" name="nhankhau_id[]" value="<?php echo $nk['id'] ?? ''; ?>" />
                                    <input type="hidden" name="quanhenhanthan_id[]" value="<?php echo $nk['quanhenhanthan_id'] ?? ''; ?>" />
                                    <input type="hidden" name="hoten[]" value="<?php echo htmlspecialchars($nk['hoten'] ?? ''); ?>" />
                                    <input type="hidden" name="ngaysinh[]" value="<?php echo htmlspecialchars($nk['ngaysinh'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai[]" value="<?php echo htmlspecialchars($nk['dienthoai'] ?? ''); ?>" />
                                    <input type="hidden" name="gioitinh_id[]" value="<?php echo $nk['gioitinh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="cccd_so[]" value="<?php echo htmlspecialchars($nk['cccd_so'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_ngaycap[]" value="<?php echo htmlspecialchars($nk['cccd_ngaycap'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_coquancap[]" value="<?php echo htmlspecialchars($nk['cccd_coquancap'] ?? ''); ?>" />
                                    <input type="hidden" name="dantoc_id[]" value="<?php echo $nk['dantoc_id'] ?? ''; ?>" />
                                    <input type="hidden" name="tongiao_id[]" value="<?php echo $nk['tongiao_id'] ?? ''; ?>" />
                                    <input type="hidden" name="trinhdohocvan_id[]" value="<?php echo $nk['trinhdohocvan_id'] ?? ''; ?>" />
                                    <input type="hidden" name="nghenghiep_id[]" value="<?php echo $nk['nghenghiep_id'] ?? ''; ?>" />
                                    <input type="hidden" name="quoctich_id[]" value="<?php echo $nk['quoctich_id'] ?? ''; ?>" />
                                    <input type="hidden" name="nhommau_id[]" value="<?php echo $nk['nhommau_id'] ?? ''; ?>" />
                                    <input type="hidden" name="qhhonnhan_id[]" value="<?php echo $nk['tinhtranghonnhan_id'] ?? ''; ?>" />
                                    <input type="hidden" name="is_tamtru[]" id="modal_tamtru" value="<?php echo $nk['is_tamtru'] ?? '0'; ?>" />
                                    <input type="hidden" name="thuongtrucu_tinhthanh_id[]" value="<?php echo $nk['thuongtrucu_tinhthanh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_phuongxa_id[]" value="<?php echo $nk['thuongtrucu_phuongxa_id'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_diachi[]" value="<?php echo htmlspecialchars($nk['thuongtrucu_diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="lydoxoathuongtru_id[]" value="<?php echo $nk['lydoxoathuongtru_id'] ?? ''; ?>" />
                                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="<?php echo $nk['id'] ?? ''; ?>"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <table class="w-100">
            <tr>
                <td class="text-center">
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
    <?php echo JHTML::_('form.token'); ?>
</form>

<!-- Modal Nhân Khẩu -->

<!-- <div class="modal fade" id="modalThemNhanVien" tabindex="-1" aria-labelledby="modalThemNhanVienLabel" aria-hidden="true"> -->
<div class="modal fade" id="modalNhankhau" tabindex="-1" aria-labelledby="modalNhankhauLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNhankhauLabel">Thêm Nhân Khẩu</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalNhankhau">
                    <input type="hidden" id="modal_edit_index" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                <select id="modal_quanhenhanthan_id" name="modal_quanhenhanthan_id" class="custom-select" data-placeholder="Chọn quan hệ">
                                    <option value=""></option>
                                    <option value="-1" data-text="Chủ hộ">Chủ hộ</option>
                                    <?php if (is_array($this->quanhe) && count($this->quanhe) > 0) { ?>
                                        <?php foreach ($this->quanhe as $qh) { ?>
                                            <option value="<?php echo $qh['id']; ?>" data-text="<?php echo htmlspecialchars($qh['tenquanhenhanthan']); ?>">
                                                <?php echo htmlspecialchars($qh['tenquanhenhanthan']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu quan hệ</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" id="modal_hoten" name="modal_hoten" class="form-control" placeholder="Nhập họ tên">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="modal_ngaysinh" name="modal_ngaysinh" class="form-control date-picker" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                                <select id="modal_gioitinh_id" name="modal_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
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
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Số CMND/CCCD <span class="text-danger">*</span></label>
                                <input type="text" id="modal_cccd_so" name="modal_cccd_so" class="form-control" placeholder="Nhập CMND/CCCD">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Ngày cấp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="modal_cccd_ngaycap" name="modal_cccd_ngaycap" class="form-control date-picker" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nơi cấp <span class="text-danger">*</span></label>
                                <input type="text" id="modal_cccd_coquancap" name="modal_cccd_coquancap" class="form-control" placeholder="Nhập nơi cấp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Điện thoại</label>
                                <input type="text" id="modal_dienthoai" class="form-control" placeholder="Nhập điện thoại">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dân tộc <span class="text-danger">*</span></label>
                                <select id="modal_dantoc_id" name="modal_dantoc_id" class="custom-select" data-placeholder="Chọn dân tộc">
                                    <option value=""></option>
                                    <?php if (is_array($this->dantoc) && count($this->dantoc) > 0) { ?>
                                        <?php foreach ($this->dantoc as $dt) { ?>
                                            <option value="<?php echo $dt['id']; ?>" data-text="<?php echo htmlspecialchars($dt['tendantoc']); ?>">
                                                <?php echo htmlspecialchars($dt['tendantoc']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu dân tộc</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tôn giáo</label>
                                <select id="modal_tongiao_id" class="custom-select" data-placeholder="Chọn tôn giáo">
                                    <option value=""></option>
                                    <?php if (is_array($this->tongiao) && count($this->tongiao) > 0) { ?>
                                        <?php foreach ($this->tongiao as $tg) { ?>
                                            <option value="<?php echo $tg['id']; ?>" data-text="<?php echo htmlspecialchars($tg['tentongiao']); ?>">
                                                <?php echo htmlspecialchars($tg['tentongiao']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu tôn giáo</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Trình độ học vấn</label>
                                <select id="modal_trinhdohocvan_id" class="custom-select" data-placeholder="Chọn trình độ">
                                    <option value=""></option>
                                    <?php if (is_array($this->trinhdo) && count($this->trinhdo) > 0) { ?>
                                        <?php foreach ($this->trinhdo as $td) { ?>
                                            <option value="<?php echo $td['id']; ?>" data-text="<?php echo htmlspecialchars($td['tentrinhdohocvan']); ?>">
                                                <?php echo htmlspecialchars($td['tentrinhdohocvan']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu trình độ</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quốc tịch</label>
                                <select id="modal_quoctich_id" class="custom-select" data-placeholder="Chọn quốc tịch">
                                    <option value=""></option>
                                    <?php if (is_array($this->quoctich) && count($this->quoctich) > 0) { ?>
                                        <?php foreach ($this->quoctich as $qt) { ?>
                                            <option value="<?php echo $qt['id']; ?>" data-text="<?php echo htmlspecialchars($qt['tenquoctich']); ?>">
                                                <?php echo htmlspecialchars($qt['tenquoctich']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu quốc tịch</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nhóm máu</label>
                                <select id="modal_nhommau_id" class="custom-select" data-placeholder="Chọn nhóm máu">
                                    <option value=""></option>
                                    <?php if (is_array($this->nhommau) && count($this->nhommau) > 0) { ?>
                                        <?php foreach ($this->nhommau as $nm) { ?>
                                            <option value="<?php echo $nm['code']; ?>" data-text="<?php echo htmlspecialchars($nm['name']); ?>">
                                                <?php echo htmlspecialchars($nm['name']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu nhóm máu</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quan hệ hôn nhân</label>
                                <select id="modal_qhhonnhan_id" class="custom-select" data-placeholder="Chọn quan hệ hôn nhân">
                                    <option value=""></option>
                                    <?php if (is_array($this->qhhonnhan) && count($this->qhhonnhan) > 0) { ?>
                                        <?php foreach ($this->qhhonnhan as $qh) { ?>
                                            <option value="<?php echo $qh['code']; ?>" data-text="<?php echo htmlspecialchars($qh['name']); ?>">
                                                <?php echo htmlspecialchars($qh['name']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu quan hệ hôn nhân</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nghề nghiệp</label>
                                <select id="modal_nghenghiep_id" class="custom-select" data-placeholder="Chọn nghề nghiệp">
                                    <option value=""></option>
                                    <?php if (is_array($this->nghenghiep) && count($this->nghenghiep) > 0) { ?>
                                        <?php foreach ($this->nghenghiep as $nn) { ?>
                                            <option value="<?php echo $nn['id']; ?>" data-text="<?php echo htmlspecialchars($nn['tennghenghiep']); ?>">
                                                <?php echo htmlspecialchars($nn['tennghenghiep']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu nghề nghiệp</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Thường trú/Tạm trú <span class="text-danger">*</span></label>
                                <select id="modal_is_tamtru" name="modal_is_tamtru" class="custom-select">
                                    <option value="0" data-text="Thường trú" selected>Thường trú</option>
                                    <option value="1" data-text="Tạm trú">Tạm trú</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 div_is_tamtru" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label">Nơi thường trú trước khi chuyển đến <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="modal_thuongtrucu_tinhthanh_id" class="custom-select" data-placeholder="Chọn tỉnh/thành">
                                            <option value=""></option>
                                            <?php if (is_array($this->tinhthanh) && count($this->tinhthanh) > 0) { ?>
                                                <?php foreach ($this->tinhthanh as $tt) { ?>
                                                    <option value="<?php echo $tt['id']; ?>" data-text="<?php echo htmlspecialchars($tt['tentinhthanh']); ?>">
                                                        <?php echo htmlspecialchars($tt['tentinhthanh']); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">Không có dữ liệu tỉnh/thành</option>
                                            <?php } ?>
                                            <option value="-1" data-text="Khác">Khác</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <select id="modal_thuongtrucu_phuongxa_id" name="modal_thuongtrucu_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                            <option value=""></option>
                                            <?php if (is_array($this->phuongxa2) && count($this->phuongxa2) > 0) { ?>
                                                <?php foreach ($this->phuongxa2 as $tt) { ?>
                                                    <option value="<?php echo $tt['id']; ?>" data-text="<?php echo htmlspecialchars($tt['tenphuongxa']); ?>">
                                                        <?php echo htmlspecialchars($tt['tenphuongxa']); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">Không có dữ liệu tỉnh/thành</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <input type="text" id="modal_thuongtrucu_diachi" name="modal_thuongtrucu_diachi" class="form-control" placeholder="Nhập số nhà, tên đường, thôn/tổ dân phố">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lý do xóa đăng ký thường trú</label>
                                <select id="modal_lydoxoathuongtru_id" class="custom-select" data-placeholder="Chọn lý do">
                                    <option value=""></option>
                                    <?php if (is_array($this->lydo) && count($this->lydo) > 0) { ?>
                                        <?php foreach ($this->lydo as $ld) { ?>
                                            <option value="<?php echo $ld['id']; ?>" data-text="<?php echo htmlspecialchars($ld['tenlydo']); ?>">
                                                <?php echo htmlspecialchars($ld['tenlydo']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="">Không có dữ liệu lý do</option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="modal_tinhtang" value="Chưa xác thực">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn_luu_nhankhau"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Trong file CSS hoặc <style> */
    .table#tblThongtin td.align-middle {
        width: 33.33%;
        /* Chia đều 3 cột */
        padding: .75rem 0rem .75rem .75rem;
    }

    /* .table#tblThongtin .mb-3 {
    width: 100%; /* Container lấp đầy <td> */
    }

    */ .table#tblThongtin .form-control,
    .table#tblThongtin .custom-select,
    .table#tblThongtin .input-group {
        width: 100% !important;
        /* Đảm bảo tất cả trường nhập liệu có chiều rộng bằng nhau */
        box-sizing: border-box;
        /* Bao gồm padding và border trong chiều rộng */
    }

    .table#tblThongtin .input-group .form-control {
        flex: 1;
        /* Đảm bảo input trong input-group lấp đầy không gian */
    }

    .status-verified {
        color: green;
        /* Màu xanh cho "Đã xác thực" */
    }

    .status-unverified {
        color: red;
        /* Màu đỏ cho "Chưa xác thực" */
    }

    .hideOpt {
        display: none !important;
    }

    .modal-body {
        max-height: 70vh;
        /* Giới hạn chiều cao tối đa */
        overflow-y: auto;
        /* Thêm thanh cuộn dọc */
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
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 80px;
    }

    td.quanhe,
    th.quanhe {
        min-width: 100px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.hoten,
    th.hoten {
        min-width: 250px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }

    td.cccd,
    th.cccd {
        min-width: 250px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 500px;
    }

    td.thongtinkhac,
    th.thongtinkhac {
        min-width: 400px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 400px;
    }

    td.noihientai,
    th.noihientai {
        min-width: 120px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.noio_truoc,
    th.noio_truoc {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.noio_truoc,
    th.noio_truoc {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.lydo,
    th.lydo {
        min-width: 100px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    td.chucnang,
    th.chucnang {
        min-width: 100px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    .modal {
        overflow-x: hidden;
    }

    .modal-body {
        overflow-x: hidden;
        overflow-y: auto;
    }

    .modal-dialog {
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

    .modal.show .modal-dialog {
        transform: translateX(0);
    }

    .modal.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    .modal.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    .modal-body {
        padding: 20px;
        word-break: break-word;
    }

    .modal-body p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .error_modal {
        margin-bottom: 0px;
        margin-top: 0;
        font-size: 12px;
        color: red;
    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.date-picker').datepicker({
            autoclose: true,
            language: 'vi'
        });

        var hasChuHo = false; // Biến để theo dõi trạng thái có Chủ hộ hay không
        // Hàm để cập nhật dropdown quan hệ
        function updateQuanHeDropdown(isEditing = false, selectedQuanHeId = '') {
            const $quanheSelect = $('#modal_quanhenhanthan_id');
            // Đếm số nhân khẩu (loại bỏ hàng "Không có dữ liệu")
            const nhanKhauCount = $('#tblDanhsach tbody tr').filter(function() {
                return $(this).find('td').length > 1 || $(this).find('td').text().trim() !== 'Không có dữ liệu';
            }).length;

            if (!hasChuHo && !isEditing && nhanKhauCount === 0) {
                // Chưa có nhân khẩu và chưa có Chủ hộ, chỉ cho phép chọn Chủ hộ
                $quanheSelect.find('option').prop('disabled', true);
                $quanheSelect.find('option[value="-1"]').prop('disabled', false);
                $quanheSelect.val('-1'); // Đặt mặc định là Chủ hộ
            } else {
                // Đã có nhân khẩu, đã có Chủ hộ, hoặc đang chỉnh sửa, kích hoạt tất cả tùy chọn
                $quanheSelect.find('option').prop('disabled', false);
                // Vô hiệu hóa Chủ hộ nếu đã có Chủ hộ và không chỉnh sửa Chủ hộ
                $quanheSelect.find('option[value="-1"]').prop('disabled', hasChuHo && selectedQuanHeId !== '-1');
                if (isEditing && selectedQuanHeId) {
                    $quanheSelect.val(selectedQuanHeId);
                } else {
                    $quanheSelect.val('');
                }
            }
            $quanheSelect.trigger('change.select2');
        }

        function initSelect2($element, options) {
            if ($element.length && $.fn.select2) {
                // Hủy Select2 nếu đã khởi tạo
                if ($element.data('select2')) {
                    $element.select2('destroy');
                }
                $element.select2($.extend({
                    width: '100%',
                    allowClear: true,
                    placeholder: function() {
                        return $(this).data('placeholder') || 'Chọn một tùy chọn';
                    }
                }, options));
            }
        }

        console.log($('#modal_tamtru').val()); // Kiểm tra giá trị hiện tại

        if ($.fn.select2) {
            // Khởi tạo Select2 cho các select ngoài modal
            initSelect2($('#phuongxa_id, #thonto_id'), {
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                minimumResultsForSearch: 0 // Thêm để thống nhất
            });

            // Khởi tạo Select2 ban đầu cho các select trong modal
            initSelect2($('#modal_quanhenhanthan_id, #modal_gioitinh_id, #modal_dantoc_id, #modal_tongiao_id, #modal_trinhdohocvan_id, #modal_nghenghiep_id, #modal_quoctich_id, #modal_nhommau_id, #modal_qhhonnhan_id, #modal_lydoxoathuongtru_id'), {
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                minimumResultsForSearch: 0,
                dropdownParent: $('#modalNhankhau') // Gắn dropdown vào modal
            });

            // $('#modalNhankhau').on('show.bs.modal', function() {
            //     $('#modal_is_tamtru').val('0').trigger('change'); // Đặt lại giá trị mặc định
            // });

            initSelect2($('#modal_thuongtrucu_tinhthanh_id, #modal_thuongtrucu_phuongxa_id'), {
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                minimumResultsForSearch: 0, // Thêm để thống nhất
                dropdownParent: $('#modalNhankhau') // Gắn dropdown vào modal
            });

            // Khởi tạo lại Select2 khi modal hiển thị
            $('#modalNhankhau').on('shown.bs.modal', function() {
                $('#modalNhankhau select.custom-select').each(function() {
                    initSelect2($(this), {
                        width: '100%',
                        allowClear: true,
                        placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#modalNhankhau'),
                        searchInputPlaceholder: 'Gõ để tìm kiếm...'
                    });
                });
            });

            // Reset modal khi đóng
            $('#modalNhankhau').on('hidden.bs.modal', function() {
                $('#frmModalNhankhau')[0].reset();
                $('#frmModalNhankhau select.custom-select').each(function() {
                    $(this).val('').trigger('change.select2');
                });
                $('.div_is_tamtru').hide();
                $('#modal_edit_index').val('');
            });
        } else {
            console.error('Select2 not loaded.');
        }



        // Handle modal show for adding new nhân khẩu
        $('#btn_themnhankhau').on('click', function() {
            $('#modalNhankhauLabel').text('Thêm Nhân Khẩu');
            $('#modal_edit_index').val('');
            $('#frmModalNhankhau')[0].reset();
            $('.div_is_tamtru').hide();
            $('#frmModalNhankhau select').each(function() {
                $(this).val('').trigger('change.select2');
            });
            updateQuanHeDropdown();
            $('#modalNhankhau').modal('show');
        });

        // Handle click on name for editing
        $('body').on('click', '.edit-nhankhau', function(e) {
            e.preventDefault();
            const index = $(this).data('index');
            const $row = $(this).closest('tr');
            $('#modalNhankhauLabel').text('Chỉnh sửa Nhân Khẩu');
            $('#modal_edit_index').val(index);
            $('#frmModalNhankhau')[0].reset();

            // Populate form fields
            const quanHeId = $row.find('input[name="quanhenhanthan_id[]"]').val();
            $('#modal_quanhenhanthan_id').val(quanHeId).trigger('change.select2');
            $('#modal_hoten').val($row.find('input[name="hoten[]"]').val());
            $('#modal_ngaysinh').val($row.find('input[name="ngaysinh[]"]').val());
            $('#modal_dienthoai').val($row.find('input[name="dienthoai[]"]').val());
            $('#modal_gioitinh_id').val($row.find('input[name="gioitinh_id[]"]').val()).trigger('change.select2');
            $('#modal_cccd_so').val($row.find('input[name="cccd_so[]"]').val());
            $('#modal_cccd_ngaycap').val($row.find('input[name="cccd_ngaycap[]"]').val());
            $('#modal_cccd_coquancap').val($row.find('input[name="cccd_coquancap[]"]').val());
            $('#modal_dantoc_id').val($row.find('input[name="dantoc_id[]"]').val()).trigger('change.select2');
            $('#modal_tongiao_id').val($row.find('input[name="tongiao_id[]"]').val()).trigger('change.select2');
            $('#modal_trinhdohocvan_id').val($row.find('input[name="trinhdohocvan_id[]"]').val()).trigger('change.select2');
            $('#modal_nghenghiep_id').val($row.find('input[name="nghenghiep_id[]"]').val()).trigger('change.select2');
            $('#modal_quoctich_id').val($row.find('input[name="quoctich_id[]"]').val()).trigger('change.select2');
            $('#modal_nhommau_id').val($row.find('input[name="nhommau_id[]"]').val()).trigger('change.select2');
            $('#modal_qhhonnhan_id').val($row.find('input[name="qhhonnhan_id[]"]').val()).trigger('change.select2');
            $('#modal_is_tamtru').val($row.find('input[name="is_tamtru[]"]').val()).trigger('change.select2');
            $('#modal_thuongtrucu_tinhthanh_id').val($row.find('input[name="thuongtrucu_tinhthanh_id[]"]').val()).trigger('change.select2');
            $('#modal_thuongtrucu_phuongxa_id').val($row.find('input[name="thuongtrucu_phuongxa_id[]"]').val()).trigger('change.select2');
            $('#modal_thuongtrucu_diachi').val($row.find('input[name="thuongtrucu_diachi[]"]').val());
            $('#modal_lydoxoathuongtru_id').val($row.find('input[name="lydoxoathuongtru_id[]"]').val()).trigger('change.select2');
            $('.div_is_tamtru').toggle($('#modal_is_tamtru').val() === '1');
            updateQuanHeDropdown(true, quanHeId);
            $('#modalNhankhau').modal('show');
        });

        // Validation for modal form
        if ($.fn.validate) {
            $('#frmModalNhankhau').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    error.addClass('error_modal'); // Thêm class error vào thông báo
                    error.appendTo(element.closest('.mb-3'));
                },
                rules: {
                    modal_quanhenhanthan_id: {
                        required: true
                    },
                    modal_hoten: {
                        required: true,
                        regex: /^[^~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]*$/
                    },
                    modal_ngaysinh: {
                        required: true
                    },
                    modal_gioitinh_id: {
                        required: true
                    },
                    modal_cccd_so: {
                        required: true
                    },
                    modal_cccd_ngaycap: {
                        required: true
                    },
                    modal_cccd_coquancap: {
                        required: true
                    },
                    modal_dantoc_id: {
                        required: true
                    },
                    modal_is_tamtru: {
                        required: true
                    },
                    modal_thuongtrucu_tinhthanh_id: {
                        required: function() {
                            return $('#modal_is_tamtru').val() === '1';
                        }
                    },
                    modal_thuongtrucu_diachi: {
                        required: function() {
                            return $('#modal_is_tamtru').val() === '1' && (
                                $('#modal_thuongtrucu_tinhthanh_id').val() === '-1' ||
                                $('#modal_thuongtrucu_phuongxa_id').val() === '-1'
                            );
                        }
                    }
                },
                messages: {
                    modal_quanhenhanthan_id: 'Chọn quan hệ với chủ hộ',
                    modal_hoten: {
                        required: 'Nhập họ tên',
                        regex: 'Họ tên không được chứa ký tự đặc biệt'
                    },
                    modal_ngaysinh: 'Nhập ngày sinh',
                    modal_gioitinh_id: 'Chọn giới tính',
                    modal_cccd_so: 'Nhập số CMND/CCCD',
                    modal_cccd_ngaycap: 'Nhập ngày cấp CMND/CCCD',
                    modal_cccd_coquancap: 'Nhập nơi cấp CMND/CCCD',
                    modal_dantoc_id: 'Chọn dân tộc',
                    modal_is_tamtru: 'Chọn thường trú/ tạm trú',
                    modal_thuongtrucu_tinhthanh_id: 'Chọn Tỉnh/Thành nơi thường trú trước khi chuyển đến',
                    modal_thuongtrucu_diachi: 'Nhập số nhà, tên đường, thôn/tổ dân phố nơi thường trú trước khi chuyển đến'
                }
            });

            $.validator.addMethod('regex', function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, 'Họ tên không được chứa ký tự đặc biệt.');
        }

        $('#btn_luu_nhankhau').on('click', function() {
            if ($('#frmModalNhankhau').valid()) {
                const editIndex = $('#modal_edit_index').val();
                const isEditing = editIndex !== '';
                const wasChuHo = isEditing && $($('#tblDanhsach tbody tr')[editIndex]).find('input[name="quanhenhanthan_id[]"]').val() === '-1';
                const newQuanHeId = $('#modal_quanhenhanthan_id').val();
                const tinhtrang_text = $('#modal_tinhtang').val() || 'Chưa xác thực';
                const nhanKhauCount = $('#tblDanhsach tbody tr').filter(function() {
                    return $(this).find('td').length > 1 || $(this).find('td').text().trim() !== 'Không có dữ liệu';
                }).length;
                $('#tblDanhsach tbody tr').each(function() {
                    if ($(this).find('td').length === 1 && $(this).find('td').text().trim() === 'Không có dữ liệu') {
                        $(this).remove();
                    }
                });
                // Kiểm tra nếu chưa có Chủ hộ và không phải đang chỉnh sửa
                if (!hasChuHo && !isEditing && nhanKhauCount === 0 && newQuanHeId !== '-1') {
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Vui lòng chọn chủ hộ</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                    return; // Ngăn không cho lưu
                }
                let stt = isEditing ? parseInt($($('#tblDanhsach tbody tr')[editIndex]).find('.stt').text()) : $('#tblDanhsach tbody tr:not(.no-data)').length + 1;
                // Cập nhật hasChuHo
                if (newQuanHeId === '-1') {
                    hasChuHo = true;
                } else if (wasChuHo && newQuanHeId !== '-1') {
                    hasChuHo = false;
                }
                const nhankhauId = isEditing ? $($('#tblDanhsach tbody tr')[editIndex]).find('input[name="nhankhau_id[]"]').val() : '';

                // Collect form data
                const quanhe_text = $('#modal_quanhenhanthan_id option:selected').data('text') || '';
                const hoten = $('#modal_hoten').val();
                const ngaysinh = $('#modal_ngaysinh').val();
                const dienthoai = $('#modal_dienthoai').val();
                const gioitinh_text = $('#modal_gioitinh_id option:selected').data('text') || '';
                const cccd_so = $('#modal_cccd_so').val();
                const cccd_ngaycap = $('#modal_cccd_ngaycap').val();
                const cccd_coquancap = $('#modal_cccd_coquancap').val();
                const dantoc_text = $('#modal_dantoc_id option:selected').data('text') || '';
                const tongiao_text = $('#modal_tongiao_id option:selected').data('text') || '';
                const trinhdo_text = $('#modal_trinhdohocvan_id option:selected').data('text') || '';
                const nghenghiep_text = $('#modal_nghenghiep_id option:selected').data('text') || '';
                const quoctich_text = $('#modal_quoctich_id option:selected').data('text') || 'Việt Nam';
                const nhommau_text = $('#modal_nhommau_id option:selected').data('text') || 'Chưa xác định';
                const qhhonnhan_text = $('#modal_qhhonnhan_id option:selected').data('text') || 'Chưa xác định';

                const is_tamtru_text = $('#modal_is_tamtru option:selected').data('text') || 'Thường trú';
                let thuongtrucu = '';
                if ($('#modal_is_tamtru').val() === '1') {
                    const tinhthanh = $('#modal_thuongtrucu_tinhthanh_id option:selected').data('text') || '';
                    const phuongxa = $('#modal_thuongtrucu_phuongxa_id option:selected').data('text') || '';
                    const diachi = $('#modal_thuongtrucu_diachi').val();
                    thuongtrucu = [diachi, phuongxa, tinhthanh].filter(Boolean).join(', ');
                }
                const lydo_text = $('#modal_lydoxoathuongtru_id option:selected').data('text') || '';

                // Gộp dữ liệu cho các cột
                const thongtin_canhan = [
                    `Họ tên: ${hoten}`,
                    `Ngày sinh: ${ngaysinh}`,
                    dienthoai ? `Điện thoại: ${dienthoai}` : '',
                    `Giới tính: ${gioitinh_text}`
                ].filter(Boolean).join('<br>');

                const cccd_info = [
                    `<strong> Số:</strong> ${cccd_so}`,
                    `<strong> Ngày cấp:</strong> ${cccd_ngaycap}`,
                    `<strong> Nơi cấp: </strong> ${cccd_coquancap}`
                ].join('<br>');

                const thongtin_khac = [
                    `<strong> Dân tộc:</strong> ${dantoc_text}`,
                    `<strong> Tôn giáo:</strong> ${tongiao_text}`,
                    `<strong> Trình độ: </strong> ${trinhdo_text}`,
                    `<strong> Nghề nghiệp: </strong> ${nghenghiep_text}`,
                    `<strong> Quốc tịch: </strong> ${quoctich_text}`,
                    `<strong> Nhóm máu: </strong> ${nhommau_text}`,
                    `<strong> Quan hệ hôn nhân:</strong> ${qhhonnhan_text}`
                ].filter(Boolean).join('<br>');

                // Generate table row
                const str = `
            <tr>
                <td class="align-middle text-center stt">${stt}</td>
                <td class="align-middle quanhe">${quanhe_text}</td>
                <td class="align-middle hoten">
                    <a href="#" class="edit-nhankhau" data-index="${isEditing ? editIndex : stt - 1}" style="color: blue;">
                       <strong> Họ tên </strong>: ${hoten}
                    </a><br>
                    <strong> Ngày sinh: </strong> ${ngaysinh}<br>
                    <strong> Điện thoại: </strong> ${dienthoai}<br>
                    <strong> Giới tính: </strong> ${gioitinh_text}
                </td>
                <td class="align-middle cccd">${cccd_info}</td>
                <td class="align-middle thongtinkhac">${thongtin_khac}</td>
                <td class="align-middle noihientai">${is_tamtru_text}</td>
                <td class="align-middle noio_truoc">${$('#modal_is_tamtru').val() === '1' ? thuongtrucu : ''}</td>
                <td class="align-middle lydo">${lydo_text}</td>
                <td class="align-middle tinhtang" style="color: red">${tinhtrang_text}</td>
                <td class="align-middle text-center chucnang">
                    <input type="hidden" name="nhankhau_id[]" value="${nhankhauId}" />
                    <input type="hidden" name="quanhenhanthan_id[]" value="${$('#modal_quanhenhanthan_id').val()}" />
                    <input type="hidden" name="hoten[]" value="${hoten}" />
                    <input type="hidden" name="ngaysinh[]" value="${ngaysinh}" />
                    <input type="hidden" name="dienthoai[]" value="${dienthoai}" />
                    <input type="hidden" name="gioitinh_id[]" value="${$('#modal_gioitinh_id').val()}" />
                    <input type="hidden" name="cccd_so[]" value="${cccd_so}" />
                    <input type="hidden" name="cccd_ngaycap[]" value="${cccd_ngaycap}" />
                    <input type="hidden" name="cccd_coquancap[]" value="${cccd_coquancap}" />
                    <input type="hidden" name="dantoc_id[]" value="${$('#modal_dantoc_id').val()}" />
                    <input type="hidden" name="tongiao_id[]" value="${$('#modal_tongiao_id').val()}" />
                    <input type="hidden" name="trinhdohocvan_id[]" value="${$('#modal_trinhdohocvan_id').val()}" />
                    <input type="hidden" name="nghenghiep_id[]" value="${$('#modal_nghenghiep_id').val()}" />
                    <input type="hidden" name="quoctich_id[]" value="${$('#modal_quoctich_id').val()}" />
                    <input type="hidden" name="nhommau_id[]" value="${$('#modal_nhommau_id').val()}" />
                    <input type="hidden" name="qhhonnhan_id[]" value="${$('#modal_qhhonnhan_id').val()}" />
                    <input type="hidden" name="is_tamtru[]" value="${$('#modal_is_tamtru').val()}" />
                    <input type="hidden" name="thuongtrucu_tinhthanh_id[]" value="${$('#modal_thuongtrucu_tinhthanh_id').val()}" />
                    <input type="hidden" name="thuongtrucu_phuongxa_id[]" value="${$('#modal_thuongtrucu_phuongxa_id').val()}" />
                    <input type="hidden" name="thuongtrucu_diachi[]" value="${$('#modal_thuongtrucu_diachi').val()}" />
                    <input type="hidden" name="lydoxoathuongtru_id[]" value="${$('#modal_lydoxoathuongtru_id').val()}" />
                    <span class="btn btn-small btn-danger btn_xoa" data-xuly=""><i class="fas fa-trash-alt"></i></span>
                </td>
            </tr>`;

                try {
                    if (isEditing) {
                        $($('#tblDanhsach tbody tr')[editIndex]).replaceWith(str);
                    } else {
                        $('#tblDanhsach tbody').append(str);
                    }
                    $('#modalNhankhau').modal('hide');
                    $('#frmModalNhankhau')[0].reset();
                    $('.div_is_tamtru').hide();
                    $('#frmModalNhankhau select').each(function() {
                        $(this).val('').trigger('change.select2');
                    });
                } catch (e) {
                    console.error('Error processing row:', e);
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Lỗi khi ' + (isEditing ? 'cập nhật' : 'thêm') + ' nhân khẩu!</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                }
            }
        });

        // Handle Phường/Xã change
        $('#phuongxa_id').on('change', function() {
            var $phuongxa_id = $(this);
            var $thonto_id = $('#thonto_id');
            var phuongxa_val = $phuongxa_id.val();

            $('#tinhthanh_id').val($phuongxa_id.find('option:selected').data('tinhthanh'));
            $('#quanhuyen_id').val($phuongxa_id.find('option:selected').data('quanhuyen'));

            // Hủy Select2 nếu đã khởi tạo
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
                        $thonto_id.val("<?php echo $item['thonto_id']; ?>").trigger('change');
                    },
                    error: function() {
                        $.gritter.add({
                            title: '<h3>Thông báo</h3>',
                            text: '<span style="font-size:24px;">Lỗi khi tải danh sách Thôn/Tổ</span>',
                            time: 2000,
                            class_name: 'gritter-error gritter-center gritter-light'
                        });
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

        // Handle delete nhân khẩu
        $(document).ready(function() {
            $('body').on('click', '.btn_xoa', function() {
                var $row = $(this).closest('tr');
                var nhankhau_id = $(this).data('xuly');
                const isChuHo = $row.find('input[name="quanhenhanthan_id[]"]').val() === '-1';

                bootbox.confirm({
                    title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: '<span class="text-danger" style="font-size:24px;">Bạn có chắc chắn muốn xóa nhân khẩu này?</span>',
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
                            if (nhankhau_id) {
                                $.post('index.php', {
                                    option: 'com_vptk',
                                    controller: 'vptk',
                                    task: 'delNhankhau',
                                    nhankhau_id: nhankhau_id,
                                    [Joomla.getOptions('csrf.token')]: 1
                                }, function(data) {
                                    // Phân tích cú pháp JSON
                                    var response = typeof data === 'string' ? JSON.parse(data) : data;
                                    console.log('Response:', response); // Debug phản hồi

                                    if (response.success) {
                                        $row.remove();
                                        if (isChuHo) hasChuHo = false;
                                        $('.stt').each(function(i) {
                                            $(this).html(i + 1);
                                            $(this).closest('tr').find('.edit-nhankhau').data('index', i);
                                        });
                                        alert(response.message || 'Đã xử lý xóa dữ liệu thành công!');
                                    } else {
                                        alert(response.message || 'Có lỗi xảy ra khi xóa dữ liệu!');
                                    }
                                }).fail(function(xhr, status, error) {
                                    console.error('AJAX error:', status, error); // Debug lỗi
                                    alert('Lỗi kết nối server!');
                                });
                            } else {
                                $row.remove();
                                if (isChuHo) hasChuHo = false;
                                $('.stt').each(function(i) {
                                    $(this).html(i + 1);
                                    $(this).closest('tr').find('.edit-nhankhau').data('index', i);
                                });
                            }
                        }
                    }
                });
            });
        });

        // Handle is_tamtru change
        $('#modal_is_tamtru').on('change', function() {
            $('.div_is_tamtru').toggle($(this).val() === '1');
            if ($(this).val() === '1') {
                initSelect2($('#modal_thuongtrucu_tinhthanh_id, #modal_thuongtrucu_phuongxa_id'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: function() {
                        return $(this).data('placeholder');
                    }
                });
            }
        });

        // Handle thuongtrucu_tinhthanh_id change
        $('#modal_thuongtrucu_tinhthanh_id').on('change', function() {
            var $phuongxa = $('#modal_thuongtrucu_phuongxa_id');
            var $diachi = $('#modal_thuongtrucu_diachi');
            var tinhthanhVal = $(this).val();

            // Hủy Select2 nếu đã khởi tạo

            if ($phuongxa.data('select2')) {
                $phuongxa.select2('destroy');
            }

            if (tinhthanhVal === '') {
                $phuongxa.html('<option value=""></option>');
                initSelect2($phuongxa, {
                    width: '100%',
                    allowClear: true,
                    placeholder: $phuongxa.data('placeholder')
                });
                hi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
            } else if (tinhthanhVal === '-1') {
                $phuongxa.html('<option value=""></option>').hide();
                initSelect2($phuongxa, {
                    width: '100%',
                    allowClear: true,
                    placeholder: $phuongxa.data('placeholder')
                });

                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã, quận/huyện, tỉnh/thành');
            } else {
                $phuongxa.show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'vptk',
                    task: 'getQuanHuyenByTinhThanh',
                    tinhthanh_id: tinhthanhVal,
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option><option value="-1" data-text="Khác">Khác</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '" data-text="' + v.tenphuongxa + '">' + v.tenphuongxa + '</option>';
                        });
                    }
                    $phuongxa.html(str);
                    initSelect2($phuongxa, {
                        width: '100%',
                        allowClear: true,
                        placeholder: $phuongxa.data('placeholder')
                    });

                }).fail(function() {
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Lỗi khi tải danh sách Quận/Huyện</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                    $phuongxa.html('<option value=""></option>');

                    initSelect2($phuongxa, {
                        width: '100%',
                        allowClear: true,
                        placeholder: $phuongxa.data('placeholder')
                    });
                });
            }
        });


        // Handle thuongtrucu_phuongxa_id change
        $('#modal_thuongtrucu_phuongxa_id').on('change', function() {
            var $diachi = $('#modal_thuongtrucu_diachi');
            $diachi.attr('placeholder', $(this).val() === '-1' ?
                'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã' :
                'Nhập số nhà, tên đường, thôn/tổ dân phố');
        });

        // Handle Quay lại button
        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vptk/?view=nhk&task=default';
        });

        // Validation for main form
        if ($.fn.validate) {
            $('#frmNhanhokhau').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    error.addClass('error_modal');
                    error.appendTo(element.closest('.mb-3').find('label.error_modal'));
                },
                rules: {
                    phuongxa_id: {
                        required: true
                    },
                    thonto_id: {
                        required: true
                    },
                    diachi: {
                        required: true
                    }
                },
                messages: {
                    phuongxa_id: 'Chọn Phường/Xã',
                    thonto_id: 'Chọn Thôn/Tổ',
                    diachi: 'Nhập địa chỉ'
                }
            });
        }


        // Trigger initial phuongxa_id change
        $('#phuongxa_id').trigger('change');
        $('.btn-secondary').on('click', function() {
            // Đóng modal
            $('#frmModalNhankhau').trigger('reset'); // Reset dữ liệu trong form
            $('#frmModalNhankhau').validate().resetForm(); // Reset các quy tắc xác thực
            $('#frmModalNhankhau .error_modal').remove(); // Xóa tất cả các thông báo lỗi
        });

    });
</script>