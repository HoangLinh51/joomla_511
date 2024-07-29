<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_core
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Controller;

use Core;
use Exception;
use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Component\Privacy\Administrator\Removal\Status;

class ConfigController extends FormController
{

    public function getModel($name = 'Config', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function save($key = null, $urlVar = null)
    { 
        $this->checkToken();
        /** @var \Joomla\Component\Core\Administrator\Model\ConfigsModel $model */
        $model   = $this->getModel();
        $data =  $this->input->get('jform', '', 'raw');
        $url = 'index.php?option=com_core&controller=configs';
        if((int) $data['id'] > 0){
            $res = $model->update($data);
        }else{
            $res = $model->save($data);
        }
        
        return $this->setRedirect('index.php?option=com_core&view=configs','Xử lý thành công','success');
    }

    public function delete(){
        $this->checkToken();
        $ids =  $this->input->get('cidh', [], 'int');
        if (!$this->app->getIdentity()->authorise('core.admin', $this->option)) {
            throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
        }
        if (empty($ids)) {
            $this->setMessage(Text::_('COM_USERS_NO_LEVELS_SELECTED'), 'warning');
        } else {
            // Get the model.
            /** @var \Joomla\Component\Core\Administrator\Model\ConfigsModel $model */
            $model = $this->getModel();

            // Remove the items.
            if ($model->delete($ids)) {
                $this->setMessage(Text::plural('Đã xóa cấu hình thành công', $ids));
            }
        }
        $this->setRedirect('index.php?option=com_core&view=configs');
    }

    public function savevalue()
    {
        $data =  $this->input->get('jform', '', 'raw');
        $this->checkToken();
        /** @var \Joomla\Component\Core\Administrator\Model\ConfigModel $model */
        $model   = $this->getModel();
        if((int) $data['id'] > 0){
            $model->updateValue($data);
        }else{
            $model->saveValue($data);
        } 
        return $this->setRedirect('index.php?option=com_core&view=configs','Xử lý thành công','success');

    }

    public function deletevalue(){
        $id =  $this->input->get('id', '', 'int');
        if (!Session::checkToken('get')) {
            throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
        }
        if (empty($id)) {
            $this->setMessage(Text::_('COM_USERS_NO_LEVELS_SELECTED'), 'warning');
        } else {
            // Get the model.
            /** @var \Joomla\Component\Core\Administrator\Model\ConfigsModel $model */
            $model = $this->getModel();

            // Remove the items.
            if ($model->delete($id)) {
                $this->setMessage(Text::plural('Đã xóa cấu hình thành công', $id));
            }
        }
        return $this->setRedirect('index.php?option=com_core&view=configs','Xử lý thành công','success');
        // or
        // $this->setRedirect('index.php?option=com_core&view=configs');
    }
    
    


    
}