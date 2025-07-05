<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_quansu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\QuanSu\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use DateTime;


defined('_JEXEC') or die;

/**
 * The QuanSu List Controller
 *
 * @since  3.1
 */
class QuanNhanDuBiController extends BaseController
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

    public function getListQuanNhanDuBi()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('QuanSu/QuanNhanDuBi');
        $modelBase = Core::model('QuanSu/Base');
        $phanquyen = $modelBase->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $modelBase->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getListQuanNhanDuBi($formData, $phuongxa);
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

        $model = Core::model('QuanSu/QuanNhanDuBi');

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

    public function checkNhankhauInQuanNhanDuBi()
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
        $model = Core::model('QuanSu/Base');

        try {
            // Check if nhankhau_id exists in xeom_id
            $exists = $model->checkNhankhauInDanhSachQuanSu($nhankhau_id, 'qs_quannhandubi');

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
    
    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('QuanSu/Base');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function getDetailQuanNhanDuBi()
    {
        $idQuanNhanDuBi = Factory::getApplication()->input->getVar('quannhandubi_id', 0);
        $model = Core::model('QuanSu/QuanNhanDuBi');
        $result = $model->getDetailQuanNhanDuBi($idQuanNhanDuBi);
        try {
            echo json_encode(
                $result['data']
            );
        } catch (Exception $e) {
            echo json_encode( $e->getMessage());
        }
        jexit();
    }


    public function getThanNhan()
    {
        $model = Core::model('QuanSu/QuanNhanDuBi');
        $nhankhau_id = Factory::getApplication()->input->getInt('nhankhau_id', 0);
        $result = $model->getThanNhan($nhankhau_id);
        try {
            echo json_encode(
                $result
            );
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
        jexit();
    }


    public function save_quannhandubi()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $formData['gioitinh'] = $formData['select_gioitinh_id'] ?? $formData['input_gioitinh_id'];
        $formData['dantoc_id'] = $formData['select_dantoc_id'] ?? $formData['input_dantoc_id'];
        $formData['phuongxa_id'] = $formData['select_phuongxa_id'] ?? $formData['input_phuongxa_id'];
        $formData['thonto_id'] = $formData['select_thonto_id'] ?? $formData['input_thonto_id'];
        $namsinh = $formData['select_namsinh'] ?? $formData['input_namsinh'] ?? '';
        $formData['namsinh'] = !empty($namsinh) ? $this->formatDate($namsinh) : '';
        $formData['ngaydangky'] = $formData['form_ngaydangky'] ?? '';
        $formData['ngaydangky'] = !empty($formData['ngaydangky']) ? $this->formatDate($formData['ngaydangky']) : '';
        $formData['ngaynhapngu'] = $formData['form_ngaynhapngu'] ?? '';
        $formData['ngaynhapngu'] = !empty($formData['ngaynhapngu']) ? $this->formatDate($formData['ngaynhapngu']) : '';
        $formData['ngayxuatngu'] = $formData['form_ngayxuatngu'] ?? '';
        $formData['ngayxuatngu'] = !empty($formData['ngayxuatngu']) ? $this->formatDate($formData['ngayxuatngu']) : '';
        $formData['ngaychungnhan'] = $formData['form_ngaychungnhan'] ?? '';
        $formData['ngaychungnhan'] = !empty($formData['ngaychungnhan']) ? $this->formatDate($formData['ngaychungnhan']) : '';

        $thanNhanFormatted = [];

        $quanheList = $formData['thannhan_quanhe_id'] ?? [];
        $hotenList = $formData['thannhan_hoten'] ?? [];
        $namsinhList = $formData['thannhan_namsinh'] ?? [];
        $nghenghiepList = $formData['thannhan_nghenghiep'] ?? [];

        $max = max(count($quanheList), count($hotenList), count($namsinhList), count($nghenghiepList));

        for ($i = 0; $i < $max; $i++) {
            // Bỏ qua nếu tất cả đều rỗng
            if (
                empty($hotenList[$i]) &&
                empty($namsinhList[$i]) &&
                empty($quanheList[$i]) &&
                empty($nghenghiepList[$i])
            ) {
                continue;
            }

            $thanNhanFormatted[] = [
                'quanhe_id'   => $quanheList[$i] ?? null,
                'hoten'       => $hotenList[$i] ?? null,
                'namsinh'     => $namsinhList[$i] ?? null,
                'nghenghiep'  => $nghenghiepList[$i] ?? null,
            ];
        }
        $formData['thannhan'] = $thanNhanFormatted;

        try {
            $model = Core::model('QuanSu/QuanNhanDuBi');

            $result = $model->saveQuanNhanDuBi($formData, $user->id);
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

    function formatDate($dateString){
        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        if ($date === false || $date->format('d/m/Y') !== $dateString) {
            throw new Exception('Invalid date format for namsinh');
        }
        // Format to YYYY-MM-DD for database
        return $date->format('Y-m-d');
    }

    public function xoa_quannhandubi()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('QuanSu/QuanNhanDuBi');
            $result = $model->deleteQuanNhanDuBi($formData['idUser'], $formData['idquannhandubi']);
            $response = [
                'success' => $result,
                'message' => 'Xóa thành công',
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
