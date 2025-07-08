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

        $model = Core::model('Vhytgd/Doituonghuongcs');

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
}
