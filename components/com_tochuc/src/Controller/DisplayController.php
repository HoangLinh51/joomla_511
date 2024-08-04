<?php
/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:42:30                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:42:30                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/Controller/DisplayController.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Tochuc\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

/**
 * Mywalks Component Controller
 *
 * @since  1.5
 */
class DisplayController extends BaseController
{

	/**
     * The default view.
     *
     * @var    string
     * @since  1.6
     */
    protected $default_view = 'tochuc';
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
	 *
	 * @return  static  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = array())
	{
		return parent::display();
	}

	
}
