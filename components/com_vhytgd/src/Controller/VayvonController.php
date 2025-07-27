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
class VayvonController extends BaseController
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
   
    function saveVayvon()
    {
        Session::checkToken() or die('Invalid Token');
        $user = Factory::getUser();



        $model = Core::model('Vhytgd/Vayvon');
        $input = Factory::getApplication()->input;
        $formData = $input->getArray($_POST);
        try {
            if (!$model->saveVayvon($formData)) {
                Factory::getApplication()->enqueueMessage('Lưu dữ liệu không thành công.', 'error');
                return;
            }
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $session = Factory::getSession();
        $session->set('message_bootbox', 'Đã cập nhật dữ liệu thành công!');
        $this->setRedirect("index.php/component/vhytgd/?view=vayvon&task=default");
    }
    public function delThongtinvayvon()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Vayvon');
        $app = Factory::getApplication();
        $trocap_id = $app->input->getInt('trocap_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$trocap_id > 0) {
            if ($model->delThongtinvayvon($trocap_id)) {
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

    public function removeVayVon()
    {
        // $user = Factory::getUser();
        $model = Core::model('Vhytgd/Vayvon');
        $app = Factory::getApplication();
        $id = $app->input->getInt('chinhsach_id', 0);

        $response = [
            'success' => false,
            'message' => 'Không thể xóa hoạt động'
        ];

        if ((int)$id > 0) {
            if ($model->removeVayVon($id)) {
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
   
  
     public function checkVayVon()
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

        $model = Core::model('Vhytgd/Vayvon');

        try {
            $exists = $model->checkVayVon($nhankhau_id, 'qs_danquan');
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
        // Tăng giới hạn bộ nhớ
        ini_set('memory_limit', '1024M');

        // Kiểm tra CSRF token
        if (!Session::checkToken('get')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Token không hợp lệ']);
            jexit();
        }

        // Kiểm tra người dùng
        $user = Factory::getUser();
        if (!$user->id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            jexit();
        }

        // Xóa bộ đệm đầu ra
        while (ob_get_level()) {
            ob_end_clean();
        }

        try {
            $input = Factory::getApplication()->input;
            $filters = [
                'hoten' => $input->getString('hoten', ''),
                'makhachhang' => $input->getString('makhachhang', ''),
                'phuongxa_id' => $input->getString('phuongxa_id', ''),
                'thonto_id' => $input->getString('thonto_id', ''),
            ];
            $model = Core::model('Vhytgd/Vayvon');
            $phanquyen = $model->getPhanquyen();
            $phuongxa = array();
            if ($phanquyen['phuongxa_id'] != '') {
                $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
            }

            $rows = $model->getDanhSachXuatExcel($filters, $phuongxa);

            // Kiểm tra dữ liệu
            if (empty($rows)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không có dữ liệu để xuất']);
                jexit();
            }


            // Tải PhpSpreadsheet qua Composer
            $autoloadPath = JPATH_ROOT . '/vendor/autoload.php';
            if (!file_exists($autoloadPath)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'File autoload.php không được tìm thấy']);
                jexit();
            }
            require_once $autoloadPath;

            // Tạo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headers = [
                'STT',
                'Mã khách hàng',
                'Tên Khách hàng',
                'Ngày sinh',
                'Điện thoại',
                'CCCD/CMND',
                'Ngày cấp',
                'Nơi cấp',
                'Địa chỉ',
                'Số món vay',
                'Ngày giải ngân',
                'Ngày đến hạn',
                'Chương trình vay',
                'Tên tổ trưởng',
                'Đoàn/hội',
                'Nguồn vốn',
                'Lãi xuất',
                'Giải ngân',
                'Tổng dư nợ',
            ];
            $sheet->fromArray($headers, null, 'A1');

            // Bôi đậm tiêu đề
            $sheet->getStyle('A1:S1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);

            // Tăng chiều rộng cột
            $columnWidths = [
                'A' => 10,  // STT
                'B' => 15,  // Mã khách hàng
                'C' => 25,  // Tên Khách hàng
                'D' => 15,  // Ngày sinh
                'E' => 15,  // Điện thoại
                'F' => 15,  // CCCD/CMND
                'G' => 15,  // Ngày cấp
                'H' => 20,  // Nơi cấp
                'I' => 50,  // Địa chỉ
                'J' => 15,  // Số món vay
                'K' => 15,  // Ngày giải ngân
                'L' => 15,  // Ngày đến hạn
                'M' => 40,  // Chương trình vay
                'N' => 20,  // Tên tổ trưởng
                'O' => 20,  // Đoàn/hội 
                'P' => 20,  // Nguồn vốn
                'Q' => 15,  // Lãi xuất
                'R' => 15,  // Giải ngân
                'S' => 15,  // Tổng dư nợ
            ];
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }
            $sheet->getStyle('S')->getNumberFormat()->setFormatCode('0');

            // Thêm dữ liệu
            $rowData = [];
            foreach ($rows as $index => $item) {
                $diachi = $item['n_diachi'] . ' - ' . $item['thonto'] . ' - ' . $item['phuongxa'];
                $rowData[] = [
                    $index + 1,
                    $item['makh'] ?? '',
                    $item['n_hoten'] ?? '',
                    $item['namsinh'] ?? '',
                    $item['n_dienthoai'] ?? '',
                    $item['n_cccd'] ?? '',
                    $item['cccd_ngaycap'] ?? '',
                    $item['cccd_coquancap'] ?? '',
                    $diachi ?? '',
                    $item['somonvay'] ?? '',
                    $item['ngaygiaingan'] ?? '',
                    $item['ngaydenhan'] ?? '',
                    $item['tenchuongtrinhvay'] ?? '',
                    $item['nguoitochuc'] ?? '',
                    $item['tendoanhoi'] ?? '',
                    $item['tennguonvon'] ?? '',
                    $item['laisuatvay'] ?? '',
                    $item['tiengiaingan'] ?? '',
                    $item['tongduno'] ?? '',
                ];
            }
            $sheet->fromArray($rowData, null, 'A2');

            // Bật wrapText cho cột Số hộ khẩu (cột B)
            $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
            $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

            // Căn lề giữa cho cột STT (cột A)
            $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
            $sheet->getStyle('A1:S' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Xuất file
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DanhSach_VayVon.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Pragma: public');

            $writer->save('php://output');
            jexit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xuất Excel: ' . $e->getMessage()]);
            jexit();
        }
    }
}
