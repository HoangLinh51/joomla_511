<?php 
	class DanhmucControllerLinhvucbaocao extends DanhmucController{
		public function themmoilinhvucbaocao(){
			JSession::checkToken() or die('Invalid Token');
			$user = JFactory::getUser();
			$user_id = $user->id;
			$today = date('Y-m-d H:i:s');
			$jinput = JFactory::getApplication()->input;
			$form  = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuc/Linhvucbaocao');
			Core::printJson($model->addLinhvucbaocao($form,$user_id,$today));exit;
		}
		public function updatelinhvucbaocao(){
			JSession::checkToken() or die('Invalid Token');
			$user = JFactory::getUser();
			$user_id = $user->id;
			$today = date('Y-m-d H:i:s');
			$jinput = JFactory::getApplication()->input;
			$form  = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuc/Linhvucbaocao');
			Core::printJson($model->updatelinhvucbaocao($form,$user_id,$today));exit;
		}
		public function xoalinhvucbaocao(){
			$jinput = JFactory::getApplication()->input;
			$id  = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuc/Linhvucbaocao');
				Core::printJson($model->xoalinhvucbaocao($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>