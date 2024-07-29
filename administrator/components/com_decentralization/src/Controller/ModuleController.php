<?php 
 /* HueNN
 *
 * Created on Thu Jul 06 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Controller;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * User controller class.
 *
 * @since  1.6
 */
class ModuleController extends FormController
{
    /**
     * @var    string  The prefix to use with controller messages.
     * @since  1.6
     */
    protected $text_prefix = 'Module';

    public function save($key = null, $urlVar = null)
    {
        // Check for request forgeries.
        $this->checkToken();

        // Check if the user is authorized to do this.
        if (!$this->app->getIdentity()->authorise('core.admin')) {
            $this->setRedirect('index.php', Text::_('JERROR_ALERTNOAUTHOR'), 'error');

            return false;
        }

        /** @var \Joomla\Component\Decentralization\Administrator\Model\ModuleModel $model */
        $model = $this->getModel('Module', 'Administrator');
        $data  = $this->input->post->get('jform', [], 'array');

        // Must load after serving service-requests
        $form = $model->getForm();

        // Validate the posted data.
        $return = $model->validate($form, $data);
        if ($return === false) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof \Exception) {
                    $this->app->enqueueMessage($errors[$i]->getMessage(), 'error');
                } else {
                    $this->app->enqueueMessage($errors[$i], 'error');
                }
            }

            // Save the posted data in the session.
            $this->app->setUserState('com_decentralization.module.global.data', $data);

            // Redirect back to the edit screen.
            $this->setRedirect(Route::_('index.php?option=com_decentralization&view=module&layout=edit', false));

            return false;
        }
        // Attempt to save the configuration.
        
        $data   = $return;
        $return = $model->save($data);
        // Check the return value.
        if ($return === false) {
            /*
            * The save method enqueued all messages for us, so we just need to redirect back.
            */
            
            // Save failed, go back to the screen and display a notice.
            $this->setRedirect(Route::_('index.php?option=com_decentralization&view=modules', false));

            return false;
        }

        // Set the success message.
        $this->app->enqueueMessage(Text::_('Lưu thành công'), 'message');

        // Set the redirect based on the task.
        switch ($this->input->getCmd('task')) {
            case 'save':
            default:
                $this->setRedirect(Route::_('index.php?option=com_decentralization&view=modules', false));
                break;
        }
    }

}
