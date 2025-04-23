<?php 
	class DanhmucControllerTrangthaidonvi extends DanhmucController{
		public function themthongtintrangthaidonvi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Trangthaidonvi');
			$kq = $model->addtrangthaidonvi($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtintrangthaidonvi(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Trangthaidonvi');
			$kq = $model->updatetrangthaidonvi($form);
			echo json_encode($kq);exit;
		}
		public function xoatrangthaidonvi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Trangthaidonvi');
			$kq = $model->xoatrangthaidonvi($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieutrangthaidonvi(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Trangthaidonvi');
			$kq = $model->xoanhieutrangthaidonvi($id);
			echo json_encode($kq);exit;
		}
		public function xuatdstrangthaidonvi(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_trangthaidonvi.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Trangthaidonvi');
			$kq = $model->xuat_exceltrangthaidonvi();
			echo json_encode(true);die;
		}
	}
?>