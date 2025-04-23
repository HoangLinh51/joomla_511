<?php 
Class DanhmucControllerThanhpho extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinthanhpho(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Thanhpho');
    	echo json_encode($model->addthanhpho($form));
    	die;
    }
    function xoathanhpho(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuchethong/Thanhpho');
    	echo json_encode($model->xoathanhpho($id));die;
    }
    function chinhsuathongtinthanhpho(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Thanhpho');
    	echo json_encode($model->updatethanhpho($form));
    	die;
    }
    function xoanhieuthanhpho(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuchethong/Thanhpho');
        $kq = $model->deletemanythanhpho($id);
        echo json_encode($kq);die;
    }
    function xuatdsthanhpho(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_thanhpho.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Thanhpho');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}