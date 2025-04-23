<?php 
	class DanhmucControllerTochucdoanthekhac extends DanhmucController{
		public function addtochucdoanthekhac(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdoanthekhac');
			$kq = $model->addtochucdoanthekhac($form);
			Core::printJson($kq);exit;
		}
		public function deletetochucdoanthekhac(){
			$jinput = JFactory::getApplication()->input;
			$tochucdoanthekhac_id = $jinput->getString('id','');
			$model = Core::model('Danhmuchethong/Tochucdoanthekhac');
			$kq = $model->deletetochucdoanthekhac($tochucdoanthekhac_id);
			Core::printJson($kq);exit;
		}
		public function updatetochucdoanthekhac(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tochucdoanthekhac');
			$kq = $model->updatetochucdoanthekhac($form);
			Core::printJson($kq);exit;
		}
		public function deletealltochucdoanthekhac(){
			$jinput = JFactory::getApplication()->input;
			$tochucdoanthekhac_id = $jinput->getInt('id',0);
			// var_dump($tochucdoanthekhac_id);die;
			$model = Core::model('Danhmuchethong/Tochucdoanthekhac');
			$kq = $model->deletealltochucdoanthekhac($tochucdoanthekhac_id);
			Core::printJson($kq);exit;
		}
	}
?>