<?php 
	class DanhmucControllerDgcbcc_tiendo extends DanhmucController{
		public function luu_dgcbcc_tiendo(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/DgcbccTiendo');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_tiendo($form));exit;
			}
			else{
				Core::printJson($model->update_dgcbcc_tiendo($form));exit;
			}
		}
		public function delete_dgcbcc_tiendo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/DgcbccTiendo');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_tiendo($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_dgcbcc_tiendo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('array_id',0);
			$model = Core::model('Danhmuchethong/DgcbccTiendo');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_dgcbcc_tiendo($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>