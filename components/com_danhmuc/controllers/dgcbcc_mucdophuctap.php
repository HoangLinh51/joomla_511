<?php 
	class DanhmucControllerDgcbcc_mucdophuctap extends DanhmucController{
		public function luu_dgcbcc_mucdophuctap(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/DgcbccMucdophuctap');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_mucdophuctap($form));exit;
			}
			else{
				Core::printJson($model->update_dgcbcc_mucdophuctap($form));exit;
			}
		}
		public function delete_dgcbcc_mucdophuctap(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/DgcbccMucdophuctap');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_mucdophuctap($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_dgcbcc_mucdophuctap(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('array_id',0);
			$model = Core::model('Danhmuchethong/DgcbccMucdophuctap');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_dgcbcc_mucdophuctap($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>