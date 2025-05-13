<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Thongbao\Site\View\Thongbao;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;
use Exception;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $id = $app->input->getInt('id');
        $task = $app->input->get('task', '', 'CMD');

        // Phân biệt edit vs add
        if (strtolower($task) === 'edit_thongbao') {
            $layout = $id > 0 ? 'EDIT_THONGBAO' : 'ADD_THONGBAO';
        } else {
            $layout = $task ? strtoupper($task) : 'DEFAULT';
        }

        switch ($layout) {
            case 'DEFAULT':
            case 'DS_THONGBAO':
                $this->setLayout('ds_thongbao');
                $this->_initDefaultPage();
                break;
            case 'DETAIL_THONGBAO':
                $this->setLayout('detail_thongbao');
                $this->_getDetailThongBao($id);
                break;
            case 'ADD_THONGBAO':
                $this->setLayout('edit_thongbao');
                // Không truyền ID vì đang tạo mới
                break;
            case 'EDIT_THONGBAO':
                $this->setLayout('edit_thongbao');
                $this->_getEditThongBao($id); // page edit nên truyền id
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
    }

    private function _getDetailThongBao($idThongbao)
    {
        $this->import();

        $modelThongbao = Core::model('Thongbao/Thongbao');
        $itemThongbao = $modelThongbao->getDetailThongbao($idThongbao);
        if (empty($itemThongbao)) {
            throw new Exception("Thông báo không tồn tại");
        }else {
            $this->item = $itemThongbao;
        }
    }
    public function _getEditThongBao($idThongbao)
    {
        $this->import();

        $modelThongbao = Core::model('Thongbao/Thongbao');
        $itemThongbao = $modelThongbao->getDetailThongbao($idThongbao);
        if (empty($itemThongbao)) {
            throw new Exception("Thông báo không tồn tại");
        } else {
            $this->item = $itemThongbao;
        }
    }

    private function import()
    {
        $document = Factory::getDocument();
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true).'/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/jquery/jquery.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
    	$document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/pace-progress/pace.min.js');
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js');

        return $document;
    }
}