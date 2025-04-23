<?php 
	class DanhmucControllerTiendo extends DanhmucController{
		public function luu_tiendo(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Tiendo');
			if($form['id']==''){
				Core::printJson($model->add_tiendo($form));exit;
			}
			else{
				Core::printJson($model->update_tiendo($form));exit;
			}
		}
		public function delete_tiendo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Tiendo');
			if($id>0){
				Core::printJson($model->delete_tiendo($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_tiendo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('array_id',0);
			$model = Core::model('Danhmuchethong/Tiendo');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_tiendo($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>