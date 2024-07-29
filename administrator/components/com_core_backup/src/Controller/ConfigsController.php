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
use Joomla\Component\Core\Administrator\Helper\CoreHelper;

/** @var \Joomla\Component\Core\Administrator\Model\MenuModel $model */
class ConfigsController extends AdminController
{

    public function getModel($name = 'Configs', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function getCoreMenu()
    {
        // Send json mime type.
        $this->app->mimeType = 'application/json';
        $this->app->setHeader('Content-Type', $this->app->mimeType . '; charset=' . $this->app->charSet);
        $this->app->sendHeaders();
        $id   = $this->input->getInt('id', 0);
        $model = $this->getModel('Configs', 'Administrator', []);
        $data = $model->treemenu($id);
        $callback = Factory::getApplication()->getInput()->getString('callback');
        $result = json_encode($data);
        if (!empty($callback)){
			echo $callback . '(',$result, ');';
		}else{
			echo $result;
		}
        die;
    }


    public function saveedit()
    {  
        $this->checkToken();
        $data  = $this->input->post->get('menu', [], 'array');
        $model = $this->getModel('Menu');
        $model->save($data);
        return $this->setRedirect('index.php?option=com_core&controller=menu','Xử lý thành công','success');
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

    public function treemenu(){
        $app = Factory::getApplication()->getInput();
		$id = $app->getInt('id',0);
		$model = $this->getModel('Configs', 'Administrator', []);
		$rows = $model->treemenu($id);
		CoreHelper::printJson($rows);
	}

    public function getlist(){
        $app = Factory::getApplication()->getInput();
		$id = $app->getInt('id',0);
		$model = $this->getModel('Configs', 'Administrator', []);
		$rows = $model->listConfigById($id);
		CoreHelper::printJson($rows);
	}
    
}