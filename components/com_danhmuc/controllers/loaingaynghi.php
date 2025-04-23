<?php 
	class DanhmucControllerLoaingaynghi extends DanhmucController{
		public function save_loaingaynghi(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Loaingaynghi');
			if($form['id']==''){
				Core::printJson($model->add_loaingaynghi($form));exit;
			}
			Core::printJson($model->update_loaingaynghi($form));exit;
		}
		public function delete_loaingaynghi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaingaynghi');
			if($id>0){
				Core::printJson($model->delete_loaingaynghi($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_loaingaynghi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaingaynghi');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_loaingaynghi($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>