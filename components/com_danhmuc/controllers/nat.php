<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerNat extends JControllerLegacy{
		function themthongtinnat(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nat');
			$kq = $model->addnat($form);
			echo json_encode($kq);die;
		}
		function xoanat(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nat');
			$kq = $model->xoanat($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinnat(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nat');
			$kq = $model->updatenat($form);
			echo json_encode($kq);die;
		}
		function xoanhieunat(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nat');
			$kq = $model->xoanhieunat($id);
			echo json_encode($kq);die;
		}
		function xuatdsnat(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_nat.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Nat');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>