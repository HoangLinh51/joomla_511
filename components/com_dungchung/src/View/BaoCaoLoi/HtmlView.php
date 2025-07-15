<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_dungchung
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\DungChung\Site\View\BaoCaoLoi;

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

        $user = Factory::getUser();
        $input = Factory::getApplication()->input;
        $id = $input->getInt('id');
        $task =  strtoupper($input->getCmd('task', 'default'));
        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }
        $modelHdsd = Core::model('DungChung/Hdsd');
        $permission = $modelHdsd->checkPermission();
        $this->permission = $permission;
        if ( ($task === 'DETAIL_BAOCAOLOI' || $task === 'ADD_BAOCAOLOI') && $permission === false) {
            echo '<div style="display: flex; flex-direction: column; align-items: center;">
                <h2 style="color: #dc3545">Bạn không có quyền truy cập vào trang này!</h2>
                <a href="/index.php" style="text-decoration: none;">
                <button style="padding: 12px 8px; border:1px solid #fff; border-radius: 4px; background-color:#007bff; color: #fff; font-size:14px;cursor: pointer">Trang chủ</button>
                </a>
              </div>';
            exit;
        }

        switch ($task) {
            case 'DEFAULT':
            case 'DS_BAOCAOLOI':
                $this->setLayout('ds_baocaoloi');
                $this->_initDefaultPage();
                break;
            case 'DETAIL_BAOCAOLOI':
                $this->setLayout('detail_baocaoloi');
                $this->_getDetailBaoCaoLoi($id);
                break;
            case 'ADD_BAOCAOLOI':
                $this->setLayout('create_baocaoloi');
                // Không truyền ID vì đang tạo mới
                $this->_createBaoCaoLoi();
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
    }

    private function _getDetailBaoCaoLoi($idBaoCaoLoi)
    {
        $this->import();

        $model = Core::model('DungChung/BaoCaoLoi');
        $itemBaoCaoLoi = $model->getDetailBaoCaoLoi($idBaoCaoLoi);
        if (empty($itemBaoCaoLoi)) {
            throw new Exception("Thông báo không tồn tại");
        } else {
            $this->item = $itemBaoCaoLoi;
        }
    }
    public function _createBaoCaoLoi()
    {
        $this->import();

        $model = Core::model('DungChung/BaoCaoLoi');
        $this->nameError = $model->getListNameError();
        $this->nameModule = $model->getListNameModule();
    }

    private function import()
    {
        $document = Factory::getDocument();
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js');

        return $document;
    }
}
