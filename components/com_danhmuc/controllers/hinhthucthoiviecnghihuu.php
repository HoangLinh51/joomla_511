<?php 
	class DanhmucControllerHinhthucthoiviecnghihuu extends DanhmucController{
		public function themthongtinhinhthucthoiviecnghihuu(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
			$kq = $model->addhinhthucthoiviecnghihuu($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinhinhthucthoiviecnghihuu(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
			$kq = $model->updatehinhthucthoiviecnghihuu($form);
			echo json_encode($kq);exit;
		}
		public function xoahinhthucthoiviecnghihuu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
			$kq = $model->xoahinhthucthoiviecnghihuu($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuhinhthucthoiviecnghihuu(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
			$kq = $model->xoanhieuhinhthucthoiviecnghihuu($id);
			echo json_encode($kq);exit;
		}
		public function xuatdshinhthucthoiviecnghihuu(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_hinhthucthoiviecnghihuu.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
			$kq = $model->xuat_excelhinhthucthoiviecnghihuu();
			echo json_encode(true);die;
		}
	}
?>