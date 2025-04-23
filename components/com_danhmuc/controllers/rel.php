<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerrel extends JControllerLegacy{
		function themthongtinrel(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Rel');
			$kq = $model->addrel($form);
			echo json_encode($kq);die;
		}
		function xoarel(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Rel');
			$kq = $model->xoarel($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinrel(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Rel');
			$kq = $model->updaterel($form);
			echo json_encode($kq);die;
		}
		function xoanhieurel(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Rel');
			$kq = $model->xoanhieurel($id);
			echo json_encode($kq);die;
		}
		function xuatdsrel(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_rel.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Rel');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>