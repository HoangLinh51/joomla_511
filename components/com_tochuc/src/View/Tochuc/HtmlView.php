<?php 
/**
 * @package     Joomla.Site
 * @subpackage  com_tochuc
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Tochuc\Site\View\Tochuc;

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
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));    
        switch($layout){
        case 'EDIT':
            $this->_initEditPage();
            break;
        case 'THANHLAP':
            $this->_initThanhLapPage();
            break;	
        case 'default':
     		// $this->_pageList();
         	break;
        }
        parent::display($tpl);

        $doc = Factory::getDocument();

        $doc->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        //$doc->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/themes/default-dark/style.min.css');
        //$doc->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree/themes/default/style.css');
        $doc->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
        $doc->addScript(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $doc->addScript(Uri::root(true).'/media/cbcc/js/jstree/jquery.cookie.js');
        //$doc->addScript(Uri::root(true).'/media/cbcc/js/jstree/jquery.jstree.js');

        $doc->addScript(Uri::root(true) . '/media/cbcc/js/caydonvi.js' );


    }

    private function _initDefaultPage($task){
    	$document = Factory::getDocument();
    	$document->addCustomTag('<link href="'.Uri::root(true).'/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
    	$document->addCustomTag('<link href="'.Uri::root(true).'/media/cbcc/js/jstree/themes/default/style.css" rel="stylesheet" />');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jstree/jquery.jstree.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/chosen.jquery.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery.maskedinput.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/upload/jquery.iframe-transport.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/upload/jquery.fileupload.js');
    	// $document->addScript(Uri::root(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
    	// $document->addScript(Uri::root(true).'/media/cbcc/js/date-time/date.js');
		$document->addScript(Uri::root(true) . '/media/cbcc/js/caydonvi.js' );
    }

    private function _initThanhLapPage(){    	
		$document = Factory::getDocument();
    	// $document->addCustomTag('<link href="'.Uri::base(true).'/media/cbcc/js/jstree/themes/default/style.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.css');

        $document->addCustomTag('<link href="'.Uri::base(true).'/media/cbcc/css/jquery.fileupload.css" rel="stylesheet" />');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css');
        // $document->addStyleSheet(Uri::root(true).'/templates/adminlte/assets/css/font-awesome.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/css/jquery.toast.css');
        // $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/dropzone/min/dropzone.min.css');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/bootstrap/moment.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/bootstrap/tempusdominus-bootstrap-4.min.js');
        // $document->addScript(Uri::root(true).'/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.js');
        // $document->addScript(Uri::base(true).'/media/cbcc/js/bootstrap/datetimepicker-vi.js');
        
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/dropzone/min/dropzone.min.js');
        $document->addScript(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.js');
    	$document->addScript(Uri::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jstree-3.2.1/jstree.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/fuelux/fuelux.tree.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/ace-elements.min.js');
        $document->addScript(Uri::root(true).'/templates/adminlte/js/adminlte.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jstree/jquery.cookie.js');
    	// $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/upload/jquery.iframe-transport.js');
    	// $document->addScript(Uri::base(true).'/media/cbcc/js/jquery/upload/jquery.fileupload.js');
    	// $document->addScript(Uri::base(true).'/templates/adminlte/plugins/dropzone/min/dropzone.min.js');

        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.toast.js');
      
		$model = Core::model('Tochuc/Tochuc');
        $app = Factory::getApplication()->input;
    	$dept_id = $app->getInt('id',0);
        $type = $app->getInt('type',1);
       
        $parent_id = $app->getInt('parent_id',0);
        $row = new stdClass();
    	if((int)$dept_id > 0 ){
    		$row = $model->read($dept_id);
    	}
       
    	if ($row && (int)$row->id == 0) {
    		$row->type = $type;
			$row->parent_id = $parent_id;
    	}
     
    	$this->id = $dept_id;
    	$this->row = $row;
    }

}