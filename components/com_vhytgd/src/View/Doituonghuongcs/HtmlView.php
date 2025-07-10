<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vptk
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\Doituonghuongcs;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;
use stdClass;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        $user = Factory::getUser();
        $app = Factory::getApplication();
        $input = $app->input;
        $component = 'com_vhytgd';
        $controller = $input->getCmd('view', '');
        $task = strtolower($input->getCmd('task', 'default'));
        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }
        if ($task === 'THONGKE' || $task === 'ADD_DTCS' || $task === 'EDIT_DTCS') {
            $checkTask = 'default';
        }
        if (!Core::checkUserMenuPermission($user->id, $component, $controller, $checkTask)) {
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
                $this->setLayout('default');
                $this->_initDefaultPage();
                break;
            case 'THONGKE':
                $this->setLayout('thongke');
                $this->_initDefaultPage();
                break;
            case 'ADD_DTCS':
            case 'EDIT_DTCS':
                $this->setLayout('edit_dtcs');
                $this->_getEditDoituongcs();
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
        $loaihinhthietche = Core::loadAssocList('danhmuc_loaihinhthietche', 'id,tenloaihinhthietche', 'trangthai = 1 AND daxoa = 0');
        $nhiemky = Core::loadAssocList('danhmuc_nhiemky', 'id,tennhiemky', 'trangthai = 1 AND daxoa = 0');
        $this->nhiemky = $nhiemky;

        $this->phuongxa = $phuongxa;
        $this->loaihinhthietche = $loaihinhthietche;
    }
    public function _getEditDoituongcs()
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
        $model = Core::model('Vhytgd/Doituonghuongcs');
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
        $dantoc = Core::loadAssocList('danhmuc_dantoc', 'id,tendantoc', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        $nganhang = Core::loadAssocList('dmnganhang', 'id,ten,ma', 'trangthai = 1 AND daxoa = 0');
        $chinhsach = Core::loadAssocList('dmchinhsach', 'id,ten,ma', 'trangthai = 1 AND daxoa = 0');
        $loaidoituong = Core::loadAssocList('dmloaidoituong', '*', 'trangthai = 1 AND daxoa = 0');



        $loaihinhthietche = Core::loadAssocList('danhmuc_loaihinhthietche', '*', 'trangthai = 1 AND daxoa = 0');
        $trinhdollct = Core::loadAssocList('danhmuc_lyluanchinhtri', 'id,tentrinhdo', 'trangthai = 1 AND daxoa = 0');
        $phuongxa2 = Core::loadAssocList('danhmuc_phuongxa', 'id,tenphuongxa', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC, tenphuongxa ASC');
        $chucdanhkiemnhiem = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 99');
        $chucdanh = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 1');
        $tinhtrang = Core::loadAssocList('danhmuc_tinhtrang', 'id,tentinhtrang', 'trangthai = 1 AND daxoa = 0');

        $thonto_id = $app->getInt('thonto_id', null);
        $giadinhvanhoa_id = $app->getInt('giadinh_id', null);
        $phuongxa_id = null;
        if ((int)$giadinhvanhoa_id > 0) {
            $this->item = $model->getEditGiaDinhVanHoa($giadinhvanhoa_id);
        }

        if ((int)$phuongxa_id > 0) {
            $thonto = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc', 'sudung = 1 AND daxoa = 0 AND level = 3 AND cha_id = ' . (int)$phuongxa_id, 'tenkhuvuc ASC');
        } else {
            $thonto = array();
        }

        // Gán các biến cho view
        $this->loaihinhthietche = $loaihinhthietche;
        $this->dantoc = $dantoc;
        $this->loaidoituong = $loaidoituong;
        $this->nganhang = $nganhang;
        $this->chinhsach = $chinhsach;
        $this->phuongxa2 = $phuongxa2;
        $this->phuongxa = $phuongxa;
        $this->thonto = $thonto;
        $this->gioitinh = $gioitinh;
        $this->trinhdollct = $trinhdollct;
        $this->chucdanh = $chucdanh;
        $this->chucdanhkiemnhiem = $chucdanhkiemnhiem;
        $this->tinhtrang = $tinhtrang;
    }
}
