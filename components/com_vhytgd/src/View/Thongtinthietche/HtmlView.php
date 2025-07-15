<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vptk
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\Thongtinthietche;

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
        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);


        switch ($layout) {
            case 'DEFAULT':
                $this->setLayout('default');
                $this->_initDefaultPage();
                break;
            case 'THONGKE':
                $this->setLayout('thongke');
                $this->_initDefaultPage();
                break;
            case 'ADD_THIETCHE':
            case 'EDIT_THIETCHE':
                $this->setLayout('edit_thietche');
                $this->_getEditThietChe();
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
    public function _getEditThietChe()
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
        $model = Core::model('Vhytgd/Thietche');
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

        // Kiểm tra ID và gán dữ liệu
        if ((int)$id > 0) {
            $this->thongtinthietche = $model->getDanhSachThongTinThietCheByID($id);
            $this->thongtinnamhoatdong = $model->getDanhSachNamHoatDongByID($id);
            $this->thongtinhoatdong = $model->getDanhSachHoatDongByID($id);
            $this->thongtinthietbi = $model->getThongTinThietBi($id);
        }

        // Lấy danh sách các thông tin khác
        $gioitinh = Core::loadAssocList('danhmuc_gioitinh', 'id,tengioitinh', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        $loaihinhthietche = Core::loadAssocList('danhmuc_loaihinhthietche', '*', 'trangthai = 1 AND daxoa = 0');
        $trinhdollct = Core::loadAssocList('danhmuc_lyluanchinhtri', 'id,tentrinhdo', 'trangthai = 1 AND daxoa = 0');
        $phuongxa2 = Core::loadAssocList('danhmuc_phuongxa', 'id,tenphuongxa', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC, tenphuongxa ASC');
        $chucdanhkiemnhiem = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 99');
        $chucdanh = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 1');
        $tinhtrang = Core::loadAssocList('danhmuc_tinhtrang', 'id,tentinhtrang', 'trangthai = 1 AND daxoa = 0');

        $thonto_id = $app->getInt('thonto_id', null);
        $nhiemky_id = $app->getInt('nhiemky_id', null);
        $phuongxa_id = null;

        if ($thonto_id != '') {
            $item = $model->getThanhVienBanDieuHanhID($thonto_id, $nhiemky_id);
            $tt_px = $model->getPhuongxa_thontoID($thonto_id, $nhiemky_id);
            $phuongxa_id = $item[0]['phuongxa_id'];
        } else {
            $item = array();
        }

        if ((int)$phuongxa_id > 0) {
            $thonto = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc', 'sudung = 1 AND daxoa = 0 AND level = 3 AND cha_id = ' . (int)$phuongxa_id, 'tenkhuvuc ASC');
        } else {
            $thonto = array();
        }

        // Gán các biến cho view
        $this->loaihinhthietche = $loaihinhthietche;
        $this->phuongxa2 = $phuongxa2;
        $this->phuongxa = $phuongxa;
        $this->thonto = $thonto;
        $this->gioitinh = $gioitinh;
        $this->item = $item;
        $this->trinhdollct = $trinhdollct;
        $this->chucdanh = $chucdanh;
        $this->chucdanhkiemnhiem = $chucdanhkiemnhiem;
        $this->tinhtrang = $tinhtrang;
    }
}
