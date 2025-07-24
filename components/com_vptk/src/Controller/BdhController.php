<?php

namespace Joomla\Component\VPTK\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cache\Psr16Cache;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

defined('_JEXEC') or die;

/**
 * The Vptk List Controller
 *
 * @since  3.1
 */
class BdhController extends BaseController
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

    public function getKhuvucByIdCha()
    {
        $cha_id = Factory::getApplication()->input->getVar('cha_id', 0);
        $model = Core::model('Vptk/Vptk');
        $result = $model->getKhuvucByIdCha($cha_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    public function delHoKhau()
    {
        if (!Session::checkToken()) {
            $this->outputJsonError('Token không hợp lệ');
        }

        $user = Factory::getUser();
        if (!$user->id) {
            $this->outputJsonError('Bạn cần đăng nhập');
        }

        $hokhau_id = $this->input->getInt('hokhau_id', 0);
        $response = ['success' => false, 'message' => 'Xóa thất bại'];

        if ($hokhau_id > 0) {
            $model = Core::model('Vptk/Vptk');
            if ($model->removeNhanhokhau($hokhau_id, $user->id)) {
                $response = ['success' => true, 'message' => 'Đã xóa dữ liệu thành công'];
            } else {
                $response['message'] = 'Lỗi khi xóa bản ghi';
            }
        } else {
            $response['message'] = 'ID không hợp lệ';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }
    public function delBandieuhanh()
    {
        $user = Factory::getUser();
        if (!$user->id) {
            $this->outputJsonError('Bạn cần đăng nhập');
        }

        $nhankhau_id = $this->input->getInt('nhankhau_id', 0);
        $response = ['success' => false, 'message' => 'Xóa thất bại'];

        if ($nhankhau_id > 0) {
            $model = Core::model('Vptk/Bdh');
            if ($model->removeBanDieuHanh($nhankhau_id, $user->id)) {
                $response = ['success' => true, 'message' => 'Đã xóa dữ liệu thành công'];
            } else {
                $response['message'] = 'Lỗi khi xóa bản ghi';
            }
        } else {
            $response['message'] = 'ID không hợp lệ';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }
    public function delDSBandieuhanh()
    {
        $app = Factory::getApplication();


        $thonto_id = $app->input->getInt('thonto_id', 0);
        $nhiemky_id = $app->input->getInt('nhiemky_id', 0);

        if ($thonto_id > 0) {
            $model = Core::model('Vptk/Bdh');
            if ($model->removeDSBanDieuHanh($thonto_id, $nhiemky_id)) {
                $response = ['success' => true, 'message' => 'Đã xóa dữ liệu thành công'];
            } else {
                $response['message'] = 'Lỗi khi xóa bản ghi';
            }
        } else {
            $response['message'] = 'ID không hợp lệ';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }


    function saveBanDieuHanh()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vptk/Bdh');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveBanDieuHanh($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vptk/?view=bdh&task=default");
    }

    private function outputJsonError($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        jexit();
    }

    private function outputExcel($writer)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DanhSach_BanDieuHanh.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        jexit();
    }
    public function getThanhVienBanDieuHanh()
    {
        $app = Factory::getApplication();
        $thonto_id = $app->input->getInt('thonto_id', 0);
        $nhiemky_id = $app->input->getInt('nhiemky_id', 0);
        $search = $app->input->getString('search', ''); // Lấy tham số tìm kiếm

        $model = Core::model('Vptk/Bdh');
        $result = $model->getThanhVienBanDieuHanh($thonto_id, $nhiemky_id, $search);

        header('Content-type: application/json');
        echo json_encode($result);
        $app->close();
    }
    public function checkBanDieuHanh()
    {
        $app = Factory::getApplication();
        $thonto_id = $app->input->getInt('thonto_id');
        $nhiemky_id = $app->input->getInt('nhiemky_id');

        // Gọi model để kiểm tra
        $model = Core::model('Vptk/Bdh');
        $exists = $model->checkBanDieuHanhExists($thonto_id, $nhiemky_id);

        // Trả về JSON
        echo json_encode(['exists' => $exists]);
        $app->close();
    }
    public function getNhankhauByThonToId()
    {
        $thonto_id = Factory::getApplication()->input->getInt('thonto_id', 0);
        $model = Core::model('Vptk/Bdh');
        $result = $model->getNhankhauByThonToId($thonto_id);
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
    public function getQuanHuyenByTinhThanh()
    {
        $tinhthanh_id = Factory::getApplication()->input->getInt('tinhthanh_id', 0);
        $trangthai = Factory::getApplication()->input->getInt('trangthai', 0);

        $model = Core::model('Danhmuc/Ajax');
        $result = $model->getQuanHuyenByTinhThanh($tinhthanh_id, $trangthai);
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }
    public function getPhuongXaByQuanHuyen()
    {
        $quanhuyen_id = Factory::getApplication()->input->getInt('quanhuyen_id', 0);
        $trangthai = Factory::getApplication()->input->getInt('trangthai', 0);
        $model = Core::model('Danhmuc/Ajax');
        $result = $model->getPhuongXaByQuanHuyen($quanhuyen_id, $trangthai);
        header('Content-type: application/json');
        echo json_encode($result);
        die;
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
            $model = Core::model('Vptk/Bdh');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'hoten' => $input->getString('hoten', ''),
                'chucdanh_id' => $input->getString('chucdanh_id', ''),
                'tinhtrang_id' => $input->getString('tinhtrang_id', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'hokhau_so' => $input->getString('hokhau_so', ''),
                'chucvukn_id' => $input->getString('chucvukn_id', ''),
                'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getDanhSachBanDieuHanhExel($filters);

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
            $headersRow1 = [
                'STT',                 // A
                'Tổ',                  // B
                'Nhiệm kỳ',            // C
                'Họ tên thành viên',   // D
                'Ngày sinh',           // E
                'Giới tính',           // F
                'Số điện thoại',       // G
                'Thông tin CMND/CCCD', // H (spans H, I, J)
                '',                    // I
                '',                    // J
                'Thông tin chức danh', // K (spans K, L, M)
                '',                    // L
                '',                    // M
                'Đảng viên',           // N
                'Trình độ lý luận chính trị', // O
                'Tình trạng',          // P
                'Lý do kết thúc',      // Q
            ];

            $headersRow2 = [
                '',                    // A
                '',                    // B
                '',                    // C
                '',                    // D
                '',                    // E
                '',                    // F
                '',                    // G
                'Số',                 // H
                'Ngày cấp',           // I
                'Nơi cấp',            // J
                'Chức danh',          // K
                'Từ ngày',            // L
                'Đến ngày',           // M
                '',                    // N
                '',                    // O
                '',                    // P
                '',                    // Q
            ];

            // Ghi tiêu đề vào sheet
            $sheet->fromArray($headersRow1, null, 'A1');
            $sheet->fromArray($headersRow2, null, 'A2');

            // Gộp ô cho tiêu đề chính
            $sheet->mergeCells('H1:J1'); // Thông tin CMND/CCCD
            $sheet->mergeCells('K1:M1'); // Thông tin chức danh

            // Gộp ô dòng 1 và dòng 2 cho các cột không có tiêu đề phụ
            $columnsToMerge = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'N', 'O', 'P', 'Q'];
            foreach ($columnsToMerge as $column) {
                $sheet->mergeCells("{$column}1:{$column}2");
            }

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:Q2')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);
            $sheet->getRowDimension(2)->setRowHeight(20);

            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 10,  // STT
                'B' => 15,  // Tổ
                'C' => 20,  // Nhiệm kỳ
                'D' => 25,  // Họ và tên
                'E' => 15,  // Ngày sinh
                'F' => 15,  // Giới tính
                'G' => 20,  // Số điện thoại
                'H' => 15,  // CMND/CCCD: Số
                'I' => 15,  // CMND/CCCD: Ngày cấp
                'J' => 20,  // CMND/CCCD: Nơi cấp
                'K' => 20,  // Chức danh
                'L' => 15,  // Từ ngày
                'M' => 15,  // Đến ngày
                'N' => 20,  // Đảng viên
                'O' => 20,  // Trình độ lý luận chính trị
                'P' => 20,  // Tình trạng
                'Q' => 40,  // Lý do kết thúc
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $rowData[] = [
                    $index + 1,                            // A: STT
                    $item['thonto'] ?? '',              // B: Tổ
                    $item['tennhiemky'] ?? '',      // C: Nhiệm kỳ
                    $item['hoten'] ?? '',                  // D: Họ tên
                    $item['ngaysinh'] ?? '',                // E: Ngày sinh
                    $item['tengioitinh'] ?? '',            // F: Giới tính
                    $item['dienthoai'] ?? '',              // G: Số điện thoại
                    $item['cccd_so'] ?? '',                // H: CMND/CCCD Số
                    $item['cccd_ngaycap'] ?? '',           // I: CMND/CCCD Ngày cấp
                    $item['cccd_coquancap'] ?? '',         // J: CMND/CCCD Nơi cấp
                    $item['tenchucdanh'] ?? '',            // K: Chức danh
                    $item['ngaybatdau'] ?? '',        // L: Từ ngày
                    $item['ngayketthuc'] ?? '',       // M: Đến ngày
                    $item['dangvien'] ?? '',              // N: Đảng viên
                    $item['tentrinhdo'] ?? '',             // O: Trình độ lý luận chính trị
                    $item['tentinhtrang'] ?? '',       // P: Tình trạng
                    $item['lydoketthuc'] ?? '',                // Q: Lý do kết thúc
                ];
            }
            $sheet->fromArray($rowData, null, 'A3');

            // Bật wrapText cho cột Tổ (cột B) và các cột văn bản dài
            $lastRow = count($rowData) + 2; // Tính dòng cuối cùng (bắt đầu từ A3)
            $sheet->getStyle('B3:B' . $lastRow)->getAlignment()->setWrapText(true);
            $sheet->getStyle('H3:J' . $lastRow)->getAlignment()->setWrapText(true);
            $sheet->getStyle('K3:M' . $lastRow)->getAlignment()->setWrapText(true);
            $sheet->getStyle('Q3:Q' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A) và các cột tiêu đề
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H1:M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:Q2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:Q$lastRow)
            $sheet->getStyle('A1:Q' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            $this->outputExcel($writer);
        } catch (Exception $e) {
            $this->outputJsonError('Lỗi khi xuất Excel: ' . $e->getMessage());
        }
    }
}
