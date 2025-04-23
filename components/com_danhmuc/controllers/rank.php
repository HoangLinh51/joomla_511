<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerRank extends JControllerLegacy{
		function themthongtinrank(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Rank');
			$kq = $model->addrank($form);
			echo json_encode($kq);die;
		}
		function xoarank(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Rank');
			$kq = $model->xoarank($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinrank(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Rank');
			$kq = $model->updaterank($form);
			echo json_encode($kq);die;
		}
		function xoanhieurank(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Rank');
			$kq = $model->xoanhieurank($id);
			echo json_encode($kq);die;
		}
		function xuatdsrank(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_rank.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Rank');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>