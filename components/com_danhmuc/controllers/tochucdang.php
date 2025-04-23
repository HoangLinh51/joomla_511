<?php 
	class DanhmucControllerTochucdang extends DanhmucController{
		public function addtochucdang(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdang');
			$kq = $model->addtochucdang($form);
			Core::printJson($kq);exit;
		}
		public function deletetochucdang(){
			$jinput = JFactory::getApplication()->input;
			$tochucdang_id = $jinput->getString('id','');
			$model = Core::model('Danhmuchethong/Tochucdang');
			$kq = $model->deletetochucdang($tochucdang_id);
			Core::printJson($kq);exit;
		}
		public function updatetochucdang(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdang');
			$kq = $model->updatetochucdang($form);
			Core::printJson($kq);exit;
		}
		public function deletealltochucdang(){
			$jinput = JFactory::getApplication()->input;
			$tochucdang_id = $jinput->getInt('id',0);
			// var_dump($tochucdang_id);die;
			$model = Core::model('Danhmuchethong/Tochucdang');
			$kq = $model->deletealltochucdang($tochucdang_id);
			Core::printJson($kq);exit;
		}
	}
?>