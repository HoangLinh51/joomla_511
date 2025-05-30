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
        // $skip = ($formData['page'] - 1) * $formData['take'];
        // var_dump($formData);

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

    public function save_user()
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

    public function trangthaiTK()
    {
        $user_id = $this->input->getInt('id', null);
        $trangthai = $this->input->getInt('status', null);
        $model = Core::model('QuanTriHeThong/QuanTriHeThong');
        if (!$model->changeTrangthaiTK($user_id, $trangthai)) {
            $result = '0';
        } else {
            $result = '1';
        }
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
    public function capnhatMK()
    {
        $user_id = $this->input->getInt('id', null);
        $matkhau = $this->input->getString('matkhau', null);
        $model = Core::model('QuanTriHeThong/QuanTriHeThong');
        $result = $model->resetPassworkTK($user_id, $matkhau);
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }

    public function xoa_taikhoan()
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
