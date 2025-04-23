<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerParty_pos extends JControllerLegacy{
		function themthongtinparty_pos(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Party_pos');
			$kq = $model->addparty_pos($form);
			echo json_encode($kq);die;
		}
		function xoaparty_pos(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Party_pos');
			$kq = $model->xoaparty_pos($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtinparty_pos(){
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Party_pos');
			$kq = $model->updateparty_pos($form);
			echo json_encode($kq);die;
		}
		function xoanhieuparty_pos(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Party_pos');
			$kq = $model->xoanhieuparty_pos($id);
			echo json_encode($kq);die;
		}
		function xuatdsparty_pos(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_party_pos.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Party_pos');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>