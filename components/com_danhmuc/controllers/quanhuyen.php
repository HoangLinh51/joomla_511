<?php 
Class DanhmucControllerQuanhuyen extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinquanhuyen(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Quanhuyen');
    	echo json_encode($model->addquanhuyen($form));
    	die;
    }
    function xoaquanhuyen(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuchethong/Quanhuyen');
    	echo json_encode($model->xoaquanhuyen($id));die;
    }
    function chinhsuathongtinquanhuyen(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Quanhuyen');
    	echo json_encode($model->updatequanhuyen($form));
    	die;
    }
    function xoanhieuquanhuyen(){
    	$id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Quanhuyen');
        $kq = $model->deletemanyquanhuyen($id);
        echo json_encode($kq);die;
    }
    function xuatdsquanhuyen(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_quanhuyen.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Quanhuyen');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}