<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$wa = $this->document->getWebAssetManager();
$wa->registerAndUseScript('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', [], ['defer' => true]);

$labels = [];
$counts = [];
foreach ($this->moduleName as $item) {
    $labels[] = $item['menu_name'];
    $counts[] = (int)$item['total_count'];
}
$years = [2022, 2023, 2024, 2025];
$currentYear = date('Y'); // hoặc lấy từ request

?>
<div class="blog-featured p-4" style="background-color: #eee;">
    <div class="row g-3 mb-4">
        <div class="col-md-8 ">
            <div class="mr-1 card">
                <div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid rgba(0, 0, 0, .125);
    padding: .75rem 1.25rem;">
                    <h3 class="card-title">Thống kê dữ liệu theo năm</h3>
                    <div class="">
                        <label for="yearSelect">Chọn năm:</label>
                        <select id="yearSelect" class="form-control" style="width:150px; display:inline-block;">
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $year == $currentYear ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <canvas id="myMixedChart" style="max-width: 800px; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 card">
            <div class="card-body scrollable-card-body" style="max-height:500px; overflow-y:auto;">
                <?php if ($this->moduleName) {
                    // Tính tổng total_count
                    $tong = 0;
                    foreach ($this->moduleName as $m) {
                        $tong += (int)$m['total_count'];
                    }
                    $stt = 1;
                ?>
                    <?php foreach ($this->moduleName as $moduleName) {
                        $count = (int)$moduleName['total_count'];
                        // Tránh chia cho 0
                        $phanTram = $tong > 0 ? round(($count / $tong) * 100, 1) : 0;
                    ?>
                        <div class="mb-4" style="font-size: 15px;">
                            <div class="d-flex justify-content-between mb-2" style="width: 85%">
                                <?= htmlspecialchars($moduleName['menu_name']) ?>
                                <div>
                                    <span><?= $count ?>/</span><span class="font-weight-bold"><?= $tong ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="progress" style="border-radius: 5px; width: 85%;">
                                    <div class="progress-bar custom-progress-bar" role="progressbar" style="width: <?= $phanTram ?>%; border-radius: 5px;">
                                    </div>
                                </div>
                                <span class="text-secondary"><?= $phanTram ?>%</span>
                            </div>
                        </div>
                    <?php $stt++;
                    } ?>
                <?php } ?>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('myMixedChart').getContext('2d');

        const dataLabels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']; // tên cột
        const dataCounts = [12, 19, 3, 5, 2, 15, 3, 5, 2, 11, 0, 0];
        const dataLine = [12, 19, 3, 5, 2, 15, 3, 5, 2, 11, 0, 0];

        new Chart(ctx, {
            data: {
                labels: dataLabels,
                datasets: [{
                    type: 'line', // đường
                    label: 'Đường xu hướng',
                    data: dataLine,
                    borderColor: '#fd6e8dce',
                    borderWidth: 2,
                    tension: 0.3, // bo cong
                    fill: false,
                    pointBackgroundColor: '#fd6e8dce',
                    pointRadius: 4
                }, {
                    type: 'bar', // cột
                    label: 'Số lượng',
                    data: dataCounts,
                    backgroundColor: '#019cb1a8',
                    borderColor: '#019cb1ff',
                    borderWidth: 1,
                    borderRadius: 4
                }, ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<style>
    .custom-progress-bar {
        position: relative;
        overflow: hidden;
    }

    .custom-progress-bar::after {
        content: "";
        position: absolute;
        top: 0;
        left: -50%;
        /* bắt đầu ngoài bên trái */
        width: 5%;
        height: 100%;
        background: linear-gradient(to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0.4) 100%);
        animation: shimmer 5s infinite;
    }

    @keyframes shimmer {
        0% {
            left: -50%;
            /* bắt đầu ngoài bên trái */
        }

        60% {
            left: 100%;
            /* sau 1.5s quét đến hết */
        }

        100% {
            left: 100%;
            /* giữ nguyên đến hết chu kỳ 3s */
        }
    }
</style>