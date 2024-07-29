<?php 
 /* HueNN
 *
 * Created on Wed Jul 05 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\View\User;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Decentralization\Administrator\Helper\DecentralizationHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * View class for a list of users.
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
     * The model state.
     *
     * @var   CMSObject
     * @since 1.6
     */
    protected $state;

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

    public function display($tpl = null) {
        $document = Factory::getDocument();           
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(Uri::root(true).'/media/vendor/jtree/js/jstree.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
    	$document->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.validate.default.js'); 
        $document->addScript(Uri::root(true).'/media/cbcc/js/comboTree/comboTreePlugin.js');
        $document->addStyleSheet(Uri::root(true).'/media/vendor/jtree/themes/default/style.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/system/css/fields/switcher.min.css');
        $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/comboTree/style.css');
        $document->addScript(Uri::root(true).'/media/cbcc/js/easyui/jquery.easyui.min.js');
        // $document->addStyleSheet(Uri::root(true).'/media/cbcc/js/easyui/themes/default/easyui.css');


        $this->item         = $this->get('Item');
        $this->form         = $this->get('Form');
        $this->donvi_id     = $this->get('DonviId');
        $this->donviquanly_id     = $this->get('DonviQuanlyId');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

        // Prevent user from modifying own group(s)
        $user = Factory::getApplication()->getIdentity();

        if ((int) $user->id != (int) $this->item->id || $user->authorise('core.admin')) {
            $this->grouplist = $this->get('Groups');
            $this->groups    = $this->get('AssignedGroups');
        }

        $this->form->setValue('password', null);
        $this->form->setValue('password2', null);

        $tree_donvi = array();
        $inArray = Core::loadAssocList('ins_dept', array('id','level','name','parent_id',"IF(type=1,'file',IF(type=2,'folder',IF(type=0,'file','folder'))) AS type"),null,'lft');
        DecentralizationHelper::makeParentChildRelationsForTree($inArray, $tree_donvi);
        unset($inArray);
        $this->donvi = $tree_donvi;

        $this->addToolbar();
        parent::display($tpl);
    }

    public function addToolbar() {

        $isNew   = ($this->item->id == 0);

        ToolbarHelper::title(Text::_($isNew ? 'COM_DECENTRALIZATION_VIEW_NEW_USER_TITLE' : 'COM_DECENTRALIZATION_VIEW_EDIT_USER_TITLE'), 'user user-profile');

        // ToolbarHelper::title(Text::_('COM_DECENTRALIZATION'), 'user user-profile');
        $toolbar = Toolbar::getInstance();
        $toolbar->save('user.save');
		$toolbar->cancel('user.cancel');
		ToolbarHelper::divider();
    }

    public function inputData(){
		$data['toolBar_title'] = 'Người dùng';
		$data['table'] = 'jos_users';
		$data['view'] = 'users';
		return $data;
	}

}

?>