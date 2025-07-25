<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_doanhoi
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Dcxddt\Site\Controller;

use Core;
use DateTime;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;


defined('_JEXEC') or die;

/**
 * The XeOm List Controller
 *
 * @since  3.1
 */
class XeOmController extends BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $user = Factory::getUser();
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

    public function getListXeOm()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('Dcxddt/XeOm');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getListXeOm($formData, $phuongxa);
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

        $model = Core::model('Dcxddt/XeOm');

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
    
    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('Dcxddt/XeOm');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function getDetailXeOm()
    {
        $idXeOm = Factory::getApplication()->input->getVar('xeom_id', 0);
        $model = Core::model('Dcxddt/XeOm');
        $result = $model->getDetailXeOm($idXeOm);
        // var_dump($result);
        // exit;
        try {
            echo json_encode(
                $result['data']
            );
        } catch (Exception $e) {
            echo json_encode( $e->getMessage());
        }
        jexit();
    }

    public function checkNhankhauInXeOm()
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
        $model = Core::model('Dcxddt/XeOm');

        try {
            // Check if nhankhau_id exists in xeom_id
            $exists = $model->checkNhankhauInXeOm($nhankhau_id);

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

    public function save_xeom()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $formData['dantoc_id'] = $formData['modal_dantoc_id'] ?? $formData['input_dantoc_id'];
        $formData['namsinh'] = $formData['select_namsinh'] ?? $formData['input_namsinh'];
        $formData['namsinh'] = !empty($formData['namsinh']) ? $this->formatDate($formData['namsinh']) : '';
        $formData['gioitinh_id'] = $formData['modal_gioitinh_id'] ?? $formData['input_gioitinh_id'];
        $formData['phuongxa_id'] = $formData['modal_phuongxa_id'] ?? $formData['input_phuongxa_id'];
        $formData['thonto_id'] = $formData['modal_thonto_id'] ?? $formData['input_thonto_id'];
        $formData['ngayhethan_thehanhnghe'] = $formData['modal_ngayhethan_thehanhnghe']  ?? '';
        $formData['ngayhethan_thehanhnghe'] = !empty($formData['ngayhethan_thehanhnghe']) ? $this->formatDate($formData['ngayhethan_thehanhnghe']) : '';
        try {
            $model = Core::model('Dcxddt/XeOm');

            $result = $model->saveXeOm($formData, $user->id);
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

    function formatDate($dateString)
    {
        $date = DateTime::createFromFormat('d/m/Y', $dateString);

        if ($date === false || $date->format('d/m/Y') !== $dateString) {
            throw new Exception('Định dạng ngày tháng không hợp lệ');
        }
        return $date->format('Y-m-d');
    }

    public function xoa_xeom()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('Dcxddt/XeOm');
            $result = $model->deleteXeOm($formData['idUser'], $formData['idTaiXe']);
            $response = [
                'success' => $result,
                'message' => 'Xóa thành viên thành công',
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
