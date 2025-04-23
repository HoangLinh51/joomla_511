<?php 
	class DanhmucControllerLydodinuocngoai extends DanhmucController{
		public function themthongtinlydodinuocngoai(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Lydodinuocngoai');
			$kq = $model->addlydodinuocngoai($form);
			echo json_encode($kq);exit;
		}
		public function chinhsuathongtinlydodinuocngoai(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Lydodinuocngoai');
			$kq = $model->updatelydodinuocngoai($form);
			echo json_encode($kq);exit;
		}
		public function xoalydodinuocngoai(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Lydodinuocngoai');
			$kq = $model->xoalydodinuocngoai($id);
			echo json_encode($kq);exit;
		}
		public function xoanhieulydodinuocngoai(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Lydodinuocngoai');
			$kq = $model->xoanhieulydodinuocngoai($id);
			echo json_encode($kq);exit;
		}
		public function xuatdslydodinuocngoai(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_lydodinuocngoai.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Lydodinuocngoai');
			$kq = $model->xuat_excellydodinuocngoai();
			echo json_encode(true);die;
		}
	}
?>