<?php 
	class DanhmucControllerDgcbcc_lydocongviecfail extends DanhmucController{
		public function save_dgcbcc_lydocongviecfail(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dgcbcc_lydocongviecfail');
			if($form['id']==''){
				Core::printJson($model->add_dgcbcc_lydocongviecfail($form));exit;
			}
			Core::printJson($model->update_dgcbcc_lydocongviecfail($form));exit;
		}
		public function delete_dgcbcc_lydocongviecfail(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_lydocongviecfail');
			if($id>0){
				Core::printJson($model->delete_dgcbcc_lydocongviecfail($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_lydocongviecfail(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dgcbcc_lydocongviecfail');
			for($i=0;$i<count($id);$i++){
				$result[] = $model->delete_dgcbcc_lydocongviecfail($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>