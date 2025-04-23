<?php
Class DanhmucControllerDonvitinhphucap extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtindvtpc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Donvitinhphucap');
        $kq     = $model->adddvtpc($form);
        echo json_encode($kq);die; 
    }
    function xoadvtpc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Donvitinhphucap');
        $kq = $model->deleteDonvitinhphucap($id);
        echo json_encode($kq);die;
    }
    function xoanhieudvtpc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Donvitinhphucap');
        $kq = $model->deletemanyDonvitinhphucap($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtindvtpc(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Donvitinhphucap');
        $kq     = $model->updateDonvitinhphucap($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsdvtpc(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_Donvitinhphucap.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Donvitinhphucap');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}