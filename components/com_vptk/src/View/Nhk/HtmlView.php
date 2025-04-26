<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vptk
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\VPTK\Site\View\Nhk;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;
use stdClass;

class HtmlView extends BaseHtmlView
{
    // protected $item;

    public function display($tpl = null)
    {

        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);
        $this->setLayout(strtolower($layout));
        switch ($layout) {
            
            case 'DEFAULT':
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
      
		$model = Core::model('Vptk/Vptk');
		$phanquyen = $model->getPhanquyen();
		$gioitinh = Core::loadAssocList('danhmuc_gioitinh','id,tengioitinh','trangthai = 1 AND daxoa = 0','sapxep ASC');
		if($phanquyen['phuongxa_id'] == ''){
			$phuongxa = array();
		}else if($phanquyen['phuongxa_id'] == '-1'){
			$phuongxa = Core::loadAssocList('danhmuc_khuvuc','id,tenkhuvuc,cha_id,level','level = 2 AND daxoa = 0','tenkhuvuc ASC');
		}else{
			$phuongxa = Core::loadAssocList('danhmuc_khuvuc','id,tenkhuvuc,cha_id,level','level = 2 AND daxoa = 0 AND id IN ('.$phanquyen['phuongxa_id'].')','tenkhuvuc ASC');
		}
    	$this->gioitinh = $gioitinh;
    	$this->phuongxa = $phuongxa;

	
    }

 
}