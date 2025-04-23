<?php 
	class DanhmucControllerHinhthucphanhangdonvi extends DanhmucController{
		public function addhtphdv(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
			$kq = $model->addhtphdv($form);
			Core::printJson($kq);exit;
		}
		public function deletehtphdv(){
			$jinput = JFactory::getApplication()->input;
			$htphdv_id = $jinput->getString('id','');
			$model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
			$kq = $model->deletehtphdv($htphdv_id);
			Core::printJson($kq);exit;
		}
		public function updatehtphdv(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
			$kq = $model->updatehtphdv($form);
			Core::printJson($kq);exit;
		}
		public function deleteallhtphdv(){
			$jinput = JFactory::getApplication()->input;
			$htphdv_id = $jinput->get('id',array(),'array');
			$model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
			$kq = $model->deleteallhtphdv($htphdv_id);
			Core::printJson($kq);exit;
		}
	}
?>