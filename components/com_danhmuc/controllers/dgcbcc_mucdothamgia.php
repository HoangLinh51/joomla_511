<?php 
	class DanhmucControllerDgcbcc_mucdothamgia extends DanhmucController{
		public function luu_dgcbcc_mucdothamgia(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/DgcbccMucdothamgia');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_mucdothamgia($form));exit;
			}
			else{
				Core::printJson($model->update_dgcbcc_mucdothamgia($form));exit;
			}
		}
		public function delete_dgcbcc_mucdothamgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/DgcbccMucdothamgia');
				Core::printJson($model->delete_dgcbcc_mucdothamgia($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_dgcbcc_mucdothamgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if(count($id)>0){
				$model = Core::model('Danhmuchethong/DgcbccMucdothamgia');
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_dgcbcc_mucdothamgia($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>