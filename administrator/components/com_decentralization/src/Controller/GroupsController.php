<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Controller;

use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Users list controller class.
 *
 * @since  1.6
 */
class GroupsController extends AdminController
{
    /**
     * Constructor.
     *
     * @param   array                $config   An optional associative array of configuration settings.
     * @param   MVCFactoryInterface  $factory  The factory.
     * @param   CMSApplication       $app      The CMSApplication for the dispatcher
     * @param   Input                $input    Input
     *
     * @since  1.6
     * @see    BaseController
     * @throws \Exception
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.6
     */
    public function getModel($name = 'Group', $prefix = 'Administrator', $config = ['ignore_request' => true])
    {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Removes an item.
     *
     * Overrides Joomla\CMS\MVC\Controller\FormController::delete to check the core.admin permission.
     *
     * @return  void
     *
     * @since   1.6
     */
    public function delete()
    {
        // Check for request forgeries.
        $this->checkToken();

        $ids = (array) $this->input->get('cid', [], 'int');
       
        // Remove zero values resulting from input filter
        $ids = array_filter($ids);
        if (!$this->app->getIdentity()->authorise('core.admin', $this->option)) {
            throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
        }

        if (empty($ids)) {
            $this->setMessage(Text::_('COM_USERS_NO_LEVELS_SELECTED'), 'warning');
        } else {
            // Get the model.
            $model = $this->getModel();
            // Remove the items.
            if ($model->delete($ids)) {
                $this->setMessage(Text::plural('Xóa thành công', ""));
            }
        }

        $this->setRedirect('index.php?option=com_decentralization&view=groups');
    }
}