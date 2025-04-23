<?php 
	class DanhmucControllerBinhbauphanloaicbcc extends DanhmucController{
		public function themthongtinbinhbauphanloaicbcc(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
			$kq = $model->addbinhbauphanloaicbcc($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinbinhbauphanloaicbcc(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
			$kq = $model->updatebinhbauphanloaicbcc($form);
			echo json_encode($kq);exit;
		}
		public function xoabinhbauphanloaicbcc(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
			$kq = $model->xoabinhbauphanloaicbcc($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieubinhbauphanloaicbcc(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
			$kq = $model->xoanhieubinhbauphanloaicbcc($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsbinhbauphanloaicbcc(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_binhbauphanloaicbcc.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
			$kq = $model->xuat_excelbinhbauphanloaicbcc();
			echo json_encode(true);die;
		}
	}
?>