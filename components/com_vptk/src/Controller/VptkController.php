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
class VptkController extends BaseController
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
    public function delNhanKhau()
    {
        $user = Factory::getUser();
        if (!$user->id) {
            $this->outputJsonError('Bạn cần đăng nhập');
        }

        $nhankhau_id = $this->input->getInt('nhankhau_id', 0);
        $response = ['success' => false, 'message' => 'Xóa thất bại'];

        if ($nhankhau_id > 0) {
            $model = Core::model('Vptk/Vptk');
            if ($model->removeNhankhau($nhankhau_id, $user->id)) {
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
            $model = Core::model('Vptk/Vptk');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'hoten' => $input->getString('hoten', ''),
                'gioitinh_id' => $input->getString('gioitinh_id', ''),
                'is_tamtru' => $input->getString('is_tamtru', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'hokhau_so' => $input->getString('hokhau_so', ''),
                'cccd_so' => $input->getString('cccd_so', ''),
                'diachi' => $input->getString('diachi', ''),
                'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getItems($filters);

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

            // Thiết lập cache để giảm bộ nhớ


            // Tạo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Định dạng tiêu đề
            $headers = [
                'STT',
                'Số hộ khẩu',
                'Quan hệ với chủ hộ',
                'Họ và tên',
                'Ngày sinh',
                'Giới tính',
                'Số CMND/CCCD',
                'Ngày cấp',
                'Nơi cấp',
                'Điện thoại',
                'Dân tộc',
                'Tôn giáo',
                'Trình độ học vấn',
                'Nghề nghiệp',
                'Nơi ở hiện tại',
                'Nơi ở thường trú trước khi chuyển đến',
                'Lý do xóa đăng ký thường trú'
            ];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);
            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 10,  // STT
                'B' => 15,  // Số hộ 
                'C' => 20,  // Quan hệ với chủ hộ
                'D' => 25,  // Họ và tên
                'E' => 15,  // Ngày sinh
                'F' => 15,  // Giới tính
                'G' => 15,  // CMND/CCCD 
                'H' => 20,   // điện thoại
                'I' => 20,   // Dân tộc
                'J' => 20,   // Tôn giáo
                'K' => 20,   // Trình độ học vấn
                'L' => 20,   // Nghề nghiệp
                'M' => 20,   // Nơi ở hiện tại
                'N' => 20,   // Nơi thường trú
                'O' => 40,   // lý do xóa
                'P' => 40,   // lý do xóa
                'Q' => 20,   // lý do xóa


            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $rowData[] = [
                    $index + 1,
                    $item['hokhau_so'] . ($item['hokhau_ngaycap'] ? "\nNgày cấp: " . $item['hokhau_ngaycap'] : ''),
                    $item['tenquanhenhanthan'] ?? '',
                    $item['hoten'] ?? '',
                    $item['namsinh'] ?? '',
                    $item['tengioitinh'] ?? '',
                    $item['cccd_so'] ?? '',
                    $item['cccd_ngaycap'] ?? '',
                    $item['cccd_coquancap'] ?? '',
                    $item['dienthoai'] ?? '',
                    $item['tendantoc'] ?? '',
                    $item['tentongiao'] ?? '',
                    $item['tentrinhdohocvan'] ?? '',
                    $item['tennghenghiep'] ?? '',
                    $item['diachi'] ?? '',
                    $item['diachi1'] ?? '',
                    $item['tenlydo'] ?? '',
                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:Q' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            $this->outputExcel($writer);
        } catch (Exception $e) {
            $this->outputJsonError('Lỗi khi xuất Excel: ' . $e->getMessage());
        }
    }
    function saveNhanhokhau()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vptk/Vptk');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveNhanhokhau($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vptk/?view=nhk&task=default");
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
        header('Content-Disposition: attachment;filename="DanhSachNhanKhau.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        jexit();
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
}
