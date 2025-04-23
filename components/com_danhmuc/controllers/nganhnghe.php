<?php 
Class DanhmucControllerNganhnghe extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinnganhnghe(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Nganhnghe');
    	echo json_encode($model->addnganhnghe($form));
    	die;
    }
    function xoanganhnghe(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Nganhnghe');
    	echo json_encode($model->xoanganhnghe($id));die;
    }
    function chinhsuathongtinnganhnghe(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Nganhnghe');
    	echo json_encode($model->updatenganhnghe($form));
    	die;
    }
    function xoanhieunganhnghe(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Nganhnghe');
        $kq = $model->deletemanynganhnghe($id);
        echo json_encode($kq);die;
    }
    function xuatdsnganhnghe(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_nganhnghe.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Nganhnghe');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}