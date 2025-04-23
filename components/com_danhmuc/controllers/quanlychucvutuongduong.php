<?php 
	class DanhmucControllerQuanlychucvutuongduong extends DanhmucController{
		public function themthongtinchucvutuongduong(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
			$kq = $model->addchucvutuongduong($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinchucvutuonduong(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
			$kq = $model->updatechucvutuongduong($form);
			echo json_encode($kq);exit;
		}
		public function xoachucvutuongduong(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
			$kq = $model->xoachucvutuongduong($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuchucvutuongduong(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
			$kq = $model->xoanhieuchucvutuongduong($id);
			echo json_encode($kq);exit;
		}
		public function xuatdscvtd(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_chucvutuongduong.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
			$kq = $model->xuat_excelchucvutuongduong();
			echo json_encode(true);die;
		}
	}
?>