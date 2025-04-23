<?php 
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Danhmuc\Administrator\View\Quanhegd;

use ContentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper as HelperContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Button\LinkButton;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * View class for a list of groups.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{    
    /**
     * The item data.
     *
     * @var   object
     * @since 1.6
     */
    protected $items;
    /**
     * The pagination object.
     *
     * @var   \Joomla\CMS\Pagination\Pagination
     * @since 1.6
     */
    protected $pagination;

    /**
     * A Form instance with filter fields.
     *
     * @var    \Joomla\CMS\Form\Form
     *
     * @since  3.6.3
     */
    public $filterForm;

    /**
     * An array with active filters.
     *
     * @var    array
     * @since  3.6.3
     */
    public $activeFilters;

    /**
     * An ACL object to verify user rights.
     *
     * @var    CMSObject
     * @since  3.6.3
     */
    protected $canDo;

    /**
     * An instance of DatabaseDriver.
     *
     * @var    DatabaseDriver
     * @since  3.6.3
     *
     * @deprecated  4.3 will be removed in 6.0
     *              Will be removed without replacement use database from the container instead
     *              Example: Factory::getContainer()->get(DatabaseInterface::class);
     */
    protected $db;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    
    /**
     * display
     *
     * @param  mixed $tpl
     * @return void
     */
    public function display($tpl = null) {
        $this->items = $this->get('Items');
        $this->state = $this->get('State');
        $this->form  = $this->get('Form');
        $this->filterForm    = $this->get('FilterForm');
        $this->pagination    = $this->get('Pagination');
        $this->canDo         = HelperContentHelper::getActions('com_danhmuc');
       

        $layout = Factory::getApplication()->input->get('task');
    	$layout = ($layout == null)?'default':strtoupper($layout); 
        $this->addToolbar(); 
        switch($layout){
        	case 'ADD':
            case 'EDIT':
        		$this->setLayout('edit');
                $this->_pageEdit();   
        		break;
            default:
                break;
        }
        parent::display($tpl);
    }
    
    /**
     * addToolbar
     *
     * @return void
     */
    public function addToolbar() {
        ToolbarHelper::title(Text::_('COM_DANHMUC_QUANHEGIADINHS'), 'grid');
        $toolbar = Toolbar::getInstance();
        $canDo = $this->canDo;
        $user  = $this->getCurrentUser();
        // Add "Save" and "Cancel" buttons for the form view edit
        if (Factory::getApplication()->input->getCmd('layout') == 'edit') {
            $toolbar->save2new('quanhegd.save2new', 'JTOOLBAR_APPLY');
            $toolbar->save('quanhegd.save', 'JTOOLBAR_SAVE');
            // $toolbar->cancel('quanhegd.cancel', 'JTOOLBAR_CANCEL');
            $buttonCancel = (new LinkButton('icon'))
                ->url('index.php?option=com_danhmuc&view=quanhegd')
                ->text('Cancel')
                ->buttonClass('btn btn-danger')
                ->icon('icon-cancel');
            $toolbar->appendButton($buttonCancel);
            $toolbar->divider();
        }else{
            // Add "New" and "Delete" buttons for the form view default
            if ($canDo->get('core.create')) {
                $button = (new LinkButton('icon'))
                    ->url('index.php?option=com_danhmuc&view=quanhegd&layout=edit')
                    ->text('New')
                    ->buttonClass('btn btn-success')
                    ->icon('fas fa-plus');
                $toolbar->appendButton($button);
                $toolbar->divider();
            }
            if ($canDo->get('core.delete')) {
                $toolbar->delete('quanhegd.delete', 'JTOOLBAR_DELETE')
                    ->message('JGLOBAL_CONFIRM_DELETE')
                    ->listCheck(true);
                $toolbar->divider();
            }
            
        }
    }

    public function _pageEdit(){
        $model = $this->getModel('Quanhegd');
        $this->item = $model->getItem();
        
    }
}
?>