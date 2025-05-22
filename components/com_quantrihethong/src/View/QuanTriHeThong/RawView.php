<?php

/*****************************************************************************
 * @Author                : LinhLH                                            *
 * @CreatedDate           : 2025-05-20                                        *
 * @LastEditors           : LinhLH                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_quantrihethong/src/View/QuanTriHeThong/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\QuanTriHeThong\Site\View\QuanTriHeThong;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

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

  function display($tpl = null)
  {
    $app = Factory::getApplication();
    $task = $app->input->get('task', 'default');
    switch ($task) {
      case "dstaikhoan":
        $this->_getDanhsachTaikhoan();
        $this->setLayout('dstaikhoan');
        break;

    }
    parent::display($tpl);
  }

  public function _getDanhsachTaikhoan()
  {
    $model = Core::model('Vptk/Danhmuc');
    $items = $model->getDanhsachTaikhoan();
    $this->item = $items;
  }
}
