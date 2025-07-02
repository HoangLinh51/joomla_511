<?php
// Prevent direct access to this file for security
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$detailDkTuoi17 = $this->detailDkTuoi17;
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<form id="formDoiTuongCS" name="formDoiTuongCS" method="post" action="<?php echo Route::_('index.php?option=com_vhytgd&controller=doituonghuongcs&task=saveDoituongCS'); ?>">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
            <h2 class="text-primary mb-3">
                <?php echo ((int)$detailDkTuoi17->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> đối tượng hưởng chính sách
            </h2>
            <span>
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
            </span>
        </div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($detailDkTuoi17->id); ?>">
        <input type="hidden" name="nhankhau_id" id="nhankhau_id" value="<?php echo htmlspecialchars($detailDkTuoi17->nhankhau_id); ?>">

        <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
            <h5 style="margin: 0">Thông tin cá nhân</h5>
            <div class="d-flex align-items-center" style="gap:5px">
                <input type="checkbox" id="checkbox_toggle" style="width: 20px; height: 20px;" <?php echo htmlspecialchars($detailDkTuoi17->nhankhau_id) ? 'checked' : ''; ?>>
                <small>Chọn người lao động từ danh sách nhân khẩu</small>
            </div>
        </div>
        <div id="select-container" style="display: <?php echo htmlspecialchars($detailDkTuoi17->nhankhau_id) ? 'block' : 'none'; ?>;" class="mb-3">
            <label for="select_top" class="form-label fw-bold">Tìm nhân khẩu</label>
            <select id="select_top" name="select_top" class="select2">
                <option value="">-- Chọn --</option>
                <?php foreach ($this->danhsach_thanhvien as $tv) { ?>
                    <option value="<?php echo $tv['id']; ?>" <?php echo htmlspecialchars($detailDkTuoi17->nhankhau_id) == $tv['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tv['hoten']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-4 mb-2">
                <label for="hoten" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                <input id="hoten" type="text" name="hoten" class="form-control" placeholder="Nhập họ và tên công dân" value="<?php echo htmlspecialchars($detailDkTuoi17->n_hoten); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="select_gioitinh_id" class="form-label fw-bold">Giới tính</label>
                <input type="hidden" id="input_gioitinh_id" name="input_gioitinh_id" value="<?php echo htmlspecialchars($detailDkTuoi17->n_gioitinh_id); ?>">
                <select id="select_gioitinh_id" name="select_gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
                    <option value=""></option>
                    <?php foreach ($this->gioitinh as $gt) { ?>
                        <option value="<?php echo $gt['id']; ?>" <?php echo $detailDkTuoi17->n_gioitinh_id == $gt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($gt['tengioitinh']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label for="cccd" class="form-label fw-bold">CCCD/CMND <span class="text-danger">*</span></label>
                <input id="cccd" type="text" name="cccd" class="form-control" value="<?php echo htmlspecialchars($detailDkTuoi17->n_cccd); ?>" placeholder="Nhập CCCD/CMND">
            </div>
            <div class="col-md-4 mb-2">
                <label for="namsinh" class="form-label fw-bold">Năm sinh <span class="text-danger">*</span></label>
                <input type="hidden" id="input_namsinh" name="input_namsinh" value="<?php echo htmlspecialchars($detailDkTuoi17->n_namsinh); ?>">
                <div class="input-group">
                    <input type="text" id="select_namsinh" name="select_namsinh" class="form-control namsinh" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailDkTuoi17->n_namsinh); ?>">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="dienthoai" class="form-label fw-bold">Điện thoại</label>
                <input id="dienthoai" type="text" name="dienthoai" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($detailDkTuoi17->n_dienthoai); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="select_dantoc_id" class="form-label fw-bold">Dân tộc</label>
                <input type="hidden" id="input_dantoc_id" name="input_dantoc_id" value="<?php echo htmlspecialchars($detailDkTuoi17->n_dantoc_id); ?>">
                <select id="select_dantoc_id" name="select_dantoc_id" class="select2" data-placeholder="Chọn dân tộc">
                    <option value=""></option>
                    <?php foreach ($this->dantoc as $dt) { ?>
                        <option value="<?php echo $dt['id']; ?>" <?php echo $detailDkTuoi17->n_dantoc_id == $dt['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dt['tendantoc']); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-4">Thông tin hộ khẩu thường trú</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="select_phuongxa_id" class="form-label fw-bold">Phường xã <span class="text-danger">*</span></label>
                <input type="hidden" id="input_phuongxa_id" name="input_phuongxa_id" value="<?php echo htmlspecialchars($detailDkTuoi17->n_phuongxa_id); ?>">
                <select id="select_phuongxa_id" name="select_phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                    <option value=""></option>
                    <?php if (is_array($this->phuongxa)) { ?>
                        <?php foreach ($this->phuongxa as $px) { ?>
                            <option value="<?php echo $px['id']; ?>" <?php echo $detailDkTuoi17->n_phuongxa_id == $px['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="select_thonto_id" class="form-label fw-bold">Thôn tổ</label>
                <input type="hidden" id="input_thonto_id" name="input_thonto_id" value="<?php echo htmlspecialchars($detailDkTuoi17->n_thonto_id); ?>">
                <select id="select_thonto_id" name="select_thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
                <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-4">Thông tin người nhận</h5>
        <div class="row g-3 mb-4">

            <div class="col-md-4 mb-2">
                <label for="namsinh" class="form-label fw-bold">Mã đối tượng<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" id="madoituong" name="madoituong" class="form-control" placeholder="Nhập mã đối tượng" value="<?php echo htmlspecialchars($detailDkTuoi17->n_namsinh); ?>">
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="sotaikhoan" class="form-label fw-bold">Số tài khoản ngân hàng</label>
                <input id="sotaikhoan" type="text" name="sotaikhoan" class="form-control" placeholder="Nhập số tài khoản ngân hàng" value="<?php echo htmlspecialchars($detailDkTuoi17->n_dienthoai); ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label for="dienthoai" class="form-label fw-bold">Ngân hàng</label>
                <select id="nganhang_id" name="nganhang_id" class="custom-select" data-placeholder="Chọn ngân hàng">
                    <option value=""></option>
                    <?php foreach ($this->nganhang as $nh) { ?>
                        <option value="<?php echo $nh['id']; ?>" <?php echo $detailDkTuoi17->n_gioitinh_id == $nh['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nh['ten']); ?></option>
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
                <thead class="table-primary">
                    <tr>
                        <th>Mã hỗ trợ</th>
                        <th>Biến động</th>
                        <th>Chính sách</th>
                        <th>Loại đối tượng</th>
                        <th>Hệ số</th>
                        <th>Mức tiền chuẩn</th>
                        <th>Thực nhận</th>
                        <th>Số quyết định</th>
                        <th>Ngày quyết định</th>
                        <th>Hưởng từ ngày</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th>Chức năng</th>

                    </tr>
                </thead>
                <tbody class="dsThongtintrocap" class="bg-gray">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModalTroCap">
                    <div id="trocap_fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã hỗ trợ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_ma_hotro" name="modal_ma_hotro" class="form-control" placeholder="Nhập mã hỗ trợ">
                                    <label class="error_modal" for="modal_ma_hotro"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Biến động <span class="text-danger">*</span></label>
                                    <select id="modal_bien_dong" name="modal_bien_dong" class="custom-select" data-placeholder="Chọn biến động">
                                        <option value=""></option>
                                        <option value="them_moi">Thêm mới</option>
                                        <option value="cap_nhat">Cập nhật</option>
                                        <option value="huy">Hủy</option>
                                    </select>
                                    <label class="error_modal" for="modal_bien_dong"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Chính sách <span class="text-danger">*</span></label>
                                    <select id="modal_chinh_sach" name="modal_chinh_sach" class="custom-select" data-placeholder="Chọn chính sách">
                                        <option value=""></option>
                                        <?php if (is_array($this->chinhsach) && count($this->chinhsach) > 0) { ?>
                                            <?php foreach ($this->chinhsach as $cs) { ?>
                                                <option value="<?php echo $cs['id']; ?>" data-text="<?php echo htmlspecialchars($cs['ten']); ?>">
                                                    <?php echo htmlspecialchars($cs['ten']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu chính sách</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_chinh_sach"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Loại đối tượng <span class="text-danger">*</span></label>
                                    <select id="modal_loai_doi_tuong" name="modal_loai_doi_tuong" class="custom-select" data-placeholder="Chọn loại đối tượng">
                                        <option value=""></option>
                                        <?php if (is_array($this->loaidoituong) && count($this->loaidoituong) > 0) { ?>
                                            <?php foreach ($this->loaidoituong as $ldt) { ?>
                                                <option value="<?php echo $ldt['id']; ?>" data-text="<?php echo htmlspecialchars($ldt['ten']); ?>">
                                                    <?php echo htmlspecialchars($ldt['ten']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Không có dữ liệu loại đối tượng</option>
                                        <?php } ?>
                                    </select>
                                    <label class="error_modal" for="modal_loai_doi_tuong"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hệ số <span class="text-danger">*</span></label>
                                    <input type="number" id="modal_he_so" name="modal_he_so" class="form-control" placeholder="Nhập hệ số" min="0" step="0.1">
                                    <label class="error_modal" for="modal_he_so"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mức tiền chuẩn <span class="text-danger">*</span></label>
                                    <input type="number" id="modal_muc_tien_chuan" name="modal_muc_tien_chuan" class="form-control" placeholder="Nhập mức tiền chuẩn" min="0">
                                    <label class="error_modal" for="modal_muc_tien_chuan"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thực nhận <span class="text-danger">*</span></label>
                                    <input type="number" id="modal_thuc_nhan" name="modal_thuc_nhan" class="form-control" placeholder="Nhập số tiền thực nhận" min="0">
                                    <label class="error_modal" for="modal_thuc_nhan"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số quyết định hưởng <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_so_quyet_dinh" name="modal_so_quyet_dinh" class="form-control" placeholder="Nhập số quyết định hưởng">
                                    <label class="error_modal" for="modal_so_quyet_dinh"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày quyết định <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_ngay_quyet_dinh" name="modal_ngay_quyet_dinh" class="form-control date-picker" placeholder="Nhập ngày quyết định">
                                    <label class="error_modal" for="modal_ngay_quyet_dinh"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hưởng từ ngày <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_huong_tu_ngay" name="modal_huong_tu_ngay" class="form-control date-picker" placeholder="Nhập ngày bắt đầu hưởng">
                                    <label class="error_modal" for="modal_huong_tu_ngay"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select id="modal_trang_thai" name="modal_trang_thai" class="custom-select" data-placeholder="Chọn trạng thái">
                                        <option value=""></option>
                                        <option value="1">Đang hưởng</option>
                                        <option value="0">Ngừng hưởng</option>
                                    </select>
                                    <label class="error_modal" for="modal_trang_thai"></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <input type="text" id="modal_ghi_chu" name="modal_ghi_chu" class="form-control" placeholder="Nhập ghi chú">
                                    <label class="error_modal" for="modal_ghi_chu"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <input type="hidden" id="modal_trocap_id" name="modal_trocap_id" value="">
                <button type="button" class="btn btn-primary" id="btn_luu_trocap"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
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
        $('#btn_themchinhsach').on('click', function(e) {
            e.preventDefault();
            // const selectedThontoId = $('#thonto_id').val();
            // const selectedNam = $('#nam').val();

            // if (!selectedThontoId || !selectedNam) {
            //     showToast('Vui lòng chọn Thôn/Tổ và Năm trước khi thêm thông tin hưởng trợ cấp', false);
            //     return false;
            // }

            $('#modalTroCapLabel').text('Thêm thông tin hưởng trợ cấp');
            $('#modal_edit_index').val('');
            $('#frmModalTroCap')[0].reset();
            initializeModalSelect2();

            // const selectedPhuongxaId = $('#phuongxa_id').val();
            // $('#modal_phuongxa_id').val(selectedPhuongxaId).prop('disabled', true);
            // $('#modal_thonto_id').html($('#thonto_id').html());
            // $('#modal_thonto_id').val(selectedThontoId).prop('disabled', true);

            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            // Gán giá trị mặc định cho modal_dat
            // $('#modal_dat').val('2').trigger('change.select2');

            $('#modal_search_toggle').prop('checked', true).trigger('change');
            $('#modalTroCap').modal('show');
        });
        // Khởi tạo Datepicker cho các trường ngày
        $('#modalTroCap .date-picker').datepicker({
            autoclose: true,
            language: 'vi',
            format: 'dd/mm/yyyy'
        });

        function updateTroCapSTT() {
            $('.dsThongtintrocap tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
            });
        }

        // Xử lý nút Lưu
        $('#btn_luu_trocap').on('click', function() {
            const $form = $('#frmModalTroCap');
            if ($form.valid()) {
                const formData = $form.serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                });

                // Lấy text từ các dropdown
                const bien_dong_text = $('#modal_bien_dong option:selected').data('text') || $('#modal_bien_dong option:selected').text() || '';
                const chinh_sach_text = $('#modal_chinh_sach option:selected').data('text') || $('#modal_chinh_sach option:selected').text() || '';
                const loai_doi_tuong_text = $('#modal_loai_doi_tuong option:selected').data('text') || $('#modal_loai_doi_tuong option:selected').text() || '';
                const trang_thai_text = $('#modal_trang_thai option:selected').data('text') || $('#modal_trang_thai option:selected').text() || '';

                // Tạo HTML cho dòng mới trong bảng
                const html = `
                <tr>
                    <td class="align-middle text-center stt"></td>
                    <td class="align-middle">${data.modal_ma_hotro || ''}</td>
                    <td class="align-middle">${bien_dong_text}</td>
                    <td class="align-middle">${chinh_sach_text}</td>
                    <td class="align-middle">${loai_doi_tuong_text}</td>
                    <td class="align-middle">${data.modal_he_so || ''}</td>
                    <td class="align-middle">${data.modal_muc_tien_chuan || ''}</td>
                    <td class="align-middle">${data.modal_thuc_nhan || ''}</td>
                    <td class="align-middle">${data.modal_so_quyet_dinh || ''}</td>
                    <td class="align-middle">${data.modal_ngay_quyet_dinh || ''}</td>
                    <td class="align-middle">${data.modal_huong_tu_ngay || ''}</td>
                    <td class="align-middle">${trang_thai_text}</td>
                    <td class="align-middle">${data.modal_ghi_chu || ''}</td>
                    <td class="align-middle text-center">
                        <input type="hidden" name="trocap_id[]" value="${data.modal_trocap_id || ''}" />
                        <input type="hidden" name="ma_hotro[]" value="${data.modal_ma_hotro || ''}" />
                        <input type="hidden" name="bien_dong[]" value="${data.modal_bien_dong || ''}" />
                        <input type="hidden" name="chinh_sach[]" value="${data.modal_chinh_sach || ''}" />
                        <input type="hidden" name="loai_doi_tuong[]" value="${data.modal_loai_doi_tuong || ''}" />
                        <input type="hidden" name="he_so[]" value="${data.modal_he_so || ''}" />
                        <input type="hidden" name="muc_tien_chuan[]" value="${data.modal_muc_tien_chuan || ''}" />
                        <input type="hidden" name="thuc_nhan[]" value="${data.modal_thuc_nhan || ''}" />
                        <input type="hidden" name="so_quyet_dinh[]" value="${data.modal_so_quyet_dinh || ''}" />
                        <input type="hidden" name="ngay_quyet_dinh[]" value="${data.modal_ngay_quyet_dinh || ''}" />
                        <input type="hidden" name="huong_tu_ngay[]" value="${data.modal_huong_tu_ngay || ''}" />
                        <input type="hidden" name="trang_thai[]" value="${data.modal_trang_thai || ''}" />
                        <input type="hidden" name="ghi_chu[]" value="${data.modal_ghi_chu || ''}" />
                        <span class="btn btn-small btn-danger btn_xoa_trocap" data-trocap-id="${data.modal_trocap_id || ''}"><i class="fas fa-trash-alt"></i></span>
                    </td>
                </tr>`;

                // Thêm dòng vào bảng
                $('.dsThongtintrocap').append(html);
                updateTroCapSTT();
                showToast('Thêm thông tin trợ cấp thành công', true);
                $('#modalTroCap').modal('hide');
            } else {
                showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
            }
        });

        // Xử lý nút Xóa trong bảng
        $('.dsThongtintrocap').on('click', '.btn_xoa_trocap', function() {
            const $row = $(this).closest('tr');
            const trocap_id = $(this).data('trocap-id');
            console.log('Xóa thông tin trợ cấp:', trocap_id);
            $row.remove();
            updateTroCapSTT();
            showToast('Xóa thông tin trợ cấp thành công', true);
            if ($('.dsThongtintrocap tr').length === 0) {
                $('.dsThongtintrocap').html('<tr class="no-data"><td colspan="13" class="text-center">Không có dữ liệu</td></tr>');
            }
        });
        // Khởi tạo validate cho form modalTroCap
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
                    modal_so_quyet_dinh: {
                        required: true
                    },
                    modal_ngay_quyet_dinh: {
                        required: true
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
                        required: 'Vui lòng nhập mức tiền chuẩn',
                        number: 'Mức tiền chuẩn phải là số',
                        min: 'Mức tiền chuẩn phải lớn hơn hoặc bằng 0'
                    },
                    modal_thuc_nhan: {
                        required: 'Vui lòng nhập số tiền thực nhận',
                        number: 'Số tiền thực nhận phải là số',
                        min: 'Số tiền thực nhận phải lớn hơn hoặc bằng 0'
                    },
                    modal_so_quyet_dinh: 'Vui lòng nhập số quyết định hưởng',
                    modal_ngay_quyet_dinh: 'Vui lòng nhập ngày quyết định',
                    modal_huong_tu_ngay: 'Vui lòng nhập ngày bắt đầu hưởng',
                    modal_trang_thai: 'Vui lòng chọn trạng thái'
                }
            });
        }

        // Xử lý sự kiện change.select2 cho các dropdown
        $('#modal_bien_dong, #modal_chinh_sach, #modal_loai_doi_tuong, #modal_trang_thai').on('change.select2', function() {
            const $form = $('#frmModalTroCap');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });

        // Xử lý sự kiện input/change cho các trường số và ngày
        $('#modal_ma_hotro, #modal_he_so, #modal_muc_tien_chuan, #modal_thuc_nhan, #modal_so_quyet_dinh, #modal_ngay_quyet_dinh, #modal_huong_tu_ngay').on('change input', function() {
            const $form = $('#frmModalTroCap');
            if ($form.validate) {
                $form.validate().element(this);
            }
        });
    });
</script>

<script>
    const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
    const detailDkTuoi17 = <?php echo json_encode($detailDkTuoi17); ?>;
    const detailphuongxa_id = <?= json_encode($detailDkTuoi17->n_phuongxa_id ?? 0) ?>;
    const detailthonto_id = <?= json_encode($detailDkTuoi17->n_thonto_id ?? 0) ?>;
    let isEditMode = <?php echo ((int)$detailDkTuoi17->id > 0) ? 'true' : 'false'; ?>;
    let isFetchingFromSelect = false;

    $(document).ready(function() {
        $('#btn_quaylai').click(() => {
            window.location.href = '<?php echo Route::_('/index.php/component/vhytgd/?view=doituonghuongcs&task=default'); ?>';
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
        if (detailDkTuoi17 && detailDkTuoi17.n_namsinh) {
            const formattedDate = formatDateToDMY(detailDkTuoi17.n_namsinh);
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
                    url: 'index.php?option=com_vhytgd&task=doituonghuongcs.timkiem_nhankhau&format=json',
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
                    controller: 'doituonghuongcs',
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
            const detailDkTuoi17 = <?php echo json_encode($detailDkTuoi17); ?>;
            if (detailDkTuoi17 && detailDkTuoi17.nhankhau_id) {
                try {
                    const nhankhauResponse = await $.post('index.php', {
                        option: 'com_vhytgd',
                        task: 'doituonghuongcs.timkiem_nhankhau',
                        format: 'json',
                        nhankhau_id: detailDkTuoi17.nhankhau_id,
                    }, null, 'json');

                    if (nhankhauResponse && nhankhauResponse.items && nhankhauResponse.items.length > 0) {
                        const nhankhau = nhankhauResponse.items.find(item => item.id === detailDkTuoi17.nhankhau_id) || nhankhauResponse.items[0];
                        if (nhankhau) {
                            const optionText = `${nhankhau.hoten} - CCCD: ${nhankhau.cccd_so || ''} - Ngày sinh: ${nhankhau.ngaysinh || ''} - Địa chỉ: ${nhankhau.diachi || ''}`;
                            const newOption = new Option(optionText, nhankhau.id, true, true);
                            $('#select_top').append(newOption).trigger('change');

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
                            showToast('Không tìm thấy nhân khẩu phù hợp', false);
                            $('#checkbox_toggle').prop('checked', false).trigger('change');
                        }
                    } else {
                        showToast('Không tìm thấy thông tin nhân khẩu', false);
                        $('#checkbox_toggle').prop('checked', false).trigger('change');
                    }
                } catch (error) {
                    console.error('Fetch nhankhau error:', error);
                    showToast('Lỗi khi tải thông tin nhân khẩu', false);
                }
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

        // validate forrm
        $('#formDoituongCS').validate({
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
                namsinh: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    },
                },
                select_phuongxa_id: {
                    required: function() {
                        return !$('#checkbox_toggle').is(':checked');
                    }
                },
                tinhtrangdangky: {
                    required: true
                }
            },
            messages: {
                select_top: 'Vui lòng chọn nhân khẩu',
                hoten: 'Vui lòng nhập họ và tên',
                cccd: 'Vui lòng nhập CCCD/CMND',
                namsinh: 'Vui lòng chọn năm sinh',
                select_phuongxa_id: 'Vui lòng chọn phường/xã',
                tinhtrangdangky: 'Vui lòng chọn tình trạng đăng ký',
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.closest('.input-group').length) {
                    error.insertAfter(element.closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // submit form chính
        // $('#formDoiTuongCS').on('submit', function(e) {
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
        //                 // setTimeout(() => location.href = "/index.php/component/quansu/?view=doituonghuongcs&task=default", 500);
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
</style>