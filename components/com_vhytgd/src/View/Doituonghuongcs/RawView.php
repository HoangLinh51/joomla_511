<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Vhytgd\Site\View\Doituonghuongcs;

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

            case 'DS_DOITUONGHUONGCS':
                $this->_pageDOITUONGHUONGCS();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_DOITUONGCS':
                $this->_pageDetailDOITUONGCS();
                break;
        }
    }



    private function _pageDOITUONGHUONGCS()
    {
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'hoten' => $app->getString('hoten', 0),
            'cccd' => $app->getString('cccd', 0),

        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);
        $this->items = $model->getDanhSachDoiTuongCS($params, $startFrom, $perPage);
        $this->total = $model->CountDanhSachDoituongCS($params);
        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getString('thonto_id', ''),
            'nam_from' => $app->getString('nam_from', 0),
            'nam_to' => $app->getString('nam_to', 0),
            'thang_from' => $app->getString('thang_from', 0),
            'thang_to' => $app->getString('thang_to', 0),
            'loaidoituong_id' => $app->getInt('loaidoituong_id', ''),


        ];
        if (!empty($params['thonto_id'])) {
            $params['thonto_id'] = array_filter(explode(',', $params['thonto_id']), 'is_numeric');
        } else {
            $params['thonto_id'] = [];
        }
        $items = $model->getThongKeDoituonghuongcs($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
    private function _pageDetailDOITUONGCS()
    {
        $app = Factory::getApplication()->input;
        $doituong_id = $app->getInt('doituong_id', 0);
        $model = Core::model('Vhytgd/Doituonghuongcs');

        $details = $model->getDetailDOITUONGCS($doituong_id);
        // var_dump($details);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }

        echo '<div class="detail-container" style="font-size:15px">';

        // Hiển thị tên và mã đối tượng
        echo '<div style="width: 100%; padding-left: 10px;">';
        echo '<strong>Tên: </strong>' . htmlspecialchars($details[0]['n_hoten']) . '<br>';
        echo '<strong>Mã đối tượng: </strong>' . htmlspecialchars($details[0]['madoituong']);
        echo '</div>';

        // Thông tin chi tiết bên phải (bảng)
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table table-bordered">';

        echo '<thead>';
        echo '<tr>';
        echo '<th>Mã hỗ trợ</th>';
        echo '<th>Biến động</th>';
        echo '<th>Loại đối tượng</th>';
        echo '<th>Mức được hưởng</th>'; // Cột Mức được hưởng
        echo '<th>Quyết định</th>';
        echo '<th>Hưởng từ ngày</th>';
        echo '<th>Trạng thái</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($details as $detail) {
            // Tính toán số tiền
            $sotien = 0 ;
            if($detail['sotien'] > 0){
                $sotien = $detail['sotien'];
            }else {
                $sotien = $detail['muctieuchuan'] * $detail['heso'];
            }

            echo '<tr>';
            echo '<td>' . htmlspecialchars($detail['maht']) . '</td>';
            echo '<td>' . htmlspecialchars($detail['tenbiendong']) . '</td>';
            echo '<td>' . htmlspecialchars($detail['tenloaidoituong']) . '</td>';
            echo '<td>' . htmlspecialchars($sotien) . '</td>'; // Hiển thị rõ ràng
            echo '<td>' . 'Số quyết định: ' . htmlspecialchars($detail['soqdhuong']) . '<br>Hưởng từ ngày: ' . htmlspecialchars($detail['tungay']) . '</td>'; // Hiển thị quyết định
            echo '<td>' . htmlspecialchars($detail['tungay']) . '</td>';
            echo '<td>' . htmlspecialchars($detail['tentrangthai']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Kết thúc detail-content
        echo '</div>'; // Kết thúc detail-container

        Factory::getApplication()->close();
    }
}
