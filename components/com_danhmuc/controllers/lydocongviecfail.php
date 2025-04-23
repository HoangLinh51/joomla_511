<?php 
	class DanhmucControllerLydocongviecfail extends DanhmucController{
		public function save_lydocongviecfail(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Lydocongviecfail');
			if($form['id']==''){
				Core::printJson($model->add_lydocongviecfail($form));exit;
			}
			Core::printJson($model->update_lydocongviecfail($form));exit;
		}
		public function delete_lydocongviecfail(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Lydocongviecfail');
			if($id>0){
				Core::printJson($model->delete_lydocongviecfail($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_lydocongviecfail(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Lydocongviecfail');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_lydocongviecfail($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>