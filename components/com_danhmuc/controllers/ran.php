<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerRan extends JControllerLegacy{
		function themthongtinran(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ran');
			$kq = $model->addran($form);
			echo json_encode($kq);die;
		}
		function xoaran(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ran');
			$kq = $model->xoaran($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinran(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ran');
			$kq = $model->updateran($form);
			echo json_encode($kq);die;
		}
		function xoanhieuran(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ran');
			$kq = $model->xoanhieuran($id);
			echo json_encode($kq);die;
		}
		function xuatdsran(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_ran.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Ran');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>