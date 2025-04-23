<?php 
// BỎ
	class DanhmucControllerHinhthuc_khenthuong_kyluat_kyluatdang extends DanhmucController{
		public function add_htktklkld(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuc/Hinhthuckhenthuongkyluatkyluatdang');
			$kq = $model->add_htktklkld($form);
			Core::printJson($kq);exit;
		}
		public function update_htktklkld(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuc/Hinhthuckhenthuongkyluatkyluatdang');
			$kq = $model->update_htktklkld($form);
			Core::printJson($kq);exit;
		}
		public function delete_htktklkld(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuc/Hinhthuckhenthuongkyluatkyluatdang');
				$kq = $model->delete_htktklkld($id);
				Core::printJson($kq);exit;
			}
			Core::printJson(false);exit;
		}
		public function deleteall_htktklkld(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->get('id',array(),'array');
			$model = Core::model('Danhmuc/Hinhthuckhenthuongkyluatkyluatdang');
			$kq = $model->deleteall_htktklkld($id);
			Core::printJson($kq);exit;
		}
	}
?>