<?php

namespace Joomla\Component\Dcxddt\Site\View\Viahe;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        $user = Factory::getUser();
        $input = Factory::getApplication()->input;
        $component = 'com_dcxddt';
        $controller = $input->getCmd('view', 'viahe');
        $task = strtoupper($input->getCmd('task', 'default'));

        // Không kiểm tra đăng nhập hoặc quyền cho task CHITIETVIAHE
        if ($task === 'CHITIETVIAHE') {
            $this->setLayout('chitiet_viahe');
            $this->_getEditViahe();
            parent::display($tpl);
            return;
        }

        // Kiểm tra đăng nhập cho các task khác
        $user = Factory::getUser();
        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
            exit;
        }

        if ($task === 'THONGKE' || $task === 'ADDVIAHE' || $task === 'EDITVIAHE' || $task === 'XEMCHITIET' || $task === 'ADDLOGO' ) {
            $checkTask = 'default';
        } else {
            $checkTask = $task;
        }

        if (!Core::checkUserMenuPermission($user->id, $component, $controller, $checkTask)) {
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

        switch ($task) {
            case 'ADDVIAHE':
            case 'EDITVIAHE':
                $this->setLayout('edit_viahe');
                $this->_getEditViahe();
                break;
            case 'ADDLOGO':
            case 'EDITLOGO':
                $this->setLayout('edit_logo');
                $this->_getEditlogo();
                break;
            case 'XEMCHITIET':
                $this->setLayout('chitiet_viahe');
                $this->_getEditViahe();
                break;
            case 'THONGKE':
                $this->setLayout('thongke');
                $this->_getThongKe();
                break;
            default:
                $this->setLayout('default');
                $this->_initDefaultPage();
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
        $model = Core::model('Dcxddt/Viahe');
        $phanquyen = $model->getPhanQuyen();
        $logoPhanQuyen = $model->getlogoPhanQuyen($phanquyen['phuongxa_id']);
        $this->logo = $logoPhanQuyen;
    }

    private function _getEditlogo()
    {
        $this->import();
        $model = Core::model('Dcxddt/XeOm');
        $phanquyen = $model->getPhanQuyen();
        $phuongxa = array();
        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc', 'level = 2 AND sudung = 1 AND daxoa = 0');
        $this->phuongxa = $phuongxa;
    }

    private function _getEditViahe()
    {
        $document = Factory::getDocument();

        // CSS
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2-bootstrap.css');

        // JS
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
        $model = Core::model('Dcxddt/Viahe');
        $input = Factory::getApplication()->input;
        $viahe_id = $input->getInt('id', 0);
        $thongtinthanhphan = [];
        if ($viahe_id) {
            $item = $model->getThongtinViahe($viahe_id);
            if (!$item) {
                echo '<div class="alert alert-error">Không tìm thấy dữ liệu vỉa hè.</div>';
                return;
            }
        } else {
            echo '<div class="alert alert-error">ID không hợp lệ.</div>';
            return;
        }
        $this->item = $item;
        $this->thongtinthanhphan = $thongtinthanhphan;
    }

    private function _getThongKe()
    {
        $this->import();
        $model = Core::model('Dcxddt/Viahe');
        $phanquyen = $model->getPhanquyen();

        $phuongxa = [];
        if ($phanquyen['phuongxa_id'] === '-1') {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0', 'tenkhuvuc ASC');
        } elseif ($phanquyen['phuongxa_id'] !== '') {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0 AND id IN (' . $phanquyen['phuongxa_id'] . ')', 'tenkhuvuc ASC');
        }

        $nhiemky = Core::loadAssocList('danhmuc_nhiemky', 'id,tennhiemky', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        $chucdanh = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');

        $this->phuongxa = $phuongxa;
        $this->nhiemky = $nhiemky;
        $this->chucdanh = $chucdanh;
    }

    private function import()
    {
        $document = Factory::getDocument();

        // CSS
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2-bootstrap.css');

        // JS
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

        return $document;
    }
}
