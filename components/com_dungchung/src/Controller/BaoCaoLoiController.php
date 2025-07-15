<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_dungchung
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\DungChung\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Response\JsonResponse;

defined('_JEXEC') or die;

/**
 * The BaoCaoLoi List Controller
 *
 * @since  3.1
 */
class BaoCaoLoiController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
        $this->registerTask('edit_baocaoloi', 'edit_baocaoloi');
        if (!$user->id) {
            if (Factory::getApplication()->input->getVar('format') == 'raw') {
                echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
                exit;
            } else {
                $this->setRedirect("index.php?option=com_users&view=login");
            }
        }
    }

    public function display($cachable = false, $urlparams = [])
    {
        return parent::display($cachable, $urlparams);
    }


    public function getListErrorReport()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/BaoCaoLoi');
            $result =  $model->getListErrorReport($formData['keyword'], $formData['page'], $formData['take']);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function create_baocaoloi()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/BaoCaoLoi');
            $model->saveBaoCaoLoi($formData, $user->id);
            $response = ['success' => true, 'message' => 'Đã lưu dữ liệu thành công'];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Có lỗi khi lưu dữ liệu', 'error' => $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }

    public function confirm_reason()
    {
        $user = Factory::getUser();
        if (!$user->id) {
            echo new JsonResponse(null, 'Bạn cần đăng nhập', true);
            Factory::getApplication()->close();
            return;
        }
        $formData["status"]= 1 ;

        // Lấy dữ liệu từ JSON body (request payload)
        $json = file_get_contents('php://input');
        $formData = json_decode($json, true);

        if (!isset($formData['idUser'], $formData['idError'], $formData['action'], $formData['contentReason'])) {
            echo new JsonResponse(null, 'Thiếu dữ liệu đầu vào', true);
            Factory::getApplication()->close();
            return;
        }

        if($formData['action']==='complete'){
            $formData["status"] = 2;
        } else if ($formData['action']==='cancel'){
            $formData['status'] = 3;
        }

        try {
            $model = Core::model('DungChung/BaoCaoLoi');

            // Gọi model
            $result = $model->saveReason($formData);

            echo new JsonResponse([
                'success' => $result,
                'message' => 'Cập nhật trạng thái thành công',
            ]);
        } catch (Exception $e) {
            echo new JsonResponse(null, $e->getMessage(), true);
        }

        Factory::getApplication()->close();
    }
}
