<?php
	defined('_JEXEC') or die('Restricted access'); 
	class DanhmucControllerNhomtieuchi extends DanhmucController{
		public function themthongtinnhomtieuchi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$kq = $model->addnhomtieuchi($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinnhomtieuchi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$kq = $model->updatenhomtieuchi($form);
			echo json_encode($kq);exit;
		}
		public function xoanhomtieuchi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$kq = $model->deletenhomtieuchi($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieunhomtieuchi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$kq = $model->deletenhieunhomtieuchi($id);
			// var_dump($kq);die;
			echo json_encode($kq);exit;
		}
		public function xuatexcelnhomtieuchi(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_nhomtieuchi.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>