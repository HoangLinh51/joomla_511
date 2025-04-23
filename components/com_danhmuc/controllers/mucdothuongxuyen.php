<?php 
	class DanhmucControllerMucdothuongxuyen extends DanhmucController{
		public function save_mucdothuongxuyen(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Mucdothuongxuyen');
			if($form['id']==''){
				Core::printJson($model->add_mucdothuongxuyen($form));exit;
			}
			Core::printJson($model->update_mucdothuongxuyen($form));exit;
		}
		public function delete_mucdothuongxuyen(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Mucdothuongxuyen');
			if($id>0){
				Core::printJson($model->delete_mucdothuongxuyen($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_mucdothuongxuyen(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Mucdothuongxuyen');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_mucdothuongxuyen($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>