<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;


$item = $this->item;
// var_dump($this->gioitinh);

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
<form id="frmGiaDinhVanHoa" name="frmGiaDinhVanHoa" method="post" action="index.php?option=com_vhytgd&controller=giadinhvanhoa&task=saveGiaDinhVanHoa">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
            <?php echo ((int)$item[0]['giadinhvanhoa_id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> gia đình văn hóa
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
                            <strong>Năm <span class="text-danger">*</span></strong>
                            <input type="text" class="form-control yearpicker" id="nam" name="nam" value="<?php echo htmlspecialchars($item[0]['nam']); ?>" placeholder="Chọn năm">
                            <label class="error_modal" for="nam"></label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 style="padding-left:15px;" class="mb-0 fw-bold">Thông tin gia đình
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themthanhvien" data-toggle="modal" data-target="#modalGiaDinhVanHoa"><i class="fas fa-plus"></i> Thêm danh hiệu</button>
            </span>
        </h3>
        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center" rowspan="2" style="width: 80px;">STT</th>
                        <th class="align-middle text-center" rowspan="2">Thông tin cá nhân</th>
                        <th class="align-middle text-center" rowspan="2">Đạt/Không đạt</th>
                        <th class="align-middle text-center" rowspan="2">Gia đình <br>văn hóa tiêu biểu</th>
                        <th class="align-middle text-center" rowspan="2">Lý do không đạt</th>
                        <th class="align-middle text-center" rowspan="2">Ghi chú</th>

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
                                        <strong>Họ tên:</strong> <?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>
                                    </a><br>
                                    <strong>CCCD:</strong> <?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?><br>
                                    <strong>Điện thoại:</strong> <?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?><br>
                                    <strong>Ngày sinh:</strong> <?php echo htmlspecialchars($nk['n_namsinh'] ?? ''); ?><br>
                                    <strong>Giới tính:</strong> <?php echo htmlspecialchars($nk['tengioitinh'] ?? ''); ?>


                                </td>
                                <td class="align-middle"><?php echo ($nk['is_dat'] == 1 ? 'Đạt' : 'Không đạt'); ?></td>
                                <td class="align-middle"><?php echo ($nk['is_giadinhvanhoatieubieu'] == 1 ? 'Có' : 'Không'); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['lydokhongdat'] ?? ''); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?></td>

                                <td class="align-middle text-center">
                                    <input type="hidden" name="nhankhau_id[]" value="<?php echo $nk['nhankhau_id'] ?? ''; ?>" />
                                    <input type="hidden" name="hoten[]" value="<?php echo htmlspecialchars($nk['n_hoten'] ?? ''); ?>" />
                                    <input type="hidden" name="cccd_so[]" value="<?php echo htmlspecialchars($nk['n_cccd'] ?? ''); ?>" />
                                    <input type="hidden" name="dienthoai[]" value="<?php echo htmlspecialchars($nk['n_dienthoai'] ?? ''); ?>" />
                                    <input type="hidden" name="ngaysinh[]" value="<?php echo htmlspecialchars($nk['n_namsinh'] ?? ''); ?>" />
                                    <input type="hidden" name="gioitinh_id[]" value="<?php echo htmlspecialchars($nk['n_gioitinh_id'] ?? ''); ?>" />
                                    <input type="hidden" name="diachi[]" value="<?php echo htmlspecialchars($nk['n_diachi'] ?? ''); ?>" />

                                    <input type="hidden" name="id_giadinhvanhoa[]" value="<?php echo (int)($nk['gdvanhoa2'] ?? '0'); ?>" /> 
                                    <input type="hidden" name="is_search[]" value="<?php echo ($nk['is_ngoai'] == 0 ? '1' : '0'); ?>" />
                                    <input type="hidden" name="is_dat[]" value="<?php echo $nk['is_dat'] ?? '0'; ?>" />
                                    <input type="hidden" name="gdvh_tieubieu[]" value="<?php echo $nk['is_giadinhvanhoatieubieu'] ?? ''; ?>" />
                                    <input type="hidden" name="lydokhongdat[]" value="<?php echo htmlspecialchars($nk['lydokhongdat'] ?? ''); ?>" />
                                    <input type="hidden" name="ghichu[]" value="<?php echo htmlspecialchars($nk['ghichu'] ?? ''); ?>" />

                                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="<?php echo $nk['gdvanhoa2'] ?? ''; ?>"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="no-data">
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="giadinhvanhoa" value="<?php echo (int)$item[0]['giadinhvanhoa_id']; ?>">

        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>

<!-- Modal thông tin thành viên -->
<div class="modal fade" id="modalGiaDinhVanHoa" tabindex="-1" role="dialog" aria-labelledby="modalGiaDinhVanHoaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGiaDinhVanHoaLabel">Thêm thông tin thành viên</h5>
            </div>
            <div class="modal-body">
                <form id="frmModalGiaDinhVanHoa">
                    <input type="hidden" id="modal_edit_index" value="">
                    <div class="mb-3">
                        <label class="form-label">Tìm kiếm công dân <input type="checkbox" id="modal_search_toggle" checked></label>
                    </div>
                    <div id="search_fields">
                        <div class="mb-3">
                            <label class="form-label">Chọn công dân <span class="text-danger"> * </span></label>
                            <select id="modal_nhankhau_search" class="custom-select" data-placeholder="Chọn công dân"></select>
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
                                    <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_ngaysinh" name="modal_ngaysinh" class="form-control date-picker" placeholder="Nhập ngày sinh" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_diachi" name="modal_diachi" class="form-control" placeholder="Nhập địa chỉ" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Đạt/Không đạt <span class="text-danger">*</span></label>
                                    <select id="modal_dat" name="modal_dat" class="custom-select" data-placeholder="Chọn trạng thái" required>
                                        <option value="1">Đạt</option>
                                        <option value="0">Không đạt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="gdvh_tieubieu_container">
                                <div class="mb-3 form-check" style="margin-top: 30px;">
                                    <input type="checkbox" class="form-check-input" id="modal_gdvh_tieubieu" name="modal_gdvh_tieubieu">
                                    <label class="form-check-label" for="modal_gdvh_tieubieu">Gia đình văn hóa tiêu biểu</label>
                                </div>
                            </div>

                            <div class="col-md-6" id="lydo_container" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Lý do không đạt <span class="text-danger">*</span></label>
                                    <input type="text" id="modal_lydokhongdat" name="modal_lydokhongdat" class="form-control" placeholder="Nhập lý do không đạt">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <input type="text" id="modal_ghichu" name="modal_ghichu" class="form-control" placeholder="Ghi chú">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="bnt_dong" data-bs-dismiss="modal" aria-label="Close">X Đóng</button>
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

        const selectElements = $('#thonto_id');
        selectElements.select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });

        $('#btn_dong').on('click', function() {
            $('div.modal-backdrop').css('display', 'none');
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
            $('#modalGiaDinhVanHoa select.custom-select').not('#modal_nhankhau_search').each(function() {
                initSelect2($(this), {
                    width: '100%',
                    allowClear: true,
                    placeholder: $(this).data('placeholder') || 'Chọn một tùy chọn',
                    dropdownParent: $('#modalGiaDinhVanHoa')
                });
            });
        }

        // $('#nam').yearpicker({
        //     year: <?php echo htmlspecialchars($item[0]['nam'] ?: date('Y')); ?>,
        //     startYear: 1900,
        //     endYear: <?php echo date('Y') + 10; ?>,
        //     onChange: function(value) {
        //         $(this).val(value);
        //         $(this).trigger('change'); // Kích hoạt sự kiện change khi chọn năm
        //     }
        // });

        // Hàm load danh sách gia đình văn hóa năm trước
        function loadPreviousYearData(thonto_id, nam) {
            if (!thonto_id || !nam) {
                $('#tblDanhsach tbody').html('<tr class="no-data"><td colspan="7" class="text-center">Vui lòng chọn Thôn/Tổ và Năm</td></tr>');
                return;
            }

            const previousYear = parseInt(nam) - 1;

            $.ajax({
                url: 'index.php?option=com_vhytgd&controller=giadinhvanhoa&task=GiaDinhVH1nam',
                type: 'GET',
                data: {
                    thonto_id: thonto_id,
                    nam: previousYear,
                    [Joomla.getOptions('csrf.token')]: 1
                },
                dataType: 'json',
                beforeSend: function() {
                    // showToast('Đang tải danh sách gia đình văn hóa năm ' + previousYear + '...', true);
                    $('#tblDanhsach tbody').html('<tr><td colspan="7" class="text-center">Đang tải...</td></tr>');
                },
                success: function(response) {
                    let html = '';
                    if (response.success && response.data && response.data.length > 0) {
                        response.data.forEach(function(item, index) {
                            const is_dat = item.is_dat || '0';
                            const gdvh_tieubieu = item.gdvh_tieubieu || '0';
                            const lydokhongdat = item.lydokhongdat || '';
                            const ghichu = item.ghichu || '';
                            const bandieuhanhId = item.bandieuhanh_id || '';

                            html += `
                            <tr>
                                <td class="align-middle text-center stt">${index + 1}</td>
                                <td class="align-middle hoten">
                                    <a href="#" class="edit-nhankhau" data-index="${index}" style="color: blue;">
                                        <strong>Họ tên:</strong> ${item.n_hoten || ''}
                                    </a><br>
                                    <strong>CCCD:</strong> ${item.n_cccd || ''}<br>
                                    <strong>Điện thoại:</strong> ${item.n_dienthoai || ''}<br>
                                    <strong>Giới tính:</strong> ${item.tengioitinh || ''}<br>
                                    <strong>Ngày sinh:</strong> ${item.n_namsinh || ''}
                                </td>
                                <td class="align-middle">${is_dat == '1' ? 'Đạt' : 'Không đạt'}</td>
                                <td class="align-middle">${gdvh_tieubieu == '1' ? 'Có' : 'Không'}</td>
                                <td class="align-middle">${lydokhongdat}</td>
                                <td class="align-middle">${ghichu}</td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="bandieuhanh_id[]" value="${bandieuhanhId}" />
                                    <input type="hidden" name="nhankhau_id[]" value="${item.nhankhau_id || ''}" />
                                    <input type="hidden" name="hoten[]" value="${item.n_hoten || ''}" />
                                    <input type="hidden" name="cccd_so[]" value="${item.n_cccd || ''}" />
                                    <input type="hidden" name="dienthoai[]" value="${item.n_dienthoai || ''}" />
                                    <input type="hidden" name="gioitinh_id[]" value="${item.gioitinh_id || ''}" />
                                    <input type="hidden" name="diachi[]" value="${item.diachi || ''}" />
                                    <input type="hidden" name="ngaysinh[]" value="${item.ngaysinh || ''}" />
                                    <input type="hidden" name="id_giadinhvanhoa[]" value="${item.id_giadinhvanhoa || ''}" />
                                    <input type="hidden" name="is_dat[]" value="${is_dat}" />
                                    <input type="hidden" name="gdvh_tieubieu[]" value="${gdvh_tieubieu}" />
                                    <input type="hidden" name="lydokhongdat[]" value="${lydokhongdat}" />
                                    <input type="hidden" name="ghichu[]" value="${ghichu}" />
                                    <input type="hidden" name="is_search[]" value="${item.is_search || '1'}" />
                                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="${bandieuhanhId}"><i class="fas fa-trash-alt"></i></span>
                                </td>
                            </tr>`;
                        });
                        showToast('Tải danh sách gia đình văn hóa năm ' + previousYear + ' thành công', true);
                    } else {
                        html = '<tr class="no-data"><td colspan="7" class="text-center">Không có dữ liệu gia đình văn hóa năm ' + previousYear + '</td></tr>';
                        // showToast('Không có dữ liệu gia đình văn hóa năm ' + previousYear, false);
                    }
                    $('#tblDanhsach tbody').html(html);
                    updateSTT();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    $('#tblDanhsach tbody').html('<tr class="no-data"><td colspan="7" class="text-center">Lỗi khi tải dữ liệu</td></tr>');
                    showToast('Lỗi khi tải danh sách gia đình văn hóa!', false);
                }
            });
        }
        const $thontoSelect = $('#thonto_id');
        $thontoSelect.select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder') || 'Chọn Thôn/Tổ';
            }
        });
        // Xử lý sự kiện change cho thonto_id và nam
        const isAddGdVanHoaPage = window.location.search.includes('task=add_gdvanhoa');

        if (isAddGdVanHoaPage) {
            // Xử lý sự kiện change cho thonto_id và nam
            const debouncedLoadData = debounce(function(e) {
                const phuongxa_id = $('#phuongxa_id').val();
                const thonto_id = $('#thonto_id').val();
                const nam = $('#nam').val();

                if (!phuongxa_id) {
                    showToast('Vui lòng chọn xã/phường trước!', false);
                    $('#tblDanhsach tbody').html('<tr class="no-data"><td colspan="7" class="text-center">Vui lòng chọn xã/phường</td></tr>');
                    return;
                }

                if (thonto_id && nam && !isNaN(parseInt(nam))) {
                    loadPreviousYearData(thonto_id, nam);
                } else {
                    $('#tblDanhsach tbody').html('<tr class="no-data"><td colspan="7" class="text-center">Vui lòng chọn Thôn/Tổ và nhập Năm hợp lệ</td></tr>');
                }
            }, 500);

            // Gắn sự kiện change cho thonto_id và nam
            $thontoSelect.on('change', debouncedLoadData);
            $('#nam').on('change input', debouncedLoadData);

            // Kích hoạt load dữ liệu nếu thonto_id và nam đã được điền khi tải trang
            if ($('#thonto_id').val() && $('#nam').val() && !isNaN(parseInt($('#nam').val()))) {
                debouncedLoadData({
                    target: $('#thonto_id')[0]
                });
            }
        }
        initSelect2($('#phuongxa_id, #thonto_id, #modal_nhankhau_search'), {
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });

        $('#btn_themthanhvien').on('click', function(e) {
            e.preventDefault();
            const selectedThontoId = $('#thonto_id').val();
            const selectedNam = $('#nam').val();

            if (!selectedThontoId || !selectedNam) {
                showToast('Vui lòng chọn Thôn/Tổ và Năm trước khi thêm danh hiệu', false);
                return false;
            }

            $('#modalGiaDinhVanHoaLabel').text('Thêm danh hiệu');
            $('#modal_edit_index').val('');
            $('#frmModalGiaDinhVanHoa')[0].reset();
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

            // Gán giá trị mặc định cho modal_dat
            // $('#modal_dat').val('2').trigger('change.select2');

            $('#modal_search_toggle').prop('checked', true).trigger('change');
            $('#modalGiaDinhVanHoa').modal('show');
            $('div.modal-backdrop').css('display', 'block');
        });

        $('#modal_search_toggle').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#search_fields').toggle(isChecked);

            // Không vô hiệu hóa các trường dữ liệu khi tìm kiếm
            $('#modal_hoten, #modal_cccd_so,#modal_dienthoai, #modal_diachi,  #modal_gioitinh_id, #modal_ngaysinh').prop('disabled', false);

            if (isChecked) {
                // Khởi tạo Select2 với AJAX cho #modal_nhankhau_search
                $('#modal_hoten, #modal_cccd_so,#modal_dienthoai, #modal_diachi,  #modal_gioitinh_id, #modal_ngaysinh').prop('disabled', true);

                initSelect2($('#modal_nhankhau_search'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                    dropdownParent: $('#modalGiaDinhVanHoa'),
                    minimumInputLength: 2,
                    ajax: {
                        url: 'index.php?option=com_vhytgd&controller=giadinhvanhoa&task=getThanhVienGiaDinhVanHoa',
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term,
                                thonto_id: $('#thonto_id').val(),
                                nam: $('#nam').val(),
                                [Joomla.getOptions('csrf.token')]: 1
                            };
                        },
                        processResults: function(data, params) {
                            var results = [];
                            if (data && Array.isArray(data) && data.length > 0) {
                                results = data.map(function(v) {
                                    return {
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

                if ($('#modal_nhankhau_id').val()) {
                    const selectedId = $('#modal_nhankhau_id').val();
                    $('#modal_nhankhau_search').val(selectedId).trigger('change.select2');
                } else {
                    $('#modal_nhankhau_search').val('').trigger('change.select2');
                }
            } else {
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_dat').val('2').trigger('change.select2');
                $('#modal_ghichu').val('');
                initializeModalSelect2();
            }
        });

        $('#modal_nhankhau_search').on('change', function(e) {
            var selectedData = $(this).select2('data')[0] || $(this).data('select2-data');
            if (selectedData && selectedData.id && selectedData.data) {
                $('#modal_hoten').val(selectedData.data.hoten || '');
                $('#modal_nhankhau_id').val(selectedData.data.id || '');
                $('#modal_cccd_so').val(selectedData.data.cccd_so || '');
                $('#modal_dienthoai').val(selectedData.data.dienthoai || '');
                $('#modal_diachi').val(selectedData.data.diachi || '');
                $('#modal_ngaysinh').val(selectedData.data.ngaysinh || '');
                var gioitinh_id = selectedData.data.gioitinh_id;
                if (!gioitinh_id && selectedData.data.gioitinh_text) {
                    $('#modal_gioitinh_id option').each(function() {
                        if ($(this).data('text') === selectedData.data.gioitinh_text) {
                            gioitinh_id = $(this).val();
                        }
                    });
                }
                $('#modal_gioitinh_id').val(gioitinh_id || '').trigger('change.select2'); // Không gán is_dat từ AJAX vì nó được nhập riêng
                $('#modal_dat').val('2').trigger('change.select2');
            } else {
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_ngaysinh, #modal_nhankhau_id').val('');
                $('#modal_nhankhau_id').val('');
                $('#modal_gioitinh_id').val('').trigger('change.select2');
                $('#modal_dat').val('2').trigger('change.select2');
                $('#modal_ghichu').val('');
            }
        });

        $('#modal_dat').on('change', function() {
            const isDat = $(this).val() === '1';
            $('#gdvh_tieubieu_container').toggle(isDat);
            if (!isDat) {
                $('#modal_gdvh_tieubieu').prop('checked', false);
            }
            $('#lydo_container').toggle(!isDat);
            $('#modal_lydokhongdat').prop('required', !isDat);
        });

        $('#modalGiaDinhVanHoa').on('show.bs.modal', function() {
            const isDat = $('#modal_dat').val() === '1';
            $('#gdvh_tieubieu_container').toggle(isDat);
            $('#lydo_container').toggle(!isDat);
            $('#modal_lydokhongdat').prop('required', !isDat);
        });

        $('#btn_luu_nhankhau').on('click', function() {
            if ($('#frmModalGiaDinhVanHoa').valid()) {
                const editIndex = $('#modal_edit_index').val();
                const isEditing = editIndex !== '';
                const isSearch = $('#modal_search_toggle').is(':checked');
                const isDat = $('#modal_dat').val() === '1';
                const lydo = $('#modal_lydokhongdat').val().trim();

                if (!isDat && !lydo) {
                    showToast('Vui lòng nhập lý do không đạt', false);
                    $('#modal_lydokhongdat').focus();
                    return false;
                }

                $('#tblDanhsach tbody tr.no-data').remove();

                const stt = isEditing ? parseInt($($('#tblDanhsach tbody tr')[editIndex]).find('.stt').text()) : $('#tblDanhsach tbody tr').length + 1;

                let nhankhauId, hoten, cccd_so, dienthoai, gioitinh_id, gioitinh_text, diachi, ngaysinh, id_giadinhvanhoa, bandieuhanhId;
                if (isSearch) {
                    const selectedData = $('#modal_nhankhau_search').select2('data')[0] || $('#modal_nhankhau_search').data('select2-data');
                    if (selectedData && selectedData.id && selectedData.data) {
                        nhankhauId = selectedData.data.nhankhau_id || '';
                        hoten = selectedData.data.hoten || '';
                        cccd_so = selectedData.data.cccd_so || '';
                        dienthoai = selectedData.data.dienthoai || '';
                        gioitinh_id = selectedData.data.gioitinh_id || '';
                        gioitinh_text = selectedData.data.gioitinh_text || $('#modal_gioitinh_id option:selected').data('text') || '';
                        diachi = selectedData.data.diachi || '';
                        ngaysinh = selectedData.data.ngaysinh || '';
                    } else {
                        showToast('Vui lòng chọn một thành viên!', false);
                        return false;
                    }
                } else {
                    nhankhauId = $('#modal_nhankhau_id').val() || '';
                    hoten = $('#modal_hoten').val() || '';
                    cccd_so = $('#modal_cccd_so').val() || '';
                    dienthoai = $('#modal_dienthoai').val() || '';
                    gioitinh_id = $('#modal_gioitinh_id').val() || '';
                    gioitinh_text = $('#modal_gioitinh_id option:selected').data('text') || '';
                    diachi = $('#modal_diachi').val() || '';
                    ngaysinh = $('#modal_ngaysinh').val() || '';
                }

                // Kiểm tra nhankhauId
                if (!nhankhauId) {
                    showToast('Vui lòng nhập hoặc chọn ID nhân khẩu!', false);
                    $('#modal_nhankhau_id').focus();
                    return false;
                }

                const is_dat = $('#modal_dat').val() || '0';
                const gdvh_tieubieu = isDat ? ($('#modal_gdvh_tieubieu').is(':checked') ? '1' : '0') : '0';
                const lydokhongdat = isDat ? '' : $('#modal_lydokhongdat').val() || '';
                const ghichu = $('#modal_ghichu').val() || '';
                id_giadinhvanhoa = isEditing ? ($('#tblDanhsach tbody tr').eq(editIndex).find('input[name="id_giadinhvanhoa[]"]').val() || $('input[name="id_giadinhvanhoa"]').val() || '0') : ($('input[name="id_giadinhvanhoa"]').val() || '0');
                bandieuhanhId = isEditing ? ($('#tblDanhsach tbody tr').eq(editIndex).find('.btn_xoa').data('xuly') || '') : '';

                const str = `
            <tr>
                <td class="align-middle text-center stt">${stt}</td>
                <td class="align-middle hoten">
                    <a href="#" class="edit-nhankhau" data-index="${isEditing ? editIndex : $('#tblDanhsach tbody tr').length}" style="color: blue;">
                        <strong>Họ tên:</strong> ${hoten}
                    </a><br>
                    <strong>CCCD:</strong> ${cccd_so}<br>
                    <strong>Điện thoại:</strong> ${dienthoai}<br>
                    <strong>Giới tính:</strong> ${gioitinh_text}<br>
                    <strong>Ngày sinh:</strong> ${ngaysinh}
                </td>
                <td class="align-middle">${is_dat === '1' ? 'Đạt' : 'Không đạt'}</td>
                <td class="align-middle">${gdvh_tieubieu === '1' ? 'Có' : 'Không'}</td>
                <td class="align-middle">${lydokhongdat}</td>
                <td class="align-middle">${ghichu}</td>
                <td class="align-middle text-center">
                    <input type="hidden" name="bandieuhanh_id[]" value="${bandieuhanhId}" />
                    <input type="hidden" name="nhankhau_id[]" value="${nhankhauId}" />
                    <input type="hidden" name="hoten[]" value="${hoten}" />
                    <input type="hidden" name="cccd_so[]" value="${cccd_so}" />
                    <input type="hidden" name="dienthoai[]" value="${dienthoai}" />
                    <input type="hidden" name="gioitinh_id[]" value="${gioitinh_id}" />
                    <input type="hidden" name="diachi[]" value="${diachi}" />
                    <input type="hidden" name="ngaysinh[]" value="${ngaysinh}" />
                    <input type="hidden" name="id_giadinhvanhoa[]" value="${id_giadinhvanhoa}" />
                    <input type="hidden" name="is_dat[]" value="${is_dat}" />
                    <input type="hidden" name="gdvh_tieubieu[]" value="${gdvh_tieubieu}" />
                    <input type="hidden" name="lydokhongdat[]" value="${lydokhongdat}" />
                    <input type="hidden" name="ghichu[]" value="${ghichu}" />
                    <input type="hidden" name="is_search[]" value="${isSearch ? '1' : '0'}" />
                    <span class="btn btn-small btn-danger btn_xoa" data-xuly="${bandieuhanhId}"><i class="fas fa-trash-alt"></i></span>
                </td>
            </tr>`;

                try {
                    if (isEditing) {
                        $($('#tblDanhsach tbody tr')[editIndex]).replaceWith(str);
                    } else {
                        $('#tblDanhsach tbody').append(str);
                    }

                    updateSTT();
                    $('#modalGiaDinhVanHoa').modal('hide');
                    $('div.modal-backdrop').css('display', 'none');
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

            const hoten = $row.find('input[name="hoten[]"]').val() || '';
            const cccd_so = $row.find('input[name="cccd_so[]"]').val() || '';
            const dienthoai = $row.find('input[name="dienthoai[]"]').val() || '';
            const diachi = $row.find('input[name="diachi[]"]').val() || '';
            const ngaysinh = $row.find('input[name="ngaysinh[]"]').val() || '';
            const gioitinh_id = $row.find('input[name="gioitinh_id[]"]').val() || '';
            const is_dat = $row.find('input[name="is_dat[]"]').val() || '0'; // Sửa từ '2' thành '0' để đồng bộ với giá trị 'Không đạt'
            const gdvh_tieubieu = $row.find('input[name="gdvh_tieubieu[]"]').val() || '0';
            const lydokhongdat = $row.find('input[name="lydokhongdat[]"]').val() || '';
            const ghichu = $row.find('input[name="ghichu[]"]').val() || '';

            const phuongxa_id = $row.find('input[name="phuongxa_id[]"]').val() || $('#phuongxa_id').val();
            const thonto_id = $row.find('input[name="thonto_id[]"]').val() || $('#thonto_id').val();

            $('#modalGiaDinhVanHoaLabel').text('Hiệu chỉnh thông tin danh hiệu');
            $('#modal_edit_index').val(index);

            initializeModalSelect2();

            $('#modal_phuongxa_id').val(phuongxa_id).prop('disabled', true);
            $('#modal_thonto_id').html($('#thonto_id').html());
            $('#modal_thonto_id').val(thonto_id).prop('disabled', true);

            initSelect2($('#modal_phuongxa_id, #modal_thonto_id'), {
                width: '100%',
                allowClear: false,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });
            $('#modal_search_toggle').prop('checked', isSearch);
            if (isSearch) {
                $('#search_fields').show();
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id').prop('disabled', true);
            } else {
                $('#search_fields').hide();
                $('#modal_hoten, #modal_cccd_so, #modal_dienthoai, #modal_diachi, #modal_gioitinh_id').prop('disabled', false);
            }
            $('#modal_nhankhau_id').val(nhankhauId);

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
                        ngaysinh,
                        gioitinh_id,
                        gioitinh_text
                    }
                };

                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html(`<option value="${selectedOption.id}">${selectedOption.text}</option>`);

                initSelect2($('#modal_nhankhau_search'), {
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Nhập tên hoặc CCCD để tìm kiếm',
                    dropdownParent: $('#modalGiaDinhVanHoa'),
                    minimumInputLength: 2,
                    ajax: {
                        url: 'index.php?option=com_vhytgd&controller=giadinhvanhoa&task=getThanhVienGiaDinhVanHoa',
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term,
                                thonto_id: $('#thonto_id').val(),
                                nam: $('#nam').val(),
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
                    },
                    templateSelection: function(selection) {
                        return selection.text || selection.id;
                    },
                    templateResult: function(result) {
                        return result.text || result.id;
                    }
                });

                $('#modal_nhankhau_search').data('select2-data', selectedOption).val(selectedOption.id).trigger('change.select2');
            } else {
                if ($('#modal_nhankhau_search').data('select2')) {
                    $('#modal_nhankhau_search').select2('destroy');
                }
                $('#modal_nhankhau_search').html('<option value=""></option>');
            }

            $('#modalGiaDinhVanHoa').one('shown.bs.modal', function() {
                $('#modal_hoten').val(hoten);
                $('#modal_cccd_so').val(cccd_so);
                $('#modal_dienthoai').val(dienthoai);
                $('#modal_diachi').val(diachi);
                $('#modal_ngaysinh').val(ngaysinh);
                $('#modal_gioitinh_id').val(gioitinh_id).trigger('change.select2');
                $('#modal_dat').val(is_dat).trigger('change.select2');
                $('#modal_gdvh_tieubieu').prop('checked', gdvh_tieubieu === '1');
                $('#modal_lydokhongdat').val(lydokhongdat);
                $('#modal_ghichu').val(ghichu);

                // Thiết lập hiển thị container dựa trên is_dat
                const isDat = is_dat === '1';
                $('#gdvh_tieubieu_container').toggle(isDat);
                $('#lydo_container').toggle(!isDat);
                $('#modal_lydokhongdat').prop('required', !isDat);
            });

            $('#modalGiaDinhVanHoa').modal('show');
            $('div.modal-backdrop').css('display', 'block');
        });

        $('body').on('click', '.btn_xoa', function() {
            var $row = $(this).closest('tr');
            var giadinh_id = $(this).data('xuly');

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
                        if (giadinh_id) {
                            $.post('index.php', {
                                option: 'com_vhytgd',
                                controller: 'giadinhvanhoa',
                                task: 'delGiaDinhVanHoa',
                                giadinh_id: giadinh_id,
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
            $('#frmModalGiaDinhVanHoa').validate({
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
                    modal_ngaysinh: {
                        required: function() {
                            return !$('#modal_search_toggle').is(':checked');
                        }
                    },
                    modal_dat: {
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
                    modal_ngaysinh: 'Nhập ngày sinh',
                    modal_dat: 'Chọn trạng thái Đạt/Không đạt'
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
                    nam: {
                        required: true,
                        digits: true,
                        min: 1900,
                        max: <?php echo date('Y') + 10; ?>
                    }
                },
                messages: {
                    phuongxa_id: 'Chọn Phường/Xã',
                    thonto_id: 'Chọn Thôn/Tổ',
                    nam: {
                        required: 'Vui lòng nhập năm',
                        digits: 'Năm phải là số nguyên',
                        min: 'Năm phải từ 1900 trở lên',
                        max: 'Năm không được vượt quá <?php echo date('Y') + 10; ?>'
                    }
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
            $('#frmModalGiaDinhVanHoa').trigger('reset');
            $('#frmModalGiaDinhVanHoa select').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
                if ($(this).attr('id') !== 'modal_dat' && $(this).attr('id') !== 'modal_gioitinh_id') {
                    $(this).val('').html('<option value=""></option>');
                }
            });

            if ($('#frmModalGiaDinhVanHoa').data('validator')) {
                $('#frmModalGiaDinhVanHoa').validate().resetForm();
            }

            $('#frmModalGiaDinhVanHoa .error_modal').remove();

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
                dropdownParent: $('#modalGiaDinhVanHoa'),
                minimumInputLength: 2,
                ajax: {
                    url: 'index.php?option=com_vhytgd&controller=giadinhvanhoa&task=getThanhVienGiaDinhVanHoa',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            thonto_id: $('#thonto_id').val(),
                            nam: $('#nam').val(),
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
            $('#frmModalGiaDinhVanHoa').trigger('reset');
            $('#frmModalGiaDinhVanHoa').validate().resetForm();
            $('#frmModalGiaDinhVanHoa .error_modal').remove();
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

        $('#modalGiaDinhVanHoa').on('hidden.bs.modal', function() {
            resetModal();
        });

        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vhytgd/?view=giadinhvanhoa&task=default';
        });

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

    /* CSS cụ thể cho #modalGiaDinhVanHoa */
    #modalGiaDinhVanHoa .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        word-break: break-word;
    }

    #modalGiaDinhVanHoa .select2-container .select2-selection--single {
        height: 38px;
    }

    #modalGiaDinhVanHoa .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        padding-left: 8px;
    }

    #modalGiaDinhVanHoa .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    #modalGiaDinhVanHoa {
        overflow-x: hidden;
    }

    #modalGiaDinhVanHoa .modal-dialog {
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

    #modalGiaDinhVanHoa.show .modal-dialog {
        transform: translateX(0);
    }

    #modalGiaDinhVanHoa.fade .modal-dialog {
        transition: transform 0.5s ease-in-out;
        opacity: 1;
    }

    #modalGiaDinhVanHoa.fade:not(.show) .modal-dialog {
        transform: translateX(100%);
    }

    #modalGiaDinhVanHoa .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #modalGiaDinhVanHoa .error_modal {
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