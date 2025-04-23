<?php 
	class DanhmucControllerLoaitrinhdo extends DanhmucController{
		public function save_loaitrinhdo(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Loaitrinhdo');
			if($form['code']==''){
				Core::printJson($model->add_loaitrinhdo($form));exit;
			}
			else{
				Core::printJson($model->update_loaitrinhdo($form));exit;
			}
		}
		public function delete_loaitrinhdo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaitrinhdo');
			if($id>0){
				Core::printJson($model->delete_loaitrinhdo($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_loaitrinhdo(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaitrinhdo');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_loaitrinhdo($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>