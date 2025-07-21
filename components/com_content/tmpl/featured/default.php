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

$years = [2025, 2024, 2023];

?>
<div class="blog-featured p-4" style="background-color: #eee;">
    <div class="row g-3 flex-row" id="top3Html">
        <div class=" col-md-3" style="padding-left: 0;">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                    <div class="body-total">
                        <h4 class="text-primary" id="total"></h4>
                        <h6 class="text-muted m-0">Tổng dữ liệu của tất cả module</h6>
                    </div>
                    <i class="far fa-chart-bar text-primary" style="font-size: 28px;"></i>
                </div>
                <div class="bg-primary-custom" style="height: 50px; border-radius: 0 0 4px 4px "></div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4 card" style="flex-direction: row;">
        <div class="col-md-8 border-right">
            <div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid rgba(0, 0, 0, .125); padding: .75rem 1.25rem;">
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

        <div class="col-md-4">
            <div id="module-progress-container" class="card-body scrollable-card-body" style="max-height:500px; overflow-y:auto;">

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('myMixedChart').getContext('2d');
        // Nhãn tháng
        const dataLabels = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];
        // Dữ liệu ban đầu (có thể để rỗng, sẽ load khi fetch xong)
        let dataCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        // Khởi tạo Chart
        const chart = new Chart(ctx, {
            data: {
                labels: dataLabels,
                datasets: [{
                        type: 'line',
                        label: 'Đường xu hướng',
                        data: dataCounts,
                        borderColor: '#fd6e8dce',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: false,
                        pointBackgroundColor: '#fd6e8dce',
                        pointRadius: 4
                    },
                    {
                        type: 'bar',
                        label: 'Số lượng',
                        data: dataCounts,
                        backgroundColor: '#019cb1a8',
                        borderColor: '#019cb1ff',
                        borderWidth: 1,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
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
        const phuongxa = "<?php echo $this->phanquyen['phuongxa_id'] ?>";
        // Hàm fetch chung
        function fetchTongTheoNam(phuongxa, onSuccess) {
            const url = "index.php?option=com_content&task=feature.getTongTheoNamCTL";
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        phuongxa
                    })
                })
                .then(res => res.json())
                .then(data => {
                    onSuccess(data); // gọi callback được truyền vào
                })
                .catch(err => {
                    console.error('Lỗi fetch dữ liệu:', err);
                });
        }

        // Hàm sử dụng cho từng trường hợp
        function fetchGetTongTheoModule(phuongxa, year) {
            fetchTongTheoNam(phuongxa, data => renderProgress(data, year));
        }

        function fetchGetTongTheoNam(phuongxa) {
            fetchTongTheoNam(phuongxa, xuLyVaRender);
        }
        // render ra html 
        function xuLyVaRender(data) {
            let totalAll = 0;
            const processed = data.map(item => {
                // Ép kiểu về số
                const n2023 = Number(item.n_2023) || 0;
                const n2024 = Number(item.n_2024) || 0;
                const n2025 = Number(item.n_2025) || 0;

                const tongItem = n2023 + n2024 + n2025;
                totalAll += tongItem;

                return {
                    ...item,
                    tong_tatca_nam: tongItem
                };
            });

            processed.sort((a, b) => b.tong_tatca_nam - a.tong_tatca_nam);
            const menuTotals = processed.slice(0, 3);

            let top3Html = '';
            const bgColors = ['bg-success-custom', 'bg-info-custom', 'bg-warning-custom'];
            menuTotals.forEach((item, idx) => {
                top3Html += `
                    <div class="col-md-3">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="body-total">
                                    <h4 class="text-primary">${item.tong_tatca_nam}</h4>
                                    <h6 class="text-muted m-0">${item.menu_name}</h6>
                                </div>
                                <i class="${item.menu_icon || 'far fa-chart-bar'} text-primary" style="font-size: 28px;"></i>
                            </div>
                            <div class="${bgColors[idx]}" style="height: 50px; border-radius: 0 0 4px 4px"></div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('total').innerText = totalAll;
            document.getElementById('top3Html').innerHTML += top3Html;
        }
        // render ra html 
        function renderProgress(data, year) {
            let moduleProgressHtml = '';
            let tongTheoNam = 0;

            // 1. Tính tổng theo năm
            data.forEach(item => {
                tongTheoNam += Number(item[`n_${year}`]) || 0;
            });

            // 2. Sắp xếp mảng giảm dần theo giá trị năm đã chọn
            const sortedData = data.slice().sort((a, b) => {
                const aValue = Number(a[`n_${year}`]) || 0;
                const bValue = Number(b[`n_${year}`]) || 0;
                return bValue - aValue; // giảm dần
            });

            // 3. Duyệt qua mảng đã sắp xếp để render
            sortedData.forEach(item => {
                const count = Number(item[`n_${year}`]) || 0;
                const phanTram = tongTheoNam > 0 ?
                    ((count / tongTheoNam) * 100).toFixed(1) :
                    "0.0";

                moduleProgressHtml += `
                    <div class="mb-4" style="font-size: 15px;">
                        <div class="d-flex justify-content-between mb-2" style="width: 85%">
                            ${item.menu_name}
                            <div>
                                <span>${count}/</span><span class="font-weight-bold">${tongTheoNam}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="progress" style="border-radius: 5px; width: 85%;">
                                <div class="progress-bar custom-progress-bar" role="progressbar" 
                                    style="width: ${phanTram}%; border-radius: 5px;">
                                </div>
                            </div>
                            <span class="text-secondary">${phanTram}%</span>
                        </div>
                    </div>
                `;
            });

            // 4. Gán vào div
            document.getElementById('module-progress-container').innerHTML = moduleProgressHtml;
        }

        // getdata gán vào chart
        function getdatachart(phuongxa, selectedYear) {
            const url = "index.php?option=com_content&task=feature.getDataChart";

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        phuongxa: phuongxa
                    })
                })
                .then(response => response.json())
                .then(data => {
                    renderChartTheoNam(data, selectedYear)
                })
                .catch(error => {
                    console.error('Lỗi fetch dữ liệu:', error);
                });
        }

        function renderChartTheoNam(dataFromBE, namChonstr) {
            // Khởi tạo mảng 12 tháng = 0
            const tongTheoThang = Array(12).fill(0);
            const namChon = parseInt(namChonstr, 10); // 1 -> 12

            const now = new Date();
            const currentYear = now.getFullYear();
            const currentMonthIndex = now.getMonth();
            dataFromBE.forEach(item => {
                const [yearStr, monthStr] = item["thang_nam"].split('-');
                const year = parseInt(yearStr, 10);
                const month = parseInt(monthStr, 10); // 1 -> 12

                // Chỉ lấy dữ liệu của năm đang chọn
                if (year === namChon) {
                    let tongThang = 0;

                    // Cộng tất cả các field có "_luyke"
                    Object.keys(item).forEach(key => {
                        if (key !== "thang_nam" && key.endsWith('_luyke')) {
                            const val = parseInt(item[key], 10);
                            if (!isNaN(val)) {
                                tongThang += val;
                            }
                        }
                    });

                    // Gán vào đúng tháng (tháng 1 ở index 0)
                    tongTheoThang[month - 1] = tongThang;
                }
            });
            if (namChon === currentYear) {
                // Chỉ reset nếu năm đang chọn là năm hiện tại
                for (let i = currentMonthIndex + 1; i < 12; i++) {
                    tongTheoThang[i] = 0;
                }
            }
            // Cập nhật dữ liệu vào chart
            chart.data.datasets[0].data = tongTheoThang; // line
            chart.data.datasets[1].data = tongTheoThang; // bar
            chart.update();
        }

        const yearSelect = document.getElementById('yearSelect');
        const year = yearSelect.value
        fetchGetTongTheoNam(phuongxa)
        fetchGetTongTheoModule(phuongxa, year)
        getdatachart(phuongxa, year)

        // Lắng nghe sự kiện change
        yearSelect.addEventListener('change', function() {
            const selectedYear = this.value;
            fetchGetTongTheoModule(phuongxa, selectedYear)
            getdatachart(phuongxa, selectedYear)
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


    h4.text-primary {
        font-size: 28px;
    }

    h6.text-muted {
        font-size: 14px;
        color: #212529 !important;
        font-weight: 600;
    }

    .bg-primary-custom,
    .bg-success-custom,
    .bg-info-custom,
    .bg-warning-custom {
        position: relative;
        overflow: hidden;
        height: 50px;
        border-radius: 0 0 4px 4px;
        background-size: 300% 300%;
        animation: diagonalFlow 6s ease infinite;
    }

    /* Gradient chéo */
    .bg-primary-custom {
        background: linear-gradient(135deg, #007b8b, #03acc2ff, #007b8b);
    }

    .bg-success-custom {
        background: linear-gradient(135deg, #198754, #25c178ff, #198754);
    }

    .bg-info-custom {
        background: linear-gradient(135deg, #a82d48ce, #f0758fce, #a82d48ce);
    }

    .bg-warning-custom {
        background: linear-gradient(135deg, #846300ff, #d8a91dff, #846300ff);
    }

    /* Gradient động */
    @keyframes diagonalFlow {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Ánh sáng lướt */
    .bg-primary-custom::after,
    .bg-success-custom::after,
    .bg-info-custom::after,
    .bg-warning-custom::after {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(120deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.6) 50%,
                rgba(255, 255, 255, 0) 100%);
        transform: skewX(-20deg);
        animation: shimmerTilt 3s infinite;
    }

    /* hiệu ứng ánh sáng chạy */
    @keyframes shimmerTilt {
        0% {
            left: -75%;
        }

        60% {
            left: 125%;
        }

        100% {
            left: 125%;
        }
    }

    /* 🌟 delay tuần tự cho từng khối */
    .bg-primary-custom::after {
        animation-delay: 0s;
    }

    .bg-success-custom::after {
        animation-delay: 0.6s;
    }

    .bg-info-custom::after {
        animation-delay: 1.2s;
    }

    .bg-warning-custom::after {
        animation-delay: 1.8s;
    }
</style>