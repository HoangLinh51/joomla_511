<?php 
	class DanhmucControllerDgcbcc_xeploaicongviec extends DanhmucController{
		public function save_dgcbcc_xeploaicongviec(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaicongviec');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_xeploaicongviec($form));exit;
			}
			Core::printJson($model->update_dgcbcc_xeploaicongviec($form));exit;
		}
		public function delete_dgcbcc_xeploaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaicongviec');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_xeploaicongviec($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_xeploaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_xeploaicongviec');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_xeploaicongviec($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>