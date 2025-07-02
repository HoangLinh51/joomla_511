<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Vhytgd\Site\View\Giadinhvanhoa;

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

            case 'DS_GDVANHOA':
                $this->_pageGDVANHOA();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_GIADINH':
                $this->_pageDetailGDVH();
                break;
        }
    }



    private function _pageGDVANHOA()
    {
        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $app = Factory::getApplication()->input;

        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', ''),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'nam' => $app->getInt('nam', ''),

        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);


        $this->items = $model->getDanhSachGiaDinhVanHoa($params, $startFrom, $perPage);
        $this->total = $model->CountDanhSachGiaDinhVanHoa($params);

        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Vptk/Bdh');
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
        $items = $model->getThongKeBanDieuHanh($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
    private function _pageDetailGDVH()
    {
        $app = Factory::getApplication()->input;
        $thonto_id = $app->getInt('thonto_id', 0);
        $nam = $app->getInt('nam', 0);

        $model = Core::model('Vhytgd/Giadinhvanhoa');

        $details = $model->getDetailGDVH($thonto_id, $nam);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }


        echo '<div class="detail-container d-flex">';



        // Thông tin chi tiết bên phải (bảng)
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table  table-bordered ">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Họ tên</th>';
        echo '<th>Địa chỉ</th>';
        echo '<th>Đạt/Không</th>';
        echo '<th>Gia đình tiêu biểu</th>';
        echo '<th>Lý do không đạt</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($details as $detail) {
           

            echo '<tr>';
            echo '<td>' . htmlspecialchars($detail['n_hoten']) . '</td>';
            echo '<td>' . htmlspecialchars($detail['n_diachi'] ?? 'Không có') . '</td>';
            echo '<td>' . htmlspecialchars($detail['is_dat'] == 1 ? 'Đạt' : 'Không đạt') . '</td>';
            echo '<td>' . htmlspecialchars($detail['is_giadinhvanhoatieubieu'] == 1 ? 'Đạt' : '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['lydokhongdat'] ?? '') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Kết thúc detail-content
        echo '</div>'; // Kết thúc detail-container

        Factory::getApplication()->close();
    }
}
