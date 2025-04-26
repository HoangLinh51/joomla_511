<?php

/**
* @ Author: huenn.dnict@gmail.com
* @ Create Time: 2024-08-06 13:39:37
* @ Modified by: huenn.dnict@gmail.com
* @ Modified time: 2024-08-06 14:23:04
* @ Description:
* Ajax Controller for the component
*
* This controller handles Ajax requests for the component.
* It checks if the user is logged in and then calls the parent display method.
*
* Example:
* ```
* $controller = new AjaxController();
* $controller->display();
* ```
*/
namespace Joomla\Component\VPTK\Site\Controller;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

class AjaxController extends BaseController{

    function __construct($config = array())
    {
        parent::__construct($config);
    }

    function display($cachable = false, $urlparams = [])
    {
        $user = Factory::getUser();
        if ($user->guest('guest')) {
            $this->setRedirect('index.php?option=com_users&view=login');
            return;
        }   
        parent::display();
    }

    public function getTinhthanh(){
        $model = Core::model('Danhmuc/CityCode');
        $result = $model->collect(null,array('muctuongduong DESC','name ASC'));
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
    public function getQuanhuyen(){
        $params['tinhthanh_id'] = Factory::getApplication()->input->getInt('tinhthanh_id', null);
        $model = Core::model('Danhmuc/DistCode');
        $result = $model->collect($params,array('muctuongduong DESC','name ASC'));
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
    public function getPhuongxa(){
        $params['tinhthanh_id'] = Factory::getApplication()->input->getInt('tinhthanh_id', null);
        $params['quanhuyen_id'] = Factory::getApplication()->input->getInt('quanhuyen_id', null);
        $model = Core::model('Danhmuc/CommCode');
        $result = $model->collect($params,array('muctuongduong DESC','name ASC'));
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
}