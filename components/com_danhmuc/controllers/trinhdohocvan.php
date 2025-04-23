<?php 
Class DanhmucControllerTrinhdohocvan extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themmoithongtintdhv(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Trinhdohocvan');
    	echo json_encode($model->addtdhv($form));
    	die;
    }
    function xoatdhv(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Trinhdohocvan');
    	echo json_encode($model->xoatdhv($id));die;
    }
    function chinhsuathongtintdhv(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Trinhdohocvan');
    	echo json_encode($model->updatetdhv($form));
    	die;
    }
    function xoanhieutdhv(){
    	$id     = JRequest::get('id');
        $model = Core::model('Danhmuckieubao/Trinhdohocvan');
        $kq = $model->deletemanytdhv($id);
        echo json_encode($kq);die;
    }
    function xuatdstdhv(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_trinhdohocvan.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Trinhdohocvan');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}