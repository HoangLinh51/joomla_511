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
class NguoicocongController extends BaseController
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
        $model = Core::model('Vhytgd/Nguoicocong');
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

        $model = Core::model('Vhytgd/Nguoicocong');

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
    public function loadDoiTuongHuong()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $hinh_thuc = $input->getInt('hinh_thuc', 0);
        $model = Core::model('Vhytgd/Nguoicocong');

        try {
            $result = $model->loadDoiTuongHuong($hinh_thuc);
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
     public function loadDMTyle()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $tyle_id = $input->getInt('tyle_id', 0);
        $model = Core::model('Vhytgd/Nguoicocong');

        try {
            $result = $model->loadDMtyle($tyle_id);
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
       public function loadDMdungcu()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $uudai_id = $input->getInt('uudai_id', 0);
        $model = Core::model('Vhytgd/Nguoicocong');

        try {
            $result = $model->loadDMdungcu($uudai_id);
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
    function saveNguoicocong()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Nguoicocong');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        // var_dump($formData);exit;
        try {
            if (!$model->saveNguoicocong($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=nguoicocong&task=default");
    }
    public function delThongtinhuongcs()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Nguoicocong');
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

    public function removeNguoiCoCong()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Nguoicocong');
        $app = Factory::getApplication();
        $id = $app->input->getInt('chinhsach_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeNguoiCoCong($id)) {
                $response['success'] = true;
                $response['message'] = 'Xóa dữ liệu thành công';
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
        $model = Core::model('Vhytgd/Nguoicocong');
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
        $model = Core::model('Vhytgd/Nguoicocong');

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
            ];
            $model = Core::model('Vhytgd/Nguoicocong');
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
            $sheet->setCellValue('S1', 'Thông tin ưu đãi');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:I1');
            $sheet->mergeCells('J1:L1');
            $sheet->mergeCells('M1:R1');
            $sheet->mergeCells('S1:X1');

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
            $sheet->setCellValue('M2', 'Hình thức hưởng');
            $sheet->setCellValue('N2', 'Loại đối tượng');
            $sheet->setCellValue('O2', 'Trợ cấp');
            $sheet->setCellValue('P2', 'Phụ cấp');
            $sheet->setCellValue('Q2', 'Ngày hưởng');
            $sheet->setCellValue('R2', 'Tình trạng');
            $sheet->setCellValue('S2', 'Loại ưu đãi');
            $sheet->setCellValue('T2', 'Nội dung ưu đãi');
            $sheet->setCellValue('U2', 'Ngày ưu đãi');
            $sheet->setCellValue('V2', 'Tên dụng cụ');
            $sheet->setCellValue('W2', 'Niên hạn');
            $sheet->setCellValue('X2', 'Trợ cấp');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:X2')->getFont()->setBold(true);
            $sheet->getStyle('A1:X2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:X2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(7);
            $sheet->getColumnDimension('B')->setWidth(25); //Họ và tên
            $sheet->getColumnDimension('C')->setWidth(15); //Ngày sinh
            $sheet->getColumnDimension('D')->setWidth(15); //CCCD/CMND
            $sheet->getColumnDimension('E')->setWidth(15); //Ngày cấp
            $sheet->getColumnDimension('F')->setWidth(30); //Nơi cấp
            $sheet->getColumnDimension('G')->setWidth(13); //Giới tính
            $sheet->getColumnDimension('H')->setWidth(15); //Điện thoại
            $sheet->getColumnDimension('I')->setWidth(45); //Địa chỉ
            $sheet->getColumnDimension('J')->setWidth(25); //Tên người nhận
            $sheet->getColumnDimension('K')->setWidth(20); //Số tài khoản
            $sheet->getColumnDimension('L')->setWidth(30); //Ngân hàng
            $sheet->getColumnDimension('M')->setWidth(25); //Hình thức hưởng
            $sheet->getColumnDimension('N')->setWidth(30); //Loại đối tượng
            $sheet->getColumnDimension('O')->setWidth(20); //Trợ cấp
            $sheet->getColumnDimension('P')->setWidth(20); //Phụ cấp
            $sheet->getColumnDimension('Q')->setWidth(15); //Ngày hưởng
            $sheet->getColumnDimension('R')->setWidth(15); //Tình trạng
            $sheet->getColumnDimension('S')->setWidth(60); //Loại ưu đãi
            $sheet->getColumnDimension('T')->setWidth(30); //Nội dung ưu đãi
            $sheet->getColumnDimension('U')->setWidth(25); //Ngày ưu đãi
            $sheet->getColumnDimension('V')->setWidth(20); //Tên dụng cụ
            $sheet->getColumnDimension('W')->setWidth(15); //Niên hạn
            $sheet->getColumnDimension('X')->setWidth(20); //Trợ cấp

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $diachi = $item['n_diachi'] . ' - ' . $item['thonto'] . ' - ' . $item['phuongxa'];
                $hinhthuchuong = 'Không xác định';
                if($item['is_hinhthuc'] == 1 ){
                    $hinhthuchuong= 'Hàng tháng';
                } else  if($item['is_hinhthuc'] == 2){
                    $hinhthuchuong = 'Một lần';
                }
                // var_dump($item['tinhtrang']);
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['n_hoten'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['ngaysinh'] ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['n_cccd'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['cccd_ngaycap'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['cccd_coquancap'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['tengioitinh'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['n_dienthoai'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $diachi ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['tennguoinhan'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $item['sotaikhoan'] ?? '');
                $sheet->setCellValue('L' . $rowIndex, $item['nganhang'] ?? '');
                $sheet->setCellValue('M' . $rowIndex, $hinhthuchuong);
                $sheet->setCellValue('N' . $rowIndex, $item['loaidoituong'] ?? '');
                $sheet->setCellValue('O' . $rowIndex, $item['trocap'] ?? '');
                $sheet->setCellValue('P' . $rowIndex, $item['phucap'] ?? '');
                $sheet->setCellValue('Q' . $rowIndex, $item['ngayhuong'] ?? '');
                $sheet->setCellValue('R' . $rowIndex, $item['tinhtranghuong'] ?? '');
                $sheet->setCellValue('S' . $rowIndex, $item['loaiuudai'] ?? '');
                $sheet->setCellValue('T' . $rowIndex, $item['noidunguudai'] ?? '');
                $sheet->setCellValue('U' . $rowIndex, $item['ngayuudai'] ?? '');
                $sheet->setCellValue('V' . $rowIndex, $item['tendungcu'] ?? '');
                $sheet->setCellValue('W' . $rowIndex, $item['nienhan'] ?? '');
                $sheet->setCellValue('X' . $rowIndex, $item['muccap'] ?? '');
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:X' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_NguoiCoCong.xlsx"');
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
