<?php 
	class DanhmucControllerDoituongquanly extends DanhmucController{
		public function themthongtindoituongquanly(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Doituongquanly');
			$kq = $model->adddoituongquanly($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtindoituongquanly(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Doituongquanly');
			$kq = $model->updatedoituongquanly($form);
			echo json_encode($kq);exit;
		}
		public function xoadoituongquanly(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Doituongquanly');
			$kq = $model->deletedoituongquanly($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieudoituongquanly(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Doituongquanly');
			$kq = $model->deletemanydoituongquanly($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsdoituongquanly(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_doituongquanly.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Doituongquanly');
			$kq = $model->xuat_exceldoituongquanly();
			echo json_encode(true);die;
		}
	}
?>