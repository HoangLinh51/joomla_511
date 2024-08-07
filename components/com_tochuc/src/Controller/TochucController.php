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
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Session\Session;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;
use stdClass;

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
		echo "<pre>";
		var_dump($formData);exit;
		try {
			$id = $model->saveDept($formData);
			// nếu là tổ chức hoặc như phòng, thì set con của nó theo trạng thái ẩn luôn
			if($formData['type'] == 1 || $formData['type'] == 3){
				if($formData['active']==0 || $formData['active']==2)
				$f = new stdClass();
				$f->parent_id = $id;
				$f->active = $formData['active'];
				Core::update('ins_dept',$f,'parent_id');
			}
			// Save to cchc_tochuc if new record and config allows
			if ((int)$formData['id'] <= 0 && Core::config('cchc/autocchc') == 1) {
				$modelCchc = Core::model('Danhmuccchc/Tochuc');
				$modelCchc->savetochucCchc($id, $formData);
				$modelCchc->rebuild();
			}

			// 	Xử lý xóa, lưu quyết định liên quan
			$model->xoaIns_dept_vanban($id);
			if (isset($formData['ins_vanban_id']) && is_array($formData['ins_vanban_id']) && count($formData['ins_vanban_id']) > 0) {
				for($i= 0; $i< count($formData['ins_vanban_id']); $i++){
					$ins_vanban_id = $formData['ins_vanban_id'][$i];
					if($ins_vanban_id>0) $model->luuIns_dept_vanban($id, $ins_vanban_id);
				}
			}
			// 	Hết xử lý quyết định liên quan

			// Update report configuration
			if ($id > 0) {
				foreach ($formData['report_group_code'] as $report_group_code) {
					$data_config = [
						'report_group_code' => $report_group_code,
						'ins_dept' => $id,
						'name' => $formData['name'],
						'type' => $formData['type'],
						'ins_loaihinh' => $model->getLoaihinhByIdCap((int)$formData['ins_cap']),
					];

					$data_caybaocao = $model->getIdConfigBc((int)$formData['parent_id'], $data_config['report_group_code']);
					if ((int)$data_caybaocao['id'] > 0) {
						$check_data_caybaocao = $model->getIdConfigBc($id, $data_config['report_group_code']);
						$data_config['id'] = (int)$check_data_caybaocao['id'] > 0 ? (int)$check_data_caybaocao['id'] : $data_caybaocao['id'];
						$data_config['parent_id'] = $data_config['id'] > 0 ? $check_data_caybaocao['parent_id'] : $data_caybaocao['id'];
						$data_config['report_group_name'] = $data_caybaocao['report_group_name'];
						$data_config['all_chirl'] = 0;

						$model_config = AdminModel::getInstance('Caybaocao', 'BaocaohosoModel');
						$model_config->save($data_config);
					}
				}
			}
			$dataLinhvuc = explode(',', $formData['ins_linhvuc']);
			$model->saveLinhvuc($id,$dataLinhvuc);

			$vanban_created = $formData['vanban_created'];
			if (strlen($vanban_created['mahieu']) > 0 ) {
				$vanban_created['tieude'] = 'QĐ '.TochucHelper::getNameById($formData['type_created'], 'ins_dept_cachthuc').' ,Ngày '.$formData['date_created'];
				$vanban_id = $model->saveVanban(array(
						'id'=>$vanban_created['id'],
						'mahieu'=>$vanban_created['mahieu'],
						'tieude'=>$vanban_created['tieude'],
						'ngaybanhanh'=>$vanban_created['ngaybanhanh'],
						'coquan_banhanh_id'=>$vanban_created['coquan_banhanh_id'],
						'coquan_banhanh'=>$vanban_created['coquan_banhanh']
				));
	    		$mapperAttachment = Core::model('Core/Attachment');
				for ($i = 0,$n=count($formData["idFile-tochuc-attachment"]); $i < $n; $i ++) {
					$mapperAttachment->updateTypeIdByCode($formData["idFile-tochuc-attachment"][$i],1,true,$vanban_id);
				}
				$dataUpdate = array('vanban_created'=>$vanban_id,'id'=>$id);
				Core::update('ins_dept', $dataUpdate, 'id');				
			}

			if ((int)$formData['id'] == 0) {
				// them moi
				$model->saveQuatrinh(array(
						'quyetdinh_so'=>$formData['number_created'],
						'quyetdinh_ngay'=>($formData['date_created']==null?date('d/m/Y'):$formData['date_created']),
						'ghichu'=>$formData['ghichu'],
						'chitiet'=>TochucHelper::getNameById($formData['type_created'], 'ins_dept_cachthuc').' '.$formData['name'],
						'name'=>$formData['name_created'],
						'hieuluc_ngay'=>($formData['date_created']==null?date('d/m/Y'):$formData['date_created']),
						'dept_id'=>$id,
						'cachthuc_id'=>$formData['type_created'],
						'ordering'=>1,
						'vanban_id'=>$vanban_id
				));
				$message = 'Thêm mới thành công';
			}

			// Edit 
			if ((int)$formData['active'] != 1) {
				$trangthai_file = $formData['trangthai_fileupload_id'];
				$formTrangThai = $formData['trangthai'];
				$formTrangThai['tieude'] = 'QĐ '.TochucHelper::getNameById($formData['active'], 'ins_status').' ,Ngày '.$formTrangThai['quyetdinh_ngay'];
				$trangthai_vanban_id = $model->saveVanban(array(
					'id'=>$formTrangThai['id'],
					'mahieu'=>$formTrangThai['mahieu'],
					'tieude'=>$formTrangThai['tieude'],
					'ngaybanhanh'=>$formTrangThai['ngaybanhanh'],
					'coquan_banhanh_id'=>$formTrangThai['coquan_banhanh_id'],
					'coquan_banhanh'=>$formTrangThai['coquan_banhanh']
				));
				$mapperAttachment = Core::model('Core/Attachment');
				for ($i = 0,$n=count($formData["idFile-trangthai-attachment"]); $i < $n; $i ++) {
					$mapperAttachment->updateTypeIdByCode($formData["idFile-trangthai-attachment"][$i],1,true,$trangthai_vanban_id);
				}
				Core::update('ins_dept', array('vanban_active'=>$trangthai_vanban_id,'id'=>$id), 'id');
				if ((int)$formData['id'] == 0) {			
					$model->saveQuatrinh(array(
							'quyetdinh_so'=>$formTrangThai['quyetdinh_so'],
							'quyetdinh_ngay'=>($formTrangThai['quyetdinh_ngay']==null?date('d/m/Y'):$formTrangThai['quyetdinh_ngay']),
							'chitiet'=>TochucHelper::getNameById($formData['active'], 'ins_status').' '.$formData['name'],
							'name'=>$formData['name'],
							'hieuluc_ngay'=>($formTrangThai['quyetdinh_ngay']==null?date('d/m/Y'):$formTrangThai['quyetdinh_ngay']),
							'dept_id'=>$id,
							'cachthuc_id'=>$formData['active'],
							'ordering'=>99,
							'vanban_id'=>$trangthai_vanban_id
					));
				}
			}
			Factory::getApplication()->enqueueMessage($message);
		} catch (Exception $e) {
			Factory::getApplication()->enqueueMessage($e->__toString(), 'error');
		}
		// Redirect based on action name
		switch ($formData['action_name']) {
			case 'SAVEANDCLOSE':
				$this->setRedirect("index.php?option=com_tochuc&view=tochuc&task=default");
				break;
			case 'SAVEANDCONTINUE':
				$this->setRedirect("index.php?option=com_tochuc&task=thanhlap&Itemid=&id=" . $id);
				break;
			default:
				$this->setRedirect("index.php?option=com_tochuc&view=tochuc&task=thanhlap&type=" . $formData['type'] . "&parent_id=" . $formData['parent_id']);
				break;
		}

	}

    
}
