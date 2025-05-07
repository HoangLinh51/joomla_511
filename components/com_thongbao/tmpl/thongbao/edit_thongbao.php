<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;

$item = $this->item;
$nhankhau = $item['nhankhau'];

// Tải CSS
HTMLHelper::_('stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', ['version' => 'auto']);
HTMLHelper::_('stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css', ['version' => 'auto']);
HTMLHelper::_('stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', ['version' => 'auto']);

// Tải JS
HTMLHelper::_('script', 'media/legacy/js/jquery-noconflict.js', ['version' => 'auto']);
HTMLHelper::_('script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/cbcc/js/jquery/jquery-validation/additional-methods.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/cbcc/js/jquery/jquery.toast.js', ['version' => 'auto']);
HTMLHelper::_('script', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js', ['version' => 'auto']);
?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/select2/js/select2.min.js" type="text/javascript"></script> -->
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form id="frmNhanhokhau" name="frmNhanhokhau" method="post" action="index.php?option=com_vptk&controller=nhk&task=saveNhanhokhau">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <h2 class="mb-3 text-primary">
            <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin nhân, hộ khẩu
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
            </span>
        </h2>
        <table class="table w-100" id="tblThongtin">
            <tbody>
                <tr>
                    <td colspan="6">
                        <h3 class="mb-0 fw-bold">Thông tin hộ khẩu</h3>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>Số hộ khẩu:</strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="hokhau_so" name="hokhau_so" value="<?php echo htmlspecialchars($item['hokhau_so']); ?>" class="form-control" placeholder="Nhập số hộ khẩu">
                        </div>
                    </td>
                    <td class="align-middle"><strong>Ngày cấp:</strong></td>
                    <td class="align-middle">
                        <div class="input-group mb-3">
                            <input type="text" id="hokhau_ngaycap" autocomplete="off" name="hokhau_ngaycap" class="form-control rounded-0" data-date-format="dd/mm/yyyy" value="<?php echo htmlspecialchars($item['hokhau_ngaycap']); ?>" placeholder="dd/mm/yyyy"> <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </td>
                    <td class="align-middle"><strong>Cơ quan cấp:</strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="hokhau_coquancap" name="hokhau_coquancap" value="<?php echo htmlspecialchars($item['hokhau_coquancap']); ?>" class="form-control" placeholder="Nhập cơ quan cấp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>Phường/Xã: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
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
                        </div>
                    </td>
                    <td class="align-middle"><strong>Thôn/Tổ: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                                <option value=""></option>
                                <?php if (is_array($this->thonto) && count($this->thonto) > 0) { ?>
                                    <?php foreach ($this->thonto as $tt) { ?>
                                        <option value="<?php echo $tt['id']; ?>" <?php echo ($item['thonto_id'] == $tt['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tt['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td class="align-middle"><strong>Số nhà/Đường: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="diachi" name="diachi" value="<?php echo htmlspecialchars($item['diachi']); ?>" class="form-control" placeholder="Nhập số nhà, tên đường">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 class="mb-0 fw-bold">Thông tin nhân khẩu
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themnhankhau" data-toggle="modal" data-target="#modalNhankhau"><i class="fas fa-plus"></i> Thêm nhân khẩu</button>
            </span>
        </h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
            <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center stt" rowspan="2" style="width: 80px;">STT</th>
                        <th class="align-middle text-center quanhe" rowspan="2">Quan hệ với<br>chủ hộ</th>
                        <th class="align-middle text-center hoten" rowspan="2">Thông tin cá nhân</th>
                        <th class="align-middle text-center cccd" rowspan="2">CMND/CCCD</th>
                        <th class="align-middle text-center thongtinkhac" rowspan="2">Thông tin khác</th>
                        <th class="align-middle text-center noihientai" rowspan="2">Thường trú/Tạm trú</th>
                        <!-- <th class="align-middle text-center noithuongtru" rowspan="2">Nơi thường trú trước khi chuyển đến</th> -->
                        <th class="align-middle text-center lydo" rowspan="2">Lý do xóa đăng ký thường trú</th>
                        <th class="align-middle text-center tinhtrang" rowspan="2">Tình trạng</th>
                        <th class="align-middle text-center chucnang" rowspan="2" style="width: 150px;">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($nhankhau) && is_array($nhankhau) && count($nhankhau) > 0) { ?>
                        <?php foreach ($nhankhau as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle quanhe"><?php echo htmlspecialchars($nk['quanhe'] ?? ''); ?></td>
                                <td class="align-middle hoten">
                                    Họ tên: <?php echo htmlspecialchars($nk['hoten'] ?? ''); ?><br>
                                    Ngày sinh: <?php echo htmlspecialchars($nk['ngaysinh'] ?? ''); ?><br>
                                    Điện thoại: <?php echo htmlspecialchars($nk['dienthoai'] ?? ''); ?><br>
                                    Giới tính: <?php echo htmlspecialchars($nk['gioitinh'] ?? ''); ?>
                                </td>
                                <td class="align-middle cccd">
                                    Số: <?php echo htmlspecialchars($nk['cccd_so'] ?? ''); ?><br>
                                    Ngày cấp: <?php echo htmlspecialchars($nk['cccd_ngaycap'] ?? ''); ?><br>
                                    Nơi cấp: <?php echo htmlspecialchars($nk['cccd_coquancap'] ?? ''); ?>
                                </td>
                                <td class="align-middle thongtinkhac">
                                    Dân tộc: <?php echo htmlspecialchars($nk['dantoc'] ?? ''); ?><br>
                                    Tôn giáo: <?php echo htmlspecialchars($nk['tongiao'] ?? ''); ?><br>
                                    Trình độ: <?php echo htmlspecialchars($nk['trinhdo'] ?? ''); ?><br>
                                    Nghề nghiệp: <?php echo htmlspecialchars($nk['nghenghiep'] ?? ''); ?><br>
                                    Quốc tịch: <?php echo htmlspecialchars($nk['quoctich'] ?? 'Việt Nam'); ?>
                                </td>
                                <td class="align-middle noihientai"><?php echo htmlspecialchars($nk['noihientai'] ?? ''); ?></td>
                                <!-- <td class="align-middle noithuongtru"><?php echo htmlspecialchars($nk['thuongtrucu_diachi'] ?? ''); ?></td> -->
                                <td class="align-middle lydo"><?php echo htmlspecialchars($nk['lydo'] ?? ''); ?></td>
                                <td class="align-middle tinhtrang"><?php echo htmlspecialchars($nk['tinhtrang'] ?? 'Hoạt động'); ?></td>
                                <td class="align-middle text-center chucnang">
                                    <input type="hidden" name="nhankhau_id[]" value="<?php echo $nk['id'] ?? ''; ?>" />
                                    <input type="hidden" name="quanhenhanthan_id[]" value="<?php echo $nk['quanhenhanthan_id'] ?? ''; ?>" />
                                    <input type="hidden" name="hoten[]" value="<?php echo htmlspecialchars($nk['hoten'] ?? ''); ?>" />
                                    <input type="hidden" name="ngaysinh[]" value="<?php echo htmlspecialchars($nk['ngaysinh'] ?? ''); ?>" />
                                    <input type="hidden" name="gioitinh_id[]" value="<?php echo $nk['gioitinh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="cccd_so[]" value="<?php echo htmlspecialchars($nk['cccd_so'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_ngaycap[]" value="<?php echo htmlspecialchars($nk['cccd_ngaycap'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_coquancap[]" value="<?php echo htmlspecialchars($nk['cccd_coquancap'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai[]" value="<?php echo htmlspecialchars($nk['dienthoai'] ?? ''); ?>" />
                                    <input type="hidden" name="dantoc_id[]" value="<?php echo $nk['dantoc_id'] ?? ''; ?>" />
                                    <input type="hidden" name="tongiao_id[]" value="<?php echo $nk['tongiao_id'] ?? ''; ?>" />
                                    <input type="hidden" name="trinhdohocvan_id[]" value="<?php echo $nk['trinhdohocvan_id'] ?? ''; ?>" />
                                    <input type="hidden" name="nghenghiep_id[]" value="<?php echo $nk['nghenghiep_id'] ?? ''; ?>" />
                                    <input type="hidden" name="quoctich_id[]" value="<?php echo $nk['quoctich_id'] ?? ''; ?>" />
                                    <input type="hidden" name="is_tamtru[]" value="<?php echo $nk['is_tamtru'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_tinhthanh_id[]" value="<?php echo $nk['thuongtrucu_tinhthanh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_quanhuyen_id[]" value="<?php echo $nk['thuongtrucu_quanhuyen_id'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_phuongxa_id[]" value="<?php echo $nk['thuongtrucu_phuongxa_id'] ?? ''; ?>" />
                                    <input type="hidden" name="thuongtrucu_diachi[]" value="<?php echo htmlspecialchars($nk['thuongtrucu_diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="lydoxoathuongtru_id[]" value="<?php echo $nk['lydoxoathuongtru_id'] ?? ''; ?>" />
                                    <input type="hidden" name="tinhtrang[]" value="<?php echo htmlspecialchars($nk['tinhtrang'] ?? 'Hoạt động'); ?>" />
                                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="<?php echo $nk['id'] ?? ''; ?>"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <table class="w-100">
                <tr>
                    <td class="text-center">
                        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>

<!-- Modal Thêm Nhân Khẩu -->
<div class="modal fade" id="modalNhankhau" tabindex="-1" role="dialog" aria-labelledby="modalNhankhauLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNhankhauLabel">Thêm Nhân Khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalNhankhau">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                <select id="modal_quanhenhanthan_id" class="custom-select" data-placeholder="Chọn quan hệ">
                                    <option value=""></option>
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
                                <input type="text" id="modal_hoten" class="form-control" placeholder="Nhập họ tên">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="modal_ngaysinh" class="form-control date-picker" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                                <select id="modal_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
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
                                <input type="text" id="modal_cccd_so" class="form-control" placeholder="Nhập CMND/CCCD">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Ngày cấp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="modal_cccd_ngaycap" class="form-control date-picker" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nơi cấp <span class="text-danger">*</span></label>
                                <input type="text" id="modal_cccd_coquancap" class="form-control" placeholder="Nhập nơi cấp">
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
                                <select id="modal_dantoc_id" class="custom-select" data-placeholder="Chọn dân tộc">
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
                                <select id="modal_quoctich_id" class="custom-select" data-placeholder="Chọn Quốc tịch">
                                    <option value=""></option>
                                    <?php if (is_array($this->quoctich) && count($this->quoctich) > 0) { ?>
                                        <?php foreach ($this->quoctich as $tg) { ?>
                                            <option value="<?php echo $tg['id']; ?>" data-text="<?php echo htmlspecialchars($tg['tenquoctich']); ?>">
                                                <?php echo htmlspecialchars($tg['tenquoctich']); ?>
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
                                <label class="form-label">Nơi ở hiện tại <span class="text-danger">*</span></label>
                                <select id="modal_is_tamtru" class="custom-select" data-placeholder="Chọn trạng thái">
                                    <option value="0" data-text="Thường trú">Thường trú</option>
                                    <option value="1" data-text="Tạm trú">Tạm trú</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 div_is_tamtru" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label">Nơi thường trú trước khi chuyển đến <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <select id="modal_thuongtrucu_quanhuyen_id" class="custom-select" data-placeholder="Chọn quận/huyện">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="modal_thuongtrucu_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <input type="text" id="modal_thuongtrucu_diachi" class="form-control" placeholder="Nhập số nhà, tên đường, thôn/tổ dân phố">
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
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn_luu_nhankhau"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>

<style>
    .hideOpt {
        display: none !important;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
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
        min-width: 60px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 50px;
    }

    td.quanhe,
    th.quanhe {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.hoten,
    th.hoten {
        min-width: 220px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }

    td.ngaysinh,
    th.ngaysinh {
        min-width: 140px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    td.gioitinh,
    th.gioitinh {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.socccd,
    th.socccd {
        min-width: 140px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    td.ngaycccd,
    th.ngaycccd {
        min-width: 140px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    td.coquancapcccd,
    th.coquancapcccd {
        min-width: 220px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }

    td.dienthoai,
    th.dienthoai {
        min-width: 140px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    td.dantoc,
    th.dantoc {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.tongiao,
    th.tongiao {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.trinhdo,
    th.trinhdo {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.nghenghiep,
    th.nghenghiep {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.noihientai,
    th.noihientai {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.noithuongtru,
    th.noithuongtru {
        min-width: 100px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 1100px;
    }

    td.lydo,
    th.lydo {
        min-width: 150px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    td.chucnang,
    th.chucnang {
        min-width: 100px;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }

    .modal {
        overflow-x: hidden;
    }

    .modal-dialog {
        max-width: 1200px;
        min-width: 300px;
        width: 1000px;
        margin-left: auto;
        /* Đẩy modal sang phải */
        margin-right: 0;
        /* Sát lề phải */
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
        transform: translateX(100%);
        /* Modal bắt đầu từ ngoài lề phải */
        transition: transform 0.5s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: translateX(0);
        /* Trượt vào vị trí sát lề phải */
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
</style>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Debug
        // console.log('jQuery loaded:', typeof $);
        // console.log('btn_themnhankhau exists:', $('#btn_themnhankhau').length);
        // console.log('tblDanhsach tbody exists:', $('#tblDanhsach tbody').length);

        // // Sử dụng noConflict để tránh xung đột
        // var bootstrapDatepicker = $.fn.datepicker.noConflict();
        // $.fn.bootstrapDatepicker = bootstrapDatepicker;
        $('#hokhau_ngaycap').datepicker({
            autoclose: true,
            language: 'vi'
        });
        $('.date-picker').datepicker({
            autoclose: true,
            language: 'vi'
        });

        // Khởi tạo Select2
        if ($.fn.select2) {
            $('#phuongxa_id, #thonto_id').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });
            $('#modal_quanhenhanthan_id, #modal_gioitinh_id, #modal_dantoc_id, #modal_tongiao_id, #modal_trinhdohocvan_id, #modal_nghenghiep_id, #modal_quoctich_id, #modal_is_tamtru, #modal_lydoxoathuongtru_id').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });
            $('#modal_thuongtrucu_tinhthanh_id, #modal_thuongtrucu_quanhuyen_id, #modal_thuongtrucu_phuongxa_id').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });
        } else {
            console.error('Select2 not loaded.');
        }

        // Validation cho modal form
        if ($.fn.validate) {
            $('#frmModalNhankhau').validate({
                ignore: [],
                invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors === 1 ? 'Kiểm tra lỗi sau:<br/>' : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errorsList = '';
                        if (validator.errorList.length > 0) {
                            for (var x = 0; x < validator.errorList.length; x++) {
                                errorsList += '<br/>\u25CF ' + validator.errorList[x].message;
                            }
                        }
                        $.gritter.add({
                            title: '<h3>Thông báo</h3>',
                            text: '<span style="font-size:24px;">' + message + errorsList + '</span>',
                            time: 2000,
                            class_name: 'gritter-error gritter-center gritter-light'
                        });
                    }
                    validator.focusInvalid();
                },
                errorPlacement: function(error, element) {
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
                    modal_thuongtrucu_tinhthanh_id: {
                        required: function() {
                            return $('#modal_is_tamtru').val() === '1';
                        }
                    },
                    modal_thuongtrucu_diachi: {
                        required: function() {
                            return $('#modal_is_tamtru').val() === '1' && (
                                $('#modal_thuongtrucu_tinhthanh_id').val() === '-1' ||
                                $('#modal_thuongtrucu_quanhuyen_id').val() === '-1' ||
                                $('#modal_thuongtrucu_phuongxa_id').val() === '-1'
                            );
                        }
                    }
                },
                messages: {
                    modal_quanhenhanthan_id: 'Chọn quan hệ với chủ hộ',
                    modal_hoten: {
                        required: 'Nhập họ tên nhân khẩu',
                        regex: 'Họ tên không được chứa ký tự đặc biệt'
                    },
                    modal_ngaysinh: 'Nhập ngày sinh',
                    modal_gioitinh_id: 'Chọn giới tính nhân khẩu',
                    modal_cccd_so: 'Nhập số CMND/CCCD',
                    modal_cccd_ngaycap: 'Nhập ngày cấp CMND/CCCD',
                    modal_cccd_coquancap: 'Nhập nơi cấp CMND/CCCD',
                    modal_dantoc_id: 'Chọn dân tộc',
                    modal_thuongtrucu_tinhthanh_id: 'Chọn Tỉnh/Thành nơi thường trú trước khi chuyển đến',
                    modal_thuongtrucu_diachi: 'Nhập số nhà, tên đường, thôn/tổ dân phố nơi thường trú trước khi chuyển đến'
                }
            });

            $.validator.addMethod('regex', function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, 'Họ tên không được chứa ký tự đặc biệt.');
        }

        // Xử lý nút Lưu trong modal
        $('#btn_luu_nhankhau').on('click', function() {
            if ($('#frmModalNhankhau').valid()) {
                var stt = $('.stt').length + 1;
                var quanhe_text = $('#modal_quanhenhanthan_id option:selected').data('text') || '';
                var hoten = $('#modal_hoten').val();
                var ngaysinh = $('#modal_ngaysinh').val();
                var dienthoai = $('#modal_dienthoai').val();
                var gioitinh_text = $('#modal_gioitinh_id option:selected').data('text') || '';
                var cccd_so = $('#modal_cccd_so').val();
                var cccd_ngaycap = $('#modal_cccd_ngaycap').val();
                var cccd_coquancap = $('#modal_cccd_coquancap').val();
                var dantoc_text = $('#modal_dantoc_id option:selected').data('text') || '';
                var tongiao_text = $('#modal_tongiao_id option:selected').data('text') || '';
                var trinhdo_text = $('#modal_trinhdohocvan_id option:selected').data('text') || '';
                var nghenghiep_text = $('#modal_nghenghiep_id option:selected').data('text') || '';
                var quoctich_text = $('#modal_quoctich_id option:selected').data('text') || 'Việt Nam';
                var is_tamtru_text = $('#modal_is_tamtru option:selected').data('text') || 'Thường trú';
                var thuongtrucu = '';
                if ($('#modal_is_tamtru').val() === '1') {
                    var tinhthanh = $('#modal_thuongtrucu_tinhthanh_id option:selected').data('text') || '';
                    var quanhuyen = $('#modal_thuongtrucu_quanhuyen_id option:selected').data('text') || '';
                    var phuongxa = $('#modal_thuongtrucu_phuongxa_id option:selected').data('text') || '';
                    var diachi = $('#modal_thuongtrucu_diachi').val();
                    thuongtrucu = [diachi, phuongxa, quanhuyen, tinhthanh].filter(Boolean).join(', ');
                }
                var lydo_text = $('#modal_lydoxoathuongtru_id option:selected').data('text') || '';
                var tinhtrang = $('#modal_tinhtrang option:selected').data('text') || 'Hoạt động';

                // Gộp dữ liệu cho cột Thông tin cá nhân
                var thongtin_canhan = [
                    `Họ tên: ${hoten}`,
                    `Ngày sinh: ${ngaysinh}`,
                    dienthoai ? `Điện thoại: ${dienthoai}` : '',
                    `Giới tính: ${gioitinh_text}`
                ].filter(Boolean).join('<br>');

                // Gộp dữ liệu cho cột CMND/CCCD
                var cccd_info = [
                    `Số: ${cccd_so}`,
                    `Ngày cấp: ${cccd_ngaycap}`,
                    `Nơi cấp: ${cccd_coquancap}`
                ].join('<br>');

                // Gộp dữ liệu cho cột Thông tin khác
                var thongtin_khac = [
                    `Dân tộc: ${dantoc_text}`,
                    tongiao_text ? `Tôn giáo: ${tongiao_text}` : '',
                    trinhdo_text ? `Trình độ: ${trinhdo_text}` : '',
                    nghenghiep_text ? `Nghề nghiệp: ${nghenghiep_text}` : '',
                    `Quốc tịch: ${quoctich_text}`
                ].filter(Boolean).join('<br>');

                var str = `
                <tr>
                    <td class="align-middle text-center stt">${stt}</td>
                    <td class="align-middle quanhe">${quanhe_text}</td>
                    <td class="align-middle hoten">${thongtin_canhan}</td>
                    <td class="align-middle cccd">${cccd_info}</td>
                    <td class="align-middle thongtinkhac">${thongtin_khac}</td>
                    <td class="align-middle noihientai">${is_tamtru_text}</td>
                    <td class="align-middle noithuongtru">${thuongtrucu}</td>
                    <td class="align-middle lydo">${lydo_text}</td>
                    <td class="align-middle tinhtrang">${tinhtrang}</td>
                    <td class="align-middle text-center chucnang">
                        <input type="hidden" name="nhankhau_id[]" value="" />
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
                        <input type="hidden" name="is_tamtru[]" value="${$('#modal_is_tamtru').val()}" />
                        <input type="hidden" name="thuongtrucu_tinhthanh_id[]" value="${$('#modal_thuongtrucu_tinhthanh_id').val()}" />
                        <input type="hidden" name="thuongtrucu_quanhuyen_id[]" value="${$('#modal_thuongtrucu_quanhuyen_id').val()}" />
                        <input type="hidden" name="thuongtrucu_phuongxa_id[]" value="${$('#modal_thuongtrucu_phuongxa_id').val()}" />
                        <input type="hidden" name="thuongtrucu_diachi[]" value="${$('#modal_thuongtrucu_diachi').val()}" />
                        <input type="hidden" name="lydoxoathuongtru_id[]" value="${$('#modal_lydoxoathuongtru_id').val()}" />
                        <input type="hidden" name="tinhtrang[]" value="${$('#modal_tinhtrang').val()}" />
                        <span class="btn btn-small btn-danger btn_xoa" data-xuly=""><i class="fas fa-trash-alt"></i></span>
                    </td>
                </tr>`;
                try {
                    $('#tblDanhsach tbody').append(str);
                    console.log('Row appended successfully');
                    $('#modalNhankhau').modal('hide');
                    $('#frmModalNhankhau')[0].reset();
                    $('.div_is_tamtru').hide();
                    $('select').trigger('change.select2');
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Thêm nhân khẩu thành công!</span>',
                        time: 1000,
                        class_name: 'gritter-success gritter-center gritter-light'
                    });
                } catch (e) {
                    console.error('Error appending row:', e);
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Lỗi khi thêm nhân khẩu!</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                }
            }
        });
        // Xử lý select Phường/Xã để tải Thôn/Tổ
        $('#phuongxa_id').on('change', function() {
            var $phuongxa_id = $(this);
            var $thonto_id = $('#thonto_id');
            var phuongxa_val = $phuongxa_id.val();

            $('#tinhthanh_id').val($phuongxa_id.find('option:selected').data('tinhthanh'));
            $('#quanhuyen_id').val($phuongxa_id.find('option:selected').data('quanhuyen'));

            $thonto_id.prop('disabled', true).select2('destroy').html('<option value=""></option>');

            if (phuongxa_val === '') {
                $thonto_id.prop('disabled', false).select2({
                    width: '100%',
                    allowClear: true,
                    placeholder: $thonto_id.data('placeholder')
                });
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
                                options += '<option value="' + v.id + '">' + v.tenkhuvuc + '</option>';
                            });
                        }
                        $thonto_id.html(options).prop('disabled', false).select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: $thonto_id.data('placeholder')
                        });
                        $thonto_id.trigger('change.select2');
                    },
                    error: function() {
                        $.gritter.add({
                            title: '<h3>Thông báo</h3>',
                            text: '<span style="font-size:24px;">Lỗi khi tải danh sách Thôn/Tổ</span>',
                            time: 2000,
                            class_name: 'gritter-error gritter-center gritter-light'
                        });
                        $thonto_id.prop('disabled', false).select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: $thonto_id.data('placeholder')
                        });
                    },
                    complete: function() {
                        $thonto_id.siblings('.select2-container').find('.select2-loading').remove();
                    }
                });
            }
        });

        // Xử lý xóa nhân khẩu
        $('body').on('click', '.btn_xoa', function() {
            var $row = $(this).closest('tr');
            var row_index = $('.btn_xoa').index($(this));
            var nhankhau_id = $(this).data('xuly');
            if (nhankhau_id) {
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
                            $.post('index.php', {
                                option: 'com_vptk',
                                controller: 'nhk',
                                task: 'delNhankhau',
                                nhankhau_id: nhankhau_id,
                                [Joomla.getOptions('csrf.token')]: 1
                            }, function(data) {
                                if (data === '1') {
                                    $row.remove();
                                    $('.stt').each(function(i) {
                                        if (i > 0) $(this).html(i);
                                    });
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Đã xử lý xóa dữ liệu thành công!</span>',
                                        time: 1000,
                                        class_name: 'gritter-success gritter-center gritter-light'
                                    });
                                } else {
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Có lỗi xảy ra!!! Vui lòng liên hệ quản trị viên.</span>',
                                        time: 1000,
                                        class_name: 'gritter-error gritter-center gritter-light'
                                    });
                                }
                            }).fail(function() {
                                $.gritter.add({
                                    title: '<h3>Thông báo</h3>',
                                    text: '<span style="font-size:24px;">Lỗi kết nối server!</span>',
                                    time: 1000,
                                    class_name: 'gritter-error gritter-center gritter-light'
                                });
                            });
                        }
                    }
                });
            } else {
                $row.remove();
                $('.stt').each(function(i) {
                    if (i > 0) $(this).html(i);
                });
            }
        });

        // Xử lý select is_tamtru trong modal
        $('#modal_is_tamtru').on('change', function() {
            $('.div_is_tamtru').toggle($(this).val() === '1');
        });

        // Xử lý select thuongtrucu_tinhthanh_id trong modal
        $('#modal_thuongtrucu_tinhthanh_id').on('change', function() {
            var $quanhuyen = $('#modal_thuongtrucu_quanhuyen_id');
            var $phuongxa = $('#modal_thuongtrucu_phuongxa_id');
            var $diachi = $('#modal_thuongtrucu_diachi');
            if ($(this).val() === '') {
                $quanhuyen.html('<option value=""></option>').trigger('change').select2("container").show();
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
            } else if ($(this).val() === '-1') {
                $quanhuyen.select2("container").hide();
                $phuongxa.select2("container").hide();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã, quận/huyện, tỉnh/thành');
            } else {
                $quanhuyen.select2("container").show();
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'ajax',
                    task: 'getQuanHuyenByTinhThanh',
                    tinhthanh_id: $(this).val(),
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option><option value="-1" data-text="Khác">Khác</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '" data-text="' + v.tenquanhuyen + '">' + v.tenquanhuyen + '</option>';
                        });
                    }
                    $quanhuyen.html(str).trigger('change');
                }).fail(function() {
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Lỗi khi tải danh sách Quận/Huyện</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                });
            }
        });

        // Xử lý select thuongtrucu_quanhuyen_id trong modal
        $('#modal_thuongtrucu_quanhuyen_id').on('change', function() {
            var $phuongxa = $('#modal_thuongtrucu_phuongxa_id');
            var $diachi = $('#modal_thuongtrucu_diachi');
            if ($(this).val() === '') {
                $phuongxa.html('<option value=""></option>').trigger('change').select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
            } else if ($(this).val() === '-1') {
                $phuongxa.select2("container").hide();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã, quận/huyện');
            } else {
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'ajax',
                    task: 'getPhuongXaByQuanHuyen',
                    quanhuyen_id: $(this).val(),
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option><option value="-1" data-text="Khác">Khác</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '" data-text="' + v.tenphuongxa + '">' + v.tenphuongxa + '</option>';
                        });
                    }
                    $phuongxa.html(str).trigger('change');
                }).fail(function() {
                    $.gritter.add({
                        title: '<h3>Thông báo</h3>',
                        text: '<span style="font-size:24px;">Lỗi khi tải danh sách Phường/Xã</span>',
                        time: 2000,
                        class_name: 'gritter-error gritter-center gritter-light'
                    });
                });
            }
        });

        // Xử lý select thuongtrucu_phuongxa_id trong modal
        $('#modal_thuongtrucu_phuongxa_id').on('change', function() {
            var $diachi = $('#modal_thuongtrucu_diachi');
            $diachi.attr('placeholder', $(this).val() === '-1' ?
                'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã' :
                'Nhập số nhà, tên đường, thôn/tổ dân phố');
        });

        // Xử lý nút Quay lại
        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vptk/?view=nhk&task=default';
        });

        // Validation cho form chính
        if ($.fn.validate) {
            $('#frmNhanhokhau').validate({
                ignore: [],
                invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors === 1 ? 'Kiểm tra lỗi sau:<br/>' : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errorsList = '';
                        if (validator.errorList.length > 0) {
                            for (var x = 0; x < validator.errorList.length; x++) {
                                errorsList += '<br/>\u25CF ' + validator.errorList[x].message;
                            }
                        }
                        $.gritter.add({
                            title: '<h3>Thông báo</h3>',
                            text: '<span style="font-size:24px;">' + message + errorsList + '</span>',
                            time: 2000,
                            class_name: 'gritter-error gritter-center gritter-light'
                        });
                    }
                    validator.focusInvalid();
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest('.mb-3'));
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

        // Xử lý nút Lưu form chính
        $('#btn_luu').on('click', function(e) {
            e.preventDefault();
            if ($.fn.validate && $('#frmNhanhokhau').valid()) {
                document.frmNhanhokhau.submit();
            }
        });

        // Kích hoạt sự kiện change ban đầu cho phuongxa_id
        $('#phuongxa_id').trigger('change');
    });
</script>