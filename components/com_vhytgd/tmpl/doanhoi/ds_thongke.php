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
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">STT</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Tên khu vực</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Đang hoạt động</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Tạm ngừng hoạt động</th>
            <th style="vertical-align:middle;color:#FFF!important;" class="text-center">Đang xây dựng</th>
        </tr>
    </thead>
    <tbody id="tbody_danhsach">
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $item) : ?>
                <tr>
                    <?php if ($item['tong_nhankhau'] == '0') : ?>
                        <td style="vertical-align:middle;" class="text-center text-danger"><?php echo htmlspecialchars($i + 1); ?></td>
                        <td style="vertical-align:middle;" class="text-danger"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                        <td style="vertical-align:middle;" class="text-danger" colspan="3">Chưa có dữ liệu</td>
                    <?php else : ?>
                        <td style="vertical-align:middle;" class="text-center"><?php echo htmlspecialchars($i + 1); ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['danghoatdong']); ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['tamngung']); ?></td>
                        <td style="vertical-align:middle;"><?php echo htmlspecialchars($item['dangxaydung']); ?></td>

                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4" class="text-center">Không có dữ liệu để hiển thị</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
