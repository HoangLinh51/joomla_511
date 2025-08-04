<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_doanhoi
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\DoanHoi;

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
        $component  = 'com_vhytgd';
        $controller = $input->getCmd('view', 'doanhoi');
        $task       = strtoupper($input->getCmd('task', 'default'));

        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }

        if ($task === 'THONGKE') {
            $checkTask = 'default';
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
            case 'DEFAULT':
                $this->setLayout('default');
                $this->_initDefaultPage();
                break;
            case 'THONGKE':
                $this->setLayout('thongke');
                $this->_initDefaultPage();
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
        $model = Core::model('Vhytgd/DoanHoi');
        $user = Factory::getUser();
        $phanquyen = $model->getPhanQuyen();
        $doanhoiPhanQuyen = $model->getPhanQuyenDoanHoi($user->id);
        $danhMucGioiTinh = $model->getDanhMucGioiTinh();
        $dmdoanhoi = $model->getListDanhMucDoanHoi();
        $phuongxa = array();
        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        $is_dung = 1;
        if($doanhoiPhanQuyen['is_doanvien'] != '1' ){
            $is_dung= 2 ;
        }
        $chucdanh = $model->getChucDanhTheoDoanHoi($is_dung);
        $dantoc = $model->getDanToc();
        $tongiao = $model->getTonGiao();
        // var_dump($phuongxa);
        
        $this->gioitinh = $danhMucGioiTinh;
        $this->doanhoiPhanQuyen = $doanhoiPhanQuyen;
        $this->doanhoi = $dmdoanhoi;
        $this->chucdanh = $chucdanh;
        $this->dantoc = $dantoc;
        $this->tongiao = $tongiao;
        $this->phuongxa = $phuongxa;
    }
    

    private function import()
    {
        $document = Factory::getDocument();

        // CSS: Framework trước, sau đó đến plugin
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');;
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css'); // Xóa dòng trùng lặp
        // $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2.min.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2-bootstrap.css');


        // JS: jQuery trước, sau đó đến plugin  media/cbcc/js/datetimepicker-master/jquery.datetimepicker.full.min.js
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-3.6.0.min.js'); // Chỉ giữ một phiên bản jQuery
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js'); // Tải ngay sau jQuery
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js'); // Bootstrap JS
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.validate.min.js'); // Chỉ giữ phiên bản nén
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
