<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

// Các tính toán phân trang giờ sẽ hoạt động đúng
$perPage = 20;
$totalRecords = $this->total; // Lấy đúng giá trị tổng từ controller

$totalPages = $totalRecords > 0 ? ceil($totalRecords / $perPage) : 0;
$currentPage = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) / $perPage + 1) : 0;
$startRecord = $totalRecords > 0 ? (Factory::getApplication()->input->getInt('start', 0) + 1) : 0;

?>

<div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
        <tr class="bg-primary text-white">
            <th class="text-center align-middle">STT</th>
            <th class="text-center align-middle">Tên thiết chế</th>
            <th class="text-center align-middle">Loại hình</th>
            <th class="text-center align-middle">Vị trí</th>
            <th class="text-center align-middle">Diện tích (m²)</th>
            <th class="text-center align-middle">Tình trạng</th>
            <th style="width:131px;" class="text-center align-middle">Chức năng</th>
        </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php if (!empty($this->items)): ?>
                <?php foreach ($this->items as $i => $item): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $startRecord + $i; ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($item['thietche_ten']); ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($item['tenloaihinhthietche']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($item['thietche_vitri']); ?></td>
                        <td class="text-center align-middle"><?php echo htmlspecialchars($item['thietche_dientich']); ?></td>
                        <td class="text-center align-middle">
                            <?php
                            if ($item['trangthaihoatdong_id'] == '1') {
                                echo '<span class="badge bg-secondary">Đang xây dựng</span>';
                            } else if ($item['trangthaihoatdong_id'] == '2') {
                                echo '<span class="badge bg-danger">Đang sửa chữa</span>';
                            } else {
                                echo '<span class="badge bg-success">Đang sử dụng</span>';
                            }
                            ?>
                        </td>

                        <td class="text-center align-middle">
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
                    <td colspan="7" class="text-center">Không có dữ liệu</td>
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
                Hiển thị <?php echo $startRecord; ?> - <?php echo min($startRecord + $actualDisplayedRows - 1, $totalRecords); ?> của tổng cộng <?php echo $totalRecords; ?> mục
                (<?php echo $totalPages; ?> trang)
            <?php else: ?>
                Không có dữ liệu
            <?php endif; ?>
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
            if (page && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
                var start = (page - 1) * <?php echo $perPage; ?>;
                loadDanhSach(start);
            }
        });

        // Xử lý click vào nút chỉnh sửa


        $('body').on('click', '.btn_xoa', function() {
            const id_thietche = $(this).data('id');

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

            // Hàm cập nhật số thứ tự (nếu sử dụng cột STT)
            function updateSTT() {
                $('#tblDanhsach tbody tr').each(function(index) {
                    $(this).find('.stt').text(index + 1);
                });
            }

            // Xác nhận xóa
            bootbox.confirm({
                title: `<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>`,
                message: `<span style="font-size:20px;">Bạn có chắc chắn muốn xóa thông tin thiết chế này?</span>`,
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
                        url: Joomla.getOptions('system.paths').base + '/index.php?option=com_vhytgd&controller=thietche&task=removeThongTinThietChe',
                        type: 'POST',
                        data: {
                            id_thietche: id_thietche,
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

        // Hàm load danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vhytgd',
                view: 'thongtinthietche',
                format: 'raw',
                task: 'DS_THIETCHE',
                phuongxa_id: $('#phuongxa_id').val(),
                tenthietche: $('#tenthietche').val(),
                loaihinhthietche_id: $('#loaihinhthietche_id').val(),
                tinhtrang_id: $('#tinhtrang_id').val(),
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
    });
</script>

<style>
    .btn i {
        font-size: 18px !important;
        vertical-align: unset;
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

    .page-link:hover {
        background-color: #e9ecef;
        color: #007b8b
    }

    .pagination-info {
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }

    .btn-group .btn {
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.5;
    }

    .btn-group .btn i {
        font-size: 15px;
        vertical-align: middle;
    }

    .text-success i,
    .text-danger i {
        font-size: 15px;
        vertical-align: middle;
    }
</style>