<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_core
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

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
     * The pagination object
     *
     * @var    Pagination
     * @since  3.9.0
     */
    protected $pagination;
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
        /** @var ConfigsModel $model */     
        $model = $this->getModel();
        $this->state         = $this->get('State');
        $this->pagination = $model->getPagination();
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
        // $document->addScript(Uri::root(true).'/media/vendor/bootstrap/js/bootstrap-es5.js');
     
        $document->addScript(Uri::root(true).'/media/vendor/dataTables/datatables.min.js');
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(Uri::root(true).'/media/vendor/jtree/js/jstree.min.js');
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
 
        $input = Factory::getApplication()->getInput();
        $id    = $input->getInt('id');
        // $task  = $input->get('task'); 
       
        $toolbar = Toolbar::getInstance();
        ToolbarHelper::title(Text::_('CORE: CONFIG'), 'menu-cog groups');
        $uri       = Uri::getInstance();
        $return    = base64_encode($uri);
        $linkNew  = 'index.php?option=com_core&amp;view=config&amp;layout=modal&amp;tmpl=component&amp;' . Session::getFormToken() . '=1';

        // $linkNew = Route::_('index.php?option=com_core&view=config&return=' . $return . '&tmpl=component&layout=modal');
        $canDo = ContentHelper::getActions('com_core', 'config', $this->state->get('filter.id'));
        if ($canDo->get('core.create')) {
            $title = Text::_('Thêm mới');
            $dhtml = "<button  data-bs-toggle=\"modal\"  data-bs-target=\"#ModalNew\" class=\"btn btn-success\">
                        <span class=\"icon-new\" title=\"$title\"></span>
                        $title</button>";
            $toolbar->customButton('new')->html($dhtml);
            echo HTMLHelper::_(
                'bootstrap.renderModal',
                'ModalNew',
                [
                        'title'       => Text::_('Thêm mới'),
                        'backdrop'    => 'static',
                        'keyboard'    => false,
                        'closeButton' => false,
                        'url'         => $linkNew,
                        'height'      => '400px',
                        'width'       => '800px',
                        'bodyHeight'  => 55,
                        'modalWidth'  => 60,
                        'footer'      => '<button type="button" class="btn btn-danger" data-bs-dismiss="modal"'
                                . ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#ModalNew\', buttonSelector: \'#closeBtn\'})">'
                                . Text::_('Đóng') . '</button>'
                                . '<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="Joomla.iframeButtonClick({iframeSelector: \'#ModalNew\', buttonSelector: \'#saveBtn\'});">'
                                . Text::_("JSAVE") . '</button>'

                        // 'footer'      => '<button type="button" class="btn btn-danger" data-bs-dismiss="modal"'
                        //     . ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#ModalNew\', buttonSelector: \'#closeBtn\'})">'
                        //     . Text::_('Đóng') . '</button>'
                        //     . '<span class="btn btn-success btn-saveConfig">'
                        //     . Text::_("JSAVE") . '</span>'        
                ]
            ); 
        }

    }

}
