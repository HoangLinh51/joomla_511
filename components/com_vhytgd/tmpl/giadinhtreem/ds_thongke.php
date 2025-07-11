<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$stt_phuongxa = 1;
$stt_thonto = 1;
$current_phuongxa_id = null;
?>

<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
    <thead>
         <thead>
        <tr style="background: #027be3;">
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center" rowspan="2">STT</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center" rowspan="2">Khu vực</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center" colspan="2">Giới tính</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center" colspan="3">Tổng số công dân</th>
        </tr>
        <tr style="background: #027be3;">
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Nam</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Nữ</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">thường trú</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Tạm trú</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Trên 18 tuổi</th>
        </tr>
    </thead>
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
                <?php if ($item['nam'] == '0' && $item['nu'] == '0' && $item['thuongtru'] == '0' && $item['tamtru'] == '0' && $item['tren18'] == '0' && $item['level'] == '3') : ?>
                    <td style="vertical-align:middle;" class="text-center text-danger"><?php echo htmlspecialchars($stt); ?></td>
                    <td style="vertical-align:middle;" class="text-danger"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                    <td style="vertical-align:middle;" class="text-danger" colspan="5">Chưa có dữ liệu></td>
                <?php else : ?>
                    <td style="vertical-align:middle;" class="text-center"><?php echo htmlspecialchars($stt); ?></td>
                    <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                    <td style="vertical-align:middle;text-align:right;"><?php echo htmlspecialchars($item['nam']); ?></td>
                    <td style="vertical-align:middle;text-align:right;"><?php echo htmlspecialchars($item['nu']); ?></td>
                    <td style="vertical-align:middle;text-align:right;"><?php echo htmlspecialchars($item['thuongtru']); ?></td>
                    <td style="vertical-align:middle;text-align:right;"><?php echo htmlspecialchars($item['tamtru']); ?></td>
                    <td style="vertical-align:middle;text-align:right;"><?php echo htmlspecialchars($item['tren18']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
// Load Bootstrap 5 and jQuery (if needed)
HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('jquery.framework');
?>