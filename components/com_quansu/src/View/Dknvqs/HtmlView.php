<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_quansu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\QuanSu\Site\View\Dknvqs;

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
        $app = Factory::getApplication();
        $input = $app->input;
        $id = $input->getInt('id');
        $component = 'com_quansu';
        $controller = $input->getCmd('view', '');
        $task = strtolower($input->getCmd('task', 'default'));

        if (!Core::checkUserMenuPermission($user->id, $component, $controller, $task)) {
            echo '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <h2 style="color: #dc3545">Bạn không có quyền truy cập vào trang này!</h2>
                <a href="/index.php" style="text-decoration: none;">
                <button style="padding: 12px 8px; border:1px solid #fff; border-radius: 4px; background-color:#007bff; color: #fff; font-size:14px;cursor: pointer">
                    Trang chủ
                </button>
                </a>
              </div>';
            exit;
        }

        // Phân biệt edit vs add
        if ($task === 'edit_dknvqs') {
            $layout = $id > 0 ? 'EDIT_DKNVQS' : 'ADD_DKNVQS';
        } else {
            $layout = $task ? strtoupper($task) : 'DEFAULT';
        }

        switch ($layout) {
            case 'DEFAULT':
            case 'DS_DKNVQS':
                $this->setLayout('default');
                $this->_initDefaultPage();
                break;
            case 'ADD_DKNVQS':
            case 'EDIT_DKNVQS':
                $this->setLayout('edit_dknvqs');
                $this->_editDknvqs();
                break;
        }

        parent::display($tpl);
    }


    private function _initDefaultPage()
    {
        $this->import();
    }

    public function _editDknvqs()
    {
        $this->import();
        $app = Factory::getApplication()->input;
        $model = Core::model('QuanSu/Dknvqs');
        $detailDknvqs = null;
        $idNguoiDK = $app->getInt('id', null);
        if ($idNguoiDK) {
            $detailDknvqs = $model->getDetailDknvqs($idNguoiDK);
        }
        $this->detailDknvqs = $detailDknvqs;
    }
    

    private function import()
    {
        $document = Factory::getDocument();
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');;
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2-bootstrap.css');
        
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-3.6.0.min.js'); 
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js'); 
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js'); 
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.validate.min.js'); 
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.gritter.min.js');

        
        $model = Core::model('QuanSu/Base');
        $phanquyen = $model->getPhanQuyen();
        $phuongxa = array();
        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        $gioitinh = $model->getDanhMucGioiTinh();
        $doituong = $model->getDanhMucTrangThaiQuanSu(2);
        $dantoc = $model->getDanhMucDanToc();
        $trinhdohocvan = $model->getDanhMucTrinhDoHocVan();
        $quanhethannhan = $model->getDanhMucQuanHeThanNhan();
        $nghenghiep = $model->getDanhMucNgheNghiep();
        

        $this->nghenghiep = $nghenghiep;
        $this->quanhethannhan = $quanhethannhan;
        $this->trinhdohocvan = $trinhdohocvan;
        $this->dantoc = $dantoc;
        $this->phuongxa = $phuongxa;
        $this->doituong = $doituong;
        $this->gioitinh = $gioitinh;
        return $document;
    }
}
