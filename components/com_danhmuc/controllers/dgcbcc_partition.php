<?php 
	class DanhmucControllerDgcbcc_partition extends DanhmucController{
		public function luu_dgcbcc_partition(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			// var_dump($form);die;
			$model = Core::model('Danhmuchethong/DgcbccPartition');
			if($form['id']==''){
				$result = $model->add_partition_for_table($form);
				if($result==true){
					Core::printJson($model->add_dgcbcc_partition($form));exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$result = $model->add_partition_for_table($form);
				if($result==true){
					Core::printJson($model->update_dgcbcc_partition($form));exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_dgcbcc_partition(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/DgcbccPartition');
				Core::printJson($model->delete_dgcbcc_partition($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_partition(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if(count($id)>0){
				$model = Core::model('Danhmuchethong/DgcbccPartition');
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_dgcbcc_partition($id[$i]);
				}
				Core::printJson($result);exit;
			}
			Core::printJson(false);exit;
		}
	}
?>