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
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Core\Administrator\Model\MenuModel;
use stdClass;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
class RawView extends BaseHtmlView
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
        $task = Factory::getApplication()->input->get('task');
    	$task = ($task == null)?'default':strtoupper($task);      
        $this->setLayout(strtolower($task));      
        switch($task){
        	case 'EDIT':
        		$this->_pageEdit();
        		break;
        }
        parent::display($tpl);
    }

    private function _pageEdit(){    
         /** @var \Joomla\Component\Core\Administrator\Model\MenuModel $model */
        $id      = Factory::getApplication()->input->getInt('id');
    	$parent_id = Factory::getApplication()->input->getInt('parent_id');
        $this->item  = $this->get('Item');
       
    	if ((int)$id > 0 ) {
            $model = $this->getModel('Menu');
            $model->setState('filter.id', $id);
            $row = $model->getMenuById();
           
    	}else{
    		$row = new stdClass();
            $row->id = $id;
            $row->menu_type = array('value'=>1,'text'=>'Menu chính');
    		$row->published = 1;
    		$row->parent_id = $parent_id;
            $row->level = null;
            $row->lft = null;
            $row->rgt = null;
            $row->params = null;
            $row->name = null;
            $row->link = null;
            $row->is_system = null;
            $row->icon = null;
            $row->component = null;
            $row->controller = null;
            $row->tasks = null;
    	}
        $this->rows =  $row;
        
    }
   
    

}
