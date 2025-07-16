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
 * The Thongbao List Controller
 *
 * @since  3.1
 */
class ThongBaoController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
        $this->registerTask('edit_thongbao', 'edit_thongbao');
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

    public function getDanhSachThongBao()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/Thongbao');
            $res =  $model->getListThongBao('all', $formData['keyword'], $formData['page'], $formData['take']);
        } catch (Exception $e) {
            $res = ['error' => $e->getMessage()];
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        jexit();
    }

    public function edit_thongbao()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('DungChung/Thongbao');
            $model->saveThongBao($formData, $user->id);
            $response = ['success' => true, 'message' => 'Đã lưu dữ liệu thành công'];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Có lỗi khi lưu dữ liệu', 'error' => $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }

    public function xoa_thongbao()
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

        if (!isset($formData['idUser'], $formData['idThongbao'])) {
            echo new JsonResponse(null, 'Thiếu dữ liệu đầu vào', true);
            Factory::getApplication()->close();
            return;
        }

        try {
            $model = Core::model('DungChung/Thongbao');

            // Gọi model
            $result = $model->deleteThongbao($formData['idUser'], $formData['idThongbao']);

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
            $model = Core::model('DungChung/Thongbao');
            $result = $model->deleteVanBan($formData['idVanban'], $formData['idThongbao']);
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