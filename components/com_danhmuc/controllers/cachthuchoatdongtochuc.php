<?php 
	class DanhmucControllerCachthuchoatdongtochuc extends DanhmucController{
		function themthongtincthdtochuc(){
	        JSession::checkToken() or die('Invalid Token');
	        $jinput = JFactory::getApplication()->input;
	        $form   = $jinput->get('frm',array(),'array');
	        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
	        $model = Core::model('Danhmuckieubao/Cachthuchoatdongtochuc');
	        // var_dump($form);die;
	        $kq     = $model->addcthdtochuc($form);
	        
	        //var_dump($form);die;
	        echo json_encode($kq);die;
	    }
	    function xoacthdtochuc(){
	    	$jinput = JFactory::getApplication()->input;
	        $id     = $jinput->getInt('id',0);
	        if($id>0){
	        	$model = Core::model('Danhmuckieubao/Cachthuchoatdongtochuc');
	        	$kq = $model->deletecthdtc($id);
	        	echo json_encode($kq);die;
	        }
	        echo json_encode(false);die;        
	    }
	    function xoanhieu_cthdtc(){
	        $jinput = JFactory::getApplication()->input;
	        $id     = $jinput->get('id',array(),'array');
	        $model = Core::model('Danhmuckieubao/Cachthuchoatdongtochuc');
	        $kq = $model->deleteManyCthdTochuc($id);
	        Core::printJson($kq);die;
	    }
	    function suathongtincthdtochuc(){
	        JSession::checkToken() or die('Invalid Token');
	       	$jinput = JFactory::getApplication()->input;
	        $form   = $jinput->get('frm',array(),'array');
	        // var_dump($form);die;
	        $model = Core::model('Danhmuckieubao/Cachthuchoatdongtochuc');
	        $kq     = $model->updatecthdtochuc($form);   
	        echo json_encode($kq);die;
	    }
	    function xuatds_cthdtochuc(){
	        header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_cachthuchoatdongtochuc.xls"'); 
	        header('Cache-Control: max-age=0');
	        // $model  = JModelLegacy::getInstance('Nghenghiep','DanhmucModel');
	        $model = Core::model('Danhmuckieubao/Cachthuchoatdongtochuc');
	        $model->export_excel_cthdtochuc();
	        echo json_encode(true);die; 
	    }
	}
?>