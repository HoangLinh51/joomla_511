<?php 
	class DanhmucControllerBienchetochuc extends DanhmucController{
		public function exportexcel_donvi(){
	        $jinput = JFactory::getApplication()->input;
	        $loaihinh_id = $jinput->getString('loaihinh_id','');
			$model= Core::model('Danhmuckieubao/Bienchetochuc');
			$kq = $model->xuat_excel($loaihinh_id);
			Core::printJson($kq);die;
		}
		public function importbctc(){
			// JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
	        $form = $jinput->get('frm',array(),'array');
	        $data_file = $jinput->files->get('data_file');
	        // var_dump($data_file);die;	
			$model= Core::model('Danhmuckieubao/Bienchetochuc');
			$kq = $model->importdatafromexcel($form);
			$kq = array_unique($kq);
			// var_dump($kq);die;
			$app = JFactory::getApplication();
			$link = 'http://localhost:8080/index.php?option=com_danhmuc&view=bienchetochuc&task=bienchetochuc_import';
			$url = JRoute::_($link);			
			if(count($kq)==1){
				$message = 'Xử lý thành công';
				$app->redirect($url,$message,'success');
			}
			else{
				$message = implode('.', $kq);				
				$app->redirect($url,$message,'error');
			}			
		}
		public function importbctc_main(){
			$jinput = JFactory::getApplication()->input;
			$date = $jinput->getString('date','');
			$model = Core::model('Danhmuckieubao/Bienchetochuc');
			$kq = $model->importbctc_main($date);
			Core::printJson($kq);exit;
		}
		public function deleteimportbctc(){
			$jinput = JFactory::getApplication()->input;
			$ngaytao = $jinput->getString('ngaytao','');
			$model = Core::model('Danhmuckieubao/Bienchetochuc');
			$kq = $model->deleteimportbctc($ngaytao);
			$kq1 = $model->deleteimportbctc_fk($ngaytao);
			if($kq==true&&$kq1==true){
				Core::printJson($kq);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function insertimportbctc(){
			$jinput = JFactory::getApplication()->input;
			$ds_biencheimport = $jinput->get('ds_biencheimport',array(),'array');
			$model = Core::model('Danhmuckieubao/Bienchetochuc');
			$kq = $model->insertimportbctc($ds_biencheimport);
			Core::printJson($kq);exit;
		}
	}
?>