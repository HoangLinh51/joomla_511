<?php 
	defined('_JEXEC') or die('Restricted access');
	class DanhmucControllernhiemvuduocgiao extends DanhmucController{
		public function themthongtinnhiemvuduocgiao(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
			$kq = $model->addnhiemvuduocgiao($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinnhiemvuduocgiao(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
			$kq = $model->updatenhiemvuduocgiao($form);
			echo json_encode($kq);exit;
		}
		public function xoanhiemvuduocgiao(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
			$kq = $model->xoanhiemvuduocgiao($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieunhiemvuduocgiao(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
			$kq = $model->xoanhieunhiemvuduocgiao($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsnhiemvuduocgiao(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_nhiemvuduocgiao.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
			$kq = $model->xuat_excelnhiemvuduocgiao();
			echo json_encode(true);die;
		}
	}
?>