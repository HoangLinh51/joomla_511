<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$perPage = 20;
$totalRecords = $this->total;
$totalPages = $totalRecords > 0 ? ceil($totalRecords / $perPage) : 0;
$currentPage = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) / $perPage + 1) : 0;
$startRecord = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) + 1) : 0;
$trangthai = Core::loadAssocList('dmlydo', 'ten, id', 'trangthai = 1 AND daxoa = 0 AND is_loai = 4');

?>

<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>

<div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
        <thead>
            <tr class="bg-primary text-white">
                <th style="vertical-align:middle;" class="text-center">STT</th>
                <th style="vertical-align:middle;" class="text-center">Thông tin đối tượng hưởng</th>
                <th style="vertical-align:middle;" class="text-center">Địa chỉ</th>
                <th style="vertical-align:middle;" class="text-center">Thông tin hưởng</th>
                <th style="vertical-align:middle;" class="text-center">Trạng thái</th>
                <th style="vertical-align:middle; width:131px;" class="text-center">Chức năng</th>
            </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php if (!empty($this->items)): ?>
                <?php foreach ($this->items as $i => $item): ?>
                    <tr>
                        <td style="vertical-align:middle;text-align: center;"><?php echo $startRecord + $i; ?></td>
                        <td style="vertical-align:middle;">
                            <strong class="label">Họ và tên:</strong><?php echo htmlspecialchars($item['n_hoten']); ?><br>
                            <strong class="label">Ngày sinh:</strong><?php echo htmlspecialchars($item['ngaysinh']); ?><br>
                            <strong class="label">CCCD/CMND:</strong><?php echo htmlspecialchars($item['n_cccd']); ?><br>
                            <strong class="label">Giới tính:</strong><?php echo htmlspecialchars($item['tengioitinh']); ?><br>
                        </td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['phuongxathonto']); ?></td>
                        <td style="vertical-align:middle;text-align: center;">
                            <span><?php echo htmlspecialchars($item['total_loaidoituong']); ?></span>
                            <i class="fas fa-eye btn_eye" style="cursor: pointer; margin-left: 10px; color: #007bff;" data-id="<?php echo $item['id']; ?>" title="Xem chi tiết"></i>
                        </td>
                        <td style="vertical-align:middle;">
                            <?php
                            $color = '';

                            // Kiểm tra trangthai_id
                            if ($item['trangthai_id'] == 17) {
                                $color = 'class="badge bg-success"'; // Màu xanh lá
                            } elseif ($item['trangthai_id'] == 16 || $item['trangthai_id'] == 18) {
                                $color = 'class="badge bg-secondary"'; // Màu xám
                            }

                            // Kiểm tra nếu tentrangthaicathuong không có hoặc rỗng
                            if (empty($item['tentrangthaicathuong'])) {
                                // Nếu không có, hiển thị trangthai_id với màu đã xác định
                                echo '<span ' . $color . '>' . htmlspecialchars($item['tentrangthai']) . '</span>';
                            } else {
                                // Nếu có, hiển thị tentrangthaicathuong với màu đỏ
                                echo '<span class="badge bg-danger">' . htmlspecialchars($item['tentrangthaicathuong']) . '</span>'; // Màu đỏ
                            }
                            ?>
                        </td>

                        <td style="vertical-align:middle;text-align: center;">
                            <div class="btn-group" role="group">
                                <span class="btn btn-sm btn_cathuong" data-id="<?php echo $item['id']; ?>" data-title="Cắt hưởng" style="cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <span style="padding: 0 5px;font-size:20px;color:#ccc">|</span>
                                <span class="btn btn-sm btn_hieuchinh" data-id="<?php echo $item['id']; ?>" data-title="Hiệu chỉnh" style="cursor: pointer;">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                                <span style="padding: 0 5px;font-size:20px;color:#ccc">|</span>
                                <span class="btn btn-sm btn_xoa" data-id="<?php echo $item['id']; ?>" data-title="Xóa" style="cursor: pointer;">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="pagination-container d-flex align-items-right mt-3">
        <div id="pagination" class="mx-auto">
            <?php if ($totalPages > 0): ?>
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="1">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo max(1, $currentPage - 1); ?>">
                            < </a>
                    </li>
                    <?php
                    $range = 2;
                    $startPage = max(1, $currentPage - $range);
                    $endPage = min($totalPages, $currentPage + $range);

                    if ($startPage > 1) {
                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                    ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php
                    }

                    if ($endPage < $totalPages) {
                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                    }
                    ?>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo min($totalPages, $currentPage + 1); ?>">></a>
                    </li>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo $totalPages; ?>">>></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        <div id="pagination-info" class="pagination-info text-left">
            <?php if ($totalRecords > 0): ?>
                Hiển thị <?php echo $startRecord; ?> - <?php echo min($startRecord + count($this->items) - 1, $totalRecords); ?> của tổng cộng <?php echo $totalRecords; ?> mục
                (<?php echo $totalPages; ?> trang)
            <?php else: ?>
                Không có dữ liệu
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Thông tin hưởng chi tiết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detailContent">Đang tải...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cutModal" tabindex="-1" role="dialog" aria-labelledby="cutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cutModalLabel">Cắt hưởng trợ cấp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCutThongtinhuongcs">
                    <input type="hidden" name="trocap_id" id="cut_trocap_id">
                    <div class="form-group">
                        <label for="cut_trangthaich_id" class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                        <select class="custom-select" name="trangthaich_id" id="cut_trangthaich_id" required>
                            <option value="">--Chọn trạng thái cắt hưởng--</option>
                            <?php foreach ($trangthai as $tt) { ?>
                                <option value="<?php echo $tt['id']; ?>"><?php echo htmlspecialchars($tt['ten']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cut_ngaycat" class="form-label fw-bold">Thời điểm cắt hưởng <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" name="ngaycat" id="cut_ngaycat" placeholder="dd/mm/yyyy" required>
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cut_lydo" class="form-label fw-bold">Lý do cắt hưởng <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="lydo" id="cut_lydo" rows="4" placeholder="Vui lòng nhập lý do cắt hưởng của đối tượng" required></textarea>
                    </div>
                    <input type="hidden" name="is_update" id="cut_is_update" value="0">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btn_save_cathuong">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var totalPages = <?php echo $totalPages; ?>;
        var perPage = <?php echo $perPage; ?>;

        function loadDetail(chinhsachID) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vhytgd',
                view: 'nguoicocong',
                format: 'raw',
                task: 'DETAIL_NCC',
                doituong_id: chinhsachID
            };
            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: params,
                success: function(response) {
                    $('#detailContent').html(response);
                    $('#detailModal').modal('show');
                    $("#overlay").fadeOut(300);
                },
                error: function(xhr, status, error) {
                    $('#detailContent').html('<p class="text-danger">Lỗi khi tải thông tin: ' + error + '</p>');
                    $('#detailModal').modal('show');
                    $("#overlay").fadeOut(300);
                }
            });
        }
        // Khởi tạo datepicker
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            language: 'vi'
        });
        $('body').on('click', '.btn_eye', function(e) {
            e.preventDefault();
            var chinhsachID = $(this).data('id');
            loadDetail(chinhsachID);
        });
        $('<style>.small-alert .bootbox.modal { width: 300px !important; margin: 0 auto; } .small-alert .modal-dialog { width: 300px !important; } .small-alert .modal-footer { display:none } .small-alert .modal-header { height:44px; padding: 7px 20px } .small-alert .modal-body { padding:14px } .success-icon { margin-right: 8px; vertical-align: middle; } </style>').appendTo('head');
        // Khởi tạo Select2 cho trạng thái
        $('#cut_trangthaich_id').select2({
            placeholder: '--Chọn trạng thái cắt hưởng--',
            allowClear: true,
            width: '100%'
        });

        // Hàm format ngày
        function formatDateToDMY(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            if (isNaN(date)) return dateStr; // Trả về nguyên gốc nếu không parse được
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Hàm hiển thị thông báo
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

        // Hàm cập nhật số thứ tự
        function updateSTT() {
            $('#tblDanhsach tbody tr').each(function(index) {
                $(this).find('.stt').text(index + 1);
            });
        }

        // Hàm load danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vhytgd',
                view: 'nguoicocong',
                format: 'raw',
                task: 'DS_NCC',
                phuongxa_id: $('#phuongxa_id').val(),
                thonto_id: $('#thonto_id').val(),
                cccd: $('#cccd').val(),
                hoten: $('#hoten').val(),
                daxoa: 0,
                start: start
            };
            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: params,
                success: function(response) {
                    $('#div_danhsach').html(response);
                    $("#overlay").fadeOut(300);
                    $('#currentPage').val(Math.floor(start / perPage) + 1);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading danh sach:', xhr.status, error);
                    showToast('Lỗi khi tải danh sách', false);
                    $("#overlay").fadeOut(300);
                }
            });
        }

        // Khởi tạo jQuery Validate cho form cắt hưởng
        $('#frmCutThongtinhuongcs').validate({
            ignore: [],
            rules: {
                trangthaich_id: {
                    required: true
                },
                ngaycat: {
                    required: true
                },
                lydo: {
                    required: true
                }
            },
            messages: {
                trangthaich_id: 'Vui lòng chọn trạng thái cắt hưởng',
                ngaycat: 'Vui lòng nhập thời điểm cắt hưởng',
                lydo: 'Vui lòng nhập lý do cắt hưởng'
            },
            errorPlacement: function(error, element) {
                if (element.is('select')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.closest('.input-group').length) {
                    error.insertAfter(element.closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
        });

        // Xử lý click nút cắt hưởng
        $('body').on('click', '.btn_cathuong', function() {
            const doituong_id = $(this).data('id');

            // Reset form và validate
            $('#frmCutThongtinhuongcs').validate().resetForm();
            $('#frmCutThongtinhuongcs').find('.is-invalid').removeClass('is-invalid');
            $('#frmCutThongtinhuongcs').find('.is-valid').removeClass('is-valid');

            $.ajax({
                url: 'index.php?option=com_vhytgd&task=nguoicocong.checkCatHuong',
                type: 'GET',
                data: {
                    doituong_id: doituong_id
                },
                dataType: 'json',
                success: function(response) {

                    // Reset form
                    $('#cut_trocap_id').val(doituong_id);
                    $('#cut_trangthaich_id').val('').trigger('change.select2');
                    $('#cut_ngaycat').val('');
                    $('#cut_lydo').val('');
                    $('#cut_is_update').val('0');
                    $('#cutModal .modal-title').text('Cắt hưởng trợ cấp');

                    if (response.hasData && response.data.length > 0) {
                        const cathuongData = response.data[0]; // Lấy phần tử đầu tiên
                        $('#cut_trangthaich_id').val(cathuongData.trangthaich_id || '').trigger('change.select2');
                        $('#cut_ngaycat').val(formatDateToDMY(cathuongData.ngaycat) || '');
                        $('#cut_lydo').val(cathuongData.lydo || '');
                        $('#cut_is_update').val('1');
                        $('#cutModal .modal-title').text('Cập nhật cắt hưởng trợ cấp');
                    }


                    // Hiển thị modal
                    $('#cutModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error checking cathuong data:', xhr.status, error, xhr.responseText);
                    showToast('Lỗi khi tải dữ liệu cắt hưởng', false);
                }
            });
        });
        $('body').on('click', '.btn_xoa', function() {
            const chinhsach_id = $(this).data('id');

            // Hàm hiển thị thông báo


            // Hàm cập nhật số thứ tự (nếu sử dụng cột STT)
            function updateSTT() {
                $('#tblDanhsach tbody tr').each(function(index) {
                    $(this).find('.stt').text(index + 1);
                });
            }

            // Xác nhận xóa
            bootbox.confirm({
                title: `<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>`,
                message: `<span style="font-size:20px;">Bạn có chắc chắn muốn xóa thông tin này?</span>`,
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
                className: 'custom-bootbox',
                callback: function(result) {
                    if (!result) return;


                    // Lấy CSRF token an toàn
                    const csrfToken = Joomla.getOptions('csrf.token', '');
                    if (!csrfToken) {
                        showToast('Lỗi: Không tìm thấy CSRF token.', false);
                        return;
                    }

                    // Gửi yêu cầu AJAX
                    $.ajax({
                        url: Joomla.getOptions('system.paths').base + '/index.php?option=com_vhytgd&controller=nguoicocong&task=removeNguoiCoCong',
                        type: 'POST',
                        data: {
                            chinhsach_id: chinhsach_id,
                            [csrfToken]: 1
                        },
                        dataType: 'json',
                        success: function(response) {
                            const message = response.success ?
                                (response.message || 'Xóa thành công') :
                                (response.message || 'Xóa thất bại!');
                            showToast(message, response.success);

                            if (response.success) {
                                // Tính start từ currentPage
                                const currentPage = parseInt($('#currentPage').val()) || 1;
                                const perPage = <?php echo $perPage; ?>;
                                const start = (currentPage - 1) * perPage;

                                // Làm mới bảng và phân trang
                                loadDanhSach(start);

                                // Cập nhật số thứ tự (nếu sử dụng cột STT)
                                updateSTT();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', xhr.status, error);
                            let errorMessage = 'Lỗi hệ thống, vui lòng thử lại sau.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.status === 403) {
                                errorMessage = 'Lỗi: Quyền truy cập bị từ chối hoặc CSRF token không hợp lệ.';
                            }
                            showToast(errorMessage, false);
                        }
                    });
                }
            });
        });
        // Xử lý lưu cắt hưởng
        $('#btn_save_cathuong').on('click', function() {
            const $form = $('#frmCutThongtinhuongcs');
            if ($form.valid()) {
                const formData = $form.serializeArray();
                const data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                });
                const csrfToken = Joomla.getOptions('csrf.token', '');
                if (!csrfToken) {
                    showToast('Lỗi: Không tìm thấy CSRF token.', false);
                    return;
                }
                data[csrfToken] = 1;

                const task = data.is_update === '1' ? 'cutThongtinhuongcs' : 'cutThongtinhuongcs';

                $.ajax({
                    url: Joomla.getOptions('system.paths').base + '/index.php?option=com_vhytgd&controller=nguoicocong&task=' + task,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        const message = response.success ?
                            (response.message || 'Cắt hưởng thành công') :
                            (response.message || 'Cắt hưởng thất bại!');
                        showToast(message, response.success);
                        if (response.success) {
                            $('#cutModal').modal('hide');
                            const currentPage = parseInt($('#currentPage').val()) || 1;
                            const start = (currentPage - 1) * perPage;
                            loadDanhSach(start);
                            updateSTT();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Cut AJAX Error:', xhr.status, error, xhr.responseText);
                        let errorMessage = 'Lỗi hệ thống, vui lòng thử lại sau.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 403) {
                            errorMessage = 'Lỗi: Quyền truy cập bị từ chối hoặc CSRF token không hợp lệ.';
                        }
                        showToast(errorMessage, false);
                    }
                });
            } else {
                showToast('Vui lòng điền đầy đủ các trường bắt buộc', false);
            }
        });
    });
