<?php 
 /* HueNN
 *
 * Created on Wed Jul 05 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\View\Module;

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
        $this->item         = $this->get('Item');
        $this->form         = $this->get('Form');
        $this->addToolbar();
        parent::display($tpl);
    }

    public function addToolbar() {

        $isNew   = ($this->item->id == 0);

        ToolbarHelper::title("Nhóm chức năng: " .Text::_($isNew ? 'COM_DECENTRALIZATION_VIEW_NEW_MODULE_TITLE' : 'COM_DECENTRALIZATION_VIEW_EDIT_MODULE_TITLE'), 'grid');
        $toolbar = Toolbar::getInstance();
        $toolbar->save('module.save');
		$toolbar->cancel('module.cancel');
		ToolbarHelper::divider();
    }

}

?>