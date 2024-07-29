<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\View\Config;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Toolbar\Button\BasicButton;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\Button\LinkButton;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Core\Administrator\Model\ConfigsModel;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
    /**
     * Display the view
     *
     * @param   string|null  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @throws  GenericDataException
     *
     * @return  void
     */
    
    public function display($tpl = null)
    {   

        $document = Factory::getDocument();           
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');   
        // $document->addScript(Uri::root(true).'/media/vendor/bootstrap/js/bootstrap-es5.js');
        $document->addScript(Uri::root(true).'/media/vendor/bootstrap/js/modal.min.js');
        $document->addScript(Uri::root(true).'/media/vendor/dataTables/datatables.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(Uri::root(true).'/media/vendor/jtree/js/jstree.min.js');

        $document->addStyleSheet(Uri::root(true).'/media/vendor/jtree/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/system/css/fields/switcher.min.css');
        $this->state = $this->get('State');
        //$this->form  = $this->get('Form');
        $this->item  = $this->get('Item');  
        $this->value = $this->get('Value');
        if ($this->getLayout() === 'modal') {           
            $this->addToolbar();        
        } 
        // $layout = Factory::getApplication()->input->get('task');
        // var_dump($layout);
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $canDo = ContentHelper::getActions('com_core', 'config');
        $toolbar    = Toolbar::getInstance();
        if ($canDo->get('core.edit') || $canDo->get('core.create')) {
            $toolbar->save('config.save');

        }
    }

}
