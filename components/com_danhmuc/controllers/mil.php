<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerMil extends JControllerLegacy{
		function themthongtinmil(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Mil');
			$kq = $model->addmil($form);
			echo json_encode($kq);die;
		}
		function xoamil(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Mil');
			$kq = $model->xoamil($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinmil(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Mil');
			$kq = $model->updatemil($form);
			echo json_encode($kq);die;
		}
		function xoanhieumil(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Mil');
			$kq = $model->xoanhieumil($id);
			echo json_encode($kq);die;
		}
		function xuatdsmil(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_mil.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Mil');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>