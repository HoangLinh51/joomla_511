<?php
Class DanhmucControllerKhuvuc extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function findphuongxabyquanhuyen() {
        
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $kq = $model->findphuongxabyquanhuyen($id);
        
        echo json_encode($kq);die;
    }
    
    function themthongtinkhuvuc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $kq     = $model->addkhuvuc($form);
        echo json_encode($kq);die;
    }
    function xoakhuvuc(){
        $id     = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $kq     = $model->deletekhuvuc($id);
        echo json_encode($kq);die;
    }
    function xoanhieukhuvuc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $kq = $model->deletemanykhuvuc($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinkhuvuc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $kq     = $model->updatekhuvuc($form);       
        echo json_encode($kq);die;
    }
    function xuatdskhuvuc(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_khuvuc.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Khuvuc');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}