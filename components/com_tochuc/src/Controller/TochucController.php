<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:26:02                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:40:28                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/Controller/TochucsController.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Tochuc\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

// phpcs:disable PSR1.Files.SideEffects
// \defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * The Tags List Controller
 *
 * @since  3.1
 */
class TochucController extends BaseController
{
    /**
     * Method to search tags with AJAX
     *
     * @return  void
     */
	function __construct($config = array()) {
		parent::__construct ( $config );
		$user = & Factory::getUser ();
    	if ($user->id == null) {
			if (Factory::getApplication()->input->getVar('format') == 'raw') {
				echo '<script> window.location.href="index.php?option=com_users&view=login"; </script>';
				exit;
			}else{
				$this->setRedirect ( "index.php?option=com_users&view=login" );
			}
		}
	}

    protected $default_view = 'tochuc';
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
	 *
	 * @return  static  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = array())
    {
        return parent::display($cachable, $urlparams);
    }

	public function generateMaxCodeTochuc(){
		
		$app = Factory::getApplication()->input;
		$model = Core::model('Tochuc/Tochuc');
		$codeCha = $model->getThongtin('max(code) as code', 'ins_dept', null, 'active =1 and type=1 and concat("",code * 1) = code', null);
		if ($codeCha[0]->code<30000) 
			$default = 30000;
		else $default = 1 + $codeCha[0]->code;
		Core::PrintJson($default);
	}
	public function generateCodeTochucNew(){
		$app = Factory::getApplication()->input;
		$model = Core::model('Tochuc/Tochuc');
		$post = $app->get('post');
		$donvi_id = $post['node_id'];
		$newCode = $model->generateCodeTochucNew($donvi_id, '');
		Core::PrintJson($newCode);
	}

	public function upload()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $file = $input->files->get('file', array(), 'array');

        // Define upload path
        $uploadDir = JPATH_SITE . '/uploader/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Handle file upload
        if ($file['error'] == 0) {
            $targetPath = $uploadDir . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                echo json_encode(['success' => true, 'file' => $file['name']]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No file uploaded or error occurred.']);
        }

        // Prevent Joomla from rendering the rest of the page
        $app->close();
    }

	public function savethanhlap()
	{
		

		Session::checkToken() or die('Invalid Token');
		$user = Factory::getUser();
		if (!Core::_checkPerAction($user->id, 'com_tochuc', 'tochuc', 'thanhlap')) {
			Factory::getApplication()->enqueueMessage('Bạn không có quyền truy cập', 'error');
			$this->setRedirect("index.php");
			return;
		}
		$model = Core::model('Tochuc/Tochuc');
		$app = Factory::getApplication();
        $input = $app->input;
        $formData = $input->post->getArray();

		try {
			$id = $model->saveDept($formData);

			// Save to cchc_tochuc if new record and config allows
			if ((int)$formData['id'] <= 0 && Core::config('cchc/autocchc') == 1) {
				$modelCchc = Core::model('Danhmuccchc/Tochuc');
				$modelCchc->savetochucCchc($id, $formData);
				$modelCchc->rebuild();
			}

			// 	Xử lý xóa, lưu quyết định liên quan
			$model->xoaIns_dept_vanban($id);
			for($i= 0; $i< count($formData['ins_vanban_id']); $i++){
				$ins_vanban_id = $formData['ins_vanban_id'][$i];
				if($ins_vanban_id>0) $model->luuIns_dept_vanban($id, $ins_vanban_id);
			}
			// 	Hết xử lý quyết định liên quan
		} catch (Exception $e) {
			Factory::getApplication()->enqueueMessage($e->__toString(), 'error');
		}

		// Redirect based on action name
		switch ($formData['action_name']) {
			case 'SAVEANDCLOSE':
				$this->setRedirect("index.php?option=com_tochuc&controller=tochuc&task=default");
				break;
			case 'SAVEANDCONTINUE':
				$this->setRedirect("index.php?option=com_tochuc&task=thanhlap&Itemid=&id=" . $id);
				break;
			default:
				$this->setRedirect("index.php?option=com_tochuc&controller=tochuc&task=thanhlap&type=" . $formData['type'] . "&parent_id=" . $formData['parent_id']);
				break;
		}

		// 	// Handle related decisions
		// 	$model->xoaIns_dept_vanban($id);
		// 	foreach ($formData['ins_vanban_id'] as $ins_vanban_id) {
		// 		if ((int)$ins_vanban_id > 0) {
		// 			$model->luuIns_dept_vanban($id, $ins_vanban_id);
		// 		}
		// 	}

		// 	// Update report configuration
		// 	// if ($id > 0) {
		// 	// 	foreach ($formData['report_group_code'] as $report_group_code) {
		// 	// 		$data_config = [
		// 	// 			'report_group_code' => $report_group_code,
		// 	// 			'ins_dept' => $id,
		// 	// 			'name' => $formData['name'],
		// 	// 			'type' => $formData['type'],
		// 	// 			'ins_loaihinh' => $model->getLoaihinhByIdCap((int)$formData['ins_cap']),
		// 	// 		];

		// 	// 		$data_caybaocao = $model->getIdConfigBc((int)$formData['parent_id'], $data_config['report_group_code']);
		// 	// 		if ((int)$data_caybaocao['id'] > 0) {
		// 	// 			$check_data_caybaocao = $model->getIdConfigBc($id, $data_config['report_group_code']);
		// 	// 			$data_config['id'] = (int)$check_data_caybaocao['id'] > 0 ? (int)$check_data_caybaocao['id'] : $data_caybaocao['id'];
		// 	// 			$data_config['parent_id'] = $data_config['id'] > 0 ? $check_data_caybaocao['parent_id'] : $data_caybaocao['id'];
		// 	// 			$data_config['report_group_name'] = $data_caybaocao['report_group_name'];
		// 	// 			$data_config['all_chirl'] = 0;

		// 	// 			$model_config = AdminModel::getInstance('Caybaocao', 'BaocaohosoModel');
		// 	// 			$model_config->save($data_config);
		// 	// 		}
		// 	// 	}
		// 	// }

		// 	// Save lĩnh vực
		// 	$model->saveLinhvuc($id, $formData['ins_linhvuc']);

		// 	// Handle created document
		// 	$vanban_created = $formData['vanban_created'];
		// 	if (strlen($vanban_created['mahieu']) > 0) {
		// 		$vanban_created['tieude'] = 'QĐ ' . TochucHelper::getNameById($formData['type_created'], 'ins_dept_cachthuc') . ', Ngày ' . $formData['date_created'];
		// 		$vanban_id = $model->saveVanban($vanban_created);

		// 		$mapperAttachment = Core::model('Core/Attachment');
		// 		foreach ($formData["idFile-tochuc-attachment"] as $attachment_id) {
		// 			$mapperAttachment->updateTypeIdByCode($attachment_id, 1, true, $vanban_id);
		// 		}

		// 		$dataUpdate = ['vanban_created' => $vanban_id, 'id' => $id];
		// 		Core::update('ins_dept', $dataUpdate, 'id');
		// 	}

		// 	// Handle new record
		// 	if ((int)$formData['id'] == 0) {
		// 		$model->saveQuatrinh([
		// 			'quyetdinh_so' => $formData['number_created'],
		// 			'quyetdinh_ngay' => $formData['date_created'] ?? date('d/m/Y'),
		// 			'ghichu' => $formData['ghichu'],
		// 			'chitiet' => TochucHelper::getNameById($formData['type_created'], 'ins_dept_cachthuc') . ' ' . $formData['name'],
		// 			'name' => $formData['name_created'],
		// 			'hieuluc_ngay' => $formData['date_created'] ?? date('d/m/Y'),
		// 			'dept_id' => $id,
		// 			'cachthuc_id' => $formData['type_created'],
		// 			'ordering' => 1,
		// 			'vanban_id' => $vanban_id,
		// 		]);
		// 		$message = 'Thêm mới thành công';
		// 	}

		// 	// Handle status update
		// 	if ((int)$formData['active'] != 1) {
		// 		$formTrangThai = $formData['trangthai'];
		// 		$formTrangThai['tieude'] = 'QĐ ' . TochucHelper::getNameById($formData['active'], 'ins_status') . ', Ngày ' . $formTrangThai['quyetdinh_ngay'];
		// 		$trangthai_vanban_id = $model->saveVanban($formTrangThai);

		// 		$mapperAttachment = Core::model('Core/Attachment');
		// 		foreach ($formData["idFile-trangthai-attachment"] as $attachment_id) {
		// 			$mapperAttachment->updateTypeIdByCode($attachment_id, 1, true, $trangthai_vanban_id);
		// 		}

		// 		Core::update('ins_dept', ['vanban_active' => $trangthai_vanban_id, 'id' => $id], 'id');

		// 		if ((int)$formData['id'] == 0) {
		// 			$model->saveQuatrinh([
		// 				'quyetdinh_so' => $formTrangThai['quyetdinh_so'],
		// 				'quyetdinh_ngay' => $formTrangThai['quyetdinh_ngay'] ?? date('d/m/Y'),
		// 				'chitiet' => TochucHelper::getNameById($formData['active'], 'ins_status') . ' ' . $formData['name'],
		// 				'name' => $formData['name'],
		// 				'hieuluc_ngay' => $formTrangThai['quyetdinh_ngay'] ?? date('d/m/Y'),
		// 				'dept_id' => $id,
		// 				'cachthuc_id' => $formData['active'],
		// 				'ordering' => 99,
		// 				'vanban_id' => $trangthai_vanban_id,
		// 			]);
		// 		}
		// 	}

		// 	Factory::getApplication()->enqueueMessage($message);
		// } catch (Exception $e) {
		// 	Factory::getApplication()->enqueueMessage($e->__toString(), 'error');
		// }

		// // Redirect based on action name
		// switch ($formData['action_name']) {
		// 	case 'SAVEANDCLOSE':
		// 		$this->setRedirect("index.php?option=com_tochuc&controller=tochuc&task=default");
		// 		break;
		// 	case 'SAVEANDCONTINUE':
		// 		$this->setRedirect("index.php?option=com_tochuc&task=thanhlap&Itemid=&id=" . $id);
		// 		break;
		// 	default:
		// 		$this->setRedirect("index.php?option=com_tochuc&controller=tochuc&task=thanhlap&type=" . $formData['type'] . "&parent_id=" . $formData['parent_id']);
		// 		break;
		// }
	}

    
}
