<?php 
	defined('_JEXEC') or die('Restricted access');
	class DanhmucControllerKhoicoquan extends DanhmucController{
		public function themthongtinkhoicoquan(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Khoicoquan');
			$kq = $model->addkhoicoquan($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinkhoicoquan(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Khoicoquan');
			$kq = $model->updatekhoicoquan($form);
			echo json_encode($kq);exit;
		}
		public function xoakhoicoquan(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Khoicoquan');
			$kq = $model->xoakhoicoquan($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieukhoicoquan(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Khoicoquan');
			$kq = $model->xoanhieukhoicoquan($id);
			echo json_encode($kq);exit;
		}
		public function xuatdskhoicoquan(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_khoicoquan.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Khoicoquan');
			$kq = $model->xuat_excelkhoicoquan();
			echo json_encode(true);die;
		}
	}
?>