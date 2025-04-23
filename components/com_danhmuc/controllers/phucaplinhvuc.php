<?php
Class DanhmucControllerPhucaplinhvuc extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinphucaplinhvuc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Phucaplinhvuc');
        $kq     = $model->addPhucaplinhvuc($form);
        echo json_encode($kq);die; 
    }
    function xoaphucaplinhvuc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Phucaplinhvuc');
        $kq = $model->deletePhucaplinhvuc($id);
        echo json_encode($kq);die;
    }
    function xoanhieuphucaplinhvuc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Phucaplinhvuc');
        $kq = $model->deletemanyPhucaplinhvuc($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinphucaplinhvuc(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Phucaplinhvuc');
        $kq     = $model->updatePhucaplinhvuc($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsphucaplinhvuc(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_Phucaplinhvuc.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Phucaplinhvuc');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}