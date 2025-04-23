<?php 
Class DanhmucControllerLydoonuocngoai extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinlydoonuocngoai(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Lydoonuocngoai');
    	echo json_encode($model->addlydoonuocngoai($form));
    	die;
    }
    function xoalydoonuocngoai(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuckieubao/Lydoonuocngoai');
    	echo json_encode($model->xoalydoonuocngoai($id));die;
    }
    function chinhsuathongtinlydoonuocngoai(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuckieubao/Lydoonuocngoai');
    	echo json_encode($model->updatelydoonuocngoai($form));
    	die;
    }
    function xoanhieulydoonuocngoai(){
    	$id     = JRequest::get('id');	
    	// var_dump($id);die;
        $model = Core::model('Danhmuckieubao/Lydoonuocngoai');
        $kq = $model->deletemanylydoonuocngoai($id);
        echo json_encode($kq);die;
    }
    function xuatdslydoonuocngoai(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_lydoonuocngoai.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Lydoonuocngoai');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}