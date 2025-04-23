<?php 
	class DanhmucControllerCacloaiquyetdinh extends DanhmucController{
		public function themthongtincacloaiquyetdinh(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
			$kq = $model->addcacloaiquyetdinh($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtincacloaiquyetdinh(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
			$kq = $model->updatecacloaiquyetdinh($form);
			echo json_encode($kq);exit;
		}
		public function xoacacloaiquyetdinh(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
			$kq = $model->xoacacloaiquyetdinh($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieucacloaiquyetdinh(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
			$kq = $model->xoanhieucacloaiquyetdinh($id);
			echo json_encode($kq);exit;
		}
		public function xuatdscacloaiquyetdinh(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_cacloaiquyetdinh.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
			$kq = $model->xuat_excelcacloaiquyetdinh();
			echo json_encode(true);die;
		}
	}
?>