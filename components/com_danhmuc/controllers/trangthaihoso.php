<?php 
	class DanhmucControllerTrangthaihoso extends DanhmucController{
		public function themthongtintrangthaihoso(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Trangthaihoso');
			$kq = $model->addtrangthaihoso($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtintrangthaihoso(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Trangthaihoso');
			$kq = $model->updatetrangthaihoso($form);
			echo json_encode($kq);exit;
		}
		public function xoatrangthaihoso(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Trangthaihoso');
			$kq = $model->deletetrangthaihoso($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieutrangthaihoso(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Trangthaihoso');
			$kq = $model->deletemanytrangthaihoso($id);
			echo json_encode($kq);exit;
		}
		public function xuatdstrangthaihoso(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_trangthaihoso.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Trangthaihoso');
			$kq = $model->xuat_exceltrangthaihoso();
			echo json_encode(true);die;
		}
	}
?>