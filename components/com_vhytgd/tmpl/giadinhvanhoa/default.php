<?php
defined('_JEXEC') or die('Restricted access');
$idUser = JFactory::getUser()->id;

use Joomla\CMS\Uri\Uri;

// Lấy giá trị is_quyen từ bảng jos_users
$db = JFactory::getDbo();
$query = $db->getQuery(true)
    ->select('is_quyen')
    ->from($db->quoteName('jos_users'))
    ->where($db->quoteName('id') . ' = ' . (int) $idUser);
$db->setQuery($query);
$is_quyen = $db->loadResult();

// Lấy thông báo từ session
$session = JFactory::getSession();
$messageBootbox = $session->get('message_bootbox', '');

// Xóa session sau khi lấy để tránh hiển thị lại
if ($messageBootbox) {
    $session->clear('message_bootbox');
}

// Lấy thông báo từ hàng đợi Joomla
$messages = JFactory::getApplication()->getMessageQueue();
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
<form action="index.php" method="post" id="frmGiadinhvanhoa" name="frmGiadinhvanhoa" class="form-horizontal" style="font-size:16px;background:white">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <!-- Hiển thị thông báo Joomla -->
        <?php if (!empty($messages)): ?>
            <div id="system-message-container" class="mt-3">
                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-<?php echo $message['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                        <?php echo htmlspecialchars($message['message']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Hidden input để truyền message_bootbox cho JavaScript -->
        <?php if ($messageBootbox): ?>
            <input type="hidden" id="message_bootbox" value="<?php echo htmlspecialchars($messageBootbox); ?>">
        <?php endif; ?>

        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý gia đình văn hóa</h3>
                </div>
                <div class="col-sm-6 text-right" style="padding:0;">
                    <?php if ($is_quyen == 0) { ?>
                        <a href="index.php?option=com_vhytgd&view=giadinhvanhoa&task=add_gdvanhoa" class="btn btn-primary" style="font-size:16px;width:136px">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div id="main-right">
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-action="reload"><i class="fas fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 10%; padding: 10px;"><b class="text-primary" style="font-size: 17px; line-height: 2.5;">Xã/Phường</b></td>
                            <td style="width: 40%; padding: 10px;">
                                <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường">
                                    <option value=""></option>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="width: 10%; padding: 10px;"><b class="text-primary" style="font-size: 17px; line-height: 2.5;">Thôn/Tổ</b></td>
                            <td style="width: 40%; padding: 10px;">
                                <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                                    <option value=""></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 10%; padding: 10px;"><b class="text-primary" style="font-size: 15px; line-height: 2.5;">Năm</b></td>
                            <td style="width: 40%; padding: 10px;">
                                <input type="text" class="form-control yearpicker" id="nam" name="nam" style="font-size: 15px;" placeholder="Nhập năm" />

                            </td>


                        </tr>
                        <tr>
                            <td colspan="4" class="text-center" style="padding-top: 10px;">
                                <button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i> Tìm kiếm</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="div_danhsach">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th style="vertical-align:middle;" class="text-center">STT</th>
                                <th style="vertical-align:middle;" class="text-center">Tên thiết chế</th>
                                <th style="vertical-align:middle;" class="text-center">Loại hình</th>
                                <th style="vertical-align:middle;" class="text-center">Vị trí</th>
                                <th style="vertical-align:middle;" class="text-center">Diện tích (m²)</th>
                                <th style="vertical-align:middle;" class="text-center">Tình trạng</th>
                                <th style="vertical-align:middle; width:131px;" class="text-center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_danhsach"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

<script>
    jQuery(document).ready(function($) {
        // Kiểm tra và hiển thị thông báo từ session
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
        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            language: 'vi',
            autoclose: true
        });
        // Hiển thị thông báo từ session
        const messageBootbox = $('#message_bootbox').val();
        if (messageBootbox) {
            showToast(messageBootbox, true);
            $('#message_bootbox').remove();
        }
        // Xử lý sự kiện click trên card-header
        $('.card-header').on('click', function(e) {
            if (!$(e.target).closest('.card-tools').length) {
                $(this).find('[data-card-widget="collapse"]').trigger('click');
            }
        });

        // Khởi tạo Select2
        $('#chucdanh_id, #tinhtrang_id, #phuongxa_id, #thonto_id, #loaihinhthietche_id').select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });

        // Xử lý sự kiện thay đổi phuongxa_id để cập nhật thonto_id
        $('#phuongxa_id').on('change', function() {
            if ($(this).val() == '') {
                $('#thonto_id').html('<option value=""></option>').trigger('change');
            } else {
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'vptk',
                    task: 'getKhuvucByIdCha',
                    cha_id: $(this).val()
                }, function(data) {
                    if (data.length > 0) {
                        var str = '<option value=""></option>';
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '">' + v.tenkhuvuc + '</option>';
                        });
                        $('#thonto_id').html(str).trigger('change');
                    }
                });
            }
        });

        // Hàm tải danh sách
        function loadDanhSach(start = 0) {
            $("#overlay").fadeIn(300);
            $('#div_danhsach').load('index.php', {
                option: 'com_vhytgd',
                view: 'giadinhvanhoa',
                format: 'raw',
                task: 'DS_GDVANHOA',
                phuongxa_id: $('#phuongxa_id').val(),
                thonto_id: $('#thonto_id').val(),
                nam: $('#nam').val(),
            }, function(response, status, xhr) {

                $("#overlay").fadeOut(300);
                if (status === "error") {
                    console.error('Error loading danh sach: ', xhr.status, xhr.statusText);
                }
            });
        }

        // Load danh sách khi trang được tải
        loadDanhSach();

        // Xử lý nút Tìm kiếm
        $('#btn_filter').on('click', function(e) {
            e.preventDefault();
            loadDanhSach();
        });

        // Xử lý nút Hiệu chỉnh
        $('body').delegate('.btn_hieuchinh', 'click', function() {
            window.location.href = 'index.php?option=com_vhytgd&view=giadinhvanhoa&task=edit_gdvanhoa&giadinh_id=' + $(this).data('id');
        });

        // Xử lý nút Xuất Excel

    });
</script>

<style>
    .card.collapsed-card .card-body {
        display: none;
    }

    .card-header {
        cursor: pointer;
    }

    .card-header .card-tools .btn-tool i {
        transition: transform 0.3s ease;
    }

    .card.collapsed-card .btn-tool i.fa-chevron-up {
        transform: rotate(180deg);
    }

    .btn_hieuchinh,
    .btn_xoa {
        position: relative;
        transition: color 0.3s;
        cursor: pointer;
        pointer-events: auto;
        color: #999;
        padding: 10px;
    }

    .btn_hieuchinh:hover i,
    .btn_xoa:hover i {
        color: #007b8bb8;
    }

    .btn_hieuchinh::after,
    .btn_xoa::after {
        content: attr(data-title);
        position: absolute;
        bottom: 72%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(79, 89, 102, .08);
        color: #000000;
        padding: 6px 10px;
        font-size: 14px;
        white-space: nowrap;
        border-radius: 6px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #ccc;
    }

    .btn_hieuchinh:hover::after,
    .btn_xoa:hover::after {
        opacity: 1;
        visibility: visible;
    }

    .content-header {
        padding: 20px .5rem 15px .5rem;
    }

    .form-control {
        height: 38px;
        font-size: 15px;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>