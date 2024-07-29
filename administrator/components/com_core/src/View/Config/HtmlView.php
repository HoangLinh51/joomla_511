<?php

/******************************************************************************
 * @Author                : HueNN                                             *
 * @CreatedDate           : 2024-06-24 20:36:26                               *
 * @LastEditors           : HueNN                                             *
 * @LastEditDate          : 2024-06-24 20:36:26                               *
 * @FilePath              : components/com_core/src/View/Config/HtmlView.php  *
 * @CopyRight             : Dnict                                             *
 *****************************************************************************/

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
        $this->form  = $this->get('Form');
        $this->item  = $this->get('Item');  
        $this->value = $this->get('Value');
        $this->addToolbar();        
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $isNew   = ($this->item->id == 0);
        $input = Factory::getApplication()->input;
        $layout   = $input->getCmd('layout', '');
        $canDo = ContentHelper::getActions('com_core', 'config');
        ToolbarHelper::title("CORE: " .Text::_($isNew ? 'CONFIG NEW' : 'CONFIG EDIT'), 'grid');
        $toolbar    = Toolbar::getInstance();
        if (($canDo->get('core.edit') && $layout != 'edit_value')  || ($canDo->get('core.create')  && $layout != 'edit_value')) {
            $toolbar->save('config.save');
        }
        if ($layout == 'edit_value') {
            $toolbar->save('config.savevalue');
        }
        $toolbar->cancel('config.cancel');
        $toolbar->divider();
    }

}
