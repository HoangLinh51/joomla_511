<?php

/**
* @file: ajax.php
* @author: nguyennpb@danang.gov.vn
* @date: 01-08-2012
* @company : http://dnict.vn
**/
namespace Joomla\Component\Core\Site\Controller;

use Core;
use CoresController;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Uri\Uri;

\defined('_JEXEC') or die;

class AttachmentController extends BaseController{

    function __construct($config = array()) {
        parent::__construct ( $config );
        $user = & Factory::getUser ();
        if ($user->id == null) {
            if (Factory::getApplication()->input->getVar('format') == 'raw') {
                echo '<script> window.location.href="index.php?option=com_users&view=login"; </script>';
                exit;
            }else{
                $this->setRedirect ( "index.php?option=com_users&view=login" );
            }
            	
        }
    }
    function display($cachable = false, $urlparams = array())
    {
        $document    = Factory::getDocument();
        $viewName    = Factory::getApplication()->input->getVar( 'view', 'attachment');
        $viewLayout  = Factory::getApplication()->input->getVar( 'layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView( $viewName, $viewType);
        $view->setLayout($viewLayout);
        $view->display();
    }

    function doattachment() {
        $formData = Factory::getApplication()->input->post->getArray();
    
        // Multiple files will be stored in an array
        $files = $_FILES['uploadfile'];
        $date = getdate();
        $from = $formData['from'];
        $is_nogetcontent = $formData['is_nogetcontent'];
        $is_new = $formData['is_new'];
        $iddiv = $formData['iddiv'];
    
        $year = $formData['year'] ?? $date['year'];
        $type = $formData['type'] ?? -1;
        $idObject = $formData['idObject'] ?? 0;
        $isTemp = $formData['isTemp'] ?? 0;
        $pdf = $formData['pdf'] ?? 0;
        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $dirPath = $mapper->getDir($date['year'], $date['mon']);
    
        // Loop through all uploaded files
        if(count($files['name']) <= 5){
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] == 0) {
                    $new_name = md5($files['name'][$i] . time());
                    $data = array(
                        'folder' => $dirPath,
                        'object_id' => $idObject,
                        'code' => $new_name,
                        'mime' => $files['type'][$i],
                        'url' => '#',
                        'filename' => $files['name'][$i],
                        'type_id' => $type,
                        'created_by' => $user->id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $mapper->create($data); 
                    $uploadfile = $dirPath . '/' . basename($new_name);
                    if (move_uploaded_file($files['tmp_name'][$i], $uploadfile)) {
                        $url = 'index.php?option=com_core&view=attachment&format=raw&task=input&iddiv='.$iddiv.'&idObject='.$idObject.'&is_new='.$is_new.'&year='.$year.'&type='.$type."&pdf=".$pdf."&is_nogetcontent=".$is_nogetcontent;
                        echo "<script>window.parent.loadDivFromUrl('".$iddiv."','$url"."');</script>";
                    } else {
                        echo "Possible file upload attack on file " . $files['name'][$i] . "!\n";
                    }
                }
            }
        }else{
            // echo  "Bạn đã đính kèm vượt quá giới hạn file cho phép";
            echo "<script>window.parent.appendHtmlDiv('".$iddiv."-error','Bạn đã đính kèm vượt quá giới hạn file cho phép"."');</script>";
        }
        
