<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Vhytgd\Site\Controller;

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
class GiadinhvanhoaController extends BaseController
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
    function saveGiaDinhVanHoa()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveGiaDinhVH($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=giadinhvanhoa&task=default");
    }
    public function delGiaDinhVanHoa()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $app = Factory::getApplication();
        $giadinh_id = $app->input->getInt('giadinh_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$giadinh_id > 0) {
            if ($model->delGiaDinhVanHoa($giadinh_id)) {
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
     
      public function removeGiaDinhVanHoa()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $app = Factory::getApplication();
        $id = $app->input->getInt('giadinh_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeGiaDinhVanHoa($id)) {
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
    public function GiaDinhVH1nam()
    {

        $input = Factory::getApplication()->input;
        $thonto_id = $input->getInt('thonto_id', 0);
        $nam = $input->getInt('nam', 0);

        if (!$thonto_id || !$nam) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Thiếu thonto_id hoặc nam'
            ));
            jexit();
        }

        $model = Core::model('Vhytgd/Giadinhvanhoa');
        $result = $model->getGiaDinhVH1nam($thonto_id, $nam);

        echo json_encode($result);
        jexit();
    }
}
