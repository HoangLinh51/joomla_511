<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerDefect extends JControllerLegacy{
		function themthongtindefect(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Defect');
			$kq = $model->adddefect($form);
			echo json_encode($kq);die;
		}
		function xoadefect(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Defect');
			$kq = $model->xoadefect($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtindefect(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Defect');
			$kq = $model->updatedefect($form);
			echo json_encode($kq);die;
		}
		function xoanhieudefect(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Defect');
			$kq = $model->xoanhieudefect($id);
			echo json_encode($kq);die;
		}
		function xuatdsdefect(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_defect.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Defect');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>