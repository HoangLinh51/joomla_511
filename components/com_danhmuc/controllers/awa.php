<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerAwa extends JControllerLegacy{
		function themthongtinawa(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Awa');
			$kq = $model->addawa($form);
			echo json_encode($kq);die;
		}
		function xoaawa(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Awa');
			$kq = $model->xoaawa($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinawa(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Awa');
			$kq = $model->updateawa($form);
			echo json_encode($kq);die;
		}
		function xoanhieuawa(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Awa');
			$kq = $model->xoanhieuawa($id);
			echo json_encode($kq);die;
		}
		function xuatdsawa(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_awa.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Awa');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>