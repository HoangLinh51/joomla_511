<?php
Class DanhmucControllerLuongcoso extends DanhmucController {
    function __construct($config = array()) {
        parent::__construct($config);
    }
    function themthongtinluongcoso(){
        JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Luongcoso');
        $ds_luongcoso = $model->getallluongcoso();
        for($i=0;$i<count($ds_luongcoso);$i++){
            if(strtotime($form['thoidiemapdung'])>strtotime($ds_luongcoso[$i]['thoidiemapdung'])&&strtotime($form['thoidiemapdung'])<strtotime($ds_luongcoso[$i]['thoidiemhetapdung'])){
                echo json_encode(false);die;
            }
        }
        $today = getdate();
        $currentDate = $today["year"] . "-". $today["mon"] . "-".$today["mday"] ;
        $tomorrow_date = $today["year"].'-'.$today['mon'].'-'.($today['mday']-1);
        $time = '00:00:00';
        $tomorrow= $tomorrow_date.' '.$time;
        $stt = count($ds_luongcoso)-1;
        $id = $ds_luongcoso[$stt]['id'];
        if(strtotime($form['thoidiemapdung'])<strtotime($currentDate)){
            $kq     = $model->addluongcoso($form);
            echo json_encode($kq);die;
        }
        else{
            $result = $model->updateenddate($tomorrow,$id);
            $kq1     = $model->addluongcoso($form);
            echo json_encode($kq1);die;
        }
        
    }
    function xoathongtinluongcoso(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Luongcoso');
        $kq = $model->deleteluongcoso($id);
        echo json_encode($kq);die;
    }
    function xoanhieuluongcoso(){
        $id     = JRequest::get('id');
        $model = Core::model('Danhmuchethong/Luongcoso');
        $kq = $model->deletemanyluongcoso($id);
        echo json_encode($kq);die;
    }
    function chinhsuathongtinluongcoso(){
        JSession::checkToken() or die('Invalid Token');
        //echo 'aaaaa';die;
        $form   = JRequest::get('post');
        $model = Core::model('Danhmuchethong/Luongcoso');
        $kq     = $model->updateluongcoso($form);
        
        echo json_encode($kq);die;
    }
    function xuatdsluongcoso(){
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ds_luongcoso.xls"'); 
        header('Cache-Control: max-age=0');
        $model = Core::model('Danhmuchethong/Luongcoso');
        $model->export_excel();
        echo json_encode(true);die; 
    }
}