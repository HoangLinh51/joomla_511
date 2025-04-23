<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class DanhmucControllerHinhthucduhoc extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinhinhthucduhoc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
        $kq     = $model->addhtdh($form);
        echo json_encode($kq);die;
    }
    function xoahinhthucduhoc(){
        $id     = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
        $kq     = $model->deletehtdh($id);
        echo json_encode($kq);die;
    }
    function xoanhieuhinhthucduhoc(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
        $kq = $model->deletemanyhtdh($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinhinhthucduhoc(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
        $kq     = $model->updatehtdh($form);
        echo json_encode($kq);die;
    }
    function xuatdshtdh(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_hinhthucduhoc.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}