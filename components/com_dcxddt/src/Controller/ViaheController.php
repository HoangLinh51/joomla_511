<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_dcxddtmt
 *
 * @copyright   (C) 2025 Your Company Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Dcxddt\Site\Controller;

use Core;
use DateTime;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

defined('_JEXEC') or die;

/**
 * The Viahe Controller
 *
 * @since  5.0
 */
class ViaheController extends BaseController
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

  public function getListViaHe()
  {
    $input = Factory::getApplication()->input;
    $formData = $input->post->getArray();
    $json = json_decode(file_get_contents('php://input'), true);
    $formData = $json ?? $formData;

    $model = Core::model('Dcxddt/Viahe');
    $phanquyen = $model->getPhanquyen();
    $phuongxa = array();

    if ($phanquyen['phuongxa_id'] != '') {
      $phuongxa = $model->getPhuongXaById($phanquyen['phuongxa_id']);
    }

    try {
      $result =  $model->getDanhSachViaHe($formData, $phuongxa);
    } catch (Exception $e) {
      $result = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($result);
    jexit();
  }

  public function save_viahe()
  {
    Session::checkToken() or $this->sendJsonResponse(['success' => false, 'message' => 'Token không hợp lệ'], 403);

    $input = Factory::getApplication()->input;
    $formData = $input->post->getArray();
    $json = json_decode(file_get_contents('php://input'), true);
    $formData = $json ?? $formData;
    // 👉 Group giấy phép lại
    $giayphep = [];

    if (isset($formData['sogiayphep']) && is_array($formData['sogiayphep'])) {
      foreach ($formData['sogiayphep'] as $i => $soGP) {
        $key = trim($soGP);
        if (!$key) continue;

        if (!isset($giayphep[$key])) {
          $giayphep[$key] = [];
        }

        $giayphep[$key][] = [
          'id_hopdong' => $formData['id_hopdong'][$i] ?? '',
          'sogiayphep' => $key,
          'solan' => $formData['solan'][$i] ?? '',
          'ngayKyStr' => $formData['ngayKyStr'][$i] ?? '',
          'ngayHetHanStr' => $formData['ngayHetHanStr'][$i] ?? '',
          'thoigian' => $formData['thoigian'][$i] ?? '',
          'sotien' => $formData['sotien'][$i] ?? '',
          'ghichu' => $formData['ghichu'][$i] ?? '',
        ];
      }

      // Xoá các key cũ đã gom
      unset(
        $formData['id_hopdong'],
        $formData['sogiayphep'],
        $formData['solan'],
        $formData['ngayKyStr'],
        $formData['ngayHetHanStr'],
        $formData['thoigian'],
        $formData['sotien'],
        $formData['ghichu']
      );

      // Gán lại mảng giayphep đã gom
      $formData['giayphep'] = $giayphep;
    }

    $model = Core::model('Dcxddt/Viahe');
    $phanquyen = $model->getPhanQuyen();

    try {
      // 👈 Gửi formData đã xử lý vào đây
      $thongtinviahe_id = $model->saveThongtinViahe($formData, $phanquyen['phuongxa_id']);

      if ($thongtinviahe_id) {
        $response = ['success' => true, 'message' => 'Đã cập nhật dữ liệu thành công', 'thongtinviahe_id' => $thongtinviahe_id];
      } else {
        $response = ['success' => false, 'message' => 'Lưu thông tin vỉa hè thất bại'];
      }
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()];
    }

    $this->sendJsonResponse($response);
  }

  public function save_logo()
  {
    Session::checkToken() or $this->sendJsonResponse(['success' => false, 'message' => 'Token không hợp lệ'], 403);

    $input = Factory::getApplication()->input;
    $formData = $input->post->getArray();
    $json = json_decode(file_get_contents('php://input'), true);
    $formData = $json ?? $formData;

    $model = Core::model('Dcxddt/Viahe');

    try {
      // 👈 Gửi formData đã xử lý vào đây
      $thongtinviahe_id = $model->saveLogo($formData);

      if ($thongtinviahe_id) {
        $response = ['success' => true, 'message' => 'Đã cập nhật dữ liệu thành công', 'thongtinviahe_id' => $thongtinviahe_id];
      } else {
        $response = ['success' => false, 'message' => 'Lưu thông tin vỉa hè thất bại'];
      }
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()];
    }

    $this->sendJsonResponse($response);
  }

  function formatDate($dateString)
  {
    $date = DateTime::createFromFormat('d/m/Y', $dateString);
    if ($date === false || $date->format('d/m/Y') !== $dateString) {
      throw new Exception('Định dạng ngày tháng không hợp lệ cho năm sinh');
    }
    return $date->format('Y-m-d');
  }

  public function xoa_tepdinhkem()
  {
    $app = Factory::getApplication();
    $body = json_decode(file_get_contents('php://input'), true);

    $fileId = (int)($body['filedinhkem_id'] ?? 0);
    $viaheId = (int)($body['viahe_id'] ?? 0);

    if (!$viaheId || !$fileId) {
      echo json_encode(['success' => false, 'message' => 'Thiếu thông tin đầu vào']);
      return;
    }

    $model = Core::model('Dcxddt/Viahe');
    try {
      $result = $model->xoatepdinhkem($viaheId, $fileId);
      $response = ['success' => (bool)$result, 'message' => $result ? 'Xóa thành công' : 'Không thể xóa'];
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()];
    }

    echo json_encode($response);
    $app->close();
  }

  public function xoa_hopdong()
  {
    $app = Factory::getApplication();
    $body = json_decode(file_get_contents('php://input'), true);

    $idhopdong = (int)($body['idhopdong'] ?? 0);

    if (!$idhopdong) {
      echo json_encode(['success' => false, 'message' => 'Thiếu thông tin đầu vào']);
      return;
    }

    $model = Core::model('Dcxddt/Viahe');
    try {
      $result = $model->xoaHopDong($idhopdong);
      $response = ['success' => (bool)$result, 'message' => $result ? 'Xóa thành công' : 'Không thể xóa'];
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()];
    }

    echo json_encode($response);
    $app->close();
  }

  public function xoa_viahe()
  {
    $app = Factory::getApplication();
    $body = json_decode(file_get_contents('php://input'), true);

    $idviahe = (int)($body['idviahe'] ?? 0);

    if (!$idviahe) {
      echo json_encode(['success' => false, 'message' => 'Thiếu thông tin đầu vào']);
      return;
    }

    $model = Core::model('Dcxddt/Viahe');
    try {
      $result = $model->xoaViahe($idviahe);
      $response = ['success' => (bool)$result, 'message' => $result ? 'Xóa thành công' : 'Không thể xóa'];
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()];
    }

    echo json_encode($response);
    $app->close();
  }

  protected function sendJsonResponse($data, $statusCode = 200)
  {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($statusCode);
    echo json_encode($data);
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
        'diachi' => $input->getString('diachi', ''),
      ];
      $model = Core::model('Dcxddt/Viahe');
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
        'Họ tên',
        'Điện thoại',
        'Địa chỉ vỉa hè',
        'Diện tích sử dụng',
        'Chiều dài',
        'Chiều rộng',
        'Mục đích sử dụng',
        'Số giấy phép',
        'Ngày bắt đầu',
        'Ngày kết thúc',
      ];
      $sheet->fromArray($headers, null, 'A1');

      // Bôi đậm tiêu đề
      $sheet->getStyle('A1:K1')->getFont()->setBold(true);
      $sheet->getRowDimension(1)->setRowHeight(30);

      // Tăng chiều rộng cột
      $columnWidths = [
        'A' => 10,  // STT
        'B' => 25,  // Họ tên
        'C' => 15,  // Điện thoại
        'D' => 40,  // Địa chỉ
        'E' => 15,  // Diện tích sử dụng
        'F' => 10,  // Chiều dài
        'G' => 10,  // Chiều rộng
        'H' => 30,  // Mục đích
        'I' => 20,  // Số giấy phép
        'J' => 15,  // Ngày bắt đầu
        'K' => 15,  // Ngày kết thúc
      ];
      foreach ($columnWidths as $column => $width) {
        $sheet->getColumnDimension($column)->setWidth($width);
      }
      $sheet->getStyle('S')->getNumberFormat()->setFormatCode('0');

      // Thêm dữ liệu
      $rowData = [];
      foreach ($rows as $index => $item) {
        $sogiayphep = $item['sogiayphep'] . '( Gia hạn lần ' . $item['solan'] . ')' ;
        $rowData[] = [
          $index + 1,                     //STT
          $item['hoten'] ?? '',           //Họ tên
          $item['dienthoai'] ?? '',       //Điện thoại
          $item['diachi'] ?? '',          //Địa chỉ
          $item['dientichtamthoi'] ?? '', //Diện tích sử dụng
          $item['chieudai'] ?? '',        //Chiều dài
          $item['chieurong'] ?? '',       //Chiều rộng
          $item['mucdichsudung'] ?? '',   //Mục đích
          $sogiayphep ?? '',              //Số giấy phép
          $item['ngayky'] ?? '',          //Ngày bắt đầu
          $item['ngayhethan'] ?? '',      //Ngày kết thúc
        ];
      }
      $sheet->fromArray($rowData, null, 'A2');

      // Bật wrapText cho cột Số hộ khẩu (cột B)
      $lastRow = count($rowData) + 1; // Tính dòng cuối cùng
      $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setWrapText(true);

      // Căn lề giữa cho cột STT (cột A)
      $sheet->getStyle('A1:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      // Thêm đường viền cho tất cả các ô (A1:G$lastRow)
      $sheet->getStyle('A1:K' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

      // Xuất file
      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="DanhSach_Viahe.xlsx"');
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
