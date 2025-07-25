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
class DongbaodantocController extends BaseController
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

        $model = Core::model('Vhytgd/Dongbaodantoc');

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
   
    function saveDongbaodantoc()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Dongbaodantoc');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveDongbaodantoc($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=dongbaodantoc&task=default");
    }
    public function delThongtinhuongcs()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Dongbaodantoc');
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

    public function removeDongbaodantoc()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Dongbaodantoc');
        $app = Factory::getApplication();
        $id = $app->input->getInt('chinhsach_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeDongbaodantoc($id)) {
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

        $model = Core::model('Vhytgd/Dongbaodantoc');

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
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id'   => $input->getString('thonto_id', ''),
                'tenduong'    => $input->getString('tenduong', ''),
            ];
            $model = Core::model('Dcxddt/Biensonha');
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

            require_once JPATH_ROOT . '/vendor/autoload.php';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // ======= Tạo 2 hàng tiêu đề giống mẫu =========
            // Hàng 1
            $sheet->setCellValue('A1', 'STT');
            $sheet->setCellValue('B1', 'Thông tin cá nhân');
            $sheet->setCellValue('J1', 'Thông tin người nhận');
            $sheet->setCellValue('M1', 'Thông tin hỗ trợ');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:I1');
            $sheet->mergeCells('J1:L1'); // Thông tin cá nhân
            $sheet->mergeCells('M1:Q1'); // Thông tin số nhà

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('B2', 'Họ và tên');
            $sheet->setCellValue('C2', 'Ngày sinh');
            $sheet->setCellValue('D2', 'CCCD/CMND');
            $sheet->setCellValue('E2', 'Ngày cấp');
            $sheet->setCellValue('F2', 'Nơi cấp');
            $sheet->setCellValue('G2', 'Giới tính');
            $sheet->setCellValue('H2', 'Điện thoại');
            $sheet->setCellValue('I2', 'Địa chỉ');
            $sheet->setCellValue('J2', 'Tên người nhận');
            $sheet->setCellValue('K2', 'Số tài khoản');
            $sheet->setCellValue('L2', 'Ngân hàng');
            $sheet->setCellValue('M2', 'Chính sách');
            $sheet->setCellValue('N2', 'Loại hỗ trợ');
            $sheet->setCellValue('O2', 'Nội dung');
            $sheet->setCellValue('P2', 'Ngày hỗ trợ');
            $sheet->setCellValue('Q2', 'Tình trạng');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:Q2')->getFont()->setBold(true);
            $sheet->getStyle('A1:Q2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:Q2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(40);
            $sheet->getColumnDimension('J')->setWidth(25);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(40);
            $sheet->getColumnDimension('M')->setWidth(40);
            $sheet->getColumnDimension('N')->setWidth(40);
            $sheet->getColumnDimension('O')->setWidth(40);
            $sheet->getColumnDimension('P')->setWidth(40);
            $sheet->getColumnDimension('Q')->setWidth(15);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['tenduong'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, ($item['n_hoten'] ?? $item['tentochuc']) ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['n_dienthoai'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['sonha'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['tobandoso'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['thuadatso'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['tenhinhthuc'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['lydothaydoi'] ?? '');
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:I' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_SoNha.xlsx"');
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
