<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

$perPage = 20;
$totalRecords = $this->total;
$totalPages = $totalRecords > 0 ? ceil($totalRecords / $perPage) : 0;
$currentPage = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) / $perPage + 1) : 0;
$startRecord = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) + 1) : 0;

?>

<div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
        <thead>
            <tr style="background-color: #FBFBFB !important;" class="bg-primary text-white">
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">STT</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tổ dân phố/Thôn</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tuyến đường</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tổng số nhà được cấp</th>
                <th style="vertical-align:middle;color:#4F4F4F!important; width:131px;" class="text-center">Chức năng</th>
            </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php if (!empty($this->items)): ?>
                <?php foreach ($this->items as $i => $item): ?>
                    <tr>
                        <td style="vertical-align:middle;text-align: center;"><?php echo $startRecord + $i; ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tenduong']); ?></td>

                        <td style="vertical-align:middle;text-align: center;">
                            <span><?php echo htmlspecialchars($item['so_nguoi']); ?></span>
                            <i class="fas fa-eye btn_eye" style="cursor: pointer; margin-left: 10px; color: #007bff;" data-sonha_id="<?php echo $item['id']; ?>" title="Xem chi tiết"></i>
                        </td>
                        <td style="vertical-align:middle;text-align: center;">
                            <div class="btn-group" role="group">
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
                    <td colspan="5" class="text-center">Không có dữ liệu</td>
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
                <h5 class="modal-title" id="detailModalLabel">Thông tin chi tiết</h5>
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


<input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">
<input type="hidden" id="currentPage" value="<?php echo $currentPage; ?>">
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var totalPages = parseInt($('#totalPages').val());
        var currentPage = parseInt($('#currentPage').val());


        function loadDetail(sonhaID) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_dcxddt',
                view: 'biensonha',
                format: 'raw',
                task: 'DETAIL_BSN',
                sonha_id: sonhaID,
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

        // Ẩn thanh tìm kiếm không cần thiết
        $('.dataTables_filter').eq(1).hide();

        // Chọn input tìm kiếm
        let $searchInput = $(".dataTables_filter input[type='search']");

        // Gán class cho input
        $searchInput.addClass("inputsearch");
        $searchInput.attr("placeholder", "");

        // Bọc input trong div và thêm label + icon
        $searchInput.wrap('<div class="search-container"></div>');
        $searchInput.before('<label class="search-label">Tìm kiếm</label>');
        $searchInput.before('<i class="icon-search"></i>');

        // Floating label
        $searchInput.on("focus", function() {
            $(this).siblings(".search-label").css({
                top: "-3px",
                fontSize: "12px",
                color: "#3b71ca",
                backgroundColor: "#fff"
            });
        });

        $searchInput.on("blur", function() {
            if ($(this).val().length === 0) {
                $(this).siblings(".search-label").css({
                    top: "33%",
                    fontSize: "16px",
                    color: "#888"
                });
            }
        });

        // Đảm bảo input có chiều rộng bằng bảng
        function setSearchWidth() {
            let tableWidth = $("#tblDanhsach").outerWidth() - 35;
            $(".inputsearch").attr("style", "width: " + tableWidth + "px !important;");
        }

        setSearchWidth();
        $(window).resize(setSearchWidth);

        $('.pagination').on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            console.log('Page clicked:', page, 'Current page:', currentPage);
            if (page && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
                var start = (page - 1) * <?php echo $perPage; ?>;
                console.log('Loading start from:', start);
                loadDanhSach(start);
            }
        });

        // Xử lý click vào nút chỉnh sửa


        // Hàm hiển thị thông báo
        function showToast(message, isSuccess = true) {
            const toast = jQuery('<div></div>').text(message).css({
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
        $('body').off('click', '.btn_xoa').on('click', '.btn_xoa', function() {
            const sonha_id = $(this).data('id');

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
                        url: Joomla.getOptions('system.paths').base + '/index.php?option=com_dcxddt&controller=biensonha&task=removeBienSoNha',
                        type: 'POST',
                        data: {
                            sonha_id: sonha_id,
                            [csrfToken]: 1
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log('AJAX Success:', response);
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

                                // Cập nhật số thứ tự
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

        // Hàm load danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_dcxddt',
                view: 'biensonha',
                format: 'raw',
                task: 'DS_BSN',
                phuongxa_id: $('#phuongxa_id').val(),
                thonto_id: $('#thonto_id').val(),
                tenduong: $('#tenduong').val(),
                start: start // Đảm bảo tham số này được truyền đúng
            };

            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: params,
                success: function(response) {
                    // Cập nhật toàn bộ nội dung div_danhsach
                    $('#div_danhsach').html(response);
                    $('#currentPage').val(Math.floor(start / <?php echo $perPage; ?>) + 1);

                    $("#overlay").fadeOut(300);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading danh sach:', xhr.status, error);
                    $("#overlay").fadeOut(300);
                    alert('Lỗi khi tải danh sách: ' + error);
                }
            });
        }
        $('body').on('click', '.btn_eye', function(e) {
            e.preventDefault();
            var sonhaID = $(this).data('sonha_id');
            loadDetail(sonhaID);
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