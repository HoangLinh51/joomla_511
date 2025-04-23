<?php 
	class DanhmucControllerVitrituyendung extends DanhmucController{
		public function themthongtinvitrituyendung(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Vitrituyendung');
			$kq = $model->addvitrituyendung($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinvitrituyendung(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Vitrituyendung');
			$kq = $model->updatevitrituyendung($form);
			echo json_encode($kq);exit;
		}
		public function xoavitrituyendung(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Vitrituyendung');
			$kq = $model->deletevitrituyendung($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieuvitrituyendung(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Vitrituyendung');
			$kq = $model->deletemanyvitrituyendung($id);
			echo json_encode($kq);exit;
		}
		public function xuatdsvitrituyendung(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_vitrituyendung.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Vitrituyendung');
			$kq = $model->xuat_excelvitrituyendung();
			echo json_encode(true);die;
		}
	}
?>