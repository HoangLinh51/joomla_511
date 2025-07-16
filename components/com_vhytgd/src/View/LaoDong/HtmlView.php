<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_baocaoloi
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\LaoDong;

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
        $component = 'com_vhytgd';
        $controller = $input->getCmd('view', '');
        $task = strtolower($input->getCmd('task', ''));

        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }

        $checkTask = in_array($task, ['ds_laodong', 'add_laodong', 'edit_laodong']) ? 'default' : $task;

        if (!Core::checkUserMenuPermission($user->id, $component, $controller, $checkTask)) {
            echo '<div style="display: flex; flex-direction: column; align-items: center;">
                <h2 style="color: #dc3545">Bạn không có quyền truy cập vào trang này!</h2>
                <a href="/index.php" style="text-decoration: none;">
                    <button style="padding: 12px 8px; border:1px solid #fff; border-radius: 4px; background-color:#007bff; color: #fff; font-size:14px;cursor: pointer">Trang chủ</button>
                </a>
            </div>';
            exit;
        }

        if ($task === 'edit_laodong') {
            $layout = $id > 0 ? 'edit_laodong' : 'add_laodong';
        } else {
            $layout = empty($task) || $task === 'default' ? 'ds_laodong' : $task;
        }

        switch ($layout) {
            case 'thongke':
                $this->setLayout('thongke');
                $this->_initDefaultPage();
                break;
            case 'ds_laodong':
                $this->setLayout('ds_laodong');
                $this->_initDefaultPage();
                break;
            case 'add_laodong':
            case 'edit_laodong':
                $this->setLayout('edit_laodong');
                $this->_editDVNhayCam();
                break;
            default:
                $this->setLayout('ds_laodong');
                $this->_initDefaultPage();
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
        $model = Core::model('Vhytgd/LaoDong');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();
        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        $doituong = $model->getDoiTuong();
        $gioitinh = $model->getDanhMucGioiTinh();
        $doituonguutien = $model->getListDoiTuongUuTien();
        $this->doituonguutien = $doituonguutien;

        $this->gioitinh = $gioitinh;
        $this->doituong = $doituong;
        $this->phuongxa = $phuongxa;
    }

    public function _editDVNhayCam()
    {
        $this->import();
        $app = Factory::getApplication()->input;
        $model = Core::model('Vhytgd/LaoDong');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();
        $detailCoSo = null;
        $idLaoDong = $app->getInt('id', null);
        $vithelamviec = $model->getListViThe();
        $doituonguutien = $model->getListDoiTuongUuTien();
        $nghenghiep = $model->getListNgheNghiep();
        $doituong = $model->getListDoiTuong();
        $dantoc = $model->getDanToc();
        $tongiao = $model->getTonGiao();
        $gioitinh = $model->getDanhMucGioiTinh();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        if ($idLaoDong) {
            $detailLaoDong = $model->getDetailLaoDong($idLaoDong);
        }

        $this->gioitinh = $gioitinh;
        $this->dantoc = $dantoc;
        $this->tongiao = $tongiao;
        $this->doituong = $doituong;
        $this->doituonguutien = $doituonguutien;
        $this->nghenghiep = $nghenghiep;
        $this->vithelamviec = $vithelamviec;
        $this->phuongxa = $phuongxa;
        $this->detailLaoDong = $detailLaoDong;
    }

    private function import()
    {
        $document = Factory::getDocument();
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2-bootstrap.css');

        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-3.6.0.min.js');
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/select2/select2.min.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.validate.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');
        $document->addScript(Uri::base(true) . '/media/legacy/js/jquery-noconflict.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.gritter.min.js');

        return $document;
    }
}
