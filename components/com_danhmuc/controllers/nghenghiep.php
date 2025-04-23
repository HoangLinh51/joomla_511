<?php
Class DanhmucControllerNghenghiep extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }

    // function display() {
    //     $document = JFactory::getDocument();
    //     $viewName = JRequest::getVar('view', 'kieubao');
    //     $viewLayout = JRequest::getVar('layout', 'default');
    //     $viewType = $document->getType();

    //     $view = $this->getView($viewName, $viewType);

    //     $view->setLayout($viewLayout);
    //     $view->display();
    // }

//    function chinhsua() {
//        echo 1;
//        die;
//        $post = $_POST['id'];
//        $form = JRequest::get('post');
//        var_dump($post);
//        var_dump($form);
//        die;
//    }
    function themthongtinnghenghiep(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $kq     = $model->addjob($form);
        
        //var_dump($form);die;
        echo json_encode($kq);die;
    }
    function xoanghenghiep(){
        $id     = JRequest::getVar('id');
        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $kq = $model->deletejob($id);
        echo json_encode($kq);die;
    }
    function xoanhieunghenghiep(){
        $id     = JRequest::get('id');
        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $kq = $model->deletemanyjob($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinnghenghiep(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $kq     = $model->updatejob($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsnn(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_nghenghiep.xls"'); 
        header('Cache-Control: max-age=0');
        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $model->export_excel();
        echo json_encode(true);die; 
    }
    function danhsachnghenghiep(){         
        // $model = JModelLegacy::getInstance('Nghenghiep', 'DanhmucModel');
        $model = Core::model('Danhmuckieubao/Nghenghiep');
        $data = $model->getDanhsachNghenghiep();
        echo json_encode($data);
    }
}