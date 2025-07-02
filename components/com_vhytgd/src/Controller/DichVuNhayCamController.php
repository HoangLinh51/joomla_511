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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


defined('_JEXEC') or die;

/**
 * The DichVuNhayCam List Controller
 *
 * @since  3.1
 */
class DichVuNhayCamController extends BaseController
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


    public function getListDichVuNhayCam()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('Vhytgd/DichVuNhayCam');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getListDichVuNhayCam($formData, $phuongxa);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function timkiem_nhankhau()
    {
        $input = Factory::getApplication()->input;
        $formDataSearch = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formDataSearch = $json ?? $formDataSearch;

        $model = Core::model('Vhytgd/DichVuNhayCam');
        $phanquyen = $model->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
        }
        try {
            $result =  $model->getDanhSachNhanKhau($formDataSearch, $phuongxa);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function save_dichvunhaycam()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        //gom dữ liệu nhân viên
        $fields = [
            "hoten_nhanvien",
            "id_nhanvien",
            "gioitinh_nhanvien",
            "cccd_nhanvien",
            "dienthoai_nhanvien",
            "diachi_nhanvien",
            "tinhtrang_cutru_nhanvien",
            "trangthai_nhanvien"
        ];

        // Kiểm tra có dữ liệu nhân viên không
        if (!empty($formData['hoten_nhanvien']) && is_array($formData['hoten_nhanvien'])) {
            $num = count($formData["hoten_nhanvien"]);
            $nhanvien = [];

            for ($i = 0; $i < $num; $i++) {
                $item = [];
                foreach ($fields as $field) {
                    $item[$field] = isset($formData[$field][$i]) ? $formData[$field][$i] : null;
                }
                $nhanvien[] = $item;
            }

            // Gắn lại vào formData
            foreach ($fields as $field) {
                unset($formData[$field]);
            }
            $formData["nhanvien"] = $nhanvien;
        }

        try {
            $model = Core::model('Vhytgd/DichVuNhayCam');
            $result = $model->saveDichVuNhayCam($formData, $user->id);
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

    public function xoa_dichvunhaycam()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        try {
            $model = Core::model('Vhytgd/DichVuNhayCam');
            $result = $model->deleteDichVuNhayCam($formData['idUser'], $formData['idCoso']);
            $response = [
                'success' => $result,
                'message' => 'Đã xóa file thành công',
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
            $this->outputJsonError('Token không hợp lệ');
        }

        // Kiểm tra người dùng
        $user = Factory::getUser();
        if (!$user->id) {
            $this->outputJsonError('Bạn cần đăng nhập');
        }

        // Xóa bộ đệm đầu ra
        while (ob_get_level()) {
            ob_end_clean();
        }

        try {
            // Tải model
            $model = Core::model('Vhytgd/DichVuNhayCam');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'tenchucoso' => $input->getString('tenchucoso',''),
				'tencoso' => $input->getString('tencoso',''),
				'ngaybatdau' => $input->getString('batdau',''),
				'ngayketthuc' => $input->getString('ketthuc',''),
				'trangthai_id' => $input->getString('trangthai_id',''),
				'phuongxa_id' => $input->getString('phuongxa_id',''),
				'thonto_id' => $input->getString('thonto_id',''),
				'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getDataExportExcel($filters);
            
            // Kiểm tra dữ liệu
            if (empty($rows)) {
                $this->outputJsonError('Không có dữ liệu để xuất');
            }

            // Tải PhpSpreadsheet qua Composer
            $autoloadPath = JPATH_ROOT . '/vendor/autoload.php';
            if (!file_exists($autoloadPath)) {
                $this->outputJsonError('File autoload.php không được tìm thấy');
            }
            require_once $autoloadPath;

            // Tạo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Định dạng tiêu đề
            $headers = ['STT', 'Tên cơ sở', 'Địa chỉ',  'Tên chủ chủ cơ sở', 'CMND/CCCD', 'Số điện thoại', 'Trạng thái'];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);

            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 8,  // stt
                'B' => 30,  // tên cơ sở 
                'C' => 50,  // địa chỉ
                'D' => 25,  // Tên chủ cơ sở
                'E' => 15,  // cccd
                'F' => 15,  // số điện thoại 
                'G' => 20,  // trạng thái 
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $rowData[] = [
                    $index + 1,
                    $item->coso_ten ?? '',
                    $item->coso_diachi ?? '',
                    $item->chucoso_ten ?? '',
                    $item->chucoso_cccd ?? '',
                    $item->chucoso_dienthoai ?? '',
                    $item->tentrangthaihoatdong ?? '',
                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:g' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DanhSachCoSoNhayCam.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Pragma: public');

            $writer->save('php://output');
            jexit();
        } catch (Exception $e) {
            $this->outputJsonError('Lỗi khi xuất Excel: ' . $e->getMessage());
        }
    }

    private function outputJsonError($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        jexit();
    }
}
