<?php 
Class DanhmucControllerQuanhegiadinh extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinquanhegiadinh(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Quanhegiadinh');
    	echo json_encode($model->addquanhegiadinh($form));
    	die;
    }
    function xoaquanhegiadinh(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Quanhegiadinh');
    	echo json_encode($model->xoaquanhegiadinh($id));die;
    }
    function chinhsuathongtinquanhegiadinh(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Quanhegiadinh');
    	echo json_encode($model->updatequanhegiadinh($form));
    	die;
    }
    function xoanhieuquanhegiadinh(){
    	$id     = JRequest::get('id');	
        $model = Core::model('Danhmuckieubao/Quanhegiadinh');
        $kq = $model->deletemanyquanhegiadinh($id);
        echo json_encode($kq);die;
    }
    function xuatdsquanhegiadinh(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_quanhegiadinh.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Quanhegiadinh');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}