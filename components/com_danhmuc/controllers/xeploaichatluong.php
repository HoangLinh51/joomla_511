<?php 
	class DanhmucControllerXeploaichatluong extends DanhmucController{
		public function save_xeploaichatluong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Xeploaichatluong');
			if($form['id']==''){
				Core::printJson($model->add_xeploaichatluong($form));exit;
			}
			Core::printJson($model->update_xeploaichatluong($form));exit;
		}
		public function delete_xeploaichatluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Xeploaichatluong');
			if($id>0){
				Core::printJson($model->delete_xeploaichatluong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_xeploaichatluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Xeploaichatluong');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_xeploaichatluong($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>