<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_thongbao
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Dcxddt\Site\Controller;

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
class BiensonhaController extends BaseController
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
    function saveBiensonha()
    {
        // Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();


        $model = Core::model('Dcxddt/Biensonha');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        var_dump($formData);
        try {
            if (!$model->saveBiensonha($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        // $this->setRedirect("index.php/component/dcxddt/?view=biensonha&task=default");
    }
    public function delSonha()
    {
        // $user = Factory::getUser();
        $model = Core::model('Dcxddt/Biensonha');
        $app = Factory::getApplication();
        $sonha_id = $app->input->getInt('sonha_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$sonha_id > 0) {
            if ($model->delSonha($sonha_id)) {
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
     
      public function removeBienSoNha()
    {
        // $user = Factory::getUser();
        $model = Core::model('Dcxddt/Biensonha');
        $app = Factory::getApplication();
        $id = $app->input->getInt('sonha_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeBienSoNha($id)) {
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
    public function checkBienSoNha()
    {

        $input = Factory::getApplication()->input;
        $thonto_id = $input->getInt('thonto_id', 0);
        $tuyenduong = $input->getInt('tuyenduong', 0);

        if (!$thonto_id || !$tuyenduong) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Thiếu thonto_id hoặc tuyền đường'
            ));
            jexit();
        }

        $model = Core::model('Dcxddt/Biensonha');
        $result = $model->checkBienSoNha($thonto_id, $tuyenduong);

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
            $sheet->setCellValue('B1', 'Tên đường');
            $sheet->setCellValue('C1', 'Thông tin cá nhân');
            $sheet->setCellValue('E1', 'Thông tin số nhà');

            // Gộp ô hàng 1
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:D1'); // Thông tin cá nhân
            $sheet->mergeCells('E1:I1'); // Thông tin số nhà

            // Hàng 2 (chỉ các cột con)
            $sheet->setCellValue('C2', 'Họ và tên');
            $sheet->setCellValue('D2', 'Điện thoại');
            $sheet->setCellValue('E2', 'Số nhà');
            $sheet->setCellValue('F2', 'Tờ bản đồ');
            $sheet->setCellValue('G2', 'Thửa đất');
            $sheet->setCellValue('H2', 'Hình thức cấp');
            $sheet->setCellValue('I2', 'Lý do thay đổi');

            // ======= Định dạng header =========
            $sheet->getStyle('A1:I2')->getFont()->setBold(true);
            $sheet->getStyle('A1:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:I2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);

            // ======= Set width cột =========
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(30);

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
