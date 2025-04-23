<?php 
Class DanhmucControllerTinhtranglaodong extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinttld(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Tinhtranglaodong');
    	echo json_encode($model->addttld($form));
    	die;
    }
    function xoattld(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Tinhtranglaodong');
    	echo json_encode($model->xoattld($id));die;
    }
    function chinhsuathongtinttld(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Tinhtranglaodong');
    	echo json_encode($model->updatettld($form));
    	die;
    }
    function xoanhieuttld(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Tinhtranglaodong');
        $kq = $model->deletemanyttld($id);
        echo json_encode($kq);die;
    }
    function xuatdsttld(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_tinhtranglaodong.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Tinhtranglaodong');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}