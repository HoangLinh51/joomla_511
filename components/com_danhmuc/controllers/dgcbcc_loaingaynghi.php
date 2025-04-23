<?php 
	class DanhmucControllerDgcbcc_loaingaynghi extends DanhmucController{
		public function save_dgcbcc_loaingaynghi(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_loaingaynghi');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_loaingaynghi($form));exit;
			}
			Core::printJson($model->update_dgcbcc_loaingaynghi($form));exit;
		}
		public function delete_dgcbcc_loaingaynghi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_loaingaynghi');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_loaingaynghi($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_loaingaynghi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_loaingaynghi');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_loaingaynghi($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>