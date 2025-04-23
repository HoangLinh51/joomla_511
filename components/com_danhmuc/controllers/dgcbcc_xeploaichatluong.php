<?php 
	class DanhmucControllerDgcbcc_xeploaichatluong extends DanhmucController{
		public function save_dgcbcc_xeploaichatluong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaichatluong');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_xeploaichatluong($form));exit;
			}
			Core::printJson($model->update_dgcbcc_xeploaichatluong($form));exit;
		}
		public function delete_dgcbcc_xeploaichatluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaichatluong');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_xeploaichatluong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_xeploaichatluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaichatluong');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_xeploaichatluong($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>