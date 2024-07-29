<?php
/**
* @file: Utils.php
* @author: huuthanh3108@gmaill.com
* @date: 03-04-2015
* @company : http://dnict.vn
* 
**/
class Search_Model_Utils{
    public function renderTemplate($user_share,$attachment_code,$result){
        
        $mapperAttachment = Core::model('Core/Attachment');
        //$mapper = ();
        $attachment = $mapperAttachment->getRowByCode($attachment_code);
        if ($attachment == null) {
            return null;
        }
        $config =  Core::config();
        $old_file = $attachment['folder'].'/'.$attachment['code'];
        if (file_exists($old_file)) {
            $new_file =$config->tmp_path.'/'.$attachment['code'].$attachment['filename'];            
            if (copy($old_file, $new_file)) {
                require_once JPATH_LIBRARIES.'/phpexcel/Classes/PHPExcel/IOFactory.php';
                $ext = end(explode('.', $attachment['filename']));
                $readerType = 'Excel5';
                if (strtoupper($ext) =='XLSX') {
                    $readerType = 'Excel2007';
                }
                $baseRow = 5;
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $objReader = PHPExcel_IOFactory::createReader($readerType);
                $objPHPExcel = $objReader->load($new_file);
            }
        }

        
    }
}