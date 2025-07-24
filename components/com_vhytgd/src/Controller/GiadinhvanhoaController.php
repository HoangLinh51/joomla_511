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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
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
            $model = Core::model('Vhytgd/Giadinhvanhoa');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'nam' => $input->getString('nam', ''),               
                'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getGiaDinhVanHoaExcel($filters);

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
                'Thông tin trung tâm thiết chế',                  // B
                '',            // C
                '',   // D
                '',           // E
                '',           // F
                'Thông tin thiết bị',       // G
                '', // H (spans H, I, J)
                '',                    // I
                '',                    // J
                'Thông tin hoạt động', // K (spans K, L, M)
                '',                    // L
                '',                    // M
                '',           // N
                '', // O
                '',          // P
            ];

            $headersRow2 = [
                '',
                'Tên thiết chế',                    // A
                'Vị trí',                    // B
                'Loại hình thiết chế',                    // C
                'Diện tích',                    // D
                'Tình trạng',                    // E
                'Loại thiết bị',                    // F
                'Tên thiết bị',                    // G
                'Đơn vị tính',                 // H
                'Số lượng',           // I
                'Năm',            // J
                'Nội dung hoạt động',          // K
                'Ngày bắt đầu',            // L
                'Ngày kế thúc',           // M
                'Nguồn kinh phí',                    // N
                'Kinh phí',                    // O
            ];

            // Ghi tiêu đề vào sheet
            $sheet->fromArray($headersRow1, null, 'A1');
            $sheet->fromArray($headersRow2, null, 'A2');
            $sheet->mergeCells('B1:F1'); // Thông tin trung tâm thiết chế
            $sheet->mergeCells('G1:J1'); // Thông tin thiết bị
            $sheet->mergeCells('K1:P1'); // Thông tin thiết bị
            $sheet->mergeCells('A1:A2'); // Thông tin thiết bị



            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:P2')->getFont()->setBold(true);
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
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $rowData[] = [
                    $index + 1,                            // A: STT
                    $item['thietche_ten'] ?? '',              // B: Tổ
                    $item['thietche_vitri'] ?? '',      // C: Nhiệm kỳ
                    $item['tenloaihinhthietche'] ?? '',                  // D: Họ tên
                    $item['thietche_dientich'] ?? '',                // E: Ngày sinh
                    $item['trangthaihoatdong_id'] =
                        ($item['trangthaihoatdong_id'] == 1) ? 'Đang xây dựng' : (($item['trangthaihoatdong_id'] == 2) ? 'Đang sửa chữa' : (($item['trangthaihoatdong_id'] == 3) ? 'Đang sử dụng' : '')),
                    $item['loaithietbi'] ?? '',              // G: Số điện thoại
                    $item['tenthietbi'] ?? '',                // H: CMND/CCCD Số
                    $item['donvitinh'] ?? '',           // I: CMND/CCCD Ngày cấp
                    $item['soluong'] ?? '',         // J: CMND/CCCD Nơi cấp
                    $item['nam'] ?? '',            // K: Chức danh
                    $item['noidunghoatdong'] ?? '',        // L: Từ ngày
                    $item['thoigianhoatdong_tungay'] ?? '',       // M: Đến ngày
                    $item['thoigianhoatdong_denngay'] ?? '',              // N: Đảng viên
                    $item['nguonkinhphi_id'] =
                        ($item['nguonkinhphi_id'] == 1) ? 'Tự chủ' : (($item['nguonkinhphi_id'] == 2) ? 'Đầu tư':''),
                    $item['kinhphi'] ?? '',       // P: Tình trạng
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
            $sheet->getStyle('B1:P1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:P2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:Q$lastRow)
            $sheet->getStyle('A1:P' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            $this->outputExcel($writer);
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

    private function outputExcel($writer)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DanhSach_ThongTinThietChe.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        jexit();
    }
}
