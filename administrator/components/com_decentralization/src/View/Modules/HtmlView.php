<?php 
 /* HueNN
 *
 * Created on Wed Jul 05 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\View\Modules;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;

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
        $this->items = $this->get('Items');
        $this->pagination    = $this->get('Pagination');
        $this->filterForm    = $this->get('FilterForm');
        $this->state         = $this->get('State');
        $this->canDo         = ContentHelper::getActions('com_decentralization');

        $this->addToolbar();
        parent::display($tpl);
    }

    public function addToolbar() {
        ToolbarHelper::title(Text::_('COM_DECENTRALIZATION_MODULES'), 'grid');
        $toolbar = Toolbar::getInstance();
        $canDo = $this->canDo;
        $user  = $this->getCurrentUser();
        if ($canDo->get('core.create')) {
            $toolbar->addNew('module.add');
        }
        if ($canDo->get('core.edit.state') || $canDo->get('core.admin')) {
            
            /** @var DropdownButton $dropdown */
            $dropdown = $toolbar->dropdownButton('status-group', 'JTOOLBAR_CHANGE_STATUS')
            ->toggleSplit(false)
            ->icon('icon-ellipsis-h')
            ->buttonClass('btn btn-action')
            ->listCheck(true);

            $childBar = $dropdown->getChildToolbar();

            
            $childBar->standardButton('unblock', 'COM_DECENTRALIZATION_TOOLBAR_PUBLISH', 'modules.publish')
                ->listCheck(true);
            $childBar->unpublish('modules.unpublish', 'COM_DECENTRALIZATION_TOOLBAR_UNPUBLISH', true);
            // Add a batch button
            if (
                $user->authorise('core.create', 'com_decentralization')
                && $user->authorise('core.edit', 'com_decentralization')
                && $user->authorise('core.edit.state', 'com_decentralization')
            ) 

            if ($canDo->get('core.delete')) {
                $childBar->delete('modules.delete', 'JTOOLBAR_DELETE')
                    ->message('JGLOBAL_CONFIRM_DELETE')
                    ->listCheck(true);
            }
        }
		ToolbarHelper::divider();
    }

}

?>