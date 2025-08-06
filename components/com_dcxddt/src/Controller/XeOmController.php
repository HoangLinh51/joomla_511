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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


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



    public function exportExcel()
    {
        // Tăng giới hạn bộ nhớ
        ini_set('memory_limit', '1024M');

        // Kiểm tra CSRF token
        if (!Session::checkToken('get')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Token không hợp lệ']);
            jexit();
        }

        // Kiểm tra người dùng
        $user = Factory::getUser();
        if (!$user->id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            jexit();
        }

        // Xóa bộ đệm đầu ra
        while (ob_get_level()) {
            ob_end_clean();
        }

        try {
            $input = Factory::getApplication()->input;
            $filters = [
                'hoten' => $input->getString('hoten', ''),
                'cccd' => $input->getString('cccd', ''),
                'gioitinh_id' => $input->getInt('gioitinh_id', 0),
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
            ];

            $model = Core::model('Dcxddt/Xeom');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = array();
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }
            // Lấy dữ liệu từ model
            $rows = $model->getDanhSachXuatExcel($filters, $phuongxa);
            // var_dump($rows); exit;

            // Kiểm tra dữ liệu
            if (empty($rows)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không có dữ liệu để xuất']);
                jexit();
            }

            // Tải PhpSpreadsheet qua Composer
            $autoloadPath = JPATH_ROOT . '/vendor/autoload.php';
            if (!file_exists($autoloadPath)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'File autoload.php không được tìm thấy']);
                jexit();
            }
            require_once $autoloadPath;

            // Tạo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Định dạng tiêu đề
            $headers = [
                'STT', 
                'Họ tên', 
                'Ngày sinh', 
                'Giới tính', 
                'CCCD/CMND',
                'Ngày cấp',
                'Nơi cấp',
                'Địa chỉ',
                'Loại xe',
                'Biển số xe',
                'Thẻ hành nghề',
                'Giấy phép lái xe',
                'Tình trạng',
            ];

            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:M1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);

            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 8,   // STT
                'B' => 25,  // Họ tên
                'C' => 15,  // Ngày sinh
                'D' => 15,  // Giới tính
                'E' => 15,  // CCCD/CMND
                'F' => 15,  // Ngày cấp
                'G' => 30,  // Nơi cấp
                'H' => 40,  // Địa chỉ
                'I' => 30,  // Loại xe
                'J' => 15,  // Biển số xe
                'K' => 15,  // Thẻ hành nghề
                'L' => 15,  // Giấy phép lái xe
                'M' => 15,  // Tình trạng
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }
            $sheet->getStyle('M')->getNumberFormat()->setFormatCode('0');

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $diachi = $item["coso_diachi"] . ' - ' . $item["thonto"] . ' - ' . $item["phuongxa"];

                $rowData[] = [
                    $index + 1,
                    $item["n_hoten"] ?? '',
                    $item["namsinh"] ?? '',
                    $item["tengioitinh"] ?? '',
                    $item["n_cccd"] ?? '',
                    $item["cccd_ngaycap"] ?? '',
                    $item["cccd_coquancap"] ?? '',
                    $diachi ?? '',
                    $item["tenloaixe"] ?? '',
                    $item["biensoxe"] ?? '',
                    $item["thehanhnghe_so"] ?? '',
                    $item["sogiaypheplaixe"] ?? '',
                    $item["tentinhtrang"] ?? '',
                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:M' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DanhSach_HanhNgheVanChuyen.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Pragma: public');

            $writer->save('php://output');
            jexit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xuất Excel: ' . $e->getMessage()]);
            jexit();
        }
    }
}
