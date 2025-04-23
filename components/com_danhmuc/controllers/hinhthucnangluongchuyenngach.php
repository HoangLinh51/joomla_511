<?php 
	class DanhmucControllerHinhthucnangluongchuyenngach extends DanhmucController{
		public function add_hinhthuc_nlcn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
			Core::printJson($model->add_hinhthuc_nlcn($form));exit;
		}
		public function delete_hinhthuc_nlcn(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
				Core::printJson($model->delete_hinhthuc_nlcn($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function update_hinhthuc_nlcn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
			Core::printJson($model->update_hinhthuc_nlcn($form));exit;
		}
		public function xoanhieu_hinhthucnangluongchuyenngach(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
				Core::printJson($model->deletemany_hinhthuc_nlcn($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>