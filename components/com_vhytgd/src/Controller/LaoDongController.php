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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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

        if ($formData['check_hopdonglaodong'] &&  $formData['check_hopdonglaodong'] === 'on') {
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
            $model = Core::model('Vhytgd/LaoDong');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'hoten' => $input->getString('hoten', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'doituong_id' => $input->getString('doituong_id', ''),
                'gioitinh_id' => $input->getString('gioitinh_id', ''),

                'cccd' => $input->getString('cccd', ''),
                'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getDanhSachLaoDongExel($filters);

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

            $headers = [
                'STT',
                'Họ và tên',
                'Ngày sinh',
                'Giới tính',
                'Số CMND/CCCD',
                'Ngày cấp',
                'Nơi cấp',
                'Điện thoại',
                'Đối tượng ưu tiên',
                'Số BHXH',
                'Tình trạng việc làm',
                'Công việc',
                'Địa chỉ nơi làm việc',
                'Hợp đồng',
                'Đã từng làm việc',
                'Thời gian làm việc',
                'Lý do không tham gia hoạt động kinh tế',

            ];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);
            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 10,  // STT
                'B' => 25,  // Số hộ 
                'C' => 20,  // Quan hệ với chủ hộ
                'D' => 25,  // Họ và tên
                'E' => 15,  // Ngày sinh
                'F' => 15,  // Giới tính
                'G' => 15,  // CMND/CCCD 
                'H' => 20,   // điện thoại
                'I' => 20,   // Dân tộc
                'J' => 20,   // Tôn giáo
                'K' => 30,   // Trình độ học vấn
                'L' => 30,   // Nghề nghiệp
                'M' => 25,   // Nơi ở hiện tại
                'N' => 25,   // Nơi thường trú
                'O' => 20,   // lý do xóa
                'P' => 20,   // lý do xóa
                'Q' => 20,   // lý do xóa



            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }
            $sheet->getStyle('K')->getNumberFormat()->setFormatCode('0');
            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $rowData[] = [

                    $index + 1,
                    $item['n_hoten'] ?? '',
                    $item['ngaysinh'] ?? '',
                    $item['tengioitinh'] ?? '',
                    $item['n_cccd'] ?? '',
                    $item['cccd_ngaycap'] ?? '',
                    $item['cccd_coquancap'] ?? '',
                    $item['n_dienthoai'] ?? '',
                    $item['doituonguutien'] ?? '',
                    $item['bhxh'] = ($item['bhxh'] == 0) ? '' : $item['bhxh'],
                    $item['tendoituong'] ?? '',
                    $item['tennghenghiep'] ?? '',
                    $item['diachinoilamviec'] ?? '',
                    $item['is_hopdonglaodong'] = ($item['is_hopdonglaodong'] == 1) ? 'Có' : '',
                    $item['is_dalamviec'] = ($item['is_dalamviec'] == 1) ? 'Đã từng đi làm' : 'Chưa bao giờ đi làm',
                    $item['thoigian_lamviec'] =
                        ($item['thoigian_lamviec'] == 1) ? 'Dưới 3 tháng' : (($item['thoigian_lamviec'] == 2) ? 'Từ 3 tháng đến 1 năm' : (($item['thoigian_lamviec'] == 3) ? 'Trên 1 năm' : '')),

                    $item['lydokhonglaodong'] ?? '',


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
    private function outputJsonError($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        jexit();
    }

    private function outputExcel($writer)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DanhSach_LaoDong.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        jexit();
    }
}
