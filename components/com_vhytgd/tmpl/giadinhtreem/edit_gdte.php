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

<form id="formDkTuoi17" name="formDkTuoi17" method="post" action="<?php echo Route::_('index.php?option=com_quansu&controller=dktuoi17&task=save_dktuoi17'); ?>">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
            <h2 class="text-primary mb-3">
                <?php echo ((int)$detailDkTuoi17->id > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> đăng ký nghĩa vụ quân sự tuổi 17
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
                <select id="select_gioitinh_id" name="select_gioitinh_id" class="select2" data-placeholder="Chọn giới tính">
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
                <select id="select_phuongxa_id" name="select_phuongxa_id" class="select2" data-placeholder="Chọn phường/xã">
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
                <select id="select_thonto_id" name="select_thonto_id" class="select2" data-placeholder="Chọn thôn/tổ">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="diachi" class="form-label fw-bold">Địa chỉ</label>
                <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-4">Thông tin học vấn</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="trinhdohocvan_id" class="form-label fw-bold">Trình độ học vấn</label>
                <select id="trinhdohocvan_id" name="trinhdohocvan_id" class="select2" data-placeholder="Chọn trình độ học vấn">
                    <option value=""></option>
                    <?php if (is_array($this->trinhdohocvan)) { ?>
                        <?php foreach ($this->trinhdohocvan as $tdhv) { ?>
                            <option value="<?php echo $tdhv['id']; ?>"><?php echo htmlspecialchars($tdhv['tentrinhdohocvan']); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-8">
                <label for="diachi" class="form-label fw-bold">Nơi làm việc (học tập, công tác)</label>
                <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>
        </div>

        <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h5 class="">Thông tin nhân thân</h5>
            <button class="btn btn-success btn-themnhanthan">Thêm nhân thân</button>
        </div>
        <div class="row g-3 mb-4">
            <table class="table table-striped table-bordered" style="height: 150px; overflow-y: auto;">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Quan hệ</th>
                        <th>Họ và tên</th>
                        <th>Năm sinh</th>
                        <th>Ngành nghề</th>
                    </tr>
                </thead>
                <tbody class="dsThanNhan" class="bg-gray">
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

        <h5 class="border-bottom pb-2 mb-4">Thông tin sức khỏe và tình trạng đăng ký</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-12">
                <label for="trinhdohocvan_id" class="form-label fw-bold">Tiền sử bệnh tật: Gia đình (trong gia đình có người đã đang mắc bệnh gì)</label>
                <input id="diachi" type="text" name="diachi" class="form-control" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>
            <div class="col-md-12">
                <label for="diachi" class="form-label fw-bold">Bản thân (hiện đang mắc bệnh gì, đã mắc bệnh gì, có dị hình, dị dạng)</label>
                <input id="diachi" type="text" name="diachi" class="form-control" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <label for="diachi" class="form-label fw-bold">Chiều cao</label>
                <div class="input-group">
                    <input id="diachi" type="text" name="diachi" class="form-control" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            <div class="col-md-2">
                <label for="diachi" class="form-label fw-bold">Cân năng</label>
                <div class="input-group">
                    <input id="diachi" type="text" name="diachi" class="form-control" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>

            <div class="col-md-4">
                <label for="diachi" class="form-label fw-bold">Tình trạng đăng ký <span class="text-danger">*</span></label>
                <input id="diachi" type="text" name="diachi" class="form-control" placeholder="Chọn tình trạng" value="<?php echo htmlspecialchars($detailDkTuoi17->n_diachi); ?>">
            </div>

            <div class="col-md-4">
                <label for="diachi" class="form-label fw-bold">Ngày đăng ký</label>
                <div class="input-group">
                    <input type="text" id="ngaydangky" name="ngaydangky" class="form-control ngaydangky" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($detailDkTuoi17->ngaydangky); ?>">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>

<script>
    const phuongxa_id = <?php echo json_encode($this->phuongxa ?? []); ?>;
    const detailDkTuoi17 = <?php echo json_encode($detailDkTuoi17); ?>;
    const detailphuongxa_id = <?= json_encode($detailDkTuoi17->n_phuongxa_id ?? 0) ?>;
    const detailthonto_id = <?= json_encode($detailDkTuoi17->n_thonto_id ?? 0) ?>;
    let isEditMode = <?php echo ((int)$detailDkTuoi17->id > 0) ? 'true' : 'false'; ?>;
    let isFetchingFromSelect = false;

    $(document).ready(function() {
        $('#btn_quaylai').click(() => {
            window.location.href = '<?php echo Route::_('/index.php/component/quansu/?view=dktuoi17&task=default'); ?>';
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
            '#phuongxagioithieu_id', '#trinhdohocvan_id'
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
                    url: 'index.php?option=com_vhytgd&task=laodong.timkiem_nhankhau&format=json',
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
            // $("#formDkTuoi17").datepicker("option", "disabled", true)/
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
                    controller: 'laodong',
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
                        option: 'com_quansu',
                        task: 'dktuoi17.timkiem_nhankhau',
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

            if (!isEditMode) {
                try {
                    const response = await $.post('index.php', {
                        option: 'com_quansu',
                        controller: 'dktuoi17',
                        task: 'checkNhankhauInDSDkTuoi17',
                        nhankhau_id: data.id,
                    }, null, 'json');

                    if (response.exists) {
                        showToast('Nhân khẩu này đã có trong danh sách lao động', false);
                        $('#select_top').val('').trigger('change');
                        return;
                    }
                } catch (error) {
                    console.error('Check nhankhau error:', error);
                    showToast('Lỗi khi kiểm tra trạng thái nhân khẩu', false);
                    return;
                }
            }

            // convert ngày thành dd/mm/yyyy
            function formatDate(dateString) {
                if (!dateString || !/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
                    return '';
                }
                const date = new Date(dateString);
                if (isNaN(date.getTime())) {
                    return '';
                }
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // gán dữ liệu đã chọn từ danh sách nhân khẩu vào trong form
            $('#nhankhau_id').val(data.id || '');
            $('#hoten').val(data.hoten || '');
            $('#input_gioitinh_id').val(data.gioitinh_id || '');
            $('#select_gioitinh_id').val(data.gioitinh_id || '').trigger('change');
            $('#cccd').val(data.cccd_so || '');
            const formattedDate = formatDate(data.ngaysinh);
            if (!formattedDate && data.ngaysinh) {
                showToast('Ngày sinh không hợp lệ', false);
            }
            $('#input_namsinh').val(formattedDate).datepicker('update');
            $('#select_namsinh').val(formattedDate).datepicker('update');
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
        $('#formDkTuoi17').validate({
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
        $('#formDkTuoi17').on('submit', function(e) {
            e.preventDefault();
            if (!$(this).valid()) {
                showToast('Vui lòng nhập đầy đủ thông tin', false);
                return;
            }

            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    const isSuccess = response.success ?? true;
                    showToast(response.message || 'Lưu dữ liệu thành công', isSuccess);
                    if (isSuccess) {
                        // setTimeout(() => location.href = "/index.php/component/quansu/?view=dktuoi17&task=default", 500);
                    }
                },
                error: function(xhr) {
                    console.error('Submit error:', xhr.responseText);
                    showToast('Đã xảy ra lỗi khi gửi dữ liệu', false);
                }
            });
        });

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
</style>