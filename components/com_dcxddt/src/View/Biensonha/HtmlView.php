<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_doanhoi
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Dcxddt\Site\View\Biensonha;

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
            case 'ADD_BSN':
            case 'EDIT_BSN':
                $this->setLayout('edit_bsn');
                $this->_getEditBiensonha();
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
        $tuyenduong = Core::loadAssocList('danhmuc_tenduong', 'id,tenduong', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        $this->tuyenduong = $tuyenduong;
        $this->phuongxa = $phuongxa;
    }
    public function _getEditBiensonha()
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
        $model = Core::model('Dcxddt/Biensonha');
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

        $hinhthuccap = Core::loadAssocList('danhmuc_hinhthuccapsonha', 'id,tenhinhthuc', 'trangthai = 1 AND daxoa = 0');
        $gioitinh = Core::loadAssocList('danhmuc_gioitinh', 'id,tengioitinh', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');

        $tenduong = Core::loadAssocList('danhmuc_tenduong', 'id,tenduong', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');


        $thonto_id = $app->getInt('thonto_id', null);
        $bsn_id = $app->getInt('bsn_id', null);
        $phuongxa_id = null;
        if ((int)$bsn_id > 0) {
            $this->item = $model->getEditBienSonha($bsn_id);
        }

        if ((int)$phuongxa_id > 0) {
            $thonto = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc', 'sudung = 1 AND daxoa = 0 AND level = 3 AND cha_id = ' . (int)$phuongxa_id, 'tenkhuvuc ASC');
        } else {
            $thonto = array();
        }

        // Gán các biến cho view
        $this->tenduong = $tenduong;
        $this->gioitinh = $gioitinh;
        $this->hinhthuccap = $hinhthuccap;
        $this->phuongxa = $phuongxa;
        $this->thonto = $thonto;
    }
}
