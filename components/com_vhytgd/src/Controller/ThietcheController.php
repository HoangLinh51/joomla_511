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
class ThietcheController extends BaseController
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
    function saveThongTinThietChe()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Thietche');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveThongTinThietChe($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=thongtinthietche&task=default");
    }
    public function removeHoatDongThietChe()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Thietche');
        $app = Factory::getApplication();
        $hoatdong_id = $app->input->getInt('hoatdong_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$hoatdong_id > 0) {
            if ($model->removeHoatDongThietChe($hoatdong_id)) {
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
    public function removeThongTinThietBi()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Thietche');
        $app = Factory::getApplication();
        $id = $app->input->getInt('id_thietbi', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeThongTinThietBi($id)) {
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
    public function removeThongTinThietChe()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Thietche');
        $app = Factory::getApplication();
        $id = $app->input->getInt('id_thietche', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeThongTinThietChe($id)) {
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
  public function exportExcel()
{
    ini_set('memory_limit', '1024M');

    if (!Session::checkToken('get')) {
        $this->outputJsonError('Token không hợp lệ');
    }

    $user = Factory::getUser();
    if (!$user->id) {
        $this->outputJsonError('Bạn cần đăng nhập');
    }

    while (ob_get_level()) {
        ob_end_clean();
    }

    try {
        $model = Core::model('Vhytgd/Thietche');
        $input = Factory::getApplication()->input;
        $filters = [
            'phuongxa_id' => $input->getString('phuongxa_id', ''),
            'tenthietche' => $input->getString('tenthietche', ''),
            'tinhtrang_id' => $input->getString('tinhtrang_id', ''),
            'loaihinhthietche_id' => $input->getString('loaihinhthietche_id', ''),
            'daxoa' => 0
        ];

        $rows = $model->getThongTinThietCheExcel($filters);

        if (empty($rows)) {
            $this->outputJsonError('Không có dữ liệu để xuất');
        }

        require_once JPATH_ROOT . '/vendor/autoload.php';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Định dạng tiêu đề
        $headersRow1 = [
            'STT', 'Thông tin trung tâm thiết chế', '', '', '', '', 'Thông tin thiết bị', 'Thông tin hoạt động'
        ];
        $headersRow2 = [
            '', 'Tên thiết chế', 'Vị trí', 'Loại hình thiết chế', 'Diện tích', 'Tình trạng',
            '', ''
        ];

        $sheet->fromArray($headersRow1, null, 'A1');
        $sheet->fromArray($headersRow2, null, 'A2');
        $sheet->mergeCells('B1:F1'); // Merge cột B-F cho tiêu đề "Thông tin trung tâm thiết chế"
        $sheet->mergeCells('A1:A2'); // Merge cột STT
        $sheet->mergeCells('G1:G2'); // Merge cột STT
        $sheet->mergeCells('H1:H2'); // Merge cột HTTH
        $sheet->getStyle('A1:H2')->getFont()->setBold(true); // Bôi đậm tiêu đề (lưu ý: chỉ đến cột I)
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Đặt chiều rộng cột
        $columnWidths = [
            'A' => 10,  // STT
            'B' => 15,  // Tên thiết chế
            'C' => 20,  // Vị trí
            'D' => 25,  // Loại hình thiết chế
            'E' => 15,  // Diện tích
            'F' => 15,  // Tình trạng
            'G' => 50,  // Thông tin thiết bị (tăng chiều rộng để chứa chuỗi dài)
            'H' => 50   // Thông tin hoạt động (tăng chiều rộng để chứa chuỗi dài)
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Thêm dữ liệu
        $rowData = [];
        $rowIndex = 3;
        foreach ($rows as $index => $item) {
            $rowData[] = [
                $index + 1, // A: STT
                $item['thietche_ten'] ?? '', // B: Tên thiết chế
                $item['thietche_vitri'] ?? '', // C: Vị trí
                $item['tenloaihinhthietche'] ?? '', // D: Loại hình thiết chế
                $item['thietche_dientich'] ?? '', // E: Diện tích
                ($item['trangthaihoatdong_id'] == 1) ? 'Đang xây dựng' : (($item['trangthaihoatdong_id'] == 2) ? 'Đang sửa chữa' : (($item['trangthaihoatdong_id'] == 3) ? 'Đang sử dụng' : '')), // F: Tình trạng
                $item['thongtinthietbi'] ?? '', // G: Thông tin thiết bị (chuỗi)
                $item['hoatdong'] ?? '' // I: Thông tin hoạt động (chuỗi)
            ];
        }

        $sheet->fromArray($rowData, null, 'A3');

        // Bật wrapText và căn lề
        $lastRow = count($rowData) + 2;
        $sheet->getStyle('B3:B' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('G3:G' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('H3:H' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

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
