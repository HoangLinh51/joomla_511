<?php
use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
$idUser = Factory::getUser()->id;

// Lấy giá trị is_quyen từ bảng jos_users
$db = Factory::getDbo();
$query = $db->getQuery(true)
    ->select('is_quyen')
    ->from($db->quoteName('jos_users'))
    ->where($db->quoteName('id') . ' = ' . (int) $idUser);
$db->setQuery($query);
$is_quyen = $db->loadResult();

// Lấy thông báo từ session
$session = Factory::getSession();
$messageBootbox = $session->get('message_bootbox', '');

// Xóa session sau khi lấy để tránh hiển thị lại
if ($messageBootbox) {
    $session->clear('message_bootbox');
}

// Lấy thông báo từ hàng đợi Joomla
$messages = Factory::getApplication()->getMessageQueue();
?>

<form action="index.php" method="post" id="frmNhanhokhau" name="frmNhanhokhau" class="form-horizontal" style="font-size:16px;background:white">
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
                    <h3 class="m-0 text-primary"><i class="fas fa-users"></i>Tra cứu dân cư</h3>
                </div>
                <div class="col-sm-6 text-right" style="padding:0;">
                    <?php if ($is_quyen == 0) { ?>
                        <a href="index.php?option=com_vptk&view=bdh&task=add_bdh" class="btn btn-primary" style="font-size:16px;width:136px">
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
                            <td style="width: 4%; padding: 10px;"><b class="text-primary" style="font-size: 17px; line-height: 2.5;">Số CCCD/CMND</b></td>
                            <td colspan="4" style="width: 40%; padding: 10px;">
                                <input type="text" name="cccd" id="cccd" class="form-control" style="font-size: 15px;" placeholder="Nhập CCCD/CMND" />
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
                                <th style="vertical-align:middle;" class="text-center">Họ tên</th>
                                <th style="vertical-align:middle;" class="text-center">Giới tính</th>
                                <th style="vertical-align:middle;" class="text-center">Ngày sinh</th>
                                <th style="vertical-align:middle;" class="text-center">CCCD/CMND</th>
                                <th style="vertical-align:middle;" class="text-center">Chỗ ở hiện nay</th>
                                <th style="vertical-align:middle;" class="text-center">Số điện thoại</th>
                                <th style="vertical-align:middle;" class="text-center" style="width:131px;">Chức năng</th>
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


        $('body').delegate('.btn_chitiet', 'click', function() {
            window.location.href = 'index.php?option=com_vptk&view=tcdc&task=xem_tcdc&id=' + $(this).data('id');
        });
        // Hàm tải danh sách
        function loadDanhSach(start = 0) {
            const cccD = $('#cccd').val();
            if (!cccD) {
                showToast('Vui lòng nhập CCCD hoặc CMND!', false);
                return;
            }
            $("#overlay").fadeIn(300);
            $('#div_danhsach').load('index.php', {
                option: 'com_vptk',
                view: 'tcdc',
                format: 'raw',
                task: 'DS_TCDC',
                cccd: cccD,

            }, function(response, status, xhr) {

                $("#overlay").fadeOut(300);
                if (status === "error") {
                    console.error('Error loading danh sach: ', xhr.status, xhr.statusText);
                }
            });
        }

        
        $('#btn_filter').on('click', function(e) {
            e.preventDefault();
            loadDanhSach();
        });


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

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #007b8b;
        color: #fff
    }
</style>