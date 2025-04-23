<?php 
	class DanhmucControllerBonhiemdieudong extends DanhmucController{
		public function addbonhiemdieudong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Bonhiemdieudong');
			$kq = $model->addbonhiemdieudong($form);
			Core::printJson($kq);exit;
		}
		public function xoa_bonhiemdieudong(){
			$jinput = JFactory::getApplication()->input;
			$bonhiemdieudong_id = $jinput->getInt('id',0);
			if($bonhiemdieudong_id>0){
				$model = Core::model('Danhmuchethong/Bonhiemdieudong');
				$kq = $model->xoa_bonhiemdieudong($bonhiemdieudong_id);
				Core::printJson($kq);exit;
			}
			Core::printJson(false);exit;
		}
		public function updatebonhiemdieudong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Bonhiemdieudong');
			$kq = $model->updatebonhiemdieudong($form);
			Core::printJson($kq);exit;
		}
		public function xoanhieubonhiemdieudong(){
			$jinput = JFactory::getApplication()->input;
			$bonhiemdieudong_id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Bonhiemdieudong');
			$kq = $model->xoanhieubonhiemdieudong($bonhiemdieudong_id);
			Core::printJson($kq);exit;
		}
	}
?>