<?php 
	class DanhmucControllerHangdonvisunghiep extends DanhmucController{
		public function addhdvsn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hangdonvisunghiep');
			$kq = $model->addhdvsn($form);
			Core::printJson($kq);exit;
		}
		public function deletehdvsn(){
			$jinput = JFactory::getApplication()->input;
			$hdvsn_id = $jinput->getString('id','');
			$model = Core::model('Danhmuchethong/Hangdonvisunghiep');
			$kq = $model->deletehdvsn($hdvsn_id);
			Core::printJson($kq);exit;
		}
		public function updatehdvsn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hangdonvisunghiep');
			$kq = $model->updatehdvsn($form);
			Core::printJson($kq);exit;
		}
		public function deleteallhdvsn(){
			$jinput = JFactory::getApplication()->input;
			$hdvsn_id = $jinput->get('id',array(),'array');
			$model = Core::model('Danhmuchethong/Hangdonvisunghiep');
			$kq = $model->deleteallhdvsn($hdvsn_id);
			Core::printJson($kq);exit;
		}
	}
?>