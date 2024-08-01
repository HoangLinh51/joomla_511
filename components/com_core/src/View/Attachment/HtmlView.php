<?php 
/**
 * @package     Joomla.Site
 * @subpackage  com_tochuc
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Site\View\Attachment;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;

class HtmlView extends BaseHtmlView
{
    // protected $item;

    public function display($tpl = null)
    {

        $layout = Factory::getApplication()->input->get('task');
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));    
        switch($layout){
        case 'default':
     		$this->_initDefaultPage();
         	break;
        }
        parent::display($tpl);
    }

    private function _initDefaultPage(){
    	$document = Factory::getDocument();
    	$document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/style.bundle.css');
        $document->addStyleSheet(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/css/jquery.toast.css');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
        // $document->addScript(Uri::base(true).'/templates/adminlte/plugins/dropzone/min/dropzone.min.js');
        // $document->addScript(Uri::base(true).'/templates/adminlte/plugins/global/plugins.bundle.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.toast.js');
    }


}