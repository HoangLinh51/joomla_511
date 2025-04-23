<?php 
	class DanhmucControllerDieukienlamviec extends DanhmucController{
		public function save_dieukienlamviec(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dieukienlamviec');
			if($form['id']==''){
				Core::printJson($model->add_dieukienlamviec($form));exit;
			}
			Core::printJson($model->update_dieukienlamviec($form));exit;
		}
		public function delete_dieukienlamviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dieukienlamviec');
			if($id>0){
				Core::printJson($model->delete_dieukienlamviec($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dieukienlamviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dieukienlamviec');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dieukienlamviec($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>