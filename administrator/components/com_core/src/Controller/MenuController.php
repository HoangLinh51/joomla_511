<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_core
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Controller;

use Exception;
use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
/** @var \Joomla\Component\Core\Administrator\Model\MenuModel $model */
class MenuController extends AdminController
{

    public function getModel($name = 'Menu', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function getCoreMenu()
    {
        // Send json mime type.
        $this->app->mimeType = 'application/json';
        $this->app->setHeader('Content-Type', $this->app->mimeType . '; charset=' . $this->app->charSet);
        $this->app->sendHeaders();
        $parent   = $this->input->getInt('id', 0);
        $model = $this->getModel('Menu', 'Administrator', []);
        $data = $model->_buildTree($parent,'core_menu');
        echo json_encode($data);
        die;
    }

    // public function getEdit(){
    //     $model = $this->getModel('Menu');
    //     $model->getMsg();
    //     header('Content-type: application/json');
    // 	echo json_encode("fdsfsdfsd");
    // 	die;
    // }

    public function saveedit()
    {  
        $this->checkToken();
        $data  = $this->input->post->get('jform', [], 'array');
        $model = $this->getModel('Menu');
        if(!$model->save($data)){
            return $this->setRedirect(Route::_('index.php?option=com_core&controller=menu'),'Xử lý không thành công');
        }else{
            return $this->setRedirect(Route::_('index.php?option=com_core&controller=menu'),'Xử lý thành công');

        }
    }

    /**
     * Removes an item.
     *
     * Overrides Joomla\CMS\MVC\Controller\AdminController::delete to check the core.admin permission.
     *
     * @return  void
     *
     * @since   1.6
     */
    public function delete()
    {
        if(!Session::checkToken('get')) { 
            throw new \Exception(Text::_('JINVALID_TOKEN_NOTICE'), 403); 
        }else{
            $cid  = Factory::getApplication()->getInput()->getInt('id', 0);
            $model = $this->getModel('Menu');
            $model->delete($cid);
            $url = 'index.php?option=com_core&controller=menu';
            return $this->setRedirect($url,'Xử lý thành công','success');
        }
       
    }

    // public function delete1()
    // {
    //     $this->checkToken();
    //     $id   = $this->input->getInt('cid', 0);
    //     $sess   = $this->input->getInt('session', "");
    //     $model = $this->getModel('Menu');
    //     $model->delete($id);
    //     $url = 'index.php?option=com_core&controller=menu';
    //     return $this->setRedirect($url,'Xử lý thành công','success');
    // }
    
}