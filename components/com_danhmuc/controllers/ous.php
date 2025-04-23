<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerOus extends JControllerLegacy{
		function themthongtinous(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ous');
			$kq = $model->addous($form);
			echo json_encode($kq);die;
		}
		function xoaous(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ous');
			$kq = $model->xoaous($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinous(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ous');
			$kq = $model->updateous($form);
			echo json_encode($kq);die;
		}
		function xoanhieuous(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ous');
			$kq = $model->xoanhieuous($id);
			echo json_encode($kq);die;
		}
		function xuatdsous(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_ous.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Ous');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>