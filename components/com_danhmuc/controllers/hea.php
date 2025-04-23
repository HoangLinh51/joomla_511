<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerHea extends JControllerLegacy{
		function themthongtinhea(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hea');
			$kq = $model->addhea($form);
			echo json_encode($kq);die;
		}
		function xoahea(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hea');
			$kq = $model->xoahea($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinhea(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hea');
			$kq = $model->updatehea($form);
			echo json_encode($kq);die;
		}
		function xoanhieuhea(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hea');
			$kq = $model->xoanhieuhea($id);
			echo json_encode($kq);die;
		}
		function xuatdshea(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_hea.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Hea');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>