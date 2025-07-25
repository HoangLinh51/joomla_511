<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Taichinh\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Response\JsonResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

defined('_JEXEC') or die;

/**
 * The Vhytgd List Controller
 *
 * @since  3.1
 */
class NopthueController extends BaseController
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

    function saveNopThueDat()
    {
        $model = Core::model('Taichinh/Nopthue');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveNopThueDat($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/taichinh/?view=nopthue&task=default");
    }
    public function delThongtinnopthue()
    {
        // $user = Factory::getUser();
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication();
        $nopthue_id = $app->input->getInt('nopthue_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$nopthue_id > 0) {
            if ($model->delThongtinnopthue($nopthue_id)) {
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

    public function removeNopThue()
    {
        // $user = Factory::getUser();
        $model = Core::model('Taichinh/Nopthue');
        $app = Factory::getApplication();
        $id = $app->input->getInt('nopthue_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeNopThue($id)) {
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
    public function checkNhankhau()
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

        $model = Core::model('Taichinh/Nopthue');

        try {
            $exists = $model->checkNopThue($nhankhau_id, 'qs_danquan');
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

    public function exportExcel()
    {
        ini_set('memory_limit', '1024M');

        if (!Session::checkToken('get')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Token không hợp lệ']);
            jexit();
        }

        $user = Factory::getUser();
        if (!$user->id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            jexit();
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        try {
            $input = Factory::getApplication()->input;
            $filters = [
                'hoten'    => $input->getString('hoten', ''),
                'cccd'    => $input->getString('cccd', ''),
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id'   => $input->getString('thonto_id', ''),
            ];
            $model = Core::model('Taichinh/Nopthue');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = [];
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }

            $rows = $model->getDanhSachXuatExcel($filters, $phuongxa);

            if (empty($rows)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không có dữ liệu để xuất']);
                jexit();
            }
            // var_dump($rows);exit;

            require_once JPATH_ROOT . '/vendor/autoload.php';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // ======= Tạo 2 hàng tiêu đề giống mẫu =========
            // Hàng 1
            $sheet->setCellValue('A1', 'STT');
            $sheet->setCellValue('B1', 'Tên đường');
            $sheet->setCellValue('C1', 'Tên người nộp thuế');
            $sheet->setCellValue('D1', 'Mã phi nông nghiệp');
            $sheet->setCellValue('E1', 'Địa chỉ thửa đất');
            $sheet->setCellValue('F1', 'Số GCN');
            $sheet->setCellValue('G1', 'Ngày cấp');
            $sheet->setCellValue('H1', 'Thửa đất số');
            $sheet->setCellValue('I1', 'Tờ bản đồ số');
            $sheet->setCellValue('J1', 'Tên đường');
            $sheet->setCellValue('K1', 'Diện tích có quyền sử dụng');
            $sheet->setCellValue('M1', 'Diện tích thực tế sử dụng');
            $sheet->setCellValue('N1', 'Miễn giảm thuế');
            $sheet->setCellValue('O1', 'Số thuế phải nộp ');
            $sheet->setCellValue('P1', 'Tình trạng');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:C2');
            $sheet->mergeCells('D1:D2');
            $sheet->mergeCells('E1:E2');
            $sheet->mergeCells('F1:F2');
            $sheet->mergeCells('G1:G2');
            $sheet->mergeCells('H1:H2');
            $sheet->mergeCells('I1:I2');
            $sheet->mergeCells('J1:J2');
            $sheet->mergeCells('K1:L1'); // Thông tin cá nhân
            $sheet->mergeCells('M1:M2'); // Thông tin số nhà
            $sheet->mergeCells('N1:N2'); // Thông tin số nhà
            $sheet->mergeCells('O1:O2');
            $sheet->mergeCells('P1:P2');
            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('K2', 'Đã có GCN');
            $sheet->setCellValue('L2', 'Chưa có GCN');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:P2')->getFont()->setBold(true);
            $sheet->getStyle('A1:P2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:P2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(25);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(25);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(15);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $trangthai = 'Đã nộp';
                if($item['tinhtrang'] == 1 ){
                    $trangthai = 'Chưa nộp';
                }
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['masothue'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['n_hoten'] ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['maphinongnghiep'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['diachi'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['sogcn'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['ngaycn'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['thuadat'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['tobando'] ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['tenduong'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $item['dientich_gcn'] ?? '');
                $sheet->setCellValue('L' . $rowIndex, $item['dientich_ccn'] ?? '');
                $sheet->setCellValue('M' . $rowIndex, $item['dientich_sd'] ?? '');
                $sheet->setCellValue('N' . $rowIndex, $item['sotienmiengiam'] ?? '');
                $sheet->setCellValue('O' . $rowIndex, $item['tongtiennop'] ?? '');
                $sheet->setCellValue('P' . $rowIndex, $trangthai);
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:P' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_Nopthue.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Pragma: public');
            $writer->save('php://output');
            jexit();
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xuất Excel: ' . $e->getMessage()]);
            jexit();
        }
    }
}
