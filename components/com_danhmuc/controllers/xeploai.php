<?php 
	class DanhmucControllerXeploai extends DanhmucController{
		public function luu_xeploai(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Xeploai');
			if($form['id']==''){
				Core::printJson($model->add_xeploai($form));exit;
			}
			else{
				Core::printJson($model->update_xeploai($form));exit;
			}
		}
		public function delete_xeploai(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Xeploai');
			if($id>0){
				Core::printJson($model->delete_xeploai($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_xeploai(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('array_id',0);
			$model = Core::model('Danhmuchethong/Xeploai');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_xeploai($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>