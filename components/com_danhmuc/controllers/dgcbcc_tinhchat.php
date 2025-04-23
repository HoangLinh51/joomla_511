<?php 
	class DanhmucControllerDgcbcc_tinhchat extends DanhmucController{
		public function save_dgcbcc_tinhchat(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_tinhchat');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_tinhchat($form));exit;
			}
			Core::printJson($model->update_dgcbcc_tinhchat($form));exit;
		}
		public function delete_dgcbcc_tinhchat(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_tinhchat');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_tinhchat($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_tinhchat(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_tinhchat');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_tinhchat($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>