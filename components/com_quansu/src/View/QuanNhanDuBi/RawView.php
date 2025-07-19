<?php

/*****************************************************************************
 * @Author                : LinhLH                                            *
 * @CreatedDate           : 2025-06-29                                        *
 * @LastEditors           : LinhLH                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_quansu/src/View/QuanNhanDuBi/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\QuanSu\Site\View\QuanNhanDuBi;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Core;
use Joomla\CMS\Factory;
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
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);
        $this->setLayout(strtolower($layout));
        switch ($layout) {


            case 'DS_THONGKE':
                $this->_pageThongke();
                break;
        }
    }
    private function _pageThongke()
    {
        $model = Core::model('QuanSu/QuanNhanDuBi');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getString('thonto_id', ''),
            'loaidoituong_id' => $app->getInt('loaidoituong_id', 0),

        ];
        if (!empty($params['thonto_id'])) {
            $params['thonto_id'] = array_filter(explode(',', $params['thonto_id']), 'is_numeric');
        } else {
            $params['thonto_id'] = [];
        }
        $items = $model->getThongKeQuanNhanDuBi($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
}