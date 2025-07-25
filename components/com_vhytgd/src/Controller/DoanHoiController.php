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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

defined('_JEXEC') or die;

/**
 * The DoanHoi List Controller
 *
 * @since  3.1
 */
class DoanHoiController extends BaseController
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

    public function getListDoanHoi()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        $model = Core::model('Vhytgd/DoanHoi');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();
        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        try {
            $result =  $model->getListDoanHoi($formData, $phuongxa);
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

        $model = Core::model('Vhytgd/DoanHoi');;
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
        $model = Core::model('Vhytgd/DoanHoi');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function getDetailDoanHoi()
    {
        $idDoanHoi = Factory::getApplication()->input->getVar('doanhoi_id', 0);
        $model = Core::model('Vhytgd/DoanHoi');
        $result = $model->getDetailDoanHoi($idDoanHoi);
        // var_dump($result);
        // exit;
        try {
            echo json_encode(
                $result['data']
            );
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
        jexit();
    }

    public function checkNhankhauInDoanhoi()
    {
        $input = Factory::getApplication()->input;
        $nhankhau_id = $input->getInt('nhankhau_id', 0);
        $doanhoi_id = $input->getInt('doanhoi_id', 0);

        // Validate input
        if (!$nhankhau_id || !$doanhoi_id) {
            $response = [
                'success' => false,
                'exists' => false,
                'message' => 'Thiếu nhankhau_id hoặc doanhoi_id'
            ];
            echo json_encode($response);
            Factory::getApplication()->close();
            return;
        }

        // Load the model
        $model = Core::model('Vhytgd/DoanHoi');

        try {
            // Check if nhankhau_id exists in doanhoi_id
            $exists = $model->checkNhankhauInDoanhoi($nhankhau_id, $doanhoi_id);

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

    public function save_doanhoi()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $formData['dantoc_id'] = $formData['modal_dantoc_id'] ?? $formData['input_dantoc_id'];
        $formData['gioitinh_id'] = $formData['modal_gioitinh_id'] ?? $formData['input_gioitinh_id'];
        $formData['phuongxa_id'] = $formData['modal_phuongxa_id'] ?? $formData['input_phuongxa_id'];
        $formData['thonto_id'] = $formData['modal_thonto_id'] ?? $formData['input_thonto_id'];


        $formData['namsinh'] = $formData['select_namsinh'] ?? $formData['input_namsinh'];
        $formData['namsinh'] = !empty($formData['namsinh']) ? $this->formatDate($formData['namsinh']) : '';
        $formData['thoidiem_batdau'] = $formData['form_thoidiem_batdau'] ?? '';
        $formData['thoidiem_batdau'] = !empty($formData['thoidiem_batdau']) ? $this->formatDate($formData['thoidiem_batdau']) : '';
        $formData['thoidiem_ketthuc'] = $formData['form_thoidiem_ketthuc'] ?? '';
        $formData['thoidiem_ketthuc'] = !empty($formData['thoidiem_ketthuc']) ? $this->formatDate($formData['thoidiem_ketthuc']) : '';

        // var_dump($formData);
        // exit;
        try {
            $model = Core::model('Vhytgd/DoanHoi');

            $result = $model->saveThanhVienDoanHoi($formData, $user->id);
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
            throw new Exception('Invalid date format for namsinh');
        }
        // Format to YYYY-MM-DD for database
        return $date->format('Y-m-d');
    }

    public function xoa_doanhoi()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('Vhytgd/DoanHoi');
            $result = $model->deleteDoanHoi($formData['idUser'], $formData['idThanhvienDoanHoi']);
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
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'doanhoi' => $input->getString('doanhoi', ''),
                'gioitinh' => $input->getInt('gioitinh_id', 0),
            ];
            $model = Core::model('Vhytgd/DoanHoi');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = array();
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }

            $rows = $model->getDanhSachXuatExcel($filters, $phuongxa);

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

            $headers = [
                'STT',
                'Họ và tên',
                'Ngày sinh',
                'Giới tính',
                'Số CMND/CCCD',
                'Ngày cấp',
                'Nơi cấp',
                'Địa chỉ',
                'Đoàn hội',
                'Chức vụ',
                'Thời gian bắt đầu',
                'Thời gian kết thúc',
            ];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:L1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);

            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 10,  // STT
                'B' => 25,  // Họ và tên
                'C' => 13,  // Ngày sinh
                'D' => 10,  // Giới tính
                'E' => 15,  // CMND/CCCD 
                'F' => 13,  // Ngày cấp
                'G' => 45,  // Nơi cấp
                'H' => 45,  // Địa chỉ 
                'I' => 20,  // Đoàn hội 
                'J' => 20,  // Chức vụ
                'K' => 17,  // Thời gian bắt đầu
                'L' => 17,  // Thời gian kết thúc
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }
            $sheet->getStyle('L')->getNumberFormat()->setFormatCode('0');

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $diachi = $item['n_diachi'] . ' - ' . $item['thonto'] . ' - ' . $item['phuongxa'];
                $rowData[] = [
                    $index + 1,
                    $item['n_hoten'] ?? '',
                    $item['ngaysinh'] ?? '',
                    $item['tengioitinh'] ?? '',
                    $item['n_cccd'] ?? '',
                    $item['cccd_ngaycap'] ?? '',
                    $item['cccd_coquancap'] ?? '',
                    $diachi ?? '',
                    $item['tendoanhoi'] ?? '',
                    $item['tenchucdanh'] ?? '',
                    $item['thoidiem_batdau'] ?? '',
                    $item['thoidiem_ketthuc'] ?? '',
                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:L' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DanhSach_DoanHoi.xlsx"');
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
