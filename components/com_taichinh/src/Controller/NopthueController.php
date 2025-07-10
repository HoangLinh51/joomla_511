<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Taichinh\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Response\JsonResponse;

defined('_JEXEC') or die;

/**
 * The Vhytgd List Controller
 *
 * @since  3.1
 */
class NopthueController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
        $this->registerTask('thongtinthietche', 'thongtinthietche');
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
            $model = Core::model('Vhytgd/Vhytgd');
            $res =  $model->getListThongBao('all', $formData['keyword'], $formData['page'], $formData['take']);
        } catch (Exception $e) {
            $res = ['error' => $e->getMessage()];
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        jexit();
    }
      public function getThanhVienGiaDinhVanHoa()
    {
        $app = Factory::getApplication();
        $thonto_id = $app->input->getInt('thonto_id', 0);
        $nam = $app->input->getInt('nam', 0);
        $search = $app->input->getString('search', ''); // Lấy tham số tìm kiếm

        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $result = $model->getThanhVienGiaDinhVanHoa($thonto_id, $nam, $search);

        header('Content-type: application/json');
        echo json_encode($result);
        $app->close();
    }
    function saveNopThueDat()
    {
        // Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();


        $model = Core::model('Taichinh/Nopthue');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveNopThueDat($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/taichinh/?view=nopthue&task=default");
    }
    public function delThongtinnopthue()
    {
        // $user = Factory::getUser();
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication();
        $nopthue_id = $app->input->getInt('nopthue_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$nopthue_id > 0) {
            if ($model->delThongtinnopthue($nopthue_id)) {
                $response['success'] = true;
                $response['message'] = 'Xóa hoạt động thành công';
            } else {
                $response['message'] = 'Xóa hoạt động thất bại';
            }
        } else {
            $response['message'] = 'ID hoạt động không hợp lệ';
        }

        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
     
      public function removeNopThue()
    {
        // $user = Factory::getUser();
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication();
        $id = $app->input->getInt('nopthue_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeNopThue($id)) {
                $response['success'] = true;
                $response['message'] = 'Xóa hoạt động thành công';
            } else {
                $response['message'] = 'Xóa hoạt động thất bại';
            }
        } else {
            $response['message'] = 'ID hoạt động không hợp lệ';
        }

        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
      public function checkNhankhau()
    {
        $input = Factory::getApplication()->input;
        $nhankhau_id = $input->getInt('nhankhau_id', 0);
        if (!$nhankhau_id) {
            $response = [
                'success' => false,
                'exists' => false,
                'message' => 'Thiếu nhankhau_id'
            ];
            echo json_encode($response);
            Factory::getApplication()->close();
            return;
        }

        $model = Core::model('Taichinh/Nopthue');

        try {
            $exists = $model->checkNopThue($nhankhau_id, 'qs_danquan');
            $response = [
                'success' => true,
                'exists' => $exists,
                'message' => $exists ? 'Nhân khẩu đã có trong danh sách dân quân' : 'Nhân khẩu chưa có trong danh sách dân quân'
            ];
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'exists' => false,
                'message' => 'Lỗi khi kiểm tra nhân khẩu: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
        Factory::getApplication()->close();
    }
}
