<?php
Class DanhmucControllerLoaiphucap extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinloaiphucap(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Loaiphucap');
        $kq     = $model->addloaiphucap($form);
        echo json_encode($kq);die; 
    }
    function xoaloaiphucap(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Loaiphucap');
        $kq = $model->deleteLoaiphucap($id);
        echo json_encode($kq);die;
    }
    function xoanhieuloaiphucap(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Loaiphucap');
        $kq = $model->deletemanyLoaiphucap($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinloaiphucap(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Loaiphucap');
        $kq     = $model->updateLoaiphucap($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsloaiphucap(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_Loaiphucap.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Loaiphucap');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}