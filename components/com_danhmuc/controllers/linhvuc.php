<?php 
	defined('_JEXEC') or die('Restricted access');
	class DanhmucControllerLinhvuc extends DanhmucController{
		public function themthongtinlinhvuc(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Linhvuc');
			$kq = $model->addlinhvuc($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinlinhvuc(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Linhvuc');
			$kq = $model->updatelinhvuc($form);
			echo json_encode($kq);exit;
		}
		public function xoalinhvuc(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Linhvuc');
			$kq = $model->xoalinhvuc($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieulinhvuc(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Linhvuc');
			$kq = $model->xoanhieulinhvuc($id);
			echo json_encode($kq);exit;
		}
		public function xuatdslinhvuc(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_linhvuc.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Linhvuc');
			$kq = $model->xuat_excellinhvuc();
			echo json_encode(true);die;
		}
	}
?>