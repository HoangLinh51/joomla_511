<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Thongbao\Site\View\Thongbao;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;
use stdClass;
use Exception;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        $id = Factory::getApplication()->input->getInt('id');

        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);

        switch ($layout) {
            case 'DEFAULT':
                $this->setLayout('default');
                $this->_initDefaultPage($id);
                break;
            case 'ADD_THONGBAO':
            case 'EDIT_THONGBAO':
                $this->setLayout('edit_thongbao');
                $this->_getEditNhanhokhau();
                break;
            default:
                $this->setLayout('default');
                $this->_initDefaultPage($id);
                break;
        }

        parent::display($tpl);
    }

    private function _initDefaultPage($idThongbao)
    {
        $document = Factory::getDocument();
        // $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/css/jquery.fileupload.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/dataTables/datatables.min.css');
        // $document->addStyleSheet('<link href="' . Uri::root(true) . '/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
        // $document->addStyleSheet('<link href="' . Uri::root(true) . '/templates/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true) . '/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true) . '/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');
        // $document->addStyleSheet(Uri::root(true) . '/components/com_vptk/js/flag-icons.min.css');

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
        // $document->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery_upload/js/jquery.fileupload.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');

        $modelThongbao = Core::model('Thongbao/Thongbao');
        $itemThongbao = $modelThongbao->getDetailThongbao($idThongbao);
        if (empty($itemThongbao)) {
            throw new Exception("Thông báo không tồn tại");
        }else {
            $this->item = $itemThongbao;
        }
        // var_dump($this->item);
    }
    public function _getEditNhanhokhau(){
        $document = Factory::getDocument();
        $app = Factory::getApplication()->input;

        // $document->addStyleSheet('<link href="'.Uri::base(true).'/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
        $document->addStyleSheet('<link href="'.Uri::base(true).'/templates/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        $document->addStyleSheet(Uri::base(true).'/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/css/jquery.toast.css');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css');

        // $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
        // $document->addScript(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');
        // $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/jquery.validate.js' );
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/jquery/jquery.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $document->addScript('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap.bundle.min.js');

        // $document->addScript(Uri::base(true).'/media/legacy/js/jquery-noconflict.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js');
    	$document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery.inputmask.min.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jstree/jquery.cookie.js');
        $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/jquery.toast.js');
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/pace-progress/pace.min.js');


        $hokhau_id = $app->getInt('id',null);

		$model = Core::model('Thongbao/Thongbao');
		$phanquyen = $model->getPhanquyen();
		$phuongxa = array();
		if($phanquyen['phuongxa_id'] != ''){
			$db = Factory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.tenkhuvuc,a.cha_id AS quanhuyen_id,b.cha_id AS tinhthanh_id,a.level');
			$query->from('danhmuc_khuvuc AS a');
			$query->innerJoin('danhmuc_khuvuc AS b ON a.cha_id = b.id');
			if($phanquyen['phuongxa_id'] == '-1'){
				$query->where('a.level = 2 AND a.daxoa = 0');
			}else{
				$query->where('a.level = 2 AND a.daxoa = 0 AND a.id IN ('.$phanquyen['phuongxa_id'].')');
				
			}
			$query->order('tenkhuvuc ASC');
			$db->setQuery($query);
			$phuongxa = $db->loadAssocList();
		}
		$tinhthanh = Core::loadAssocList('danhmuc_tinhthanh','id,tentinhthanh','trangthai = 1 AND daxoa = 0','sapxep ASC, tentinhthanh ASC');
		$quanhe = Core::loadAssocList('danhmuc_quanhenhanthan','id,tenquanhenhanthan','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$gioitinh = Core::loadAssocList('danhmuc_gioitinh','id,tengioitinh','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$dantoc = Core::loadAssocList('danhmuc_dantoc','id,tendantoc','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$tongiao = Core::loadAssocList('danhmuc_tongiao','id,tentongiao','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$trinhdo = Core::loadAssocList('danhmuc_trinhdohocvan','id,tentrinhdohocvan','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$nghenghiep = Core::loadAssocList('danhmuc_nghenghiep','id,tennghenghiep','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$lydo = Core::loadAssocList('danhmuc_lydoxoathuongtru','id,tenlydo','trangthai = 1 AND daxoa = 0','sapxep ASC');
		$quoctich = Core::loadAssocList('danhmuc_quoctich','id,tenquoctich','trangthai = 1 AND daxoa = 0','sapxep ASC');

        if($hokhau_id != ''){
            $item = $model->getHokhauById($hokhau_id);

			$item['nhankhau'] = $model->getNhankhauByHokhauId($hokhau_id);
			$phuongxa_id = $item['phuongxa_id'];
        }else{
            $item = array();
			$item['nhankhau'][0]['quanhenhanthan_id'] = '-1';
			if(count($phuongxa) == 1){ $phuongxa_id = $phuongxa[0]['id']; }
        }
		if((int)$phuongxa_id > 0){
			$thonto = Core::loadAssocList('danhmuc_khuvuc','id,tenkhuvuc','sudung = 1 AND daxoa = 0 AND level = 3 AND cha_id = '.(int)$phuongxa_id,'tenkhuvuc ASC');
		}else{
			$thonto = array();
		}
        $this->tinhthanh = $tinhthanh;
        $this->phuongxa = $phuongxa;
        $this->thonto = $thonto;
        $this->quanhe = $quanhe;
        $this->gioitinh = $gioitinh;
        $this->dantoc = $dantoc;
        $this->tongiao = $tongiao;
        $this->trinhdo = $trinhdo;
        $this->nghenghiep = $nghenghiep;
        $this->lydo = $lydo;
        $this->item = $item;
        $this->quoctich = $quoctich;

		
	}
}