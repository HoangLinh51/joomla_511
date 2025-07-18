<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;


$item = $this->item;
// var_dump($item);

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
<form id="frmBanDieuHanh" name="frmBanDieuHanh" method="post" action="index.php?option=com_vptk&controller=bdh&task=saveBanDieuHanh">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
            <?php echo ((int)$item[0]['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> ban điều hành tổ dân phố
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
                            <strong>Nhiệm kỳ <span class="text-danger">*</span></strong>
                            <select id="nhiemky_id" name="nhiemky_id" class="custom-select" data-placeholder="Chọn nhiệm kỳ">
                                <option value=""></option>
                                <?php if (is_array($this->nhiemky) && count($this->nhiemky) > 0) { ?>
                                    <?php foreach ($this->nhiemky as $nk) { ?>
                                        <option value="<?php echo $nk['id']; ?>" <?php echo ($item[0]['nhiemky_id'] === $nk['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($nk['tennhiemky']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="nhiemky_id"></label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 style="padding-left:15px;" class="mb-0 fw-bold">Thông tin ban điều hành
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themthanhvien" data-toggle="modal" data-target="#modalBanDieuHanh"><i class="fas fa-plus"></i> Thêm thành viên</button>
            </span>
        </h3>
        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center" rowspan="2" style="width: 80px;">STT</th>
                        <th class="align-middle text-center hoten" rowspan="2">Thông tin cá nhân</th>
                        <th class="align-middle text-center diachi" rowspan="2">Địa chỉ</th>
                        <th class="align-middle text-center thongtintdllct" rowspan="2">Thông tin trình độ lý luận chính trị</th>
                        <th class="align-middle text-center thongtinchucdanh" rowspan="2">Thông tin chức danh</th>
                        <th class="align-middle text-center tinhtrang" rowspan="2">Tình trạng</th>
                        <th class="align-middle text-center lydo" rowspan="2">Lý do kết thúc</th>
                        <th class="align-middle text-center chucnang" rowspan="2" style="width: 150px;">Chức năng</th>
                    </tr>
                </thead>
                <tbody id="tbodyDanhSach">
                    <?php if (is_array($item) && count($item) > 0) { ?>
                        <?php foreach ($item as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center stt"><?php echo $index + 1; ?></td>
                                <td class="align-middle hoten" style="cursor: pointer;">
                                    <a href="#" class="edit-nhankhau" data-index="<?php echo $index; ?>">
                                        <strong>Họ tên:</strong> <?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>
                                    </a><br>
                                    <strong>CCCD:</strong> <?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?><br>
                                    <strong>Điện thoại:</strong> <?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?><br>
                                    <strong>Giới tính:</strong> <?php echo htmlspecialchars($nk['gioitinh_text'] ?? ''); ?>
                                </td>
                                <td class="align-middle diachi"><?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?></td>
                                <td class="align-middle thongtintdllct">
                                    <strong>Đảng viên:</strong> <?php echo htmlspecialchars($nk['is_dangvien'] == 1 ? 'Có' : 'Không'); ?><br>
                                    <strong>Trình độ lý luận chính trị:</strong> <?php echo htmlspecialchars($nk['trinhdolyluanchinhtri_text'] ?? ''); ?>
                                </td>
                                <td class="align-middle thongtinchucdanh">
                                    <strong>Chức danh:</strong> <?php echo htmlspecialchars($nk['chucdanh_text'] ?? ''); ?><br>
                                    <strong>Chức danh kiêm nhiệm:</strong> <?php echo htmlspecialchars($nk['chucvukn_text'] ?? ''); ?><br>
                                    <strong>Thời gian:</strong> <?php echo htmlspecialchars(($nk['tungay'] ?? '') . ($nk['denngay'] ? ' - ' . $nk['denngay'] : '')); ?>
                                </td>
                                <td class="align-middle tinhtrang"><?php echo htmlspecialchars($nk['tinhtrang_text'] ?? ''); ?></td>
                                <td class="align-middle lydo"><?php echo htmlspecialchars($nk['lydoketthuc'] ?? ''); ?></td>
                                <td class="align-middle text-center chucnang">
                                    <input type="hidden" name="bandieuhanh_id[]" value="<?php echo $nk['id'] ?? ''; ?>" />
                                    <input type="hidden" name="nhankhau_id[]" value="<?php echo $nk['nhankhau_id'] ?? ''; ?>" />
                                    <input type="hidden" name="hoten[]" value="<?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_so[]" value="<?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai[]" value="<?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?>" />
                                    <input type="hidden" name="gioitinh_id[]" value="<?php echo $nk['n_gioitinh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="diachi[]" value="<?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?>" />
                                    <input type="hidden" name="is_dangvien[]" value="<?php echo $nk['is_dangvien'] ?? '0'; ?>" />
                                    <input type="hidden" name="trinhdolyluanchinhtri_id[]" value="<?php echo $nk['id_llct'] ?? ''; ?>" />
                                    <input type="hidden" name="chucdanh_id[]" value="<?php echo $nk['chucdanh_id'] ?? ''; ?>" />
                                    <input type="hidden" name="chucdanh_kiemnhiem_id[]" value="<?php echo $nk['chucvukn_id'] ?? ''; ?>" />
                                    <input type="hidden" name="tungay[]" value="<?php echo $nk['tungay'] ?? ''; ?>" />
                                    <input type="hidden" name="denngay[]" value="<?php echo $nk['denngay'] ?? ''; ?>" />
                                    <input type="hidden" name="tinhtrang_id[]" value="<?php echo $nk['tinhtrang_id'] ?? ''; ?>" />
                                    <input type="hidden" name="lydoketthuc_id[]" value="<?php echo $nk['lydoketthuc'] ?? ''; ?>" />
                                    <input type="hidden" name="is_search[]" value="<?php echo ($nk['is_ngoai'] == 0 ? '1' : '0'); ?>" />
                                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="<?php echo $nk['id'] ?? ''; ?>"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="no-data">
                            <td colspan="8" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>

<!-- Modal thông tin thành viên -->
<div class="modal fade" id="modalBanDieuHanh" tabindex="-1" role="dialog" aria-labelledby="modalBanDieuHanhLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBanDieuHanhLabel">Thêm thông tin thành viên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalBanDieuHanh">
                    <input type="hidden" id="modal_edit_index" value="">
                    <div class="mb-3">
                        <label class="form-label">Tìm kiếm thành viên <input type="checkbox" id="modal_search_toggle" checked></label>
                    </div>
                    <div id="search_fields">
                        <div class="mb-3">
                            <label class="form-label">Chọn thành viên <span class="text-danger"> * </span></label>
                            <select id="modal_nhankhau_search" class="custom-select" data-placeholder="Chọn thành viên"></select>
                        </div>
                    </div>
                    <div id="manual_fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_hoten" name="modal_hoten" class="form-control" placeholder="Nhập họ tên">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">CCCD <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_cccd_so" name="modal_cccd_so" class="form-control" placeholder="Nhập CCCD" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Điện thoại</label>
                                    <input type="text" id="modal_dienthoai" class="form-control" placeholder="Nhập điện thoại" disabled>
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
                                </div>
                            </div>
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
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_diachi" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Đảng viên</label>
                                    <select id="modal_is_dangvien" name="modal_is_dangvien" class="custom-select" data-placeholder="Chọn ">
                                        <option value="1">Có</option>
                                        <option value="2"> Không</option>
                                    </select>

                                    <!-- <input type="checkbox" id="modal_is_dangvien" name="modal_is_dangvien" value="1"> -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trình độ lý luận chính trị</label>
                                    <select id="modal_trinhdolyluanchinhtri_id" name="modal_trinhdolyluanchinhtri_id" class="custom-select" data-placeholder="Chọn trình độ">
                                        <option value=""></option>
                                        <?php if (is_array($this->trinhdollct) && count($this->trinhdollct) > 0) { ?>
                                            <?php foreach ($this->trinhdollct as $td) { ?>
                                                <option value="<?php echo $td['id']; ?>" data-text="<?php echo htmlspecialchars($td['tentrinhdo']); ?>">
                                                    <?php echo htmlspecialchars($td['tentrinhdo']); ?>
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
                                    <label class="form-label">Chức danh <span class="text-danger">*</span></label>
                                    <select id="modal_chucdanh_id" name="modal_chucdanh_id" class="custom-select" data-placeholder="Chọn chức danh">
                                        <option value=""></option>
                                        <?php if (is_array($this->chucdanh) && count($this->chucdanh) > 0) { ?>
                                            <?php foreach ($this->chucdanh as $cd) { ?>
                                                <option value="<?php echo $cd['id']; ?>" data-text="<?php echo htmlspecialchars($cd['tenchucdanh']); ?>">
                                                    <?php echo htmlspecialchars($cd['tenchucdanh']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu chức danh</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Chức danh kiêm nhiệm</label>
                                    <select id="modal_chucdanh_kiemnhiem" name="modal_chucdanh_kiemnhiem" class="custom-select" data-placeholder="Chọn chức danh kiêm nhiệm">
                                        <option value=""></option>
                                        <?php if (is_array($this->chucdanhkiemnhiem) && count($this->chucdanhkiemnhiem) > 0) { ?>
                                            <?php foreach ($this->chucdanhkiemnhiem as $cd) { ?>
                                                <option value="<?php echo $cd['id']; ?>" data-text="<?php echo htmlspecialchars($cd['tenchucdanh']); ?>">
                                                    <?php echo htmlspecialchars($cd['tenchucdanh']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu chức danh kiêm nhiệm</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3" style="margin-left:2px">
                                <div class="col-md-6">
                                    <label class="form-label">Từ ngày</label>
                                    <input type="text" id="modal_thoigian_tungay" name="modal_thoigian_tungay" class="form-control date-picker" placeholder="Từ ngày">
                                </div>
                                <div class="col-md-6" style="padding-left:19px;padding-right:10px">
                                    <label class="form-label">Đến ngày</label>
                                    <input type="text" id="modal_thoigian_denngay" name="modal_thoigian_denngay" class="form-control date-picker" placeholder="Đến ngày">
                                </div>
                            </div>

                            <div class="col-md-6" style="margin-left:6px">
                                <div class="mb-3">
                                    <label class="form-label">Tình trạng <span class="text-danger">*</span></label>
                                    <select id="modal_tinhtrang_id" name="modal_tinhtrang_id" class="custom-select" data-placeholder="Chọn tình trạng">
                                        <option value=""></option>
                                        <?php if (is_array($this->tinhtrang) && count($this->tinhtrang) > 0) { ?>
                                            <?php foreach ($this->tinhtrang as $tt) { ?>
                                                <option value="<?php echo $tt['id']; ?>" data-text="<?php echo htmlspecialchars($tt['tentinhtrang']); ?>">
                                                    <?php echo htmlspecialchars($tt['tentinhtrang']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu tình trạng</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Lý do kết thúc</label>
                                    <input type="text" id="modal_lydoketthuc" name="modal_lydoketthuc" class="form-control" placeholder="Nhập lý do kết thúc">


                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
                <input type="hidden" id="modal_nhankhau_id" name="modal_nhankhau_id" value="">

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

        const selectElements = $('#thonto_id, #nhiemky_id'); // Khởi tạo selectElements ở đây
        selectElements.select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });

        let isRedirecting = false;
        let isChecking = false;

        const REDIRECT_KEY = 'hasRedirectedBDH';

        const currentPath = window.location.pathname;
        const currentSearch = window.location.search;
        const isCorrectPage =
            (currentPath === '/index.php/component/vptk/' || currentPath === '/index.php') &&
            currentSearch.includes('view=bdh') &&
            currentSearch.includes('task=add_bdh');

        console.log('isCorrectPage:', isCorrectPage, {
            currentPath,
            currentSearch
        });

        if (isCorrectPage && sessionStorage.getItem(REDIRECT_KEY) !== '1') {
            function handleChange(e) {
                if (isChecking) {
                    console.log('Đang kiểm tra, bỏ qua');
                    return;
                }

                const phuongxa_id = $('#phuongxa_id').val();
                const thonto_id = $('#thonto_id').val();
                const nhiemky_id = $('#nhiemky_id').val();

                if (!phuongxa_id) {
                    showToast('Vui lòng chọn xã/phường trước!', false);
                    return;
                }

                if (thonto_id && nhiemky_id) {
                    isChecking = true;
                    $('#btn_luu_nhankhau').prop('disabled', true);
                    selectElements.prop('disabled', true);

                    $.ajax({
                        url: 'index.php?option=com_vptk&controller=bdh&task=checkBanDieuHanh',
                        type: 'POST',
                        data: {
                            thonto_id: thonto_id,
                            nhiemky_id: nhiemky_id,
                            [Joomla.getOptions('csrf.token')]: 1
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            showToast('Đang kiểm tra ban điều hành...', true);
                        },
                        success: function(response) {
                            console.log('AJAX response:', response);
                            isChecking = false;
                            $('#btn_luu_nhankhau').prop('disabled', false);
                            selectElements.prop('disabled', false);

                            if (response && response.exists) {
                                sessionStorage.setItem(REDIRECT_KEY, '1');
                                showToast('Ban điều hành đã tồn tại. Đang chuyển hướng...', false);

                                setTimeout(function() {
                                    const redirectUrl = `index.php?option=com_vptk&view=bdh&task=edit_bdh&thonto_id=${thonto_id}&nhiemky_id=${nhiemky_id}`;
                                    window.location.assign(redirectUrl);
                                }, 2000);
                            } else {
                                showToast('Có thể thêm ban điều hành mới', true);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            isChecking = false;
                            $('#btn_luu_nhankhau').prop('disabled', false);
                            selectElements.prop('disabled', false);
                            showToast('Lỗi khi kiểm tra ban điều hành!', false);
                        }
                    });
                }
            }

            const debouncedHandleChange = debounce(handleChange, 500);
            selectElements.on('change', debouncedHandleChange);

            // Kiểm tra ngay khi tải trang
            if ($('#thonto_id').val() && $('#nhiemky_id').val()) {
                debouncedHandleChange({
                    target: $('#thonto_id')[0]
                });
            }
        } else if (sessionStorage.getItem(REDIRECT_KEY) === '1') {
            console.log('Đã chuyển hướng trước đó, bỏ qua xử lý');
            sessionStorage.removeItem(REDIRECT_KEY);
        }

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

        // Hàm khởi tạo Select2
        function initSelect2($element, options) {
            if ($element.length && $.fn.select2) {
                // Chỉ hủy Select2 nếu đã được khởi tạo
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

        // Cập nhật số thứ tự (STT)
        function updateSTT() {
            $('#tblDanhsach tbody tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
                $(this).find('.edit-nhankhau').data('index', index);
            });
        }

        // Khởi tạo Select2 cho các select trong modal
        function initializeModalSelect2() {
            $('#modalBanDieuHanh select.custom-select').not('#modal_nhankhau_search').each(function() {
                initSelect2($(this), {
                    width: '100%',
                    allowClear: true,
                    placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                    dropdownParent: $('#modalBanDieuHanh')
                });
            });
        }

        // Khởi tạo datepicker
        $('.date-picker').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy'
        });

        // Khởi tạo Select2 cho form chính
        initSelect2($('#phuongxa_id, #thonto_id, #nhiemky_id,#modal_nhankhau_search'), {
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });
        $('#btn_themthanhvien').on('click', function(e) {
            e.preventDefault();
            const selectedThontoId = $('#thonto_id').val();
            const selectedNhiemkyId = $('#nhiemky_id').val();

            if (!selectedThontoId || !selectedNhiemkyId) {
                showToast('Vui lòng chọn Thôn/Tổ và Nhiệm kỳ trước khi thêm thành viên', false);
                return false;
            }

            $('#modalBanDieuHanhLabel').text('Thêm Thành Viên');
            $('#modal_edit_index').val('');
            $('#frmModalBanDieuHanh')[0].reset();
            initializeModalSelect2();

            // Gán giá trị và vô hiệu hóa modal_phuongxa_id
            const selectedPhuongxaId = $('#phuongxa_id').val();
            const phuongxa_text = $('#phuongxa_id option:selected').text();
            const thonto_text = $('#thonto_id option:selected').text();

            // Debug giá trị

            // Đồng bộ danh sách option của modal_thonto_id với thonto_id
            $('#modal_thonto_id').html($('#thonto_id').html()); // Sao chép toàn bộ <option> từ #thonto_id
            $('#modal_phuongxa_id').val(selectedPhuongxaId).prop('disabled', true);
            $('#modal_thonto_id').val(selectedThontoId).prop('disabled', true);



            // Khởi tạo Select2 cho modal_phuongxa_id và modal_thonto_id
            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            $('#modal_search_toggle').prop('checked', true).trigger('change');
            // $('#modal_nhankhau_search').val('').trigger('change.select2');
            $('#modalBanDieuHanh').modal('show');
        });
        $('#modal_search_toggle').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#search_fields').toggle(isChecked);

            // Không vô hiệu hóa các trường dữ liệu khi tìm kiếm
            $('#modal_hoten, #modal_cccd_so,#modal_dienthoai, #modal_diachi,  #modal_gioitinh_id').prop('disabled', false);

            if (isChecked) {
                // Khởi tạo Select2 với AJAX cho #modal_nhankhau_search
                $('#modal_hoten, #modal_cccd_so,#modal_dienthoai, #modal_diachi,  #modal_gioitinh_id').prop('disabled', true);

                initSelect2($('#modal_nhankhau_search'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                    dropdownParent: $('#modalBanDieuHanh'),
                    minimumInputLength: 2,
                    ajax: {
                        url: 'index.php?option=com_vptk&controller=bdh&task=getThanhVienBanDieuHanh',
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term,
                                thonto_id: $('#thonto_id').val(),
                                nhiemky_id: $('#nhiemky_id').val(),
                                [Joomla.getOptions('csrf.token')]: 1
                            };
                        },
                        processResults: function(data, params) {
                            console.log('Dữ liệu trả về từ server:', data);
                            var results = [];
                            if (data && Array.isArray(data) && data.length > 0) {
                                results = data.map(function(v) {
                                    var member = v.bandieuhanh && v.bandieuhanh.length > 0 ? v.bandieuhanh[0] : {};
                                    return {
                                        id: v.nhankhau_id,
                                        text: `${v.hoten || ''} - CCCD: ${v.cccd_so || ''} - Ngày sinh: ${v.ngaysinh || ''} - Địa chỉ: ${v.diachi || ''}`,
                                        data: {
                                            hoten: v.hoten || '',
                                            cccd_so: v.cccd_so || '',
                                            dienthoai: v.dienthoai || '',
                                            diachi: v.diachi || '',
                                            gioitinh_id: v.gioitinh_id || member.gioitinh_id || '',
                                            gioitinh_text: v.tengioitinh || '',
                                            is_dangvien: member.is_dangvien || '2',
                                            trinhdolyluanchinhtri_id: member.id_llct || '',
                                            chucdanh_id: member.chucdanh_id || '',
                                            chucdanh_kiemnhiem: member.chucvukn_id || '',
                                            tungay: member.tungay || '',
                                            denngay: member.denngay || '',
                                            tinhtrang_id: member.tinhtrang_id || '',
                                            nhankhau_id: v.nhankhau_id || ''
                                        }
                                    };
                                });
                            } else {
                                console.warn('Dữ liệu trả về rỗng hoặc không đúng định dạng:', data);
                            }
                            return {
                                results: results
                            };
                        },
                        cache: true
                    },
                    templateSelection: function(selection) {
                        return selection.text || selection.id;
                    },
                    templateResult: function(result) {
                        return result.text || result.id;
                    }
                });

                // Nếu đang ở chế độ chỉnh sửa, giữ lại dữ liệu đã tìm kiếm
                if ($('#modal_nhankhau_id').val()) {
                    const selectedId = $('#modal_nhankhau_id').val();
                    $('#modal_nhankhau_search').val(selectedId).trigger('change.select2');
                } else {
                    // Xóa dữ liệu hiện tại nếu không có ID
                    $('#modal_nhankhau_search').val('').trigger('change.select2');
                }
            } else {
                // Chế độ nhập tay
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_is_dangvien').val('2').trigger('change.select2');
                $('#modal_trinhdolyluanchinhtri_id').val('').trigger('change.select2');
                $('#modal_chucdanh_id').val('').trigger('change.select2');
                $('#modal_chucdanh_kiemnhiem').val('');
                $('#_modal_thoigian_tungay, #modal_thoigian_denngay').val('');
                $('#modal_tinhtrang_id').val('').trigger('change.select2');
                initializeModalSelect2();
            }
        });

        // Xử lý sự kiện chọn từ dropdown tìm kiếm
        $('#modal_nhankhau_search').on('change', function(e) {
            var selectedData = $(this).select2('data')[0] || $(this).data('select2-data');
            console.log('Dữ liệu của tùy chọn được chọn:', selectedData);
            if (selectedData && selectedData.id && selectedData.data) {
                $('#modal_hoten').val(selectedData.data.hoten || '');
                $('#modal_nhankhau_id').val(selectedData.data.nhankhau_id || '');
                $('#modal_cccd_so').val(selectedData.data.cccd_so || '');
                $('#modal_dienthoai').val(selectedData.data.dienthoai || '');
                $('#modal_diachi').val(selectedData.data.diachi || '');
                $('#modal_is_dangvien').val(selectedData.data.is_dangvien === '0' ? '2' : selectedData.data.is_dangvien || '2').trigger('change.select2');
                $('#modal_trinhdolyluanchinhtri_id').val(selectedData.data.trinhdolyluanchinhtri_id || '').trigger('change.select2');
                $('#modal_chucdanh_id').val(selectedData.data.chucdanh_id || '').trigger('change.select2');
                $('#modal_chucdanh_kiemnhiem').val(selectedData.data.chucdanh_kiemnhiem || '').trigger('change.select2');
                $('#modal_thoigian_tungay').val(selectedData.data.tungay || '');
                $('#modal_thoigian_denngay').val(selectedData.data.denngay || '');
                $('#modal_tinhtrang_id').val(selectedData.data.tinhtrang_id || '').trigger('change.select2');

                var gioitinh_id = selectedData.data.gioitinh_id;
                if (!gioitinh_id && selectedData.data.gioitinh_text) {
                    $('#modal_gioitinh_id option').each(function() {
                        if ($(this).data('text') === selectedData.data.gioitinh_text) {
                            gioitinh_id = $(this).val();
                        }
                    });
                }
                $('#modal_gioitinh_id').val(gioitinh_id || '').trigger('change.select2');
            } else {
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi').val('');
                $('#modal_nhankhau_id').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_is_dangvien').val('2').trigger('change.select2');
                $('#modal_trinhdolyluanchinhtri_id').val('').trigger('change.select2');
                $('#modal_chucdanh_id').val('').trigger('change.select2');
                $('#modal_chucdanh_kiemnhiem').val('').trigger('change.select2');
                $('#modal_thoigian_tungay, #modal_thoigian_denngay').val('');
                $('#modal_tinhtrang_id').val('').trigger('change.select2');
            }
        });


        // Xử lý sự kiện lưu
        $('#btn_luu_nhankhau').on('click', function() {
            if ($('#frmModalBanDieuHanh').valid()) {
                const editIndex = $('#modal_edit_index').val();
                const isEditing = editIndex !== '';
                const isSearch = $('#modal_search_toggle').is(':checked');

                $('#tblDanhsach tbody tr.no-data').remove();

                const stt = isEditing ? parseInt($($('#tblDanhsach tbody tr')[editIndex]).find('.stt').text()) : $('#tblDanhsach tbody tr').length + 1;

                let nhankhauId, hoten, cccd_so, dienthoai, gioitinh_id, gioitinh_text, diachi;
                if (isSearch) {
                    if (isEditing) {
                        nhankhauId = $('#modal_nhankhau_id').val() || '';
                        hoten = $('#modal_hoten').val() || '';
                        cccd_so = $('#modal_cccd_so').val() || '';
                        dienthoai = $('#modal_dienthoai').val() || '';
                        gioitinh_id = $('#modal_gioitinh_id').val() || '';
                        gioitinh_text = $('#modal_gioitinh_id option:selected').data('text') || '';
                        diachi = $('#modal_diachi').val() || '';

                        // Kiểm tra nhankhauId để đảm bảo có thành viên
                        if (!nhankhauId) {
                            console.warn('Không có nhankhau_id trong chế độ chỉnh sửa tìm kiếm');
                            showToast('Không tìm thấy thông tin thành viên!', false);
                            return;
                        }
                    } else {
                        // Khi thêm mới ở Babel
                        const selectedData = $('#modal_nhankhau_search').select2('data')[0] || $('#modal_nhankhau_search').data('select2-data');
                        if (selectedData && selectedData.id && selectedData.data) {
                            nhankhauId = selectedData.data.nhankhau_id || '';
                            hoten = selectedData.data.hoten || '';
                            cccd_so = selectedData.data.cccd_so || '';
                            dienthoai = selectedData.data.dienthoai || '';
                            gioitinh_id = selectedData.data.gioitinh_id || '';
                            gioitinh_text = selectedData.data.gioitinh_text || $('#modal_gioitinh_id option:selected').data('text') || '';
                            diachi = selectedData.data.diachi || '';
                        } else {
                            console.warn('Không có thành viên được chọn trong chế độ tìm kiếm');
                            showToast('Vui lòng chọn một thành viên!', false);
                            return;
                        }
                    }
                } else {
                    nhankhauId = $('#modal_nhankhau_id').val() || '';
                    hoten = $('#modal_hoten').val() || '';
                    cccd_so = $('#modal_cccd_so').val() || '';
                    dienthoai = $('#modal_dienthoai').val() || '';
                    gioitinh_id = $('#modal_gioitinh_id').val() || '';
                    gioitinh_text = $('#modal_gioitinh_id option:selected').data('text') || '';
                    diachi = $('#modal_diachi').val() || '';
                }

                const is_dangvien = $('#modal_is_dangvien').val() || '2';
                const is_dangvien_text = $('#modal_is_dangvien option:selected').text() || 'Không';
                const trinhdolyluanchinhtri_id = $('#modal_trinhdolyluanchinhtri_id').val() || '';
                const trinhdolyluanchinhtri_text = $('#modal_trinhdolyluanchinhtri_id option:selected').data('text') || '';
                const chucdanh_id = $('#modal_chucdanh_id').val() || '';
                const chucdanh_text = $('#modal_chucdanh_id option:selected').data('text') || '';
                const chucdanh_kiemnhiem_id = $('#modal_chucdanh_kiemnhiem').val() || '';
                const chucdanh_kiemnhiem = $('#modal_chucdanh_kiemnhiem option:selected').data('text') || '';
                const tungay = $('#modal_thoigian_tungay').val() || '';
                const denngay = $('#modal_thoigian_denngay').val() || '';
                const tinhtrang_id = $('#modal_tinhtrang_id').val() || '';
                const tinhtrang_text = $('#modal_tinhtrang_id option:selected').data('text') || '';
                const lydoketthuc = $('#modal_lydoketthuc').val() || '';
                id_giadinhvanhoa = isEditing ? ($('#tblDanhsach tbody tr').eq(editIndex).find('input[name="id_giadinhvanhoa[]"]').val() || $('input[name="giadinhvanhoa"]').val() || '0') : ($('input[name="giadinhvanhoa"]').val() || '0');
                // Debug dữ liệu trước khi lưu


                const str = `
            <tr>
                <td class="align-middle text-center stt">${stt}</td>
                <td class="align-middle hoten">
                    <a href="#" class="edit-nhankhau" data-index="${isEditing ? editIndex : $('#tblDanhsach tbody tr').length}">
                        <strong>Họ tên:</strong> ${hoten}
                    </a><br>
                    <strong>CCCD:</strong> ${cccd_so}<br>
                    <strong>Điện thoại:</strong> ${dienthoai}<br>
                    <strong>Giới tính:</strong> ${gioitinh_text}
                </td>
                <td class="align-middle diachi">${diachi}</td>
                <td class="align-middle thongtintdllct">
                    <strong>Đảng viên:</strong> ${is_dangvien == '1' ? 'Có' : 'Không'}<br>
                    <strong>Trình độ lý luận chính trị:</strong> ${trinhdolyluanchinhtri_text}
                </td>
                <td class="align-middle thongtinchucdanh">
                    <strong>Chức danh:</strong> ${chucdanh_text}<br>
                    <strong>Chức danh kiêm nhiệm:</strong> ${chucdanh_kiemnhiem}<br>
                    <strong>Thời gian:</strong> ${tungay} - ${denngay}
                </td>
                <td class="align-middle tinhtrang">${tinhtrang_text}</td>
                <td class="align-middle lydo">${lydoketthuc}</td>
                <td class="align-middle text-center chucnang">
                    <input type="hidden" name="bandieuhanh_id[]" value="${isEditing ? ($('#tblDanhsach tbody tr').eq(editIndex).find('input[name="bandieuhanh_id[]"]').val() || '') : ''}" />
                    <input type="hidden" name="nhankhau_id[]" value="${nhankhauId}" />
                    <input type="hidden" name="hoten[]" value="${hoten}" />
                    <input type="hidden" name="cccd_so[]" value="${cccd_so}" />
                    <input type="hidden" name="dienthoai[]" value="${dienthoai}" />
                    <input type="hidden" name="gioitinh_id[]" value="${gioitinh_id}" />
                    <input type="hidden" name="diachi[]" value="${diachi}" />
                    <input type="hidden" name="is_dangvien[]" value="${is_dangvien}" />
                    <input type="hidden" name="trinhdolyluanchinhtri_id[]" value="${trinhdolyluanchinhtri_id}" />
                    <input type="hidden" name="chucdanh_id[]" value="${chucdanh_id}" />
                    <input type="hidden" name="chucdanh_kiemnhiem_id[]" value="${chucdanh_kiemnhiem_id}" />
                    <input type="hidden" name="tungay[]" value="${tungay}" />
                    <input type="hidden" name="id_giadinhvanhoa[]" value="${id_giadinhvanhoa}" />
                    <input type="hidden" name="denngay[]" value="${denngay}" />
                    <input type="hidden" name="tinhtrang_id[]" value="${tinhtrang_id}" />
                    <input type="hidden" name="lydoketthuc_id[]" value="${lydoketthuc}" />
                    <input type="hidden" name="is_search[]" value="${isSearch ? '1' : '0'}" />
                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="${nhankhauId}"><i class="fas fa-trash-alt"></i></span>
                </td>
            </tr>`;

                try {
                    if (isEditing) {
                        $($('#tblDanhsach tbody tr')[editIndex]).replaceWith(str);
                    } else {
                        $('#tblDanhsach tbody').append(str);
                    }
                    updateSTT();
                    $('#modalBanDieuHanh').modal('hide');
                    $('#frmModalBanDieuHanh')[0].reset();
                    $('#frmModalBanDieuHanh select').val('').trigger('change.select2');
                    resetModal();

                    showToast('Lưu thành viên thành công', true);
                } catch (e) {
                    console.error('Error processing row:', e);
                    showToast('Lỗi khi ' + (isEditing ? 'cập nhật' : 'thêm') + ' thành viên!', false);
                }
            }
        });

        $('body').on('click', '.edit-nhankhau', function(e) {
            e.preventDefault();
            const index = $(this).data('index');
            const $row = $(this).closest('tr');
            const isSearch = $row.find('input[name="is_search[]"]').val() == '1';
            const nhankhauId = $row.find('input[name="nhankhau_id[]"]').val();

            // Lấy dữ liệu từ hàng
            const hoten = $row.find('input[name="hoten[]"]').val() || '';
            const cccd_so = $row.find('input[name="cccd_so[]"]').val() || '';
            const dienthoai = $row.find('input[name="dienthoai[]"]').val() || '';
            const diachi = $row.find('input[name="diachi[]"]').val() || '';
            const gioitinh_id = $row.find('input[name="gioitinh_id[]"]').val() || '';
            const is_dangvien = $row.find('input[name="is_dangvien[]"]').val() === '0' ? '2' : $row.find('input[name="is_dangvien[]"]').val() || '2';
            const trinhdolyluanchinhtri_id = $row.find('input[name="trinhdolyluanchinhtri_id[]"]').val() || '';
            const chucdanh_id = $row.find('input[name="chucdanh_id[]"]').val() || '';
            const chucdanh_kiemnhiem_id = $row.find('input[name="chucdanh_kiemnhiem_id[]"]').val() || '';
            const tungay = $row.find('input[name="tungay[]"]').val() || '';
            const denngay = $row.find('input[name="denngay[]"]').val() || '';
            const tinhtrang_id = $row.find('input[name="tinhtrang_id[]"]').val() || '';
            const lydoketthuc = $row.find('input[name="lydoketthuc_id[]"]').val() || '';

            // Lấy phuongxa_id và thonto_id (từ input ẩn trong hàng hoặc từ form chính)
            const phuongxa_id = $row.find('input[name="phuongxa_id[]"]').val() || $('#phuongxa_id').val();
            const thonto_id = $row.find('input[name="thonto_id[]"]').val() || $('#thonto_id').val();

            // Debug dữ liệu
            console.log('Dữ liệu từ hàng bảng:', {
                nhankhauId,
                hoten,
                cccd_so,
                diachi,
                isSearch,
                phuongxa_id,
                thonto_id
            });

            $('#modalBanDieuHanhLabel').text('Chỉnh sửa Thành Viên');
            $('#modal_edit_index').val(index);

            // Khởi tạo select2 trước
            initializeModalSelect2();

            // Gán giá trị cho modal_phuongxa_id và modal_thonto_id
            $('#modal_phuongxa_id').val(phuongxa_id).prop('disabled', true);
            $('#modal_thonto_id').html($('#thonto_id').html()); // Sao chép danh sách option từ #thonto_id
            $('#modal_thonto_id').val(thonto_id).prop('disabled', true);

            // Khởi tạo Select2 cho modal_phuongxa_id và modal_thonto_id
            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            // Gán trạng thái checkbox tìm kiếm và hiển thị/ẩn #search_fields
            $('#modal_search_toggle').prop('checked', isSearch);
            if (isSearch) {
                $('#search_fields').show();
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id').prop('disabled', true);
            } else {
                $('#search_fields').hide();
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id').prop('disabled', false);
            }

            // Gán modal_nhankhau_id ẩn
            $('#modal_nhankhau_id').val(nhankhauId);

            // Với chế độ tìm kiếm
            if (isSearch) {
                const gioitinh_text = $row.find('.hoten').find('strong:contains("Giới tính")').next().text().trim() || '';
                const selectedOption = {
                    id: nhankhauId,
                    text: `${hoten} - CCCD: ${cccd_so} - Địa chỉ: ${diachi}`,
                    data: {
                        nhankhau_id: nhankhauId,
                        hoten,
                        cccd_so,
                        dienthoai,
                        diachi,
                        gioitinh_id,
                        gioitinh_text,
                        is_dangvien,
                        trinhdolyluanchinhtri_id,
                        chucdanh_id,
                        chucdanh_kiemnhiem: chucdanh_kiemnhiem_id,
                        tungay,
                        denngay,
                        tinhtrang_id
                    }
                };

                // Reset #modal_nhankhau_search trước khi gán giá trị mới
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html(`<option value="${selectedOption.id}">${selectedOption.text}</option>`);

                // Khởi tạo lại Select2
                initSelect2($('#modal_nhankhau_search'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                    dropdownParent: $('#modalBanDieuHanh'),
                    minimumInputLength: 2,
                    ajax: {
                        url: 'index.php?option=com_vptk&controller=bdh&task=getThanhVienBanDieuHanh',
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term,
                                thonto_id: $('#thonto_id').val(),
                                nhiemky_id: $('#nhiemky_id').val(),
                                [Joomla.getOptions('csrf.token')]: 1
                            };
                        },
                        processResults: function(data) {
                            const results = (data || []).map(v => {
                                const member = v.bandieuhanh?.[0] || {};
                                return {
                                    id: v.nhankhau_id,
                                    text: `${v.hoten || ''} - CCCD: ${v.cccd_so || ''} - Ngày sinh: ${v.ngaysinh || ''} - Địa chỉ: ${v.diachi || ''}`,
                                    data: {
                                        hoten: v.hoten,
                                        cccd_so: v.cccd_so,
                                        dienthoai: v.dienthoai,
                                        diachi: v.diachi,
                                        gioitinh_id: v.gioitinh_id || member.gioitinh_id || '',
                                        gioitinh_text: v.tengioitinh || '',
                                        is_dangvien: member.is_dangvien || '2',
                                        trinhdolyluanchinhtri_id: member.id_llct || '',
                                        chucdanh_id: member.chucdanh_id || '',
                                        chucdanh_kiemnhiem: member.chucvukn_id || '',
                                        tungay: member.tungay || '',
                                        denngay: member.denngay || '',
                                        tinhtrang_id: member.tinhtrang_id || '',
                                        nhankhau_id: v.nhankhau_id
                                    }
                                };
                            });
                            return {
                                results
                            };
                        },
                        cache: true
                    },
                    templateSelection: function(selection) {
                        return selection.text || selection.id;
                    },
                    templateResult: function(result) {
                        return result.text || result.id;
                    }
                });

                // Gán dữ liệu và kích hoạt change
                $('#modal_nhankhau_search').data('select2-data', selectedOption).val(selectedOption.id).trigger('change.select2');
            } else {
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');
            }

            // Show modal
            $('#modalBanDieuHanh').modal('show');

            // Gán dữ liệu vào các input khi modal đã hiển thị
            $('#modalBanDieuHanh').one('shown.bs.modal', function() {
                $('#modal_hoten').val(hoten);
                $('#modal_cccd_so').val(cccd_so);
                $('#modal_dienthoai').val(dienthoai);
                $('#modal_diachi').val(diachi);
                $('#modal_gioitinh_id').val(gioitinh_id).trigger('change.select2');
                $('#modal_is_dangvien').val(is_dangvien).trigger('change.select2');
                $('#modal_trinhdolyluanchinhtri_id').val(trinhdolyluanchinhtri_id).trigger('change.select2');
                $('#modal_chucdanh_id').val(chucdanh_id).trigger('change.select2');
                $('#modal_chucdanh_kiemnhiem').val(chucdanh_kiemnhiem_id).trigger('change.select2');
                $('#modal_thoigian_tungay').val(tungay);
                $('#modal_thoigian_denngay').val(denngay);
                $('#modal_tinhtrang_id').val(tinhtrang_id).trigger('change.select2');
                $('#modal_lydoketthuc').val(lydoketthuc);
            });
        });




        // Xử lý sự kiện xóa
        $('body').on('click', '.btn_xoa', function() {
            var $row = $(this).closest('tr');
            var nhankhau_id = $(this).data('xuly');

            bootbox.confirm({
                title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                message: '<span class="text-danger" style="font-size:24px;">Bạn có chắc chắn muốn xóa thành viên này?</span>',
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
                                controller: 'bdh',
                                task: 'delBandieuhanh',
                                nhankhau_id: nhankhau_id,
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

        // Xử lý validation form
        if ($.fn.validate) {
            $('#frmModalBanDieuHanh').validate({
                ignore: [],
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
                    modal_chucdanh_id: {
                        required: true
                    },
                    modal_tinhtrang_id: {
                        required: true
                    }
                },
                messages: {
                    modal_nhankhau_search: 'Chọn thành viên',
                    modal_hoten: {
                        required: 'Nhập họ tên',
                        regex: 'Họ tên không được chứa ký tự đặc biệt'
                    },
                    modal_cccd_so: 'Nhập số CCCD',
                    modal_gioitinh_id: 'Chọn giới tính',
                    modal_diachi: 'Nhập địa chỉ',
                    modal_chucdanh_id: 'Chọn chức danh',
                    modal_tinhtrang_id: 'Chọn tình trạng'
                }
            });

            $.validator.addMethod('regex', function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, 'Họ tên không được chứa ký tự đặc biệt.');
        }

        // Xử lý Phường/Xã change
        $('#phuongxa_id').on('change', function() {
            var $phuongxa_id = $(this);
            var $thonto_id = $('#thonto_id');
            var phuongxa_val = $phuongxa_id.val();

            $('#tinhthanh_id').val($phuongxa_id.find('option:selected').data('tinhthanh'));
            $('#quanhuyen_id').val($phuongxa_id.find('option:selected').data('quanhuyen'));

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
            // Reset form
            $('#frmModalBanDieuHanh').trigger('reset');

            // Reset tất cả các trường Select2
            $('#frmModalBanDieuHanh select').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
                $(this).val('').html('<option value=""></option>');
            });

            // Reset xác thực
            if ($('#frmModalBanDieuHanh').data('validator')) {
                $('#frmModalBanDieuHanh').validate().resetForm();
            }

            // Xóa thông báo lỗi
            $('#frmModalBanDieuHanh .error_modal').remove();

            // Đặt lại trạng thái tìm kiếm
            $('#modal_search_toggle').prop('checked', true);
            $('#search_fields').show();
            $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id').prop('disabled', true);
            $('#modal_nhankhau_id').val('');

            // Khởi tạo lại Select2 cho các trường
            initializeModalSelect2();

            // Khởi tạo lại Select2 cho modal_nhankhau_search với AJAX
            initSelect2($('#modal_nhankhau_search'), {
                width: '100%',
                allowClear: true,
                placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                dropdownParent: $('#modalBanDieuHanh'),
                minimumInputLength: 2,
                ajax: {
                    url: 'index.php?option=com_vptk&controller=bdh&task=getThanhVienBanDieuHanh',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            thonto_id: $('#thonto_id').val(),
                            nhiemky_id: $('#nhiemky_id').val(),
                            [Joomla.getOptions('csrf.token')]: 1
                        };
                    },
                    processResults: function(data) {
                        const results = (data || []).map(v => {
                            const member = v.bandieuhanh?.[0] || {};
                            return {
                                id: v.nhankhau_id,
                                text: `${v.hoten || ''} - CCCD: ${v.cccd_so || ''} - Ngày sinh: ${v.ngaysinh || ''} - Địa chỉ: ${v.diachi || ''}`,
                                data: {
                                    hoten: v.hoten,
                                    cccd_so: v.cccd_so,
                                    dienthoai: v.dienthoai,
                                    diachi: v.diachi,
                                    gioitinh_id: v.gioitinh_id || member.gioitinh_id || '',
                                    gioitinh_text: v.tengioitinh || '',
                                    is_dangvien: member.is_dangvien || '2',
                                    trinhdolyluanchinhtri_id: member.id_llct || '',
                                    chucdanh_id: member.chucdanh_id || '',
                                    chucdanh_kiemnhiem: member.chucvukn_id || '',
                                    tungay: member.tungay || '',
                                    denngay: member.denngay || '',
                                    tinhtrang_id: member.tinhtrang_id || '',
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

            // Đồng bộ modal_phuongxa_id và modal_thonto_id
            const selectedPhuongxaId = $('#phuongxa_id').val();
            const selectedThontoId = $('#thonto_id').val();
            $('#modal_phuongxa_id').html($('#phuongxa_id').html()).val(selectedPhuongxaId).prop('disabled', true);
            $('#modal_thonto_id').html($('#thonto_id').html()).val(selectedThontoId).prop('disabled', true);

            // Khởi tạo Select2 cho modal_phuongxa_id và modal_thonto_id
            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });
        }
        $('.btn-secondary').on('click', function() {
            // Đóng modal
            $('#frmModalBanDieuHanh').trigger('reset'); // Reset dữ liệu trong form
            $('#frmModalBanDieuHanh').validate().resetForm(); // Reset các quy tắc xác thực
            $('#frmModalBanDieuHanh .error_modal').remove(); // Xóa tất cả các thông báo lỗi
        });
        // Xử lý khi modal bị ẩn
        $('#modalBanDieuHanh').on('hidden.bs.modal', function() {
            resetModal(); // Gọi hàm reset modal
        });
        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vptk/?view=bdh&task=default';
        });
        // Trigger initial phuongxa_id change
        $('#phuongxa_id').trigger('change');
    });
</script>
<style>
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

    /* CSS cụ thể cho #modalBanDieuHanh */
    #modalBanDieuHanh .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        word-break: break-word;
    }

    #modalBanDieuHanh .select2-container .select2-selection--single {
        height: 38px;
    }

    #modalBanDieuHanh .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    #modalBanDieuHanh .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    #modalBanDieuHanh {
        overflow-x: hidden;
    }

    #modalBanDieuHanh .modal-dialog {
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

    #modalBanDieuHanh.show .modal-dialog {
        transform: translateX(0);
    }

    #modalBanDieuHanh.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    #modalBanDieuHanh.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    #modalBanDieuHanh .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #modalBanDieuHanh .error_modal {
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

    td.thongtintdllct,
    th.thongtintdllct {
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