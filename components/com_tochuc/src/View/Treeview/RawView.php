<?php 
/**
 * @package     Joomla.Site
 * @subpackage  com_tochuc
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 namespace Joomla\Component\Tochuc\Site\View\Treeview;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;


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
        $layout = Factory::getApplication()->input->get('task');
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));    
        switch($layout){
        case 'TREETOCHUC':
            $this->_getTreeTochuc();
            break;
        }
        parent::display($tpl);
    }

    private function _getTreeTochuc($tpl = null){
        $app = Factory::getApplication()->input;
		$model = $this->getModel('Treeview');

		$id = $app->getInt('id',null);
		$checked = $app->getInt('checked',null);
		$parent_id = $app->getInt('parent_id',null);
        $items = array();
		if ($id !== null) {
            $items = $model->treeViewTochuc($id, array(
                'component' => 'com_tochuc',
                'view' => 'treeview',
                'task' => 'treetochuc',
                'checked' => $checked,
                'parent_id' => $parent_id
            ));
        }
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
        echo $items;
		exit;
	}


   
    

}
