<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Access\Access;
use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\MVC\Controller\FormController;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Group controller class.
 *
 * @since  1.6
 */
class GroupController extends FormController
{
    /**
     * @var    string  The prefix to use with controller messages.
     * @since  1.6
     */
    protected $text_prefix = 'COM_DECENTRALIZATION_GROUP';

    /**
     * Method to check if you can save a new or existing record.
     *
     * Overrides Joomla\CMS\MVC\Controller\FormController::allowSave to check the core.admin permission.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowSave($data, $key = 'id')
    {
        return ($this->app->getIdentity()->authorise('core.admin', $this->option) && parent::allowSave($data, $key));
    }

    /**
     * Overrides Joomla\CMS\MVC\Controller\FormController::allowEdit
     *
     * Checks that non-Super Admins are not editing Super Admins.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowEdit($data = [], $key = 'id')
    {
        // Check if this group is a Super Admin
        if (Access::checkGroup($data[$key], 'core.admin')) {
            // If I'm not a Super Admin, then disallow the edit.
            if (!$this->app->getIdentity()->authorise('core.admin')) {
                return false;
            }
        }

        return parent::allowEdit($data, $key);
    }

    public function save($key = null, $urlVar = null)
    {
        // Check for request forgeries.
        $this->checkToken();

        $app = Factory::getApplication();
        $task				=	$app->getInput()->get('task',null,'POST');
		$view				=	$app->getInput()->get('view','');
        $id				    =	$app->getInput()->get('id');

        //$id = $this->state('file')
        // Check if the user is authorized to do this.
        if (!$this->app->getIdentity()->authorise('core.admin')) {
            $this->setRedirect('index.php', Text::_('JERROR_ALERTNOAUTHOR'), 'error');

            return false;
        }

        /** @var \Joomla\Component\Decentralization\Administrator\Model\GroupModel $model */
        $model = $this->getModel('Group', 'Administrator');
        $data  = $this->input->post->get('jform', [], 'array');
        if ($model->save($data) && $model->storeData()) {
			$msg = 'Xử lý thành công!';
		} else {
			$msg = 'Xử lý lỗi.';
		}
        if ($task == 'save2new'){
			$link = 'index.php?option=com_decentralization&view='.$view.'&layout=edit';
			$this->setRedirect($link, $msg);
		}else if($task == 'save') {
			$link = 'index.php?option=com_decentralization&view=groups';
			$this->setRedirect($link, $msg);
		}else if($task == 'apply') {
            $link = 'index.php?option=com_decentralization&view='.$view.'&layout=edit&id='.$id;
			$this->setRedirect($link, $msg);
        }

    }


}