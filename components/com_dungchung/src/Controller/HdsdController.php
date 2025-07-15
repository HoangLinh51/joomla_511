<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_DungChung
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
 * The hdsd List Controller
 *
 * @since  3.1
 */
class HdsdController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
        $this->registerTask('edit_hdsd', 'edit_hdsd');
        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
        }
    }

    public function display($cachable = false, $urlparams = [])
    {
        return parent::display($cachable, $urlparams);
    }

    public function getDanhSachHdsd()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/Hdsd');
            $res =  $model->getListHdsd();
        } catch (Exception $e) {
            $res = ['error' => $e->getMessage()];
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        jexit();
    }

    public function edit_hdsd()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/Hdsd');
            $model->saveHdsd($formData, $user->id);
            $response = ['success' => true, 'message' => 'Đã lưu dữ liệu thành công'];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Có lỗi khi lưu dữ liệu', 'error' => $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }

    public function xoa_hdsd()
    {
        // Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();
        if (!$user->id) {
            echo new JsonResponse(null, 'Bạn cần đăng nhập', true);
            Factory::getApplication()->close();
            return;
        }

        // Lấy dữ liệu từ JSON body (request payload)
        $json = file_get_contents('php://input');
        $formData = json_decode($json, true);

        if (!isset($formData['idUser'], $formData['idHdsd'])) {
            echo new JsonResponse(null, 'Thiếu dữ liệu đầu vào', true);
            Factory::getApplication()->close();
            return;
        }

        try {
            $model = Core::model('DungChung/Hdsd');

            // Gọi model
            $result = $model->deleteHdsd($formData['idUser'], $formData['idHdsd']);

            echo new JsonResponse([
                'success' => true,
                'message' => 'Xóa thành công',
                'id' => $result
            ]);
        } catch (Exception $e) {
            echo new JsonResponse(null, $e->getMessage(), true);
        }

        Factory::getApplication()->close();
    }

    public function deleteVanBanCTL()
    {
        // Session::checkToken() or die('Token không hợp lệ');
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/Hdsd');
            $result = $model->deleteVanBan($formData['idVanban'], $formData['idHdsd']);
            return $response = [
                'success' => $result,
                'message' => 'Đã xóa file thành công',
            ];
        } catch (Exception $e) {
            return  $response = [
                'success' => false,
                'message' => 'Có lỗi khi xóa dữ liệu:' . $e->getMessage(),
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }
}
