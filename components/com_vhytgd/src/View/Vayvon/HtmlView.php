<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vptk
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\Vayvon;

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
        $component  = 'com_vhytgd';
        $controller = $input->getCmd('view', 'vayvon');
        $task       = strtoupper($input->getCmd('task', 'default'));

        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }

        if ($task === 'ADD_VAYVON' || $task === 'EDIT_VAYVON' || $task === 'THONGKE') {
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
            case 'THONGKE':
                $this->setLayout('thongke');
                $this->_initDefaultPage();
                break;
            case 'ADD_VAYVON':
            case 'EDIT_VAYVON':
                $this->setLayout('edit_vayvon');
                $this->_getEditVayVon();
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
        $document = Factory::getDocument();
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/css/jquery.fileupload.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/dataTables/datatables.min.css');
        $document->addCustomTag('<link href="' . Uri::root(true) . '/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
        $document->addCustomTag('<link href="' . Uri::root(true) . '/templates/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::root(true) . '/components/com_vptk/js/flag-icons.min.css');

        $document->addScript(Uri::root(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
        // $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/dataTables/datatables.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript('https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js');
        $document->addScript(Uri::root(true) . '/media/legacy/js/jquery-noconflict.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/caydonvi.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::root(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/js/vendor/jquery.ui.widget.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/js/jquery.iframe-transport.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/js/jquery.fileupload.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');


        $model = Core::model('Vptk/Vptk');
        $phanquyen = $model->getPhanquyen();
        if ($phanquyen['phuongxa_id'] == '') {
            $phuongxa = array();
        } else if ($phanquyen['phuongxa_id'] == '-1') {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0', 'tenkhuvuc ASC');
        } else {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0 AND id IN (' . $phanquyen['phuongxa_id'] . ')', 'tenkhuvuc ASC');
        }
        $tinhtrang = Core::loadAssocList('danhmuc_trangthaivay', 'id, tentrangthaivay', 'trangthai = 1 AND daxoa = 0');
        $chuongtrinh = Core::loadAssocList('danhmuc_chuongtrinhvay', 'id,tenchuongtrinhvay', 'trangthai = 1 AND daxoa = 0');
        $this->chuongtrinh = $chuongtrinh;

        $this->phuongxa = $phuongxa;
        $this->tinhtrang = $tinhtrang;
    }
    public function _getEditVayVon()
    {
        $document = Factory::getDocument();
        $app = Factory::getApplication()->input;

        // Thêm các tag CSS và JS cần thiết
        $document->addCustomTag('<link href="' . Uri::base(true) . '/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
        $document->addCustomTag('<link href="' . Uri::base(true) . '/templates/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        $document->addStyleSheet(Uri::base(true) . '/media/cbcc/css/jquery.gritter.css');

        // Thêm các script cần thiết
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.gritter.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');

        $id = $app->getInt('thietche_id', null);
        $model = Core::model('Vhytgd/Vayvon');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $db = Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('a.id,a.tenkhuvuc,a.cha_id AS quanhuyen_id,b.cha_id AS tinhthanh_id,a.level');
            $query->from('danhmuc_khuvuc AS a');
            $query->innerJoin('danhmuc_khuvuc AS b ON a.cha_id = b.id');

            if ($phanquyen['phuongxa_id'] == '-1') {
                $query->where('a.level = 2 AND a.daxoa = 0');
            } else {
                $query->where('a.level = 2 AND a.daxoa = 0 AND a.id IN (' . $phanquyen['phuongxa_id'] . ')');
            }
            $query->order('tenkhuvuc ASC');
            $db->setQuery($query);
            $phuongxa = $db->loadAssocList();
        }

        $gioitinh = Core::loadAssocList('danhmuc_gioitinh', 'id,tengioitinh', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        $dantoc = Core::loadAssocList('danhmuc_dantoc', 'id,tendantoc', 'trangthai = 1 AND daxoa = 0 AND id != 1', 'sapxep ASC');
        $vayvon = Core::loadAssocList('danhmuc_nguonvon', 'id,tennguonvon', 'trangthai = 1 AND daxoa = 0');
        $chuongtrinh = Core::loadAssocList('danhmuc_chuongtrinhvay', 'id,tenchuongtrinhvay', 'trangthai = 1 AND daxoa = 0');
        $tochuc = Core::loadAssocList('danhmuc_doanhoi', 'id, tendoanhoi', 'trangthai = 1 AND daxoa = 0');
        $tinhtrang = Core::loadAssocList('danhmuc_trangthaivay', 'id, tentrangthaivay', 'trangthai = 1 AND daxoa = 0');



       

        $thonto_id = $app->getInt('thonto_id', null);
        $vayvon_id = $app->getInt('vayvon_id', null);
        $phuongxa_id = null;
        if ((int)$vayvon_id > 0) {
            $this->item = $model->getEditVayvon($vayvon_id);
        }

        if ((int)$phuongxa_id > 0) {
            $thonto = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc', 'sudung = 1 AND daxoa = 0 AND level = 3 AND cha_id = ' . (int)$phuongxa_id, 'tenkhuvuc ASC');
        } else {
            $thonto = array();
        }

        $this->tinhtrang = $tinhtrang;       
        $this->dantoc = $dantoc;
        $this->tochuc = $tochuc;
        $this->vayvon = $vayvon;
        $this->chuongtrinh = $chuongtrinh;
        $this->phuongxa = $phuongxa;
        $this->thonto = $thonto;
        $this->gioitinh = $gioitinh;
      
    }
}
