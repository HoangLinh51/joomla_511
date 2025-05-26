<?php
defined('_JEXEC') or die('Restricted access');
$perPage = 20;
$result = $this->countitems;
$totalRecords = $result[0]['tongnhankhau'];
$totalPages = ceil($totalRecords / $perPage);
$currentPage = JFactory::getApplication()->input->getInt('start', 0) / $perPage + 1;

// Tính toán START và END
$startRecord = JFactory::getApplication()->input->getInt('start', 0) + 1;
$endRecord = min($startRecord + $perPage - 1, $totalRecords);
?>

<div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
        <thead>
            <tr style="background-color: #FBFBFB !important;" class="bg-primary text-white">
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">STT</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Số hộ khẩu</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tên chủ hộ</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Giới tính</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Năm sinh</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Chỗ ở hiện nay</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Số điện thoại</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center" style="width:131px;">Chức năng</th>
            </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php
            if (!empty($this->rows)) {
                $stt = JFactory::getApplication()->input->getInt('start', 0) + 1;
                foreach ($this->rows as $item) {
            ?>
                    <tr>
                        <td class="text-center" style="vertical-align: middle"><?php echo $stt++; ?></td>
                        <td style="vertical-align: middle">
                            <?php
                            if (!empty($item['hokhau_so'])) {
                                echo "Số: " . htmlspecialchars($item['hokhau_so']);
                            } else {
                                echo " ";
                            }
                            ?>
                            <br>
                            <?php
                            if (!empty($item['hokhau_ngaycap'])) {
                                echo "Ngày cấp: " . htmlspecialchars($item['hokhau_ngaycap']);
                            } else {
                                echo " ";
                            }
                            ?>
                        </td>
                        <td style="vertical-align: middle">
                            <a href="#" class="hoten-link" data-hokhau="<?php echo $item['id']; ?>">
                                <?php echo htmlspecialchars($item['hotenchuho']); ?>
                            </a>
                        </td>
                        <td style="vertical-align: middle"><?php echo htmlspecialchars($item['tengioitinh']); ?></td>
                        <td style="vertical-align: middle"><?php echo htmlspecialchars($item['namsinh'] ?? ''); ?></td>
                        <td style="vertical-align: middle"><?php echo htmlspecialchars($item['diachi']); ?></td>
                        <td style="vertical-align: middle"><?php echo htmlspecialchars($item['dienthoai']); ?></td>
                        <td class="text-center">
                            <span class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" data-hokhau="<?php echo $item['id']; ?>" data-title="Hiệu chỉnh">
                                <i class="fas fa-pencil-alt"></i>
                            </span>
                            <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
                            <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-hokhau="<?php echo $item['id']; ?>" data-title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Bọc pagination-info và pagination trong một div Flexbox -->
    <div class="pagination-container d-flex align-items-center mt-3">
        <div id="pagination" class="mx-auto">
            <?php if ($totalPages > 1): ?>
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="1">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo max(1, $currentPage - 1); ?>">
                            <</a>
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

        <div class="pagination-info text-right">
            <?php if ($totalRecords > 0): ?>
                Hiển thị <?php echo $startRecord; ?> - <?php echo $endRecord; ?> của tổng cộng <?php echo $totalRecords; ?> mục
                (<?php echo $totalPages; ?> trang)
            <?php else: ?>
                Không có dữ liệu
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Thông tin chi tiết</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detailContent">Đang tải...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">
    <input type="hidden" id="currentPage" value="<?php echo $currentPage; ?>">
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var totalPages = parseInt($('#totalPages').val());
        var currentPage = parseInt($('#currentPage').val());

        // Xử lý click vào phân trang
        $('.pagination').on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
                var start = (page - 1) * <?php echo $perPage; ?>;
                loadDanhSach(start);
            }
        });

        // Xử lý click vào tên chủ hộ
        $(document).on('click', '.hoten-link', function(e) {
            e.preventDefault();
            var hokhauId = $(this).data('hokhau');
            loadDetail(hokhauId);
        });

        // Xử lý click vào tên trong danh sách
        $(document).on('click', '.name-link', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Ẩn tất cả chi tiết và hiển thị chi tiết tương ứng
            $('.detail-item').hide();
            $('#detail-' + id).show();

            // Cập nhật class active
            $('.name-link').removeClass('active');
            $(this).addClass('active');
        });

        // Hàm load danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vptk',
                view: 'nhk',
                format: 'raw',
                task: 'DS_NHK',
                phuongxa_id: $('#phuongxa_id').val() || '',
                hoten: $('#hoten').val() || '',
                gioitinh_id: $('#gioitinh_id').val() || '',
                is_tamtru: $('#is_tamtru').val() || '',
                thonto_id: $('#thonto_id').val() || '',
                hokhau_so: $('#hokhau_so').val() || '',
                daxoa: 0,
                start: start
            };
            console.log('Pagination Params:', params);
            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: params,
                success: function(response) {
                    $('#div_danhsach').html(response);
                    $("#overlay").fadeOut(300);
                    $('#currentPage').val(Math.floor(start / <?php echo $perPage; ?>) + 1);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading danh sach:', xhr.status, error);
                    $("#overlay").fadeOut(300);
                }
            });
        }

        // Hàm load chi tiết
        function loadDetail(hokhauId) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vptk',
                view: 'nhk',
                format: 'raw',
                task: 'DETAIL_NHK',
                hokhau_id: hokhauId
            };
            console.log('Detail Params:', params);
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
        $('<style>.small-alert .bootbox.modal { width: 300px !important; margin: 0 auto; } .small-alert .modal-dialog { width: 300px !important; } .small-alert .modal-footer { display:none } .small-alert .modal-header { height:44px; padding: 7px 20px } .small-alert .modal-body { padding:14px } .success-icon { margin-right: 8px; vertical-align: middle; } </style>').appendTo('head');
       

        $('body').delegate('.btn_xoa', 'click', function() {
            var hokhau_id = $(this).data('hokhau');
            bootbox.confirm({
                title: "<span class='red' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                message: '<span class="red" style="font-size:20px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
                buttons: {
                    confirm: {
                        label: '<i class="icon-ok"></i> Đồng ý',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: '<i class="icon-remove"></i> Không',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result) {
                        console.log('Sending AJAX with hokhau_id:', hokhau_id);
                        $.ajax({
                            url: Joomla.getOptions('system.paths').base + '/index.php?option=com_vptk&task=vptk.delHoKhau&format=raw',
                            type: 'POST',
                            data: {
                                hokhau_id: hokhau_id,
                                [Joomla.getOptions('csrf.token')]: 1
                            },
                            success: function(response) {
                                console.log('AJAX Success:', response);
                                var res = typeof response === 'string' ? JSON.parse(response) : response;
                                var message = res.success ? res.message : 'Xóa thất bại!';
                                var icon = res.success ?
                                    '<svg class="success-icon" width="20" height="20" viewBox="0 0 20 20" fill="green"><path d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zm-1 15.59L4.41 11l1.42-1.42L9 12.17l5.59-5.58L16 8l-7 7z"/></svg>' :
                                    '';
                                bootbox.alert({
                                    title: icon + "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                                    message: '<span style="font-size:20px;">' + message + '</span>',
                                    backdrop: true,
                                    className: 'small-alert',
                                    buttons: {
                                        ok: {
                                            label: 'OK',
                                            className: 'hidden' // Ẩn nút OK
                                        }
                                    },
                                    onShown: function() {
                                        // Tự động đóng sau 2 giây
                                        setTimeout(function() {
                                            bootbox.hideAll();
                                            if (res.success) {
                                                window.location.reload();
                                            }
                                        }, 2000);
                                    }
                                });
                            },
                            error: function(xhr) {
                                console.error('AJAX Error:', xhr.status, xhr.responseText);
                                bootbox.alert({
                                    title: "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                                    message: '<span style="font-size:20px;">Lỗi: ' + xhr.responseText + '</span>',
                                    className: 'small-alert',
                                    buttons: {
                                        ok: {
                                            label: 'OK',
                                            className: 'hidden' // Ẩn nút OK
                                        }
                                    },
                                    onShown: function() {
                                        // Tự động đóng sau 2 giây
                                        setTimeout(function() {
                                            bootbox.hideAll();
                                        }, 2000);
                                    }
                                });
                            }
                        });
                    }
                },
                className: 'custom-bootbox'
            });
        });
    });
</script>

<style>
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

    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .page-link {
        padding: 6px 12px;
        margin: 0 2px;
        color: #007bff;
    }

    .page-link:hover {
        background-color: #e9ecef;
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