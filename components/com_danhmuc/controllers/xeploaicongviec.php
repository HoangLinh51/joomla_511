<?php 
	class DanhmucControllerXeploaicongviec extends DanhmucController{
		public function save_xeploaicongviec(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Xeploaicongviec');
			if($form['id']==''){
				Core::printJson($model->add_xeploaicongviec($form));exit;
			}
			Core::printJson($model->update_xeploaicongviec($form));exit;
		}
		public function delete_xeploaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Xeploaicongviec');
			if($id>0){
				Core::printJson($model->delete_xeploaicongviec($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_xeploaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Xeploaicongviec');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_xeploaicongviec($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>