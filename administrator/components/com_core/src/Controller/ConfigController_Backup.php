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
        $data    = $this->input->get('jform');
        $url = 'index.php?option=com_core&controller=configs';

        if((int) $data['id'] > 0){
            $res = $model->update($data);
        }else{
            $res = $model->save($data);
        }
        
        // return $this->setRedirect('index.php?option=com_core&view=configs','Xử lý thành công','success');
        if ($res) {
            $response = [
                'success' => true,
                'message' => Text::_('Xử lý thành công'),
                'redirect' => Route::_($url)
            ];
        } else {
            $response = [
                'success' => false,
                'message' => Text::_('Xảy ra lỗi. Vui lòng thử lại.'),
                'redirect' => Route::_($url)
            ];
        }
        echo new JsonResponse($response);
        Factory::getApplication()->close();
    }

    public function delete(){
        if(!Session::checkToken('get')) { 
            throw new \Exception(Text::_('JINVALID_TOKEN_NOTICE'), 403); 
        }else{
            $id = Factory::getApplication()->getInput()->getInt('id');
            $url = 'index.php?option=com_core&controller=configs';
            $user = Factory::getUser();
            /** @var \Joomla\Component\Core\Administrator\Model\ConfigsModel $model */
            $model   = $this->getModel();
            if($user->authorise('core.edit', 'com_modules.module.' . (int) $id)){
                $model->delete($id);
                return $this->setRedirect($url,'Xử lý thành công','success');
            }else{
                Factory::getApplication()->enqueueMessage('Bạn chưa chọn đúng thành viên ban điều hành để xóa. Vui lòng kiểm tra kết nối hoặc liên hệ quản trị viên!','error');
            }
        }

    }

    public function addValue()
    {
        $data    = $this->input->post->get('jform', [], 'array');
        $this->checkToken();
        /** @var \Joomla\Component\Core\Administrator\Model\ConfigModel $model */
        $model   = $this->getModel();
       
        if((int) $data['id'] > 0){
            $model->updateValue($data);
        }else{
            $model->saveValue($data);
        }
       
    }
    


    
}