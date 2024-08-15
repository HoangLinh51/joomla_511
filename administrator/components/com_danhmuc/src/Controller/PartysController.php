<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Danhmuc\Administrator\Controller;

use Core;
use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Users list controller class.
 *
 * @since  1.6
 */
class PartysController extends AdminController
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
        $this->registerTask('unpublish', 'publish');
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
    public function getModel($name = 'Partys', $prefix = 'Administrator', $config = ['ignore_request' => true])
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
            // Cách 1
            // $model = $this->getModel();
            // // Remove the items.
            // if ($model->delete($ids)) {
            //     $this->setMessage(Text::plural('Xóa thành công', ""));
            // }
            // Get the model.
            // Cách 2
            $model_core = Core::model('Danhmuchethong/Party_pos');
            if ($model_core->xoanhieuparty_pos($ids)) {
                $this->setMessage(Text::plural('Xóa thành công', ""));
            }
        }

        $this->setRedirect('index.php?option=com_danhmuc&view=partys');
    }


    public function save2new($key = null, $urlVar = null)
    {
        $this->checkToken();
        if (!$this->app->getIdentity()->authorise('core.admin')) {
            $this->setRedirect('index.php', Text::_('JERROR_ALERTNOAUTHOR'), 'error');

            return false;
        }

        /** @var \Joomla\Component\Danhmuc\Administrator\Model\PartysModel $model */
        $model = $this->getModel('Partys', 'Administrator');
        $data  = $this->input->post->get('jform', [], 'array');
        $code = $this->input->getInt('code');
        // Must load after serving service-requests
        $form = $model->getForm();
        $return = $model->save($data, $code);
        
        // Cách 1
        // $model_core = Core::model('Danhmuchethong/Party_pos');
        // $return = $model_core->addparty_pos($data);


        // Check the return value.
        if ($return === false) {
            $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys', false));
            return false;
        }

        $this->app->enqueueMessage(Text::_('Lưu thành công'), 'message');
        switch ($this->input->getCmd('task')) {
            case 'save2new':
            default:
                $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys&layout=edit', false));
                break;
        }
    }

    public function save($key = null, $urlVar = null)
    {
        $this->checkToken();
        if (!$this->app->getIdentity()->authorise('core.admin')) {
            $this->setRedirect('index.php', Text::_('JERROR_ALERTNOAUTHOR'), 'error');

            return false;
        }
        /** @var \Joomla\Component\Danhmuc\Administrator\Model\PartysModel $model */
        $model = $this->getModel('Partys', 'Administrator');
        $data  = $this->input->post->get('jform', [], 'array');
        $code = $this->input->getInt('code');
        $form = $model->getForm();
        $return = $model->save($data, $code);
        
        // Cách 1
        // $model_core = Core::model('Danhmuchethong/Party_pos');
        // $return = $model_core->addparty_pos($data);


        if ($return === false) {
            $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys', false));
            return false;
        }

        $this->app->enqueueMessage(Text::_('Lưu thành công'), 'message');
        
        switch ($this->input->getCmd('task')) {
            case 'save':
            default:
                $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys', false));
                break;
        }
    }

    public function publish()
    {

        $ids    = (array) $this->input->get('cid', [], 'int');
        $values = ['publish' => 1, 'unpublish' => 0];
        $task   = $this->getTask();
        
        $value  = ArrayHelper::getValue($values, $task, 0, 'int');
        $ids = array_filter($ids);

        $model_core = Core::model('Danhmuchethong/Party_pos');
        $return = $model_core->updateStatus($ids[0], $value);
        if ($return === false) {
            $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys', false));
            return false;
        }
        $this->app->enqueueMessage(Text::_('Lưu thành công'), 'message');
        $this->setRedirect(Route::_('index.php?option=com_danhmuc&view=partys', true));
    }   
}