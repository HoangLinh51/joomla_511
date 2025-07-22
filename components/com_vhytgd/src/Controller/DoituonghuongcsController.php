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
class DoituonghuongcsController extends BaseController
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

    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
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

        $model = Core::model('Vhytgd/Doituonghuongcs');

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
    function saveDoituongCS()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Doituonghuongcs');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveDoituongCS($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=doituonghuongcs&task=default");
    }
    public function delThongtinhuongcs()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $app = Factory::getApplication();
        $trocap_id = $app->input->getInt('trocap_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$trocap_id > 0) {
            if ($model->delThongtinhuongcs($trocap_id)) {
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

    public function removeDoiTuongChinhSach()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $app = Factory::getApplication();
        $id = $app->input->getInt('chinhsach_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeDoiTuongChinhSach($id)) {
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
    public function cutThongtinhuongcs()
    {
        Session::checkToken() or die('Invalid Token');
        $model = Core::model('Vhytgd/Doituonghuongcs');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveCatHuongCS($formData)) {
                echo json_encode(['success' => false, 'message' => 'Lưu dữ liệu không thành công.']);
                return;
            }
            echo json_encode(['success' => true, 'message' => 'Đã cập nhật trạng thái cắt hưởng thành công!']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit; // Đảm bảo không có thêm nội dung nào được gửi về
    }
    public function checkCatHuong()
    {
        $doituong_id = $this->input->getInt('doituong_id');
        $model = Core::model('Vhytgd/Doituonghuongcs');

        $data = $model->getDetailCatCS($doituong_id);

        if (!empty($data)) {
            // Format lại dữ liệu nếu cần
            foreach ($data as &$item) {
                // Đảm bảo các trường quan trọng tồn tại
                $item['trangthaich_id'] = $item['trangthaich_id'] ?? null;
                $item['lydo'] = $item['lydo'] ?? '';

                // Format ngày nếu cần (đã được format trong SQL)
            }

            echo json_encode([
                'hasData' => true,
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'hasData' => false,
                'data' => []
            ]);
        }

        Factory::getApplication()->close();
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
            $model = Core::model('Vhytgd/Doituonghuongcs');

            // Lấy tham số tìm kiếm
            $input = Factory::getApplication()->input;
            $filters = [
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'hoten' => $input->getString('hoten', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
                'cccd' => $input->getString('cccd', ''),
                'daxoa' => 0
            ];

            // Lấy dữ liệu từ model
            $rows = $model->getDanhSachDTBTXHExel($filters);

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
                'Mã đối tượng',
                'Họ và tên',
                'Ngày sinh',
                'Số CMND/CCCD',
                'Ngày cấp',
                'Nơi cấp',
                'Giới tính',
                'Điện thoại',
                'Biến động',
                'Mã hỗ trợ',
                'Loại đối tượng',
                'Mức hỗ trợ',
                'Số quyết định',
                'Ngày quyết định',
                'Ngày hỗ trợ',
                'Tình trạng',
                'Cắt hưởng',
                'Thời điểm cắt hưởng',
                'Lý do',

            ];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:T1')->getFont()->setBold(true);
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
                'L' => 40,   // Nghề nghiệp
                'M' => 20,   // Nơi ở hiện tại
                'N' => 20,   // Nơi thường trú
                'O' => 20,   // lý do xóa
                'P' => 20,   // lý do xóa
                'Q' => 20,   // lý do xóa
                'R' => 20,   // lý do xóa
                'S' => 20,   // lý do xóa
                'T' => 20,   // lý do xóa



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
                    $item['madoituong'] ?? '',
                    $item['n_hoten'] ?? '',
                    $item['ngaysinh'] ?? '',
                    $item['n_cccd'] ?? '',
                    $item['cccd_ngaycap'] ?? '',
                    $item['cccd_coquancap'] ?? '',
                    $item['tengioitinh'] ?? '',
                    $item['n_dienthoai'] ?? '',
                    $item['tenbiendong'] ?? '',
                    $item['maht'] ?? '',
                    $item['tenloaidoituong'] ?? '',
                    $item['sotien'] ?? '',
                    $item['soqdhuong'] ?? '',
                    $item['ngayky'] ?? '',
                    $item['huongtungay'] ?? '',
                    $item['tentrangthai'] ?? '',
                    $item['tentrangthaicathuong'] ?? '',
                    $item['ngaycat'] ?? '',
                    $item['lydo'] ?? '',

                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:T' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

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
        header('Content-Disposition: attachment;filename="DanhSach_DoiTuongBaoTroXaHoi.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Pragma: public');

        $writer->save('php://output');
        jexit();
    }
}
