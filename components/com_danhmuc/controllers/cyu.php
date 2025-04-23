<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerCyu extends JControllerLegacy{
		function themthongtincyu(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cyu');
			$kq = $model->addcyu($form);
			echo json_encode($kq);die;
		}
		function xoacyu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cyu');
			$kq = $model->xoacyu($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtincyu(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cyu');
			$kq = $model->updatecyu($form);
			echo json_encode($kq);die;
		}
		function xoanhieucyu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cyu');
			$kq = $model->xoanhieucyu($id);
			echo json_encode($kq);die;
		}
		function xuatdscyu(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_cyu.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Cyu');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>