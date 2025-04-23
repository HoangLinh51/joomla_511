<?php 
Class DanhmucControllerPhuongxa extends DanhmucController{
	function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinphuongxa(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Phuongxa');
    	echo json_encode($model->addphuongxa($form));
    	die;
    }
    function xoaphuongxa(){
    	$id = JRequest::getVar('id');
    	$model = Core::model('Danhmuchethong/Phuongxa');
    	echo json_encode($model->xoaphuongxa($id));die;
    }
    function chinhsuathongtinphuongxa(){
    	JSession::checkToken() or die('Invalid Token');
    	$form = JRequest::get('post');
    	$model = Core::model('Danhmuchethong/Phuongxa');
    	echo json_encode($model->updatephuongxa($form));
    	die;
    }
    function xoanhieuphuongxa(){
    	$id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Phuongxa');
        $kq = $model->deletemanyphuongxa($id);
        echo json_encode($kq);die;
    }
    function findquanhuyenbythanhpho(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Phuongxa');
        $kq     = $model->findquanhuyenbythanhpho($id);
        echo json_encode($kq);die;
    }
    function xuatdsphuongxa(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_phuongxa.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Phuongxa');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}