<?php
defined('_JEXEC') or die('Restricted access');
$perPage = 20;
$result = $this->countitems;
$totalRecords = $result[0]['tongbandieudanh'];
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
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Thôn/ Tổ dân phố</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Nhiệm kỳ</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Họ tên thành viên</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Chức danh</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Số điện thoại</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tình trạng</th>
                <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center" style="width:131px;">Chức năng</th>
            </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php $stt = JFactory::getApplication()->input->getInt('start', 0); ?>
            <?php foreach ($this->items as $thontos => $nhiemkys) { ?>
                <?php foreach ($nhiemkys as $nhiemky => $thanhviens) { ?>
                    <?php $rowspan = count($thanhviens); ?>
                    <?php for ($i = 0, $n = count($thanhviens); $i < $n; $i++) { ?>
                        <?php $item = $thanhviens[$i]; ?>
                        <?php $stt++; ?>
                        <tr>
                            <?php if ($i == 0) { ?>
                                <td style="vertical-align:middle;" class="text-center" rowspan="<?php echo $rowspan; ?>"><?php echo $stt; ?></td>
                                <td style="vertical-align:middle;" rowspan="<?php echo $rowspan; ?>"><?php echo htmlspecialchars($thontos); ?></td>
                                <td style="vertical-align:middle;" rowspan="<?php echo $rowspan; ?>"><?php echo htmlspecialchars($item['tennhiemky']); ?></td>
                            <?php } ?>
                            <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['hoten']); ?></td>
                            <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tenchucdanh']); ?></td>
                            <td style="vertical-align:middle;" class="text-center"><?php echo htmlspecialchars($item['dienthoai']); ?></td>
                            <td style="vertical-align:middle;" class="text-center">
                                <?php if ($item['tinhtrang_id'] == '1') {
                                    echo '<span class="text-success"><i class="fas fa-check"></i> ' . htmlspecialchars($item['tentinhtrang']) . '</span>';
                                } else {
                                    echo '<span class="text-danger"><i class="fas fa-times"></i> ' . htmlspecialchars($item['tentinhtrang']) . '</span>';
                                } ?>
                            </td>
                            <td style="vertical-align:middle;" class="text-center">
                                <div class="btn-group" role="group">
                                    <span class="btn btn-sm btn_hieuchinh" style="padding:10px; cursor: pointer;" data-nhiemky="<?php echo $item['nhiemky_id']; ?>" data-title="Hiệu chỉnh">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                    <span style="padding: 0 5px;font-size:18px;color:#999">|</span>
                                    <span class="btn btn-sm btn_xoa" style="padding:10px; cursor: pointer;" data-hokhau="<?php echo $item['id']; ?>" data-title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination-container d-flex align-items-center mt-3">
        <div id="pagination" class="mx-auto">
            <?php if ($totalPages > 1): ?>
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="1">&laquo;</a>
                    </li>
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo max(1, $currentPage - 1); ?>">&lsaquo;</a>
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
                        <a class="page-link" href="#" data-page="<?php echo min($totalPages, $currentPage + 1); ?>">&rsaquo;</a>
                    </li>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?php echo $totalPages; ?>">&raquo;</a>
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

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Thông tin chi tiết</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                var start = (page - 1) * <?php echo $perPage; ?>; // Tính toán lại giá trị start
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
            $('.detail-item').hide();
            $('#detail-' + id).show();
            $('.name-link').removeClass('active');
            $(this).addClass('active');
        });

        // Hàm load danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            var params = {
                option: 'com_vptk',
                view: 'bdh',
                format: 'raw',
                task: 'DS_BDH',
                phuongxa_id: $('#phuongxa_id').val(),
                hoten: $('#hoten').val(),
                chucdanh_id: $('#chucdanh_id').val(),
                tinhtrang_id: $('#tinhtrang_id').val(),
                thonto_id: $('#thonto_id').val(),
                chucdanh_kn: $('#chucdanh_kn').val(),

                start: start,
                limit: <?php echo $perPage; ?>
            };
            console.log('Pagination Params:', params);
            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: params,
                success: function(response) {
                    $('#tbody_danhsach').html($(response).find('#tbody_danhsach').html());
                    $('#pagination').html($(response).find('#pagination').html());
                    $('#pagination-info').html($(response).find('#pagination-info').html());
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

        // Xử lý xóa
        $('body').on('click', '.btn_xoa', function() {
            var hokhau_id = $(this).data('hokhau');
            bootbox.confirm({
                title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                message: '<span style="font-size:20px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
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
                                    '<i class="fas fa-check-circle success-icon"></i>' :
                                    '<i class="fas fa-exclamation-circle success-icon"></i>';
                                bootbox.alert({
                                    title: icon + "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                                    message: '<span style="font-size:20px;">' + message + '</span>',
                                    backdrop: true,
                                    className: 'small-alert',
                                    buttons: {
                                        ok: {
                                            label: 'OK',
                                            className: 'hidden'
                                        }
                                    },
                                    onShown: function() {
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
                                    title: "<i class='fas fa-exclamation-circle success-icon'></i><span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                                    message: '<span style="font-size:20px;">Lỗi: ' + xhr.responseText + '</span>',
                                    className: 'small-alert',
                                    buttons: {
                                        ok: {
                                            label: 'OK',
                                            className: 'hidden'
                                        }
                                    },
                                    onShown: function() {
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
    .btn i {
        font-size: 18px !important;
        vertical-align: unset;
    }

    .modal {
        overflow-x: hidden;
    }

    .modal-dialog {
        max-width: 1200px;
        min-width: 300px;
        width: 1000px;
        margin-left: auto;
        margin-right: 0;
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
        transition: transform 0.5s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: translateX(0);
    }

    .modal.fade .modal-dialog {
        transform: translateX(100%);
    }

    .modal-body {
        padding: 20px;
        word-break: break-word;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-header,
    .modal-footer {
        padding: 15px 20px;
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

    .btn-group .btn {
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.5;
    }

    .btn-group .btn i {
        font-size: 16px;
        vertical-align: middle;
    }

    .text-success i,
    .text-danger i {
        font-size: 16px;
        vertical-align: middle;
    }

    .custom-bootbox .modal-dialog {
        width: 498px !important;
        margin: 30px auto !important;
        transform: translateY(-50%);
    }

    .success-icon {
        margin-right: 8px;
        vertical-align: middle;
    }

    .small-alert .bootbox.modal {
        width: 300px !important;
        margin: 0 auto;
    }

    .small-alert .modal-dialog {
        width: 300px !important;
    }

    .small-alert .modal-footer {
        display: none;
    }

    .small-alert .modal-header {
        height: 44px;
        padding: 7px 20px;
    }

    .small-alert .modal-body {
        padding: 14px;
    }
</style>