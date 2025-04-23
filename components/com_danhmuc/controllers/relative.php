<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerRelative extends JControllerLegacy{
		function themthongtinrelative(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Relative');
			$kq = $model->addrelative($form);
			echo json_encode($kq);die;
		}
		function xoarelative(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Relative');
			$kq = $model->xoarelative($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinrelative(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Relative');
			$kq = $model->updaterelative($form);
			echo json_encode($kq);die;
		}
		function xoanhieurelative(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Relative');
			$kq = $model->xoanhieurelative($id);
			echo json_encode($kq);die;
		}
		function xuatdsrelative(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_relative.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Relative');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>