<?php 
	class DanhmucControllerMucdothamgia extends DanhmucController{
		public function luu_mucdothamgia(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Mucdothamgia');
			if($form['id']==''){
				Core::printJson($model->add_mucdothamgia($form));exit;
			}
			else{
				Core::printJson($model->update_mucdothamgia($form));exit;
			}
		}
		public function delete_mucdothamgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Mucdothamgia');
				Core::printJson($model->delete_mucdothamgia($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_mucdothamgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if(count($id)>0){
				$model = Core::model('Danhmuchethong/Mucdothamgia');
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_mucdothamgia($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>