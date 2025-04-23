<?php 
	class DanhmucControllerTrinhdo extends DanhmucController{
		public function save_trinhdo(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			// var_dump($form);die;
			$model = Core::model('Danhmuchethong/Trinhdo');
			if($form['id']==''){
				Core::printJson($model->add_trinhdo($form));exit;
			}
			else{
				Core::printJson($model->update_trinhdo($form));exit;
			}
		}
		public function delete_trinhdo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Trinhdo');
			if($id>0){
				Core::printJson($model->delete_trinhdo($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_trinhdo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Trinhdo');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_trinhdo($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>