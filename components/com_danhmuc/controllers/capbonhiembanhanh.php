<?php
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerCapbonhiembanhanh extends DanhmucController{
		function __construct($config = array()) {
	        parent::__construct($config);
	    }
		function themthongtincapbonhiembanhanh(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Capbonhiembanhanh');
			$kq = $model->addcapbonhiembanhanh($form);
			echo json_encode($kq);die;
		}
		function xoacapbonhiembanhanh(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Capbonhiembanhanh');
			$kq = $model->xoacapbonhiembanhanh($id);
			echo json_encode($kq);die;
		}
		function chinhsuathongtincapbonhiembanhanh(){
			JSession::checkToken() or die('Invalid Token');
			$form = JRequest::get('post');
			$model = Core::model('Danhmuchethong/Capbonhiembanhanh');
			$kq = $model->updatecapbonhiembanhanh($form);
			echo json_encode($kq);die;
		}
		function xoanhieucapbonhiembanhanh(){
			$id = JRequest::get('id');
			$model = Core::model('Danhmuchethong/Capbonhiembanhanh');
			$kq = $model->xoanhieucapbonhiembanhanh($id);
			echo json_encode($kq);die;
		}
		function xuatdscbnbh(){
			header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_capbonhiembanhanh.xls"'); 
	        header('Cache-Control: max-age=0');
			$model = Core::model('Danhmuchethong/Capbonhiembanhanh');
			$kq = $model->xuat_excel();
			echo json_encode(true);die;
		}
	}
?>