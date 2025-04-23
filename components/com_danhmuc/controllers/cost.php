<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllercost extends JControllerLegacy{
		function themthongtincost(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cost');
			$kq = $model->addcost($form);
			echo json_encode($kq);die;
		}
		function xoacost(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cost');
			$kq = $model->xoacost($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtincost(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cost');
			$kq = $model->updatecost($form);
			echo json_encode($kq);die;
		}
		function xoanhieucost(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cost');
			$kq = $model->xoanhieucost($id);
			echo json_encode($kq);die;
		}
		function xuatdscost(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_cost.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Cost');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>