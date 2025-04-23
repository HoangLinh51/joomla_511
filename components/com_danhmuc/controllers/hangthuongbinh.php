<?php
Class DanhmucControllerhangthuongbinh extends DanhmucController {
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
    function themthongtinhangthuongbinh(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('hangthuongbinh','DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $kq     = $model->addhangthuongbinh($form);
        
        //var_dump($form);die;
        echo json_encode($kq);die;
    }
    function xoahangthuongbinh(){
        $id     = JRequest::getVar('id');
        // $model  = JModelLegacy::getInstance('hangthuongbinh','DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $kq = $model->deletehangthuongbinh($id);
        echo json_encode($kq);die;
    }
    function xoanhieuhangthuongbinh(){
        $id     = JRequest::get('id');
        // $model  = JModelLegacy::getInstance('hangthuongbinh','DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $kq = $model->deletemanyhangthuongbinh($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinhangthuongbinh(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('hangthuongbinh','DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $kq     = $model->updatehangthuongbinh($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsnn(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_hangthuongbinh.xls"'); 
        header('Cache-Control: max-age=0');
        // $model  = JModelLegacy::getInstance('hangthuongbinh','DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $model->export_excel();
        echo json_encode(true);die; 
    }
    function danhsachhangthuongbinh(){         
        // $model = JModelLegacy::getInstance('hangthuongbinh', 'DanhmucModel');
        $model = Core::model('Danhmuchethong/Hangthuongbinh');
        $data = $model->getDanhsachhangthuongbinh();
        echo json_encode($data);
    }
}