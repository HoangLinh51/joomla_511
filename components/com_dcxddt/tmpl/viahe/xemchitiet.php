<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');
$item = $this->item;
$idUser = Factory::getUser()->id;
$detailViaHe = $this->itemNoAuth;
$giayphep = $detailViaHe['giayphep'] ?? [];

$sogiayphep = array_key_first($giayphep);
$hopdong = $giayphep[$sogiayphep][0] ?? null;
?>
<div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
        <h2 class="text-primary mb-3">
            Giấy phép sử dụng tạm thời một phần vỉa hè
        </h2>
    </div>
    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
        <h5 style="margin: 0">Thông tin khách hàng</h5>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-8 mb-2">
            <label class="form-label fw-bold">Họ và tên</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['hoten']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="sodienthoai" class="form-label fw-bold">Số điện thoại</label>
            <input id="sodienthoai" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['dienthoai']); ?>" readonly>
        </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin cấp phép</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-12 mb-2">
            <label for="diachiviahe" class="form-label fw-bold">Địa chỉ vỉa hè</label>
            <input id="diachiviahe" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['diachi']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="dientichtamthoi" class="form-label fw-bold">Diện tích sử dụng tạm thời</label>
            <input id="dientichtamthoi" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['dientichtamthoi']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="chieudai" class="form-label fw-bold">Chiều dài dọc vỉa hè</label>
            <input id="chieudai" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['chieudai']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="chieurong" class="form-label fw-bold">Chiều rộng</label>
            <input id="chieurong" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['chieurong']); ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
            <label for="mucdichsudung" class="form-label fw-bold">Mục đích sử dụng</label>
            <input id="mucdichsudung" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['mucdichsudung']); ?>" readonly>
        </div>
        <div class="col-md-12 mb-2 mt-2">
            <label for="mucdichsudung" class="form-label fw-bold">Tình trạng</label>
            <div class="w-100">
                <?php
                $ngayHetHan = DateTime::createFromFormat('d/m/Y', $hopdong['ngayhethan']);
                $homNay = new DateTime();
                $ngayHetHan->setTime(0, 0, 0);
                $homNay->setTime(0, 0, 0);

                $diff = (int)$ngayHetHan->diff($homNay)->format('%r%a'); // %r: dấu âm/dương, %a: số ngày

                // Gán tình trạng dựa trên số ngày còn lại
                if ($diff < 0) {
                    // Còn hạn
                    $daysLeft = abs($diff);
                    if ($daysLeft < 7) {
                        echo '<span class="badge bg-warning">Sắp hết hạn</span>';
                    } else {
                        echo '<span class="badge bg-success">Còn hạn</span>';
                    }
                } elseif ($diff >= 0) {
                    // Hết hạn
                    echo '<span class="badge bg-danger">Hết hạn</span>';
                } else {
                    echo '<span class="badge bg-secondary">Không xác định</span>';
                }
                ?>
            </div>
        </div>
        <div class="col-md-12 mb-2 vanbancu">
            <?php if (!empty($detailViaHe['filedinhkem'])): ?>

                <?php
                $images = [];
                $others = [];

                foreach ($detailViaHe['filedinhkem'] as $item) {
                    if (in_array($item['mime'], ['image/jpeg', 'image/png'])) {
                        $images[] = $item;
                    } else {
                        $others[] = $item;
                    }
                }
                ?>

                <!-- 🖼️ Hiển thị ảnh (1 hàng riêng) -->
                <?php if (!empty($images)): ?>
                    <label class="form-label fw-bold">Ảnh đính kèm</label>
                    <div class="d-flex flex-wrap mb-3" style="gap: 5px">
                        <?php foreach ($images as $item): ?>
                            <?php
                            $filename = htmlspecialchars($item['filename']);
                            $url = "uploader/get_image.php/{$item['folder']}?code={$item['code']}";
                            ?>
                            <img src="<?= $url ?>" alt="<?= $filename ?>" class="preview-link image-preview" data-type="image" data-url="<?= $url ?>">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- 📄 Hiển thị các file khác (1 hàng riêng) -->
                <?php if (!empty($others)): ?>
                    <label class="form-label fw-bold">Tệp đính kèm khác</label>
                    <?php foreach ($others as $item): ?>
                        <?php
                        $filename = htmlspecialchars($item['filename']);
                        $url = '';
                        $type = '';

                        if ($item['mime'] === 'application/pdf') {
                            $url = "index.php?option=com_dungchung&view=hdsd&format=raw&task=viewpdf&file={$item['code']}&folder={$item['folder']}";
                            $type = 'pdf';
                        } else {
                            $url = "index.php?option=com_core&controller=attachment&format=raw&task=download&year=" . date('Y') . "&code={$item['code']}";
                            $type = 'download';
                        }
                        ?>

                        <div class="mb-2">
                            <?php if ($type === 'download'): ?>
                                <a href="<?= $url ?>" download><?= $filename ?></a>
                            <?php else: ?>
                                <a href="<?= $url ?>"
                                    class="preview-link"
                                    data-type="<?= $type ?>"
                                    data-url="<?= $url ?>">
                                    <?= $filename ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>

    <h5 class="border-bottom pb-2 mb-4">Thông tin hợp đồng</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-6 mb-2">
            <label class="form-label fw-bold">Số giấy phép</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($sogiayphep); ?>" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label fw-bold">Số lần</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($hopdong['solan'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label fw-bold">Ngày ký hợp đồng</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($hopdong['ngayky'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label fw-bold">Ngày hết hạn</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($hopdong['ngayhethan'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-12 mb-2">
            <label class="form-label fw-bold">Ghi chú</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($hopdong['ghichu'] ?? ''); ?>" readonly>
        </div>
    </div>
</div>
<div id="lightboxOverlay">
    <div id="lightboxContent">
        <button id="lightboxClose">✖</button>
        <div id="lightboxInner" class="d-flex justify-content-center"></div>
        <div style="padding:20px"></div>
    </div>
</div>
<script>
    let detailViaHe = <?php echo json_encode($detailViaHe ?? []); ?>;
    $(document).ready(function() {
        $('#btn_quaylai').click(() => {
            window.location.href = '<?php echo Route::_('/index.php/component/dcxddt/?view=viahe&task=default'); ?>';
        });
        $('.preview-link').on('click', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let baseUrl = window.location.origin;
            let relativeUrl = $(this).data('url');
            let fullUrl = baseUrl + '/' + relativeUrl;
            let content = '';

            if (type === 'image') {
                content = `<img src="/${relativeUrl}" style="max-width:90vw; max-height:90vh;">`;
            } else if (type === 'pdf') {
                content = `<iframe src="/${relativeUrl}" style="width:80vw; height:80vh;" frameborder="0"></iframe>`;
            }

            $('#lightboxInner').html(content);
            $('#lightboxOverlay').addClass('active');
        });

        $('#lightboxOverlay, #lightboxClose').on('click', function(e) {
            if (e.target.id === 'lightboxOverlay' || e.target.id === 'lightboxClose') {
                $('#lightboxOverlay').removeClass('active');
                $('#lightboxInner').empty();
            }
        });
    })
</script>

<style>
    .card-body {
        padding: 2.5rem;
        font-size: 15px;
    }

    .input-group-text {
        border-radius: 0px 4px 4px 0px;
    }

    #lightboxOverlay {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        overflow: auto;
    }

    #lightboxOverlay.active {
        display: flex;
    }

    #lightboxContent {
        max-height: 90%;
        position: relative;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
    }

    #lightboxContent img,
    #lightboxContent iframe {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        max-height: 100%;
    }

    #lightboxClose {
        position: absolute;
        top: -30px;
        right: -70px;
        color: #fff;
        background: inherit;
        border: none;
        font-size: 26px;
        cursor: pointer;
    }

    .table-responsive-custom {
        width: 100%;
        overflow-x: auto;
    }

    .table-responsive-custom table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    .table-responsive-custom th,
    .table-responsive-custom td {
        padding: 8px 12px;
        text-align: left;
        white-space: nowrap;
        /* giữ chữ trên 1 dòng */
    }

    .image-preview {
        border: 1px solid;
        max-width: 100px;
        width: 100%;
        height: 65px;
        border-radius: 4px;
    }

    @media (max-width: 768px) {

        #lightboxContent {
            max-width: 95%;
            max-height: 90vh;
            padding: 10px;
        }

        #lightboxClose {
            top: -20px;
            right: -15px;
            font-size: 18px;
        }

        #lightboxContent img,
        #lightboxContent iframe {
            max-height: 75vh;
        }
    }

    @media (max-width: 480px) {

        #lightboxContent {
            max-width: 100%;
            max-height: 85vh;
            padding: 8px;
        }

        #lightboxClose {
            top: -8px;
            right: -8px;
            font-size: 16px;
        }

        #lightboxContent img,
        #lightboxContent iframe {
            max-height: 70vh;
        }
    }
</style>