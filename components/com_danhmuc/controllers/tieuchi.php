<?php
	defined('_JEXEC') or die('Restricted access'); 
	class DanhmucControllerTieuchi extends DanhmucController{
		public function themthongtintieuchi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$kq = $model->addtieuchi($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtintieuchi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$kq = $model->updatetieuchi($form);
			echo json_encode($kq);exit;
		}
		public function xoatieuchi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$kq = $model->deletetieuchi($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieutieuchi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$kq = $model->deletenhieutieuchi($id);
			// var_dump($kq);die;
			echo json_encode($kq);exit;
		}
		public function xuatexceltieuchi(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_tieuchi.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>