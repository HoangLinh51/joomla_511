<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Vhytgd\Site\View\Thongtinthietche;

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

            case 'DS_THIETCHE':
                $this->_pageTHIETCHE();
                break;
            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
        }
    }



    private function _pageTHIETCHE()
    {
        $model = Core::model('Vhytgd/Thietche');
        $app = Factory::getApplication()->input;

        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', ''),
            'tenthietche' => $app->getString('tenthietche', ''),
            'loaihinhthietche_id' => $app->getInt('loaihinhthietche_id', ''),
            'tinhtrang_id' => $app->getInt('tinhtrang_id', ''),
          
        ];

        $perPage = 20;
        $startFrom = $app->getInt('start', 0);

       
        $this->items = $model->getDanhSachThongTinThietChe($params, $startFrom, $perPage);
        $this->total = $model->countThongTinThietChe($params);

        // Không cần xử lý gì thêm, chỉ cần gọi display
        parent::display();
    }
    private function _pageThongke()
    {
        $model = Core::model('Vhytgd/Thietche');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'trangthai_id' => $app->getInt('trangthai_id', 0),
            'thietche_id' => $app->getInt('thietche_id', 0),

        ];
      
        $items = $model->getThongKeThietche($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
}
