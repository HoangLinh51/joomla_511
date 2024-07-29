<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\View\Menu;

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
        $this->form  = $this->get('Form');
        $this->item  = $this->get('Item');
        $this->state = $this->get('State');
        $this->addToolbar();
        $this->_pageDefault();
        parent::display($tpl);
    }

    public function _pageDefault(){
        $document = Factory::getDocument();           
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(Uri::root(true).'/media/vendor/jtree/js/jstree.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.default.js'); 
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
        $id    = $input->get('id');
        $task  = $input->get('task'); 
        // var_dump($task);exit;
        $toolbar = Toolbar::getInstance();

        ToolbarHelper::title(Text::_('CORE: MENU'), 'menu-cog groups');
        $toolbar->standardButton('menu')
        ->text('Thêm mới')
        ->buttonClass('button-new btn btn-success')
        ->icon('icon-new')
        ->onclick('return false');

        $toolbar->standardButton('menu')
        ->text('Lưu')

        // ->task('core.saveedit')
        ->buttonClass('button-save btn_luu btn btn-success')
        ->icon('icon-save')
        ->onclick('return true');

        $button = (new LinkButton('icon-delete'))
        ->url('#')
        ->text('Xóa')
        ->buttonClass('btn btn-danger')
        ->icon('icon-cancel-2');
        $toolbar->appendButton($button);

        $toolbar->divider();
        $toolbar->help('Private_Messages');
    }

}