        exit;
    }
    

    function doattachment_old(){
        $formData = Factory::getApplication()->input->post->getArray();
        var_dump($formData);
       
        $file = $_FILES['uploadfile'];
        var_dump($file);exit;
        if ($file['error'] == 0) {
            //$adapter = new Zend_File_Transfer_Adapter_Http();
            //Lay tham so nhan tu client
            $date = getdate();
            $from=$formData['from'];
            $is_nogetcontent= $formData['is_nogetcontent'];
            $is_new = $formData['is_new'];
            $iddiv= $formData['iddiv'];
          
            $year = '2015'; //nam cua bang du lieu
            $type = $formData['type'];
            if(!$type)
                $type = -1;
            if(!$year)
                $year = $date['year'];
            $idObject = $formData['idObject'];//id cua doi tuong chua file dinh kem
            if(!$idObject)
                $idObject = 0;
            $isTemp = $formData['isTemp'];
            if(!$isTemp)
                $isTemp = 0;
            $pdf = $formData['pdf'];
            if(!$pdf)
                $pdf = 0;
            $user = Factory::getUser();
            $mapper = Core::model('Core/Attachment');
            //$mapper = new CoreAttachment_Model_AttachmentMapper(); //doi tuong model
            $dirPath = $mapper->getDir($date['year'],$date['mon']);
            // $dirPath = $mapper->getTempPath();
            $new_name = md5($file['name'].time());
            $data = array(
                'folder'=> $dirPath,
                'object_id'=> $idObject,
                'code'=> $new_name,
                'mime'=> $file['type'],
                'url'=> '#',
                'filename'=> $file['name'],
                'type_id'=> $type,
                'created_by'=> $user->id,
                'created_at'=> date('Y-m-d H:i:s')
            );
           $mapper->create($data); 
           $uploadfile = $dirPath .'/'. basename($new_name);
           if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
                $url = 'index.php?option=com_core&view=attachment&format=raw&task=input&iddiv='.$iddiv.'&idObject='.$idObject.'&is_new='.$is_new.'&year='.$year.'&type='.$type."&pdf=".$pdf."&is_nogetcontent=".$is_nogetcontent;
                echo "<script>window.parent.loadDivFromUrl('".$iddiv."','$url"."'); </script>";
           } else {
               echo "Possible file upload attack!\n";
           }

           exit;
        }

    }

    function doattachment_new(){
        // $formData = Factory::getApplication()->get('post');
        $app = Factory::getApplication()->input;
        $formData = array(
            'from' => $app->getVar('from', ""),
            'is_nogetcontent' => $app->getInt('is_nogetcontent', 0),
            'is_new' => $app->getInt('is_new', 0),
            'iddiv' => $app->getVar('iddiv', ""),
            'type' => $app->getVar('type', ""),
            'year' => $app->getVar('year', ""),
            'idObject' => $app->getInt('idObject', 0),
            'isTemp' => $app->getVar('isTemp', ""),
            'pdf' => $app->getVar('pdf', "")
        );
        $response = [];
        $file = $_FILES['file'];
     
        if ($file['error'] == 0) {
            //$adapter = new Zend_File_Transfer_Adapter_Http();
            //Lay tham so nhan tu client
            $date = getdate();
            $from=$formData['from'];
            $is_nogetcontent= $formData['is_nogetcontent'];
            $is_new = $formData['is_new'];
            $iddiv= $formData['iddiv'];
            $year = $date['year']; //nam cua bang du lieu
            $type = $formData['type'];
            if(!$type)
                $type = -1;
            if(!$year)
                $year = $date['year'];
            $idObject = $formData['idObject'];//id cua doi tuong chua file dinh kem
            if(!$idObject)
                $idObject = 0;
            $isTemp = $formData['isTemp'];
            if(!$isTemp)
                $isTemp = 0;
            $pdf = $formData['pdf'];
            if(!$pdf)
                $pdf = 0;
            $user = Factory::getUser();
            $mapper = Core::model('Core/Attachment');
            $dirPath = $mapper->getDir($date['year'],$date['mon']);
            // $dirPath = $mapper->getTempPath();
            $new_name = md5($file['name'].time());
            $data = array(
                'folder'=> $dirPath,
                'object_id'=> $idObject,
                'code'=> $new_name,
                'mime'=> $file['type'],
                'url'=> '#',
                'filename'=> $file['name'],
                'type_id'=> $type,
                'created_by'=> $user->id,
                'created_at'=> date('Y-m-d H:i:s')
            );
           
            $mapper->create($data); 
            $uploadfile = $dirPath .'/'. basename($new_name);
            if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
                $fileUrl = "index.php?option=com_core&controller=attachment&format=raw&task=download&year=".$year."&code=".$new_name."";
                echo json_encode(['success' => true, 'file' => $file['name'], 'fileUrl' => $fileUrl, 'code' => $new_name]);
                // array_push($response, ['success' => true, 'file' => $file['name'], 'fileUrl' => $fileUrl]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
            
            }
        }
        Factory::getApplication()->close();

    }

    function doDinhKemMotFile(){
        $formData = Factory::getApplication()->get('post');
        $file = $_FILES['uploadfile'];
        for($i=0; $i<count($file['name']); $i++){
            if ($file['error'][$i] == 0) {
                // kiểm tra size
                //if(ini_get('upload_max_filesize')*1024*1024< $file[$i]['size']){ echo "Quá dung lượng cho phép";die;}
                //Lay tham so nhan tu client
                $date = getdate();
                $from=$formData['from'];
                $is_nogetcontent= $formData['is_nogetcontent'];
                $is_new = $formData['is_new'];
                // var_dump($formData);exit;
                $iddiv= $formData['iddiv'];
                $year = date('Y'); //nam cua bang du lieu
                $type = $formData['type'];
                if(!$type)
                    $type = -1;
                if(!$year)
                    $year = $date['year'];
                $idObject = $formData['idObject'];//id cua doi tuong chua file dinh kem
                if(!$idObject)
                    $idObject = 0;
                $isTemp = $formData['isTemp'];
                if(!$isTemp)
                    $isTemp = 0;
                $pdf = $formData['pdf'];
                if(!$pdf)
                    $pdf = 0;
                $user = Factory::getUser();
                $mapper = Core::model('Core/Attachment');
                $dirPath = $mapper->getTempPath();
                $new_name = md5($file['name'][$i] .time());
                $data = array(
                    'folder'=> $dirPath,
                    'object_id'=> $idObject,
                    'code'=> $new_name,
                    'mime'=> $file['type'][$i],
                    'url'=> '#',
                    'filename'=> $file['name'][$i],
                    'type_id'=> $type,
                    'created_by'=> $user->id,
                    'created_at'=> date('Y-m-d H:i:s')
                );
               $mapper->create($data); 
               $uploadfile = $dirPath .'/'. basename($new_name);
               if (move_uploaded_file($file['tmp_name'][$i], $uploadfile)) {
                    $url = 'index.php?option=com_core&controller=attachment&format=raw&task=dinhKemMotFile&iddiv='.$iddiv.'&idObject='.$idObject.'&is_new='.$is_new.'&year='.$year.'&type='.$type."&pdf=".$pdf."&is_nogetcontent=".$is_nogetcontent;
                    echo "<script>window.parent.loadDivFromUrl('".$iddiv."','$url"."'); </script>";
               } else {
                   echo "Lỗi không upload được tập tin\n";
               }
               
            }else{
                echo '<br>- Tập tin '.$file['name'][$i].' không hợp lệ !';
            }
        }
        die;
    }

   public function delete(){
        $date = getdate();
        $year =  Factory::getApplication()->input->getInt('year',0);
        $iddiv=  Factory::getApplication()->input->getVar('iddiv');
        $is_new = 0;
        //truongvc attachment for traodoi module
        $from = Factory::getApplication()->input->getVar('from');
        if(!$year)
            $year = $date['year'];
        $code = Factory::getApplication()->input->getVar('maso');
        $idObject = Factory::getApplication()->input->getVar('idObject');
        if(!$idObject)
            $idObject = 0;
        $isTemp = Factory::getApplication()->input->getVar('isTemp');
        if(!$isTemp)
            $isTemp = 0;
        $type = Factory::getApplication()->input->getVar('type');
        $arr_code = Factory::getApplication()->input->getVar('DELidfiledk'.$idObject);
        $pdf = Factory::getApplication()->input->getVar('pdf');
        $is_nogetcontent = Factory::getApplication()->input->getVar('is_nogetcontent');
        $mapper = Core::model('Core/Attachment');
        //var_dump($arr_code);exit;
        for($i=0 ; $i< count($arr_code);$i++){
            $mapper->deleteFileByMaso($arr_code[$i]);
        }
        $url = Uri::root(true).'/index.php?option=com_core&view=attachment&format=raw&task=input&iddiv='.$iddiv.'&idObject='.$idObject.'&is_new='.$is_new.'&year='.$year.'&type='.$type."&pdf=".$pdf."&is_nogetcontent=".$is_nogetcontent;
        echo "<script>window.parent.loadDivFromUrl('".$iddiv."','$url"."'); </script>";
        exit;
    }

    public function deleteOneFile(){
        $date = getdate();
        $year =  Factory::getApplication()->input->getInt('year',0);
        $iddiv=  Factory::getApplication()->input->getVar('iddiv');
        $is_new = 0;
        //truongvc attachment for traodoi module
        $from = Factory::getApplication()->input->getVar('from');
        if(!$year)
            $year = $date['year'];
        $code =     Factory::getApplication()->input->getVar('maso');
        $idObject = Factory::getApplication()->input->getVar('idObject');
        if(!$idObject)
            $idObject = 0;
        $isTemp = Factory::getApplication()->input->getVar('isTemp');
        if(!$isTemp)
            $isTemp = 0;
        $type = Factory::getApplication()->input->getVar('type');
        $arr_code = Factory::getApplication()->input->getVar('DELidfiledk'.$idObject);
        $pdf = Factory::getApplication()->input->getVar('pdf');
        $is_nogetcontent = Factory::getApplication()->input->getVar('is_nogetcontent');
        $mapper = Core::model('Core/Attachment');
        //var_dump($arr_code);exit;
        for($i=0 ; $i< count($arr_code);$i++){
            $mapper->deleteFileByMaso($arr_code[$i]);
        }
        
        //$this->_redirect($url);
        //echo "parent.loadDivFromUrl('".$iddiv."','$url"."',1);";
        $url = Uri::root(true).'/index.php?option=com_core&controller=attachment&format=raw&task=dinhKemMotFile&iddiv='.$iddiv.'&idObject='.$idObject.'&is_new='.$is_new.'&year='.$year.'&type='.$type."&pdf=".$pdf."&is_nogetcontent=".$is_nogetcontent;
        echo "<script>window.parent.loadDivFromUrl('".$iddiv."','$url"."'); </script>";
        exit;
    }

    public function updatetypebycode(){
        $formData = Factory::getApplication()->input->get('post');
        $mapper = Core::model('Core/Attachment');
        for ($i = 0; $i < count($formData["idFile"]); $i ++) {
            $mapper->updateTypeIdByCode($formData["idFile"][$i],$formData['type_id'],true);
        }
        //var_dump($formData);
        //exit;
    }
    public function download(){
        $date = getdate();
        $code = Factory::getApplication()->input->getVar('code');
        $mapper = Core::model('Core/Attachment');       
        $file = $mapper->getRowByCode($code);
        if(null != $file['code']){
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header( "Content-type:".$file['mime']);
            header( 'Content-Disposition: attachment; filename="'.$file['filename'].'"' );
            echo file_get_contents($file['folder'].'/'.$file['code']);
        }
        exit;
    }
    public function fixedFileNotCopy(){
        $user_id = Factory::getApplication()->input->getUser()->id;
        if($user_id == '1'){
            $model = Core::model('Core/Attachment');
            $model->fixedFileNotCopy();
            $data = Factory::getApplication()->get('post');
            var_dump($data);exit;
        }else{
            echo '';exit;
        }
    }
}