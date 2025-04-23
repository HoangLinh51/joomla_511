<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerBlood extends JControllerLegacy{
		function themthongtinblood(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Blood');
			$kq = $model->addblood($form);
			echo json_encode($kq);die;
		}
		function xoablood(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Blood');
			$kq = $model->xoablood($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinblood(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Blood');
			$kq = $model->updateblood($form);
			echo json_encode($kq);die;
		}
		function xoanhieublood(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Blood');
			$kq = $model->xoanhieublood($id);
			echo json_encode($kq);die;
		}
		function xuatdsblood(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_blood.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Blood');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>