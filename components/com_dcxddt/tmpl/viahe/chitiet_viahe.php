<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');
$item = $this->item;
$idUser = Factory::getUser()->id;
$detailViaHe = $this->item;
?>
<div class="card-body">
    <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
        <h2 class="text-primary mb-3">
            Xem chi tiết thông tin cấp phép sử dụng tạm thời một phần vỉa hè
        </h2>
        <span>
            <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
        </span>
    </div>
    <div class="d-flex align-items-center border-bottom pb-2 mb-4" style="gap:15px">
        <h5 style="margin: 0">Thông tin khách hàng</h5>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-8 mb-2">
            <label for="hoten" class="form-label fw-bold">Họ và tên</label>
            <input id="hoten" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['hoten']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="sodienthoai" class="form-label fw-bold">Số điện thoại</label>
            <input id="sodienthoai" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['dienthoai']); ?>" readonly>
        </div>
        <div class="col-md-8 mb-2">
            <label for="diachi" class="form-label fw-bold">Địa chỉ thường trú</label>
            <input id="diachi" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['diachithuongtru']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="namsinh" class="form-label fw-bold">Năm sinh</label>
            <div class="input-group">
                <input type="text" id="select_namsinh" class="form-control namsinh" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['ngaysinh']); ?>" readonly>
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <label for="cccd" class="form-label fw-bold">CCCD/CMND</label>
            <input id="cccd" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['cccd']); ?>" readonly>
        </div>
        <div class="col-md-4 mb-2">
            <label for="cccd_ngaycap" class="form-label fw-bold">Ngày cấp</label>
            <div class="input-group">
                <input type="text" id="cccd_ngaycap" class="form-control namsinh" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['ngaycap_cccd']); ?>" readonly>
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <label for="cccd_noicap" class="form-label fw-bold">Nơi cấp</label>
            <input id="cccd_noicap" type="text" class="form-control" value="<?php echo htmlspecialchars($detailViaHe['thongtin']['noicap_cccd']); ?>" readonly>
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
    <div class="border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
        <h5 class="">Thông tin hợp đồng</h5>
    </div>
    <div class="row g-3 mb-4 table-responsive-custom" style="border: 1px solid #d9d9d9; border-radius: 4px;">
        <table id="table-thannhan" class="table table-striped table-bordered" style="table-layout: fixed; width: 100%; margin: 0px; overflow: auto;">
            <thead class="table-primary text-white">
                <tr>
                    <th class="text-center align-middle">STT</th>
                    <th class="text-center align-middle">Số giấy phép</th>
                    <th class="text-center align-middle">Số lần</th>
                    <th class="text-center align-middle">Ngày ký hợp đồng</th>
                    <th class="text-center align-middle">Ngày hết hạn</th>
                    <th class="text-center align-middle">Thời gian</th>
                    <th class="text-center align-middle">Số tiền</th>
                    <th class="text-center align-middle">Ghi chú</th>
                </tr>
            </thead>
            <tbody class="dsHopDong">
            </tbody>
        </table>
    </div>
    <?php echo HTMLHelper::_('form.token'); ?>
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
        renderDanhSachHopDong()
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

    function renderDanhSachHopDong() {
        if (!detailViaHe || !detailViaHe.giayphep) return;

        let parentIndex = 1;

        Object.entries(detailViaHe.giayphep).forEach(([sogiayphep, danhSachHopDong]) => {
            let childCount = 0;

            danhSachHopDong.forEach((hopdong, idx) => {
                let rowIndex;
                if (idx === 0) {
                    // Hợp đồng gốc
                    rowIndex = parentIndex;
                } else {
                    // Các hợp đồng gia hạn
                    childCount++;
                    rowIndex = `${parentIndex}.${childCount}`;
                }

                const newRow = `
                    <tr data-row="${rowIndex}">
                    <td class="text-center">${rowIndex}</td>
                    <input type="hidden" name="id_hopdong[]" value="${hopdong.id_hopdong}">
                    <td class="text-center">
                        <input type="text" class="form-control" name="sogiayphep[]" value="${sogiayphep}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="solan[]" value="${hopdong.solan ?? (idx + 1)}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="ngayKyStr[]" value="${hopdong.ngayky}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="ngayHetHanStr[]" value="${hopdong.ngayhethan}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="thoigian[]" value="${tinhSoNgayTuChuoi(hopdong.ngayky, hopdong.ngayhethan)}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="sotien[]" value="${hopdong.sotien}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" name="ghichu[]" value="${hopdong.ghichu}" readonly>
                    </td>
                    </tr>
                `;
                $('.dsHopDong').append(newRow);
            });
            parentIndex++;
        });
    }

    function tinhSoNgayTuChuoi(ngay1, ngay2) {
        const [d1, m1, y1] = ngay1.split('/');
        const [d2, m2, y2] = ngay2.split('/');
        const start = new Date(`${y1}-${m1}-${d1}`);
        const end = new Date(`${y2}-${m2}-${d2}`);
        const diff = (end - start) / (1000 * 60 * 60 * 24) + 1;
        return diff > 0 ? `${diff} ngày` : '';
    }
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