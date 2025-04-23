<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerSex extends JControllerLegacy{
		function themthongtinsex(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Sex');
			$kq = $model->addsex($form);
			echo json_encode($kq);die;
		}
		function xoasex(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Sex');
			$kq = $model->xoasex($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinsex(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Sex');
			$kq = $model->updatesex($form);
			echo json_encode($kq);die;
		}
		function xoanhieusex(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Sex');
			$kq = $model->xoanhieusex($id);
			echo json_encode($kq);die;
		}
		function xuatdssex(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_sex.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Sex');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>