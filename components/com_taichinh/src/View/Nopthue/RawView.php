<?php

/*****************************************************************************
 * @Author                : Nienvnd                                            *
 * @CreatedDate           : 2025-07-09                                        *
 * @LastEditors           : Nienvnd                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_dcxddt/src/View/Biensonha/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\Taichinh\Site\View\Nopthue;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
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

            case 'DS_THUEDAT':
                $this->_page();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_THUEDAT':
                $this->_pageDetailTHUEDAT();
                break;
        }
    }



    private function _page()
    {
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication()->input;

        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', ''),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'tenduong' => $app->getInt('tenduong', ''),

        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);


        $this->items = $model->getDanhSachNopThue($params, $startFrom, $perPage);
        $this->total = $model->CountDanhSachNopThue($params);

        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getString('thonto_id', ''),
            'chucdanh_id' => $app->getInt('chucdanh_id', 0),
            'nhiemky_id' => $app->getInt('nhiemky_id', 0),

        ];
        if (!empty($params['thonto_id'])) {
            $params['thonto_id'] = array_filter(explode(',', $params['thonto_id']), 'is_numeric');
        } else {
            $params['thonto_id'] = [];
        }
        $items = $model->getThongKeNopThue($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
    private function _pageDetailTHUEDAT()
    {
        $app = Factory::getApplication()->input;
        $thuedat_id = $app->getInt('thuedat_id', 0);

        $model = Core::model('Taichinh/Nopthue');

        $details = $model->getDetailthuedat($thuedat_id);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }


        echo '<div class="detail-container d-flex" style="font-size:14px">';
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="table-primary">';
        echo '<tr>';
        echo '<th>Mã PNN</th>';
        echo '<th>Địa chỉ thửa đất</th>';
        echo '<th>Giấy chứng nhận</th>';
        echo '<th>Thông Tin Thửa Đất</th>';
        echo '<th>Diện tích sử dụng</th>';
        echo '<th>Mục đích sử dụng</th>';
        echo '<th>Miễn giảm thuế</th>';
        echo '<th>Tổng tiền nộp</th>';
        echo '<th>Tình trạng</th>';
        echo '<th>Ghi chú</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($details as $index => $detail) {
            $sotienmiengiam = $detail['tongtiennop'] ?? 0; // Mặc định là 0 nếu không có giá trị
            $formatted_money = (floor($sotienmiengiam) == $sotienmiengiam) ?
                number_format($sotienmiengiam, 0, ',', '.') :
                number_format($sotienmiengiam, 2, ',', '.');
            echo '<tr>';


            // Các cột còn lại
            echo '<td class="align-middle">' . htmlspecialchars($detail['maphinongnghiep'] ?? '') . '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($detail['diachi'] ?? '') . '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($detail['sogcn'] ?? '') . '-' . htmlspecialchars($detail['ngaycn'] ?? '');
            echo '</td>';
            echo '<td class="align-middle">';
            echo '<strong>Tờ bản đồ:</strong> ' . htmlspecialchars($detail['tobando'] ?? '') . '<br>';
            echo '<strong>Thửa đất:</strong> ' . htmlspecialchars($detail['thuadat'] ?? '');
            echo '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($detail['dientich_sd'] ?? '') . '</td>';

            echo '<td class="align-middle">' . htmlspecialchars($detail['tenmucdich'] ?? '') . '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($detail['sotienmiengiam'] ?? '') . '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($formatted_money) . '</td>';
            echo '<td class="align-middle">';
            echo $detail['tinhtrang'] == 1 ? 'Chưa nộp' : ($detail['tinhtrang'] == 2 ? 'Đã nộp' : '');
            echo '</td>';
            echo '<td class="align-middle">' . htmlspecialchars($detail['ghichu'] ?? '') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';

        Factory::getApplication()->close();
    }
}
