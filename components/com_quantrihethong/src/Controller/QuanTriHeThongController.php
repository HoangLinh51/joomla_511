<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_quantrihethong
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\QuanTriHeThong\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;

defined('_JEXEC') or die;

/**
 * The Quan Tri He Thong List Controller
 *
 * @since  3.1
 */
class QuanTriHeThongController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
        $this->registerTask('edit_quantrihethong', 'edit_quantrihethong');
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

    public function getListAccount()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('QuanTriHeThong/QuanTriHeThong');
            $result = $model->getListAccount($formData['keyword'], $formData['page'], $formData['take']);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function saveInfoAccount()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('QuanTriHeThong/QuanTriHeThong');
            $result = $model->saveUserModel($formData);

            if (!$result['success']) {
                throw new Exception($result['error']);
            }

            $response = [
                'success' => true,
                'message' => 'Đã lưu dữ liệu thành công',
                'user_id' => $result['user_id'] ?? null
            ];
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Có lỗi khi lưu dữ liệu',
                'error' => $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }

    public function changeStatusCTL()
    {
        $user_id = $this->input->getInt('id', null);
        $trangthai = $this->input->getInt('status', null);

        // Kiểm tra đầu vào
        if (is_null($user_id) || !in_array($trangthai, [0, 1])) {
            $response = [
                'status' => 'error',
                'message' => 'Invalid user ID or status'
            ];
            header('Content-type: application/json');
            echo json_encode($response);
            exit;
        }

        $model = Core::model('QuanTriHeThong/QuanTriHeThong');
        $result = $model->changeStatus($user_id, $trangthai);

        $response = [
            'status' => $result ? 'success' : 'error',
            'result' => $result ? '1' : '0',
            'message' => $result ? 'Status updated successfully' : 'Failed to update status'
        ];

        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }

    public function resetPasswordCTL()
    {
        $user_id = $this->input->getInt('id', null);
        $password = $this->input->getString('password', null);
        $model = Core::model('QuanTriHeThong/QuanTriHeThong');
        $result = $model->resetPassword($user_id, $password);
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }

    public function deleteAccountCTL()
    {
        // Session::checkToken() or die('Token không hợp lệ');
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('QuanTriHeThong/QuanTriHeThong');
            $result = $model->deleteAccount($formData);

            if (!$result['success']) {
                throw new Exception($result['error']);
            }

            $response = [
                'success' => true,
                'message' => 'Đã xóa tài khoản thành công',
            ];
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Có lỗi khi xóa dữ liệu:' . $e->getMessage(),
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }
}
