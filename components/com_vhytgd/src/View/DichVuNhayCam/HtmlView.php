<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_baocaoloi
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\View\DichVuNhayCam;

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
        $app    = Factory::getApplication();
        $user   = Factory::getUser();
        $input  = $app->input;
        $id     = $input->getInt('id');
        $component  = 'com_vhytgd';
        $controller = $input->getCmd('view', '');
        $task       = strtolower($input->getCmd('task', 'default'));

        if (!Core::checkUserMenuPermission($user->id, $component, $controller, $task)) {
            echo '<div style="display: flex; flex-direction: column; align-items: center;">
                <h2 style="color: #dc3545">Bạn không có quyền truy cập vào trang này!</h2>
                <a href="/index.php" style="text-decoration: none;">
                <button style="padding: 12px 8px; border:1px solid #fff; border-radius: 4px; background-color:#007bff; color: #fff; font-size:14px;cursor: pointer">Trang chủ</button>
                </a>
              </div>';
            exit;
        }

        // Xác định layout
        if ($task === 'edit_dichvunhaycam') {
            $layout = $id > 0 ? 'EDIT_DICHVUNHAYCAM' : 'ADD_DICHVUNHAYCAM';
        } else {
            $layout = $task ? strtoupper($task) : 'DEFAULT';
        }

        switch ($layout) {
            case 'DEFAULT':
            case 'DS_DICHVUNHAYCAM':
                $this->setLayout('ds_dichvunhaycam');
                $this->_initDefaultPage();
                break;
            case 'ADD_DICHVUNHAYCAM':
            case 'EDIT_DICHVUNHAYCAM':
                $this->setLayout('edit_dichvunhaycam');
                $this->_editDVNhayCam();
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage()
    {
        $this->import();
        $model = Core::model('Vhytgd/DichVuNhayCam');
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
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.tentrangthaihoatdong')
            ->from('danhmuc_trangthaihoatdong AS a')
            ->where('a.daxoa = 0');
        $db->setQuery($query);
        $trangthaihoatdong = $db->loadAssocList();


        $this->trangthaihoatdong = $trangthaihoatdong;
        $this->phuongxa = $phuongxa;
    }

    public function _editDVNhayCam()
    {
        $this->import();
        $app = Factory::getApplication()->input;
        $model = Core::model('Vhytgd/DichVuNhayCam');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();
        $detailCoSo = null; 
        $idCoSo = $app->getInt('id', null);

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        if($idCoSo){
            $detailCoSo = $model->getDetailDichVuNhayCam($idCoSo);
        }

        $this->trangthaihoatdong = $model->getTrangThaiHoatDong();
        $this->phuongxa = $phuongxa;
        $this->detailCoSo = $detailCoSo;
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

        $document->addScript(Uri::base(true) . '/templates/adminlte/plugins/jquery/jquery.min.js');
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
        $document->addScript(Uri::root(true) . '/media/cbcc/js/bootbox.min.js');
        $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.gritter.min.js');

        return $document;
    }
}
