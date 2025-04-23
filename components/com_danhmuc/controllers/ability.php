<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerAbility extends JControllerLegacy{
		function themthongtinability(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ability');
			$kq = $model->addability($form);
			echo json_encode($kq);die;
		}
		function xoaability(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ability');
			$kq = $model->xoaability($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinability(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Ability');
			$kq = $model->updateability($form);
			echo json_encode($kq);die;
		}
		function xoanhieuability(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Ability');
			$kq = $model->xoanhieuability($id);
			echo json_encode($kq);die;
		}
		function xuatdsability(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_ability.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Ability');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>