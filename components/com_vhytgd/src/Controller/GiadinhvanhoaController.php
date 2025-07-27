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
                'nam'    => $input->getString('nam', ''),
            ];
            $model = Core::model('Vhytgd/Giadinhvanhoa');
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
            $sheet->setCellValue('B1', 'Thôn tổ');
            $sheet->setCellValue('C1', 'Thông tin cá nhân');
            $sheet->setCellValue('J1', 'Thông tin danh hiệu');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:I1'); // Thông tin cá nhân
            $sheet->mergeCells('J1:M1'); // Thông tin số nhà

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('C2', 'Họ và tên');
            $sheet->setCellValue('D2', 'Ngày sinh');
            $sheet->setCellValue('E2', 'Giới tính');
            $sheet->setCellValue('F2', 'CCCD/CMND');
            $sheet->setCellValue('G2', 'Ngày cấp');
            $sheet->setCellValue('H2', 'Nơi cấp');
            $sheet->setCellValue('I2', 'Điện thoại');
            $sheet->setCellValue('J2', 'Năm');
            $sheet->setCellValue('K2', 'Đạt/Không');
            $sheet->setCellValue('L2', 'Gia đình văn hóa tiêu biểu');
            $sheet->setCellValue('M2', 'Lý do Không đạt');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:M2')->getFont()->setBold(true);
            $sheet->getStyle('A1:M2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:M2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(30);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(25);
            $sheet->getColumnDimension('M')->setWidth(40);

            // ======= Ghi dữ liệu bắt đầu từ dòng 3 =========
            $rowIndex = 3;
            foreach ($rows as $i => $item) {
                $isDat = 'Không xác định';
                if($item['is_dat'] == 1){
                    $isDat = 'Đạt';
                } else if($item['is_dat'] == 0){
                    $isDat = 'Không đạt';
                }
                $giadinhvanhoatieubieu = '';
                if ($item['is_giadinhvanhoatieubieu'] == 1) {
                    $giadinhvanhoatieubieu = 'Đạt';
                } else if ($item['is_giadinhvanhoatieubieu'] == 0) {
                    $giadinhvanhoatieubieu = 'Không đạt';
                }
                $sheet->setCellValue('A' . $rowIndex, $i + 1);
                $sheet->setCellValue('B' . $rowIndex, $item['thonto'] ?? '');
                $sheet->setCellValue('C' . $rowIndex, $item['n_hoten']  ?? '');
                $sheet->setCellValue('D' . $rowIndex, $item['namsinh'] ?? '');
                $sheet->setCellValue('E' . $rowIndex, $item['tengioitinh'] ?? '');
                $sheet->setCellValue('F' . $rowIndex, $item['n_cccd'] ?? '');
                $sheet->setCellValue('G' . $rowIndex, $item['cccd_ngaycap'] ?? '');
                $sheet->setCellValue('H' . $rowIndex, $item['cccd_coquancap'] ?? '');
                $sheet->setCellValue('I' . $rowIndex, $item['n_dienthoai'] ?? '');
                $sheet->setCellValue('J' . $rowIndex, $item['nam'] ?? '');
                $sheet->setCellValue('K' . $rowIndex, $isDat);
                $sheet->setCellValue('L' . $rowIndex, $giadinhvanhoatieubieu);
                $sheet->setCellValue('M' . $rowIndex, $item['lydokhongdat'] ?? '');
                $rowIndex++;
            }

            // ======= Thêm border cho toàn bộ bảng =========
            $lastRow = $rowIndex - 1;
            $sheet->getStyle('A1:M' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Căn giữa STT
            $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // ======= Xuất file =========
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Danhsach_GiaDinhVanHoa.xlsx"');
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
