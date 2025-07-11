<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Vhytgd\Site\View\Giadinhtreem;

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

            case 'DS_VAYVON':
                $this->_pageVayVon();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_VAYVON':
                $this->_pageDetailVayVon();
                break;
        }
    }



    private function _pageVayVon()
    {
        $model = Core::model('Vhytgd/Vayvon');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'hoten' => $app->getString('hoten', 0),
            'makhachhang' => $app->getString('makhachhang', 0),

        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);
        $this->items = $model->getDanhSachVayVon($params, $startFrom, $perPage);
        $this->total = $model->CountDBDT($params);
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
    private function _pageDetailVayVon()
    {
        $app = Factory::getApplication()->input;
        $vayvon_id = $app->getInt('vayvon_id', 0);
        $model = Core::model('Vhytgd/Vayvon');

        $details = $model->getDetailVayVon($vayvon_id);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }

        echo '<div class="detail-container" style="font-size:15px" >';

        // Hiển thị tên và mã đối tượng
        echo '<div style="width: 100%; padding-left: 10px; margin-bottom: 10px">';
        echo '<strong>Họ và tên: </strong>' . htmlspecialchars($details[0]['n_hoten'])  .' <strong style="margin-left: 10px">Mã khách hàng: </strong>' . htmlspecialchars($details[0]['makh']);
        echo '</div>';

        // Thông tin chi tiết bên phải (bảng)
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table table-bordered">';

        echo '<thead>';
        echo '<tr>';
        echo '<th>Số món vay</th>';
        echo '<th>Nguồn vốn</th>';
        echo '<th>Chương trình</th>';
        echo '<th>Tổng dư nợ</th>';
        echo '<th>Ngày giải ngân và hạn</th>';
        echo '<th>Tổ chức hội</th>';
        echo '<th>Tình trạng</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($details as $detail) {

            // Xử lý hình thức
           

            echo '<tr>';
            echo '<td >' . htmlspecialchars($detail['somonvay']) . '</td>';
            echo '<td >' . htmlspecialchars($detail['tennguonvon']) . '</td>';
            echo '<td >' . htmlspecialchars($detail['tenchuongtrinhvay']) . '</td>';
            echo '<td >' . htmlspecialchars($detail['tongduno_formatted']) . '</td>';

            echo '<td >' . htmlspecialchars($detail['ngaygiaingan2']) . '-' .  htmlspecialchars($detail['ngaydenhan2']) .'</td>';
            echo '<td >' . htmlspecialchars($detail['tendoanhoi']) . '</td>';
            echo '<td>' . htmlspecialchars($detail['tentrangthaivay']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Kết thúc detail-content
        echo '</div>'; // Kết thúc detail-container

        Factory::getApplication()->close();
    }
}
