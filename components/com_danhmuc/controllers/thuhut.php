<?php 
	defined('_JEXEC') or die('Restricted access');
	class DanhmucControllerThuhut extends DanhmucController{
		public function themthongtinthuhut(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Thuhut');
			$kq = $model->addthuhut($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinthuhut(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Thuhut');
			$kq = $model->updatethuhut($form);
			echo json_encode($kq);exit;
		}
		public function xoathuhut(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Thuhut');
			$kq = $model->xoathuhut($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuthuhut(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Thuhut');
			$kq = $model->xoanhieuthuhut($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsthuhut(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_thuhut.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Thuhut');
			$kq = $model->xuat_excelthuhut();
			echo json_encode(true);die;
		}
	}
?>