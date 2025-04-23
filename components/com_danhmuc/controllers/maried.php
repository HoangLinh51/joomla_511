<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerMaried extends JControllerLegacy{
		function themthongtinmaried(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Maried');
			$kq = $model->addmaried($form);
			echo json_encode($kq);die;
		}
		function xoamaried(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Maried');
			$kq = $model->xoamaried($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinmaried(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Maried');
			$kq = $model->updatemaried($form);
			echo json_encode($kq);die;
		}
		function xoanhieumaried(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Maried');
			$kq = $model->xoanhieumaried($id);
			echo json_encode($kq);die;
		}
		function xuatdsmaried(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_maried.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Maried');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>