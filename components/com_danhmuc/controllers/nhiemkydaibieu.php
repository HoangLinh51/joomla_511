<?php
Class DanhmucControllerNhiemkydaibieu extends DanhmucController {
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
    function themthongtinnhiemkydaibieu(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('nhiemkydaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $kq     = $model->addnhiemkydaibieu($form);
        
        //var_dump($form);die;
        echo json_encode($kq);die;
    }
    function xoanhiemkydaibieu(){
        $id     = JRequest::getVar('id');
        // $model  = JModelLegacy::getInstance('nhiemkydaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $kq = $model->deletenhiemkydaibieu($id);
        echo json_encode($kq);die;
    }
    function xoanhieunhiemkydaibieu(){
        $id     = JRequest::get('id');
        // $model  = JModelLegacy::getInstance('nhiemkydaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $kq = $model->deletemanynhiemkydaibieu($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinnhiemkydaibieu(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('nhiemkydaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $kq     = $model->updatenhiemkydaibieu($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsnn(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_nhiemkydaibieu.xls"'); 
        header('Cache-Control: max-age=0');
        // $model  = JModelLegacy::getInstance('nhiemkydaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $model->export_excel();
        echo json_encode(true);die; 
    }
    function danhsachnhiemkydaibieu(){         
        // $model = JModelLegacy::getInstance('nhiemkydaibieu', 'DanhmucModel');
        $model = Core::model('Danhmuchethong/Nhiemkydaibieu');
        $data = $model->getDanhsachnhiemkydaibieu();
        echo json_encode($data);
    }
}