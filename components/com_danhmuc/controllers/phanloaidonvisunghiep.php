<?php 
	class DanhmucControllerPhanloaidonvisunghiep extends DanhmucController{
		public function themthongtinphanloaidonvisunghiep(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Phanloaidonvisunghiep');
			$kq = $model->addphanloaidonvisunghiep($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinphanloaidonvisunghiep(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Phanloaidonvisunghiep');
			$kq = $model->updatephanloaidonvisunghiep($form);
			echo json_encode($kq);exit;
		}
		public function xoaphanloaidonvisunghiep(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Phanloaidonvisunghiep');
			$kq = $model->xoaphanloaidonvisunghiep($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuphanloaidonvisunghiep(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Phanloaidonvisunghiep');
			$kq = $model->xoanhieuphanloaidonvisunghiep($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsphanloaidonvisunghiep(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_phanloaidonvisunghiep.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Phanloaidonvisunghiep');
			$kq = $model->xuat_excelphanloaidonvisunghiep();
			echo json_encode(true);die;
		}
	}
?>