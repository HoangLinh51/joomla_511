<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_quansu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\QuanSu\Site\Controller;

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
 * The QuanSu List Controller
 *
 * @since  3.1
 */
class DkTuoi17Controller extends BaseController
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

    // lấy danh sách đăng ký tuổi 17
    public function getListDktuoi17()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $model = Core::model('QuanSu/Dktuoi17');
        $modelBase = Core::model('QuanSu/Base');
        $phanquyen = $modelBase->getPhanquyen();
        $phuongxa = array();

        if ($phanquyen['phuongxa_id'] != '') {
            $phuongxa = $modelBase->getPhuongXaById($phanquyen['phuongxa_id']);
        }

        try {
            $result =  $model->getListDktuoi17($formData, $phuongxa);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        jexit();
    }

    // tìm kiếm nhân khẩu
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

        $model = Core::model('QuanSu/DkTuoi17');

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

    // kiểm tra xem nhân khẩu đã có trong danh sách đăng ký tuổi 17 chưa 
    public function checkNhankhauInDSDkTuoi17()
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
        $model = Core::model('QuanSu/Base');

        try {
            $exists = $model->checkNhankhauInDanhSachQuanSu($nhankhau_id, 'qs_dangkytuoi17');

            $response = [
                'success' => true,
                'exists' => $exists,
                'message' => $exists ? 'Nhân khẩu đã có trong danh sách đăng ký tuổi 17' : 'Nhân khẩu chưa có trong danh sách đăng ký tuổi 17'
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
    
    // lấy danh sách thôn tổ theo phường xã 
    public function getThonTobyPhuongxa()
    {
        $phuongxa_id = Factory::getApplication()->input->getVar('phuongxa_id', 0);
        $model = Core::model('QuanSu/Base');
        $result = $model->getThonTobyPhuongxaId($phuongxa_id);
        header('Content-type: application/json');
        echo json_encode($result);
        jexit();
    }

    // lấy thông tin của người đăng ký tuổi 17
    public function getDetailDktuoi17()
    {
        $idDktuoi17 = Factory::getApplication()->input->getVar('dktuoi17_id', 0);
        $model = Core::model('QuanSu/Dktuoi17');
        $result = $model->getDetailDktuoi17($idDktuoi17);
        try {
            echo json_encode(
                $result['data']
            );
        } catch (Exception $e) {
            echo json_encode( $e->getMessage());
        }
        jexit();
    }

    // lấy thông tin của thân nhân 
    public function getThanNhan()
    {
        $model = Core::model('QuanSu/Dktuoi17');
        $nhankhau_id = Factory::getApplication()->input->getInt('nhankhau_id', 0);
        $result = $model->getThanNhan($nhankhau_id);
        try {
            echo json_encode(
                $result
            );
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
        jexit();
    }

    // lưu người đăng ký 
    public function save_dktuoi17()
    {
        Session::checkToken() or die('Token không hợp lệ');
        $user = Factory::getUser();

        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;

        $formData['gioitinh'] = $formData['select_gioitinh_id'] ?? $formData['input_gioitinh_id'];
        $formData['dantoc_id'] = $formData['select_dantoc_id'] ?? $formData['input_dantoc_id'];
        $formData['phuongxa_id'] = $formData['select_phuongxa_id'] ?? $formData['input_phuongxa_id'];
        $formData['thonto_id'] = $formData['select_thonto_id'] ?? $formData['input_thonto_id'];
        $namsinh = $formData['select_namsinh'] ?? $formData['input_namsinh'] ?? '';
        $formData['namsinh'] = !empty($namsinh) ? $this->formatDate($namsinh) : '';
        
        $formData['ngaydangky'] = $formData['form_ngaydangky'] ?? '';
        $formData['ngaydangky'] = !empty($formData['ngaydangky']) ? $this->formatDate($formData['ngaydangky']) : '';

        $thanNhanFormatted = [];

        $quanheList = $formData['thannhan_quanhe_id'] ?? [];
        $hotenList = $formData['thannhan_hoten'] ?? [];
        $namsinhList = $formData['thannhan_namsinh'] ?? [];
        $nghenghiepList = $formData['thannhan_nghenghiep'] ?? [];

        $max = max(count($quanheList), count($hotenList), count($namsinhList), count($nghenghiepList));

        for ($i = 0; $i < $max; $i++) {
            // bỏ qua nếu tất cả đều rỗng
            if (
                empty($hotenList[$i]) &&
                empty($namsinhList[$i]) &&
                empty($quanheList[$i]) &&
                empty($nghenghiepList[$i])
            ) {
                continue;
            }

            $thanNhanFormatted[] = [
                'quanhe_id'   => $quanheList[$i] ?? null,
                'hoten'       => $hotenList[$i] ?? null,
                'namsinh'     => $namsinhList[$i] ?? null,
                'nghenghiep'  => $nghenghiepList[$i] ?? null,
            ];
        }
        $formData['thannhan'] = $thanNhanFormatted;

        try {
            $model = Core::model('QuanSu/Dktuoi17');

            $result = $model->saveDktuoi17($formData, $user->id);
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

    // hàm format ngày từ dd/mm/yyyy sang yyyy-mm-dd
    function formatDate($dateString){
        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        if ($date === false || $date->format('d/m/Y') !== $dateString) {
            throw new Exception('Định dạng ngày tháng không hợp lệ cho năm sinh');
        }
        return $date->format('Y-m-d');
    }

    // xóa đăng ký tuổi 17
    public function xoa_dktuoi17()
    {
        $input = Factory::getApplication()->input;
        $formData = $input->post->getArray();
        $json = json_decode(file_get_contents('php://input'), true);
        $formData = $json ?? $formData;
        try {
            $model = Core::model('QuanSu/Dktuoi17');
            $result = $model->deleteDktuoi17($formData['idUser'], $formData['iddktuoi17']);
            $response = [
                'success' => $result,
                'message' => 'Xóa thành công',
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
                'hoten'    => $input->getString('hoten', ''),
                'cccd'    => $input->getString('cccd', ''),
                'gioitinh_id'    => $input->getString('gioitinh_id', ''),
                'tinhtrang_id'    => $input->getString('tinhtrang_id', ''),
            ];
            $modelBase = Core::model('QuanSu/Base');
            $model = Core::model('QuanSu/Dktuoi17');
            $phanquyen = $modelBase->getPhanquyen();
            $phuongxa = [];
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $modelBase->getPhuongXaById($phanquyen['phuongxa_id']);
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
            $sheet->setCellValue('J1', 'Thông tin thân nhân');
            $sheet->setCellValue('M1', 'Thông tin đăng ký');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:I1');
            $sheet->mergeCells('J1:L1'); // Thông tin cá nhân
            $sheet->mergeCells('M1:R1'); // Thông tin số nhà

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('B2', 'Họ tên');
            $sheet->setCellValue('C2', 'Ngày sinh');
            $sheet->setCellValue('D2', 'Giới tính');
            $sheet->setCellValue('E2', 'CCCD/CMND');
            $sheet->setCellValue('F2', 'Ngày cấp');
            $sheet->setCellValue('G2', 'Nơi cấp');
            $sheet->setCellValue('H2', 'Địa chỉ');
            $sheet->setCellValue('I2', 'Điện thoại');
            $sheet->setCellValue('J2', 'Họ tên cha/mẹ');
            $sheet->setCellValue('K2', 'Năm sinh');
            $sheet->setCellValue('L2', 'Nghề nghiệp');
            $sheet->setCellValue('M2', 'Tiền sử bệnh tật trong gia đình');
            $sheet->setCellValue('N2', 'Tiền sử bệnh tật của cá nhân');
            $sheet->setCellValue('O2', 'Chiều cao');
            $sheet->setCellValue('P2', 'Cân nặng');
            $sheet->setCellValue('Q2', 'Ngày đăng ký');
            $sheet->setCellValue('R2', 'Tình trạng');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:R2')->getFont()->setBold(true);
            $sheet->getStyle('A1:R2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:R2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(50);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(25);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(50);
            $sheet->getColumnDimension('M')->setWidth(40);
            $sheet->getColumnDimension('N')->setWidth(40);
            $sheet->getColumnDimension('O')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(15);
            $sheet->getColumnDimension('Q')->setWidth(15);
            $sheet->getColumnDimension('R')->setWidth(15);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $diachi = $item["n_diachi"] . ' - ' . $item["thonto"] . ' - ' . $item["phuongxa"];
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['n_hoten'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['namsinh'] ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['tengioitinh'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['n_cccd'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['cccd_ngaycap'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['cccd_coquancap'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $diachi ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['n_dienthoai'] ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['thannhan_ten'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $item['thannhan_namsinh'] ?? '');
                $sheet->setCellValue('L' . $rowIndex, $item['thannhan_nghenghiep'] ?? '');
                $sheet->setCellValue('M' . $rowIndex, $item['tiensubenhtat'] ?? '');
                $sheet->setCellValue('N' . $rowIndex, $item['macbenh'] ?? '');
                $sheet->setCellValue('O' . $rowIndex, $item['chieucao'] ?? '');
                $sheet->setCellValue('P' . $rowIndex, $item['cannang'] ?? '');
                $sheet->setCellValue('Q' . $rowIndex, $item['ngaydangky'] ?? '');
                $sheet->setCellValue('R' . $rowIndex, $item['tentrangthai'] ?? '');
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:R' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_DKTuoi17.xlsx"');
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
