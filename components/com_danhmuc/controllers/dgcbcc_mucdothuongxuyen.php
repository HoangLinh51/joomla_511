<?php 
	class DanhmucControllerDgcbcc_mucdothuongxuyen extends DanhmucController{
		public function save_dgcbcc_mucdothuongxuyen(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_mucdothuongxuyen');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_mucdothuongxuyen($form));exit;
			}
			Core::printJson($model->update_dgcbcc_mucdothuongxuyen($form));exit;
		}
		public function delete_dgcbcc_mucdothuongxuyen(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_mucdothuongxuyen');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_mucdothuongxuyen($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_mucdothuongxuyen(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_mucdothuongxuyen');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_mucdothuongxuyen($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>