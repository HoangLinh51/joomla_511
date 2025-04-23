<?php
Class DanhmucControllerLoaidaibieu extends DanhmucController {
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
    function themthongtinloaidaibieu(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('loaidaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $kq     = $model->addloaidaibieu($form);
        
        //var_dump($form);die;
        echo json_encode($kq);die;
    }
    function xoaloaidaibieu(){
        $id     = JRequest::getVar('id');
        // $model  = JModelLegacy::getInstance('loaidaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $kq = $model->deleteloaidaibieu($id);
        echo json_encode($kq);die;
    }
    function xoanhieuloaidaibieu(){
        $id     = JRequest::get('id');
        // $model  = JModelLegacy::getInstance('loaidaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $kq = $model->deletemanyloaidaibieu($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinloaidaibieu(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        // $model  = JModelLegacy::getInstance('loaidaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $kq     = $model->updateloaidaibieu($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsnn(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_loaidaibieu.xls"'); 
        header('Cache-Control: max-age=0');
        // $model  = JModelLegacy::getInstance('loaidaibieu','DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $model->export_excel();
        echo json_encode(true);die; 
    }
    function danhsachloaidaibieu(){         
        // $model = JModelLegacy::getInstance('loaidaibieu', 'DanhmucModel');
        $model = Core::model('Danhmuchethong/Loaidaibieu');
        $data = $model->getDanhsachloaidaibieu();
        echo json_encode($data);
    }
}