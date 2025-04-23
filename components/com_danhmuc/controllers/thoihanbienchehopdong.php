<?php 
	class DanhmucControllerThoihanbienchehopdong extends DanhmucController{
		public function luuthoihanbienchehopdong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Thoihanbienchehopdong');
			Core::printJson($model->luuthoihanbienchehopdong($form));exit;
		}
		public function delete_thoihanbienchehopdong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Thoihanbienchehopdong');
				Core::printJson($model->delete_thoihanbienchehopdong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function updatethoihanbienchehopdong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Thoihanbienchehopdong');
			Core::printJson($model->updatethoihanbienchehopdong($form));exit;
		}
		public function xoanhieu_thoihanbienchehopdong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->get('id',array(),'array');
			if(count($id>0)){
				$model = Core::model('Danhmuchethong/Thoihanbienchehopdong');
				Core::printJson($model->xoanhieu_thoihanbienchehopdong($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>