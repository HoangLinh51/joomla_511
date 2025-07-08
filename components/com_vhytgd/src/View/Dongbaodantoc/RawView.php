<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Vhytgd\Site\View\Dongbaodantoc;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Component\Vhytgd\Site\Helper\VhytgdHelper;
use stdClass;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
class RawView extends BaseHtmlView
{
    /**
     * The pagination object
     *
     * @var    Pagination
     * @since  3.9.0
     */
    protected $pagination;
    /**
     * Display the view
     *
     * @param   string|null  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @throws  GenericDataException
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);
        $this->setLayout(strtolower($layout));
        switch ($layout) {

            case 'DS_NCC':
                $this->_pageNCC();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_NCC':
                $this->_pageDetailNCC();
                break;
        }
    }



    private function _pageNCC()
    {
        $model = Core::model('Vhytgd/Nguoicocong');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'hoten' => $app->getString('hoten', 0),
            'cccd' => $app->getString('cccd', 0),

        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);
        $this->items = $model->getDanhSachNguoiCoCong($params, $startFrom, $perPage);
        $this->total = $model->CountDanhSachNCC($params);
        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Vptk/Bdh');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'hoten' => $app->getString('hoten', 0),
            'cccd' => $app->getString('cccd', 0),

        ];
        if (!empty($params['thonto_id'])) {
            $params['thonto_id'] = array_filter(explode(',', $params['thonto_id']), 'is_numeric');
        } else {
            $params['thonto_id'] = [];
        }
        $items = $model->getThongKeBanDieuHanh($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
    private function _pageDetailNCC()
    {
        $app = Factory::getApplication()->input;
        $doituong_id = $app->getInt('doituong_id', 0);
        $model = Core::model('Vhytgd/Nguoicocong');

        $details = $model->getDetailDOITUONGCS($doituong_id);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }

        echo '<div class="detail-container" style="font-size:15px" >';

        // Hiển thị tên và mã đối tượng
        echo '<div style="width: 100%; padding-left: 10px;">';
        echo '<strong>Họ và tên: </strong>' . htmlspecialchars($details[0]['n_hoten']) . '<br>';
        echo '</div>';

        // Thông tin chi tiết bên phải (bảng)
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table table-bordered">';

        echo '<thead>';
        echo '<tr>';
        echo '<th>Hình thức hưởng</th>';
        echo '<th>Loại đối tượng</th>';
        echo '<th>Thực nhận</th>';
        echo '<th>Ngày hưởng</th>';
        echo '<th>Loại ưu đãi</th>';
        echo '<th>Trạng thái</th>';

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($details as $detail) {
            // Tính toán số tiền
            $sotien = $detail['muctieuchuan'] * $detail['heso'];

            // Xử lý hình thức
            $hinhThuc = htmlspecialchars($detail['is_hinhthuc']);
            $hinhThucText = '';
            if ($hinhThuc == 1) {
                $hinhThucText = 'Hàng tháng';
            } elseif ($hinhThuc == 2) {
                $hinhThucText = 'Một lần';
            } else {
                $hinhThucText = 'Không xác định';
            }

            echo '<tr>';
            echo '<td style="width:100px" >' . $hinhThucText . '</td>';  // Hiển thị hình thức
            echo '<td style="width:280px">' . htmlspecialchars($detail['tenncc']) . '</td>';
            echo '<td style="width:120px">' . 'Trợ cấp: ' . htmlspecialchars($detail['trocap']) . '<br>Phụ cấp: ' . htmlspecialchars($detail['phucap']) . '</td>'; // Hiển thị quyết định
            echo '<td style="width:110px">' . htmlspecialchars($detail['ngayhuong2']) . '</td>';
            echo '<td>' . 'Tên ưu đãi: ' . htmlspecialchars($detail['tenuudai']) . '<br>Nội dung ưu đãi: ' . htmlspecialchars($detail['noidunguudai']) . '<br>Trộ cấp ưu đãi: ' . htmlspecialchars($detail['trocapuudai']) . '<br> Ngày ưu đãi: ' . htmlspecialchars($detail['ngayuudai2']) . '</td>'; // Hiển thị quyết định


            echo '<td>' . htmlspecialchars($detail['trangthai']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Kết thúc detail-content
        echo '</div>'; // Kết thúc detail-container

        Factory::getApplication()->close();
    }
}
