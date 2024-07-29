<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\View\Users;


use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Core\Administrator\Model\ConfigsModel;
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
        $layout = Factory::getApplication()->input->get('layout');
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));      
        switch($layout){
        	case 'LIST':
        		$this->_pageList();
        		break;
        }
        parent::display($tpl);
    }

    private function _pageList(){   
        $document = Factory::getDocument();   
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');   
        $document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
        $document->addScript(Uri::root(true).'/media/vendor/dataTables/datatables.min.js');

        
    }

}
