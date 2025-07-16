<?php
defined('_JEXEC') or die('Restricted access');


// Initialize variables
$stt_phuongxa = 1;
$stt_thonto = 1;
$current_phuongxa_id = null;
?>

<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
    <thead>
        <tr class="bg-primary">
            <th class="text-center align-middle" rowspan="2">STT</th>
            <th class="text-center align-middle" rowspan="2">Tên khu vực</th>
            <th class="text-center align-middle" colspan="2">Số lượng Tổ trường/Trưởng thôn</th>
            <th class="text-center align-middle" colspan="2">Số lượng Tổ phó/Phó trưởng thôn</th>
        </tr>
        <tr class="bg-primary">
            <th class="text-center align-middle">Nam</th>
            <th class="text-center align-middle">Nữ</th>
            <th class="text-center align-middle">Nam</th>
            <th class="text-center align-middle">Nữ</th>
        </tr>
    </thead>
    <tbody id="tbody_danhsach">
        <?php foreach ($this->items as $i => $item) : ?>
            <?php
            if ($item['level'] == '2') {
                // Xã/phường
                $stt = $stt_phuongxa;
                $current_phuongxa_id = $item['id'];
                $stt_thonto = 1; // Đặt lại cho thôn/tổ tiếp theo
                $stt_phuongxa++; // Tăng số thứ tự cho xã/phường tiếp theo
            } else {
                // Thôn/tổ
                if ($i > 0 && $item['cha_id'] != $current_phuongxa_id) {
                    $stt_thonto = 1;
                    $stt_phuongxa++; // Tăng khi chuyển sang xã/phường mới
                    $current_phuongxa_id = $item['cha_id'];
                }
                $stt = ($current_phuongxa_id == $item['cha_id']) ? ($stt_phuongxa - 1) . '.' . $stt_thonto : $stt_phuongxa . '.' . $stt_thonto;
                $stt_thonto++;
            }
            ?>
            <tr>
                <?php if ($item['totruongnam'] == '0' && $item['totruongnu'] == '0' && $item['tophonam'] == '0' && $item['tophonu'] == '0' && $item['level'] == '3') : ?>
                    <td class="text-center text-danger align-middle"><?php echo htmlspecialchars($stt); ?></td>
                    <td class="text-danger align-middle"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                    <td class="text-danger align-middle" colspan="4">Chưa có dữ liệu</td>
                <?php else : ?>
                    <td class="text-center align-middle"><?php echo htmlspecialchars($stt); ?></td>
                    <td class="align-middle"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                    <td class="text-align-right align-middle"><?php echo htmlspecialchars($item['totruongnam']); ?></td>
                    <td class="text-align-right align-middle"><?php echo htmlspecialchars($item['totruongnu']); ?></td>
                    <td class="text-align-right align-middle"><?php echo htmlspecialchars($item['tophonam']); ?></td>
                    <td class="text-align-right align-middle"><?php echo htmlspecialchars($item['tophonu']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>