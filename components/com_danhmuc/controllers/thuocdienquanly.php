<?php 
	class DanhmucControllerThuocdienquanly extends DanhmucController{
		public function themthongtinthuocdienquanly(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Thuocdienquanly');
			$kq = $model->addthuocdienquanly($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinthuocdienquanly(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Thuocdienquanly');
			$kq = $model->updatethuocdienquanly($form);
			echo json_encode($kq);exit;
		}
		public function xoathuocdienquanly(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Thuocdienquanly');
			$kq = $model->xoathuocdienquanly($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuthuocdienquanly(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Thuocdienquanly');
			$kq = $model->xoanhieuthuocdienquanly($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsthuocdienquanly(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_thuocdienquanly.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Thuocdienquanly');
			$kq = $model->xuat_excelthuocdienquanly();
			echo json_encode(true);die;
		}
	}
?>