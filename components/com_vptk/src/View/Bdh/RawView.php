<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\VPTK\Site\View\Bdh;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Component\VPTK\Site\Helper\VPTKHelper;
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

            case 'DS_BDH':
                $this->_pageBDH();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
        }
    }



    private function _pageBDH()
    {
        $model = Core::model('Vptk/Bdh');
        $app = Factory::getApplication()->input;

        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', ''),
            'thonto_id' => $app->getInt('thonto_id', ''),
            'hoten' => $app->getString('hoten', ''),
            'chucdanh_id' => $app->getInt('chucdanh_id', ''),
            'chucvukn_id' => $app->getInt('chucvukn_id', ''),
            'tinhtrang_id' => $app->getInt('tinhtrang_id', ''),
            'chucdanh_kn' => $app->getInt('chucdanh_kn', ''),
            'daxoa' => $app->getInt('daxoa', 0) // Giả sử có tham số này
        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);

        // XÓA BỎ TOÀN BỘ LOGIC PHÂN TRANG THỦ CÔNG
        // GỌI MODEL ĐÚNG CÁCH ĐỂ PHÂN TRANG TẠI SQL
        $this->items = $model->getDanhSachBanDieuHanh($params, $startFrom, $perPage);
        $this->countitems = $model->countitems($params);

        // Không cần xử lý gì thêm, chỉ cần gọi display
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
}
