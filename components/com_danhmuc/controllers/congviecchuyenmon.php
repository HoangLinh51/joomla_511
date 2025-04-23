<?php 
	class DanhmucControllerCongviecchuyenmon extends DanhmucController{
		public function themthongtincongviecchuyenmon(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Congviecchuyenmon');
			$kq = $model->addcongviecchuyenmon($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtincongviecchuyenmon(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Congviecchuyenmon');
			$kq = $model->updatecongviecchuyenmon($form);
			echo json_encode($kq);exit;
		}
		public function xoacongviecchuyenmon(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Congviecchuyenmon');
			$kq = $model->xoacongviecchuyenmon($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieucongviecchuyenmon(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Congviecchuyenmon');
			$kq = $model->xoanhieucongviecchuyenmon($id);
			echo json_encode($kq);exit;
		}
		public function xuatdscongviecchuyenmon(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_congviecchuyenmon.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Congviecchuyenmon');
			$kq = $model->xuat_excelcongviecchuyenmon();
			echo json_encode(true);die;
		}
	}
?>