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

  public function checkDiaChi()
  {
    $input = Factory::getApplication()->input;
    $diachi = trim($input->getString('diachi', ''));

    $model = Core::model('Dcxddt/Viahe');
    $phanquyen = $model->getPhanQuyen();

    try {
      // 👈 Gửi formData đã xử lý vào đây
      $idViahe = $model->checkDiaChi($diachi, $phanquyen['phuongxa_id']);

      if ($idViahe) {
        $response = ['success' => true, 'idViahe' => $idViahe];
      } else {
        $response = ['success' => false];
      }
    } catch (Exception $e) {
      $response = ['success' => false, 'message' => 'Lỗi khi lấy dữ liệu: ' . $e->getMessage()];
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

  protected function sendJsonResponse($data, $statusCode = 200)
  {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($statusCode);
    echo json_encode($data);
    Factory::getApplication()->close();
  }
}
