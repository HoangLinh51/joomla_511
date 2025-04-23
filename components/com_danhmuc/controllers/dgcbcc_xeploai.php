<?php 
	class DanhmucControllerDgcbcc_xeploai extends DanhmucController{
		public function luu_dgcbcc_xeploai(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/DgcbccXeploai');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_xeploai($form));exit;
			}
			else{
				Core::printJson($model->update_dgcbcc_xeploai($form));exit;
			}
		}
		public function delete_dgcbcc_xeploai(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/DgcbccXeploai');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_xeploai($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_dgcbcc_xeploai(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('array_id',0);
			$model = Core::model('Danhmuchethong/DgcbccXeploai');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_dgcbcc_xeploai($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>