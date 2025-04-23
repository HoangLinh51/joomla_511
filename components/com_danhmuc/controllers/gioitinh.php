<?php 
Class DanhmucControllerGioitinh extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtingioitinh(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Gioitinh');
    	echo json_encode($model->addgioitinh($form));
    	die;
    }
    function xoagioitinh(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Gioitinh');
    	echo json_encode($model->xoagioitinh($id));die;
    }
    function chinhsuathongtingioitinh(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Gioitinh');
    	echo json_encode($model->updategioitinh($form));
    	die;
    }
    function xoanhieugioitinh(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Gioitinh');
        $kq = $model->deletemanygioitinh($id);
        echo json_encode($kq);die;
    }
    function xuatdsgioitinh(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_gioitinh.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Gioitinh');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}