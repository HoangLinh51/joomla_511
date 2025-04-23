<?php 
	class DanhmucControllerTinhchat extends DanhmucController{
		public function save_tinhchat(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tinhchat');
			if($form['id']==''){
				Core::printJson($model->add_tinhchat($form));exit;
			}
			Core::printJson($model->update_tinhchat($form));exit;
		}
		public function delete_tinhchat(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Tinhchat');
			if($id>0){
				Core::printJson($model->delete_tinhchat($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_tinhchat(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Tinhchat');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_tinhchat($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>