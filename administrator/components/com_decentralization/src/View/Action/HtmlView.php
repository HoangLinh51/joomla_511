<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\View\Action;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * View to edit a user group.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The Form object
     *
     * @var  \Joomla\CMS\Form\Form
     */
    protected $form;

    /**
     * The item data.
     *
     * @var   object
     * @since 1.6
     */
    protected $item;

    /**
     * The model state.
     *
     * @var   CMSObject
     * @since 1.6
     */
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $document = Factory::getDocument();     
        $document->addScript(Uri::root(true).'/media/vendor/jquery/js/jquery.min.js');   
        $this->state = $this->get('State');
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     * @throws  \Exception
     */
    protected function addToolbar()
    {

        $isNew   = ($this->item->id == 0);
        $canDo   = ContentHelper::getActions('com_decentralization');
        $toolbar = Toolbar::getInstance();

        ToolbarHelper::title("Chức năng: " .Text::_($isNew ? 'COM_DECENTRALIZATION_VIEW_NEW_GROUP_TITLE' : 'COM_DECENTRALIZATION_VIEW_EDIT_GROUP_TITLE'), 'grid');

        if ($canDo->get('core.edit') || $canDo->get('core.create')) {
            $toolbar->apply('action.apply');
        }

        $saveGroup = $toolbar->dropdownButton('save-group');
        $saveGroup->configure(
            function (Toolbar $childBar) use ($canDo, $isNew) {
                if ($canDo->get('core.edit') || $canDo->get('core.create')) {
                    $childBar->save('action.save');
                }

                if ($canDo->get('core.create')) {
                    $childBar->save2new('action.save2new');
                }
            }
        );

        if (empty($this->item->id)) {
            $toolbar->cancel('action.cancel', 'JTOOLBAR_CANCEL');
        } else {
            $toolbar->cancel('action.cancel');
        }

        $toolbar->divider();
    }
}
