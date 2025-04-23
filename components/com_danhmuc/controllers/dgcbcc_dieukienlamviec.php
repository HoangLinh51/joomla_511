<?php 
	class DanhmucControllerDgcbcc_dieukienlamviec extends DanhmucController{
		public function save_dgcbcc_dieukienlamviec(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_dieukienlamviec');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_dieukienlamviec($form));exit;
			}
			Core::printJson($model->update_dgcbcc_dieukienlamviec($form));exit;
		}
		public function delete_dgcbcc_dieukienlamviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_dieukienlamviec');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_dieukienlamviec($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_dieukienlamviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_dieukienlamviec');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_dieukienlamviec($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>