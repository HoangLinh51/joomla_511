<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_vhytgd
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
use DateTime;


defined('_JEXEC') or die;

/**
 * The LaoDong List Controller
 *
 * @since  3.1
 */
class LaoDongController extends BaseController
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

    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('Vhytgd/LaoDong');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function getListLaoDong()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('Vhytgd/LaoDong');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getDanhSachLaoDong($formData, $phuongxa);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function timkiem_nhankhau()
    {
        $app = Factory::getApplication();
        $input = $app->input;

        $keyword = $input->get('keyword', '', 'string');
        $nhankhau_id = $input->getInt('nhankhau_id', 0);
        $page = $input->getInt('page', 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $phuongxa_ids = $input->get('phuongxa_id', [], 'array');

        $model = Core::model('Vhytgd/LaoDong');

        try {
            $result = $model->getDanhSachNhanKhau($phuongxa_ids, $keyword, $limit, $offset, $nhankhau_id);
        } catch (Exception $e) {
            $result = [
                'items' => [],
                'has_more' => false,
                'error' => $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function checkNhankhauInDsLaoDong()
    {
        $input = Factory::getApplication()->input;
        $nhankhau_id = $input->getInt('nhankhau_id', 0);
        // Validate input
        if (!$nhankhau_id) {
            $response = [
                'success' => false,
                'exists' => false,
                'message' => 'Thiếu nhankhau_id hoặc xeom_id'
            ];
            echo json_encode($response);
            Factory::getApplication()->close();
            return;
        }

        // Load the model
        $model = Core::model('Vhytgd/LaoDong');

        try {
            // Check if nhankhau_id exists in xeom_id
            $exists = $model->checkNhankhauInDsLaoDong($nhankhau_id);

            $response = [
                'success' => true,
                'exists' => $exists,
                'message' => $exists ? 'Nhân khẩu đã là thành viên của đoàn hội' : 'Nhân khẩu chưa là thành viên của đoàn hội'
            ];
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'exists' => false,
                'message' => 'Lỗi khi kiểm tra nhân khẩu: ' . $e->getMessage()
            ];
        }

        // Return JSON response
        echo json_encode($response);
        Factory::getApplication()->close();
    }

    public function save_laodong()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        $formData['namsinh'] = $formData['select_namsinh'] ?? $formData['input_namsinh'];
        $formData['dantoc_id'] = $formData['select_dantoc_id'] ?? $formData['input_dantoc_id'];
        $formData['tongiao_id'] = $formData['select_tongiao_id'] ?? $formData['input_tongiao_id'];
        $formData['gioitinh_id'] = $formData['select_gioitinh_id'] ?? $formData['input_gioitinh_id'];
        $formData['phuongxa_id'] = $formData['select_phuongxa_id'] ?? $formData['input_phuongxa_id'];
        $formData['thonto_id'] = $formData['select_thonto_id'] ?? $formData['input_thonto_id'];
        $formData['hopdonglaodong'] = '0';
        $formData['kinhdoanhcathe'] = '0';

        if($formData['check_hopdonglaodong'] &&  $formData['check_hopdonglaodong'] === 'on'){
            $formData['hopdonglaodong'] = '1';
        }
        if ($formData['check_kinhdoanhcathe'] &&  $formData['check_kinhdoanhcathe'] === 'on') {
            $formData['kinhdoanhcathe'] = '1';
        }

        if (!empty($formData['namsinh'])) {
                // Validate and convert date
                $date = DateTime::createFromFormat('d/m/Y', $formData['namsinh']);
                if ($date === false || $date->format('d/m/Y') !== $formData['namsinh']) {
                    throw new Exception('Invalid date format for namsinh');
                }
            // Format to YYYY-MM-DD for database
            $formData['namsinh'] = $date->format('Y-m-d');
        }
        try {
            $model = Core::model('Vhytgd/LaoDong');
            $result = $model->saveLaoDong($formData, $user->id);
            if ((int)$result && $result > 0) {
                $response = ['success' => true, 'result' => $result,  'message' => 'Đã lưu dữ liệu thành công'];
            } else {
                $response = ['success' => false, 'message' => 'Có lỗi khi lưu dữ liệu', 'error' => $result];
            }
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Có lỗi khi lưu dữ liệu', 'error' => $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }

    public function xoa_laodong()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('Vhytgd/LaoDong');
            $result = $model->deleteLaoDong($formData['idUser'], $formData['idLaoDong']);
            $response = [
                'success' => $result,
                'message' => 'Xóa người lao động thành công',
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
