<?php

/******************************************************************************
 * @Author                : HueNN                                             *
 * @CreatedDate           : 2024-06-24 20:16:56                               *
 * @LastEditors           : HueNN                                             *
 * @LastEditDate          : 2024-06-24 20:17:38                               *
 * @FilePath              : Joomla_511/administrator/components/com_core/src/View/Configs/HtmlView.php*
 * @CopyRight             : Dnict                                             *
 *****************************************************************************/

namespace Joomla\Component\Core\Administrator\View\Configs;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Toolbar\Button\BasicButton;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\Button\LinkButton;
use Joomla\CMS\Toolbar\Button\PopupButton;
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
    
    public function display($tpl = null)
    {
        /** @var ConfigsModel $model */     
        $model = $this->getModel();
        $this->state         = $this->get('State');
        $this->pagination = $model->getPagination();
        $this->canDo         = ContentHelper::getActions('com_core');

        if ($this->getLayout() !== 'modal') {
            $this->addToolBar();
        }
        // $this->addToolbar();
        $this->_pageDefault();
        parent::display($tpl);

    }

    public function _pageDefault(){
        $document = Factory::getDocument();           
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');   
     
        $document->addScript(Uri::root(true).'/media/vendor/dataTables/datatables.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(Uri::root(true).'/media/vendor/jtree/js/jstree.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/bootbox.min.js');

        $document->addScript(Uri::root(true).'/media/vendor/bootstrap/js/modal.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery.colorbox-min.js');

       
        // // $document->addStyleSheet(Uri::root(true).'/media/vendor/dataTables/bootstrap.min.css'); 
        // // $document->addStyleSheet(Uri::root(true).'/media/vendor/dataTables/DataTables-1.10.25/css/dataTables.bulma.min.css'); 
        $document->addStyleSheet(Uri::root(true).'/media/vendor/jtree/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/system/css/fields/switcher.min.css');

    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */

    public function fetchButton($type = 'Link', $name = 'button-delete btn btn-danger', $text = '', $url = null,$target=null)
	{
		$text = Text::_($text);
		$class = $this->fetchIconClass($name);
		$doTask = $this->_getCommand($url);
		$html = "<a class='button-delete btn btn-danger' href=\"$doTask\" target=\"$target\">\n";
		$html .= "<span class=\"$class\">\n";
		$html .= "</span>\n";
		$html .= "$text\n";
		$html .= "</a>\n";
		return $html;
	}

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('CORE: CONFIG'), 'menu-cog groups');
        $toolbar = Toolbar::getInstance();
        $canDo = $this->canDo;
        if ($canDo->get('core.create')) {
            $toolbar->addNew('config.add');
        }
        if ($canDo->get('core.delete')) {
            $toolbar->delete('config.delete', 'JTOOLBAR_DELETE')
                ->message('Bạn có chắc chắn muốn xóa không? Xác nhận sẽ xóa vĩnh viễn các mục đã chọn!')
                ->attributes(array('disabled' => 'disabled'));
        }
    }

}
