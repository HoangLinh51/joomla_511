<?php
Class DanhmucControllerCachtinhphucap extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinctpc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        // $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $kq     = $model->addctpc($form);
        echo json_encode($kq);die; 
    }
    function xoactpc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $kq = $model->deleteCachtinhphucap($id);
        echo json_encode($kq);die;
    }
    function xoanhieuctpc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $kq = $model->deletemanyCachtinhphucap($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinctpc(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $kq     = $model->updateCachtinhphucap($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsctpc(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_Cachtinhphucap.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Cachtinhphucap');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}