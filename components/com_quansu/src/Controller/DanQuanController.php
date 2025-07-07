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
class DanQuanController extends BaseController
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

    // lấy danh sách dân quân
    public function getListDanQuan()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('QuanSu/DanQuan');
        $modelBase = Core::model('QuanSu/Base');
        $phanquyen = $modelBase->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $modelBase->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getListDanQuan($formData, $phuongxa);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    // lấy danh sách nhân khẩu
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

        $model = Core::model('QuanSu/DanQuan');

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

    // kiểm tra nhân khẩu đó đã có trong danh sách dân quân chưa 
    public function checkNhankhauInDanQuan()
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

        $model = Core::model('QuanSu/Base');

        try {
            $exists = $model->checkNhankhauInDanhSachQuanSu($nhankhau_id, 'qs_danquan');

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
    
    // lấy thôn tổ theo phường xã
    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('QuanSu/Base');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    // lấy thông tin của dân quân 
    public function getDetailDanQuan()
    {
        $idDanQuan = Factory::getApplication()->input->getVar('danquan_id', 0);
        $model = Core::model('QuanSu/DanQuan');
        $result = $model->getDetailDanQuan($idDanQuan);
        try {
            echo json_encode(
                $result['data']
            );
        } catch (Exception $e) {
            echo json_encode( $e->getMessage());
        }
        jexit();
    }

    // lấy thân nhân của dân quân 
    public function getThanNhan()
    {
        $model = Core::model('QuanSu/DanQuan');
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

    // lưu dân quân 
    public function save_danquan()
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
        $formData['ngayvao'] = $formData['form_ngayvao'] ?? '';
        $formData['ngayvao'] = !empty($formData['ngayvao']) ? $this->formatDate($formData['ngayvao']) : '';
        $formData['ngayquyetdinhvao'] = $formData['form_ngayquyetdinhvao'] ?? '';
        $formData['ngayquyetdinhvao'] = !empty($formData['ngayquyetdinhvao']) ? $this->formatDate($formData['ngayquyetdinhvao']) : '';
        $formData['ngayra'] = $formData['form_ngayra'] ?? '';
        $formData['ngayra'] = !empty($formData['ngayra']) ? $this->formatDate($formData['ngayra']) : '';
        $formData['ngayquyetdinhra'] = $formData['form_ngayquyetdinhra'] ?? '';
        $formData['ngayquyetdinhra'] = !empty($formData['ngayquyetdinhra']) ? $this->formatDate($formData['ngayquyetdinhra']) : '';

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
            $model = Core::model('QuanSu/DanQuan');

            $result = $model->saveDanQuan($formData, $user->id);
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

    // hàm format ngày từ dd/mm/yyyy sang yyyy-mm-dd
    function formatDate($dateString){
        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        if ($date === false || $date->format('d/m/Y') !== $dateString) {
            throw new Exception('Định dạng ngày tháng không hợp lệ cho năm sinh');
        }
        return $date->format('Y-m-d');
    }

    // xóa dân quân
    public function xoa_danquan()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('QuanSu/DanQuan');
            $result = $model->deleteDanQuan($formData['idUser'], $formData['iddanquan']);
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
