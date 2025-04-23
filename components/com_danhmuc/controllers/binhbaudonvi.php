<?php 
	class DanhmucControllerBinhbaudonvi extends DanhmucController{
		public function themthongtinvbbdv(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Binhbaudonvi');
			$kq = $model->addbbdv($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinvbbdv(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Binhbaudonvi');
			$kq = $model->updatebbdv($form);
			echo json_encode($kq);exit;
		}
		public function xoabbdv(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Binhbaudonvi');
			$kq = $model->deletebbdv($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieubbdv(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Binhbaudonvi');
			$kq = $model->deletemanybbdv($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsbbdv(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_binhbaudonvi.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Binhbaudonvi');
			$kq = $model->xuat_excelbbdv();
			echo json_encode(true);die;
		}
	}
?>