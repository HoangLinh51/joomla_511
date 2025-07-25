<?php

/*****************************************************************************
 * @Author                : Nienvnd                                            *
 * @CreatedDate           : 2025-07-09                                        *
 * @LastEditors           : Nienvnd                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_dcxddt/src/View/Biensonha/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\Dcxddt\Site\View\Biensonha;

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

            case 'DS_BSN':
                $this->_pageBiensonha();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
            case 'DETAIL_BSN':
                $this->_pageDetailBSN();
                break;
        }
    }



    private function _pageBiensonha()
    {
        $model = Core::model('Dcxddt/Biensonha');
        $app = Factory::getApplication()->input;

        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', ''),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'tenduong' => $app->getInt('tenduong', ''),
        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);


        $this->items = $model->getDanhSachBienSoNha($params, $startFrom, $perPage);
        $this->total = $model->CountDanhSachBienSoNha($params);

        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Dcxddt/Biensonha');
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
        $items = $model->getThongKeBiensonha($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
    private function _pageDetailBSN()
    {
        $app = Factory::getApplication()->input;
        $sonha_id = $app->getInt('sonha_id', 0);

        $model = Core::model('Dcxddt/Biensonha');

        $details = $model->getDetailBSN($sonha_id);

        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }


        echo '<div class="detail-container d-flex">';



        // Thông tin chi tiết bên phải (bảng)
        echo '<div class="detail-content" style="width: 100%; padding-left: 10px;">';
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Thông tin sở hữu</th>';
        echo '<th>Số nhà</th>';
        echo '<th>Tờ bản đồ</th>';
        echo '<th>Thửa đất</th>';
        echo '<th>Hình thức cấp</th>';
        echo '<th>Lý do thay đổi</th>';
        echo '<th>Ghi chú</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($details as $detail) {
            echo '<tr>';
            // Cột Thông tin sở hữu
            echo '<td>';
            if (!empty($detail['tentochuc']) || (isset($detail['loaisohuu']) && $detail['loaisohuu'] == 2)) {
                // Hiển thị thông tin tổ chức
                echo '<strong>Tên tổ chức:</strong> ' . htmlspecialchars($detail['tentochuc'] ?? '') . '<br>';
                echo '<strong>Điện thoại:</strong> ' . htmlspecialchars($detail['n_dienthoai'] ?? '') . '<br>';
                echo '<strong>Địa chỉ:</strong> ' . htmlspecialchars($detail['n_diachi'] ?? '');
            } else {
                // Hiển thị thông tin cá nhân
                echo '<strong>Họ tên:</strong> ' . htmlspecialchars($detail['n_hoten'] ?? '') . '<br>';
                echo '<strong>CCCD:</strong> ' . htmlspecialchars($detail['n_cccd'] ?? '') . '<br>';
                echo '<strong>Điện thoại:</strong> ' . htmlspecialchars($detail['n_dienthoai'] ?? '') . '<br>';
                echo '<strong>Ngày sinh:</strong> ' . htmlspecialchars($detail['n_namsinh'] ?? '') . '<br>';
                echo '<strong>Giới tính:</strong> ' . htmlspecialchars($detail['tengioitinh'] ?? '') . '<br>';
                echo '<strong>Địa chỉ:</strong> ' . htmlspecialchars($detail['n_diachi'] ?? '');
            }
            echo '</td>';

            // Các cột còn lại
            echo '<td>' . htmlspecialchars($detail['sonha'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['tobandoso'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['thuadatso'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['tenhinhthuc'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['lydothaydoi'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($detail['ghichu'] ?? '') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        Factory::getApplication()->close();
    }
}