</script>

<style>
    .modal {
        overflow-x: hidden;
    }

    .label {
        padding-right: 5px;
        /* Khoảng cách bên phải */
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
        font-size: 15px;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-header,
    .modal-footer {
        padding: 15px 20px;
    }

    .name-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .name-list ul {
        margin: 0;
        padding: 0;
    }

    .name-list li {
        margin-bottom: 5px;
    }

    .name-link {
        display: block;
        padding: 5px 10px;
        color: #007bff;
        text-decoration: none;
        border-radius: 4px;
    }

    .name-link:hover {
        background-color: #f0f0f0;
        text-decoration: none;
    }

    .name-link.active {
        background-color: #007bff;
        color: white;
    }

    .detail-container {
        min-height: 300px;
    }

    .hoten-link {
        color: #007bff;
        text-decoration: none;
        cursor: pointer;
    }

    .hoten-link:hover {
        text-decoration: underline;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .pagination {
        display: inline-flex;
        justify-content: center;
        margin: 0;
    }

    .page-item.disabled .page-link {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .page-link {
        padding: 6px 12px;
        margin: 0 2px;
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: #007b8b
    }

    .pagination-info {
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }


    #detailModal.show .modal-dialog {
        transform: translateX(0);
        /* Trượt vào vị trí */
    }

    /* CSS cho modal Bootbox (.custom-bootbox) */
    /* .custom-bootbox {
    right: 0;
    top: 60%;
    margin: 0;
} */
    .custom-bootbox .modal-dialog {
        /* position: absolute; */
        width: 498px !important;
        /* Kích thước cố định */
        margin: 30px auto !important;
        /* Căn giữa */
        /* transform: none !important; Loại bỏ hiệu ứng trượt */
        /* transition: none !important; Loại bỏ animation */
        transform: translateY(-50%);

    }

    /* Đảm bảo các thuộc tính chung không ảnh hưởng */
    .modal {
        overflow-x: hidden;
    }

    /* .modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
} */

    .modal-header,
    .modal-footer {
        padding: 15px 20px;
    }

    .modal-body {
        padding: 20px;
        word-break: break-word;
    }
</style>