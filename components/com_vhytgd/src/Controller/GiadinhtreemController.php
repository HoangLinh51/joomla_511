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
class GiadinhtreemController extends BaseController
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

        $model = Core::model('Vhytgd/Giadinhtreem');

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
    public function getThanNhan()
    {
        $model = Core::model('Vhytgd/Giadinhtreem');
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
    function saveGiadinhtreem()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Giadinhtreem');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveGiadinhtreem($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=giadinhtreem&task=default");
    }
    public function saveBaoLuc()
    {
        Session::checkToken() or die('Invalid Token');
        $app = Factory::getApplication();
        $input = $app->input;
        $formData = $input->getArray($_POST);

        $model = Core::model('Vhytgd/Giadinhtreem');
        try {
            $baoluc_id = $model->saveBaoLuc($formData);
            $response = [
                'success' => true,
                'baoluc_id' => $baoluc_id,
                'message' => 'Đã lưu dữ liệu thành công!'
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        }

        $app->close();
    }
    public function getBaoLucList()
    {
        Session::checkToken() or die('Invalid Token');
        $app = Factory::getApplication();
        $input = $app->input;
        $giadinh_id = $input->getInt('giadinh_id', 0);

        $model = Core::model('Vhytgd/Giadinhtreem');
        try {
            $baolucList = $model->getBaoLucList($giadinh_id);
            $response = [
                'success' => true,
                'data' => $baolucList
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        }

        $app->close();
    }
    public function delThongtingiadinh()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhtreem');
        $app = Factory::getApplication();
        $nhanthan_id = $app->input->getInt('nhanthan_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$nhanthan_id > 0) {
            if ($model->delThongtingiadinh($nhanthan_id)) {
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
    public function delThongtinBaoluc()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhtreem');
        $app = Factory::getApplication();
        $baoluc_id = $app->input->getInt('baoluc_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$baoluc_id > 0) {
            if ($model->delThongtinBaoluc($baoluc_id)) {
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
    public function removeGDTE()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhtreem');
        $app = Factory::getApplication();
        $id = $app->input->getInt('giadinh_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeGDTE($id)) {
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

    public function getThannhanBaoluc()
    {
        $model = Core::model('Vhytgd/Giadinhtreem');
        $nhankhau_id = Factory::getApplication()->input->getInt('nhankhau_id', 0);
        $result = $model->getThannhanBaoluc($nhankhau_id);
        try {
            echo json_encode(
                $result
            );
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
        jexit();
    }
    public function getTreEmList()
    {
        Session::checkToken() or die('Invalid Token');
        $app = Factory::getApplication();
        $input = $app->input;
        $giadinh_id = $input->getInt('giadinh_id', 0);

        $model = Core::model('Vhytgd/Giadinhtreem');
        try {
            $baolucList = $model->getTreEmList($giadinh_id);
            $response = [
                'success' => true,
                'data' => $baolucList
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        }

        $app->close();
    }

    public function saveTreEm()
    {
        Session::checkToken() or die('Invalid Token');
        $app = Factory::getApplication();
        $input = $app->input;
        $formData = $input->getArray($_POST);

        $model = Core::model('Vhytgd/Giadinhtreem');
        try {
            $baoluc_id = $model->saveTreEm($formData);
            $response = [
                'success' => true,
                'baoluc_id' => $baoluc_id,
                'message' => 'Đã lưu dữ liệu thành công!'
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            $app->setHeader('Content-Type', 'application/json');
            echo json_encode($response);
        }

        $app->close();
    }
    public function delThongtinTreem()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Giadinhtreem');
        $app = Factory::getApplication();
        $hotrotreem_id = $app->input->getInt('hotrotreem_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$hotrotreem_id > 0) {
            if ($model->delThongtinTreem($hotrotreem_id)) {
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
    public function checkTreem()
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

        $model = Core::model('Vhytgd/Giadinhtreem');

        try {
            $exists = $model->checkTreem($nhankhau_id, 'qs_danquan');
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

    public function exportExcelBaoLuc()
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
                'mahogiadinh'    => $input->getString('mahogiadinh', ''),
            ];
            $model = Core::model('Vhytgd/Giadinhtreem');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = [];
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }

            $rows = $model->getDanhSachBaoLucXuatExcel($filters, $phuongxa);

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
            $sheet->setCellValue('B1', 'Mã hộ gia đình');
            $sheet->setCellValue('C1', 'Mã vụ việc');
            $sheet->setCellValue('D1', 'Người gây bạo lực');
            $sheet->setCellValue('G1', 'Nạn nhân');
            $sheet->setCellValue('J1', 'Hình thức xử lý');
            $sheet->setCellValue('K1', 'Hình thức hỗ  trợ');
            $sheet->setCellValue('L1', 'Cơ quan xử lý');
            $sheet->setCellValue('M1', 'Ngày xử lý');
            $sheet->setCellValue('N1', 'Tình trạng');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:C2');
            $sheet->mergeCells('D1:F1');
            $sheet->mergeCells('G1:I1');
            $sheet->mergeCells('J1:J2');
            $sheet->mergeCells('K1:K2');
            $sheet->mergeCells('L1:L2');
            $sheet->mergeCells('M1:M2');
            $sheet->mergeCells('N1:N2');

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('C2', '');
            $sheet->setCellValue('D2', 'Họ và tên');
            $sheet->setCellValue('E2', 'Giới tính');
            $sheet->setCellValue('F2', 'Ngày sinh');
            $sheet->setCellValue('G2', 'Họ và tên');
            $sheet->setCellValue('H2', 'Giới tính');
            $sheet->setCellValue('I2', 'Ngày sinh');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:N2')->getFont()->setBold(true);
            $sheet->getStyle('A1:N2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:N2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(40);
            $sheet->getColumnDimension('K')->setWidth(40);
            $sheet->getColumnDimension('L')->setWidth(25);
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $tinhtrang = '';
                if ($item['tinhtrang'] == 0) {
                    $tinhtrang = 'Chưa xử lý';
                } else  if ($item['tinhtrang'] == 1) {
                    $tinhtrang = 'Đã xử lý';
                } else if ($item['tinhtrang'] == 2) {
                    $tinhtrang = 'Đang xử lý';
                }
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['makh'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['mavuviec']  ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['nguoibaoluc_ten'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['nguoibaoluc_gioitinh'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['nguoibaoluc_ngaysinh'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['nannhan_ten'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['nannhan_gioitinh'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['nannhan_ngaysinh'] ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['tenxuly'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $item['tenhotro'] ?? '');
                $sheet->setCellValue('L' . $rowIndex, $item['coquanxuly'] ?? '');
                $sheet->setCellValue('M' . $rowIndex, $item['ngayxuly'] ?? '');
                $sheet->setCellValue('N' . $rowIndex, $tinhtrang);
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:N' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_GiaDinhBaoLuc.xlsx"');
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

    public function exportExcelTreem()
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
                'mahogiadinh'    => $input->getString('mahogiadinh', ''),
            ];
            $model = Core::model('Vhytgd/Giadinhtreem');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = [];
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }

            $rows = $model->getDanhSachTreEmXuatExcel($filters, $phuongxa);

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
            $sheet->setCellValue('B1', 'Mã hộ gia đình');
            $sheet->setCellValue('C1', 'Thông tin trẻ em');
            $sheet->setCellValue('F1', 'Tình trạng học tập');
            $sheet->setCellValue('G1', 'Tình trạng sức khỏe');
            $sheet->setCellValue('H1', 'Nhóm hoàn cảnh');
            $sheet->setCellValue('I1', 'Trợ giúp');
            $sheet->setCellValue('J1', 'Nội dung trợ giúp');
            $sheet->setCellValue('K1', 'tình trạng');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:E1');
            $sheet->mergeCells('F1:F2');
            $sheet->mergeCells('G1:G2');
            $sheet->mergeCells('H1:H2');
            $sheet->mergeCells('I1:I2');
            $sheet->mergeCells('J1:J2');
            $sheet->mergeCells('K1:K2');

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('C2', 'Họ và tên');
            $sheet->setCellValue('D2', 'Giới tính');
            $sheet->setCellValue('E2', 'Ngày sinh');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:K2')->getFont()->setBold(true);
            $sheet->getStyle('A1:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:K2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(45);
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(15);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $tinhtrang = '';
                if ($item['tinhtrang'] == 1) {
                    $tinhtrang = 'Đã hỗ trợ';
                } else  if ($item['tinhtrang'] == 1) {
                    $tinhtrang = 'Chưa hỗ trợ';
                } 
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['makh'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['treem_ten']  ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['treem_gioitinh'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['treem_ngaysinh'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['tinhtranghoctap'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['tinhtrangsuckhoe'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['tennhom'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['tenhotro'] ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['noidunghotro'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $tinhtrang);
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:K' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_GiaDinhTreEm.xlsx"');
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
