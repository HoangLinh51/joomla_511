<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerCountry extends JControllerLegacy{
		function themthongtincountry(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Country');
			$kq = $model->addcountry($form);
			echo json_encode($kq);die;
		}
		function xoacountry(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Country');
			$kq = $model->xoacountry($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtincountry(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Country');
			$kq = $model->updatecountry($form);
			echo json_encode($kq);die;
		}
		function xoanhieucountry(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Country');
			$kq = $model->xoanhieucountry($id);
			echo json_encode($kq);die;
		}
		function xuatdscountry(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_country.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Country');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>