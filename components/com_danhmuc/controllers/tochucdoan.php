<?php 
	class DanhmucControllerTochucdoan extends DanhmucController{
		public function addtochucdoan(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdoan');
			$kq = $model->addtochucdoan($form);
			Core::printJson($kq);exit;
		}
		public function deletetochucdoan(){
			$jinput = JFactory::getApplication()->input;
			$tochucdoan_id = $jinput->getString('id','');
			$model = Core::model('Danhmuchethong/Tochucdoan');
			$kq = $model->deletetochucdoan($tochucdoan_id);
			Core::printJson($kq);exit;
		}
		public function updatetochucdoan(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdoan');
			$kq = $model->updatetochucdoan($form);
			Core::printJson($kq);exit;
		}
		public function deletealltochucdoan(){
			$jinput = JFactory::getApplication()->input;
			$tochucdoan_id = $jinput->getInt('id',0);
			// var_dump($tochucdoan_id);die;
			$model = Core::model('Danhmuchethong/Tochucdoan');
			$kq = $model->deletealltochucdoan($tochucdoan_id);
			Core::printJson($kq);exit;
		}
	}
?>