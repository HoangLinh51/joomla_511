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
   
}
