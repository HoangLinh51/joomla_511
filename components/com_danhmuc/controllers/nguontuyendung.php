<?php 
	class DanhmucControllerNguontuyendung extends DanhmucController{
		public function themthongtinnguontuyendung(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nguontuyendung');
			$kq = $model->addnguontuyendung($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinnguontuyendung(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nguontuyendung');
			$kq = $model->updatenguontuyendung($form);
			echo json_encode($kq);exit;
		}
		public function xoanguontuyendung(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nguontuyendung');
			$kq = $model->xoanguontuyendung($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieunguontuyendung(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nguontuyendung');
			$kq = $model->xoanhieunguontuyendung($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsnguontuyendung(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_nguontuyendung.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Nguontuyendung');
			$kq = $model->xuat_excelnguontuyendung();
			echo json_encode(true);die;
		}
	}
?>