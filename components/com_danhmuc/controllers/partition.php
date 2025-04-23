<?php 
	class DanhmucControllerPartition extends DanhmucController{
		public function luu_partition(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			// var_dump($form);die;
			$model = Core::model('Danhmuchethong/Partition');
			if($form['id']==''){
				$result = $model->add_partition_for_table($form);
				if($result==true){
					Core::printJson($model->add_partition($form));exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$result = $model->add_partition_for_table($form);
				if($result==true){
					Core::printJson($model->update_partition($form));exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_partition(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Partition');
				Core::printJson($model->delete_partition($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_partition(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if(count($id)>0){
				$model = Core::model('Danhmuchethong/Partition');
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_partition($id[$i]);
				}
				Core::printJson($result);exit;
			}
			Core::printJson(false);exit;
		}
	}
?>