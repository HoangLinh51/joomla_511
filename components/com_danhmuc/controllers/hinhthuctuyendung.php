<?php 
	class DanhmucControllerHinhthuctuyendung extends DanhmucController{
		public function luuhinhthuctuyendung(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthuctuyendung');
			Core::printJson($model->luuhinhthuctuyendung($form));exit;
		}
		public function delete_hinhthuctuyendung(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Hinhthuctuyendung');
				Core::printJson($model->delete_hinhthuctuyendung($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function updatehinhthuctuyendung(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthuctuyendung');
			Core::printJson($model->updatehinhthuctuyendung($form));exit;
		}
		public function xoanhieu_hinhthuctuyendung(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->get('id',array(),'array');
			if(count($id>0)){
				$model = Core::model('Danhmuchethong/Hinhthuctuyendung');
				Core::printJson($model->xoanhieu_hinhthuctuyendung($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>