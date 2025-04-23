<?php 
Class DanhmucControllerChuyennganhdaotao extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinchuyennganhdaotao(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
    	echo json_encode($model->addchuyennganhdaotao($form));
    	die;
    }
    function xoachuyennganhdaotao(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
    	echo json_encode($model->xoachuyennganhdaotao($id));die;
    }
    function chinhsuathongtinchuyennganhdaotao(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
    	echo json_encode($model->updatechuyennganhdaotao($form));
    	die;
    }
    function xoanhieuchuyennganhdaotao(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
        $kq = $model->deletemanychuyennganhdaotao($id);
        echo json_encode($kq);die;
    }
    function xuatdscndt(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_chuyennganhdaotao.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}