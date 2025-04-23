<?php 
Class DanhmucControllerQuocgia extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinquocgia(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Quocgia');
    	echo json_encode($model->addquocgia($form));
    	die;
    }
    function xoaquocgia(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Quocgia');
    	echo json_encode($model->xoaquocgia($id));die;
    }
    function chinhsuathongtinquocgia(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Quocgia');
    	echo json_encode($model->updatequocgia($form));
    	die;
    }
    function xoanhieuquocgia(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Quocgia');
        $kq = $model->deletemanyquocgia($id);
        echo json_encode($kq);die;
    }
    function xuatdsquocgia(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_quocgia.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Quocgia');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}