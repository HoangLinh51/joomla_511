<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vptk
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\VPTK\Site\View\Tcdc;

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
        $input = Factory::getApplication()->input;
        $component = 'com_vptk';
        $controller = $input->getCmd('view', 'bdh');
        $task = strtoupper($input->getCmd('task', 'default'));
        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }
        if ($task === 'THONGKE' || $task === 'ADD_BDH' || $task === 'EDIT_BDH') {
            $checkTask = 'default';
        }

        // if (!Core::checkUserMenuPermission($user->id, $component, $controller, $checkTask)) {
        //     echo '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        //             <h2 style="color: #dc3545">Bạn không có quyền truy cập vào trang này!</h2>
        //             <a href="/index.php" style="text-decoration: none;">
        //                 <button style="padding: 12px 8px; border:1px solid #fff; border-radius: 4px; background-color:#007bff; color: #fff; font-size:14px;cursor: pointer">
        //                     Trang chủ
        //                 </button>
        //             </a>
        //         </div>';
        //     exit;
        // }

        switch ($task) {

            case 'XEM_TCDC':
                $this->setLayout('xem_tcdc');
                $this->_getXemTCDC();
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
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
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
        $gioitinh = Core::loadAssocList('danhmuc_gioitinh', 'id,tengioitinh', 'trangthai = 1 AND daxoa = 0', 'sapxep ASC');
        if ($phanquyen['phuongxa_id'] == '') {
            $phuongxa = array();
        } else if ($phanquyen['phuongxa_id'] == '-1') {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0', 'tenkhuvuc ASC');
        } else {
            $phuongxa = Core::loadAssocList('danhmuc_khuvuc', 'id,tenkhuvuc,cha_id,level', 'level = 2 AND daxoa = 0 AND id IN (' . $phanquyen['phuongxa_id'] . ')', 'tenkhuvuc ASC');
        }
        $chucdanh = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 1');
        $tinhtrang = Core::loadAssocList('danhmuc_tinhtrang', 'id,tentinhtrang', 'trangthai = 1 AND daxoa = 0 ');
        $chucdanhkiemnhiem = Core::loadAssocList('danhmuc_chucdanh', 'id,tenchucdanh', 'trangthai = 1 AND daxoa = 0 AND module_id = 99');
        $nhiemky = Core::loadAssocList('danhmuc_nhiemky', 'id,tennhiemky', 'trangthai = 1 AND daxoa = 0');
        $this->nhiemky = $nhiemky;

        $this->gioitinh = $gioitinh;
        $this->phuongxa = $phuongxa;
        $this->chucdanh = $chucdanh;
        $this->chucdanhkiemnhiem = $chucdanhkiemnhiem;
        $this->tinhtrang = $tinhtrang;
    }
    public function _getXemTCDC()
    {
        $document = Factory::getDocument();
        $app = Factory::getApplication()->input;

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
        // $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
        // $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/jquery.validate.js' );
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
        // $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/datatables-rowgroup/js/dataTables.rowGroup.js');

        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.gritter.min.js');
        // $document->addScript('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        // $document->addScript(Uri::base(true).'/media/legacy/js/jquery-noconflict.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/pace-progress/pace.min.js');


        // Lấy dữ liệu từ model
        $model = Core::model('Vptk/Tcdc');
        $nhankhau_id = $app->getInt('id', null);

        if ($nhankhau_id !== null) {
            $item = $model->getThongTinTCCD($nhankhau_id);
            $nhanthan = $model->getThongTinNhanThan($item['hokhau_id'] ?? 0);
            $bandieuhanh = $model->getThongTinBanDieuHanh($item['id'] ?? 0);
            $chinhsach = $model->getThongtinDoiTuongCS($item['id'] ?? 0);
            $vayvon = $model->getThongTinVay($item['id'] ?? 0);
            $nguoicocong = $model->getThongTinNCC($item['id'] ?? 0);
            $giadinhvanhoa = $model->getThongTinGDVH($item['id'] ?? 0);
            $doanhoi = $model->getThongTinDHoi($item['id'] ?? 0);
            $sonha = $model->getThongTinSoNha($item['id'] ?? 0);
            $nopthue = $model->getThongTinDat($item['id'] ?? 0);
            $baoluc = $model->getThongtinBaoluc($item['id'] ?? 0);
            $treem = $model->getThongtinTreEm($item['id'] ?? 0);
            $dongbao = $model->getThongtinDBDT($item['id'] ?? 0);

        } else {
            $item = [];
            $nhanthan = [];
            $bandieuhanh = [];
            $chinhsach = [];
            $vayvon = [];
            $nguoicocong = [];
            $giadinhvanhoa = [];
            $doanhoi = [];
            $sonha = [];
            $nopthue = [];
            $baoluc = [];
            $treem = [];
            $dongbao = [];
        }

        $this->item = $item;
        $this->nhanthan = $nhanthan;
        $this->bandieuhanh = $bandieuhanh;
        $this->chinhsach = $chinhsach;
        $this->vayvon = $vayvon;
        $this->nguoicocong = $nguoicocong;
        $this->giadinhvanhoa = $giadinhvanhoa;
        $this->doanhoi = $doanhoi;
        $this->sonha = $sonha;
        $this->nopthue = $nopthue;
        $this->baoluc = $baoluc;
        $this->treem = $treem;
        $this->dongbao = $dongbao;
    }
}
