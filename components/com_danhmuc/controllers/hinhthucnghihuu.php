<?php 
	class DanhmucControllerHinhthucnghihuu extends DanhmucController{
		public function themthongtinhinhthucnghihuu(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hinhthucnghihuu');
			$kq = $model->addhinhthucnghihuu($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinhinhthucnghihuu(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hinhthucnghihuu');
			$kq = $model->updatehinhthucnghihuu($form);
			echo json_encode($kq);exit;
		}
		public function xoahinhthucnghihuu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hinhthucnghihuu');
			$kq = $model->deletehinhthucnghihuu($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuhinhthucnghihuu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hinhthucnghihuu');
			$kq = $model->deletemanyhinhthucnghihuu($id);
			echo json_encode($kq);exit;
		}
		public function xuatdshinhthucnghihuu(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_hinhthucnghihuu.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Hinhthucnghihuu');
			$kq = $model->xuat_excelhinhthucnghihuu();
			echo json_encode(true);die;
		}
	}
?>