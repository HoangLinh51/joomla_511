<?php 
	class DanhmucControllerLoaidoituong extends DanhmucController{
		public function luuloaidoituong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Loaidoituong');
			Core::printJson($model->luuloaidoituong($form));exit;
		}
		public function delete_loaidoituong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Loaidoituong');
				Core::printJson($model->delete_loaidoituong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function updateloaidoituong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Loaidoituong');
			Core::printJson($model->updateloaidoituong($form));exit;
		}
		public function xoanhieu_loaidoituong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->get('id',array(),'array');
			if(count($id>0)){
				$model = Core::model('Danhmuchethong/Loaidoituong');
				Core::printJson($model->xoanhieu_loaidoituong($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>