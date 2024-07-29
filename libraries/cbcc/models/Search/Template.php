<?php
/**
* @file: SearchTemplate.php
* @author: huuthanh3108@gmaill.com
* @date: 02-04-2015
* @company : http://dnict.vn
* 
**/
class Search_Model_Template{
    public function save($formData){		
		$flag = false;
		$table = Core::table('Search/Template');		
		$src['id'] = $formData['id'];
		$src['user_id'] = $formData['user_id'];
		$src['user_share'] = $formData['user_share'];		
		$src['attachment_code'] = $formData['attachment_code'];		
		$table->save($src);
		return $table->id;			
	}
	public function findAll($params = null,$order = null,$offset = null,$limit = null){
	    $table = Core::table('Search/Template');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);
	    $query->select(array('b.filename','b.created_at','b.code','u.name','a.user_share','a.user_id','a.start'))
	           ->from($table->getTableName().' a')
	           ->join('INNER', 'core_attachment b ON b.code = a.attachment_code')
	           ->join('INNER', 'jos_users u ON u.id = a.user_id')
	          
	    ;	    
	    if (isset($params['user_share']) && !empty($params['user_share'])) {
	        $query->where('a.user_share = -1 OR a.user_share = '.$db->quote($params['user_share']));
	    }
	   // echo $q2;
	   //$abc =  $query->union($q2);

	    if ($order == null) {
	        $query->order('b.created_at DESC');
	    }else{
	        $query->order($order);
	    }
	    if($offset != null && $limit != null){
	        $db->setQuery($query,$offset,$limit);
	    }else{
	        $db->setQuery($query);
	    }
	   
	    //echo $query;
	  //  echo $abc;
	    return $db->loadAssocList();
	    //return $table->delete($id);
	}
	public function deteleByAttachmentCodeAndUserShare($attachment_code,$user_share){
	    $table = Core::table('Search/Template');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);

// 	    $query->select('*')
// 	           ->from($table->getTableName())
// 	           ->where(array(
// 	               $db->quoteName('attachment_code') . ' = ' . $db->quote($attachment_code)	              
// 	           ))
// 	    ;
// 	    $item = $db->loadAssoc($query);
	    // delete all custom keys for user 1001.
	    $conditions = array(
	        $db->quoteName('attachment_code') . ' = ' . $db->quote($attachment_code),
	        '('.$db->quoteName('user_share') . ' = ' . $db->quote($user_share) .' OR '. $db->quoteName('user_id'). ' = ' . $db->quote($user_share).')'
	    );
	    $query->delete($db->quoteName($table->getTableName()));
	    //$query->select($columns);
	    $query->where($conditions);
	    $db->setQuery($query);
	    return $db->execute();	
	}
	public function changeRowStart($attachment_code,$value,$user_share){
	    $table = Core::table('Search/Template');
	    $db = $table->getDbo();	    
	    $query = $db->getQuery(true);	    
	    // Fields to update.
	    $fields = array(
	        $db->quoteName('start') . ' = ' . $db->quote($value)
	    );	    
	    // Conditions for which records should be updated.
	    $conditions = array(
	        $db->quoteName('attachment_code') . ' = ' . $db->quote($attachment_code),
	        $db->quoteName('user_share'). ' = ' . $db->quote($user_share)
	    );	    
	    $query->update($db->quoteName($table->getTableName()))->set($fields)->where($conditions);	    
	    $db->setQuery($query);	    
	    return $db->execute();
	}
	function strip_single($tag,$string){
	    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
	    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
	    return $string;
	}
	public function renderTemplate($user_share,$attachment_code,$result){
	    $arrKT=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');
	    ini_set("display_errors",1);
	    ini_set('memory_limit', '-1');
	    set_time_limit(0);
	    $table = Core::table('Search/Template');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);
	    $query->select('*')
	           ->from($table->getTableName())
	           ->where(array(
	               $db->quoteName('attachment_code') . ' = ' . $db->quote($attachment_code),
	               '('.$db->quoteName('user_share') . ' = ' . $db->quote($user_share) .' OR '. $db->quoteName('user_share'). ' = -1)'
	           ))
	    ;
	    $db->setQuery($query);
	    $template = $db->loadAssoc();
	    $mapperAttachment = Core::model('Core/Attachment');
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
	            // require_once JPATH_LIBRARIES.'/phpexcel181/Classes/PHPExcel/IOFactory.php';
	            $ext = end(explode('.', $attachment['filename']));
	            $readerType = 'Excel5';
	            if (strtoupper($ext) =='XLSX') {
	                $readerType = 'Excel2007';
	            }
	            $objReader = PHPExcel_IOFactory::createReader($readerType);
	            PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
	            $objPHPExcel = $objReader->load($new_file);
	            $baseRow = substr($template['start'],1);
	            //var_dump($baseRow);exit;
	            $styleArray = array(
	                'font' => array(
	                    'name' => 'Times New Roman',
	                    'size' => '11',
	                    'bold' => false
	                ),
	                'alignment' => array(
	                    'wrap'       => true,
	                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	                ),
	                'borders' => array(
	                    'allborders' => array(
	                        'style' => PHPExcel_Style_Border::BORDER_THIN
	                    )
	                )
	            );
	            $sheet = $objPHPExcel->getActiveSheet();
	            $sheet->insertNewRowBefore($baseRow,count($result['aData']));	            
	            $elLast = $arrKT[count($result['aColumn'])];
	            $sheet->setCellValueByColumnAndRow(0, $baseRow, 'Stt');
                    for ($i = 0,$n=count($result['aColumn']); $i < $n; $i++) {
                        $sheet->setCellValueByColumnAndRow(($i+1), $baseRow, $result['aColumn'][$i]);
                       // $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $baseRow)->applyFromArray($styleArray, False);
                    }
                    //$row = $baseRow + 1;
                    $row = 1;
                    for ($i = 0,$n=count($result['aData']); $i < $n; $i++) {
                        $row = $baseRow + $i + 1;
                        //var_dump($row);
                        //$sheet->insertNewRowBefore($row,1);
                        $sheet->setCellValueByColumnAndRow(0, $row,($i + 1));
                        for ($j=0,$k=count($result['aData'][$i]);$j<$k;$j++){
                           $result['aData'][$i][$j] = $this->strip_single('a', $result['aData'][$i][$j]);
                           $sheet->setCellValueByColumnAndRow(($j+1), $row,($result['aData'][$i][$j]));
                         //   $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $row)->applyFromArray($styleArray, False);
                        }

                    }
                    //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
                    $sheet->getStyle($template['start'].":".$elLast.$row)->applyFromArray($styleArray, False);
                    //$sheet->getColumnDimension($template['start'].":".$elLast.$row)->setAutoSize(true);
    //             	foreach(range($template['start'],$elLast) as $columnID)
    //             	{
    //             	    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    //             	}
                    //var_dump($objPHPExcel->getActiveSheet()->getHighestDataColumn());
                    foreach(range('A', $elLast) as $columnID) {
                        $sheet->getColumnDimension($columnID)->setAutoSize(true);

                    }
                    //$objPHPExcel->getActiveSheet()->getStByColumnAndRow(0, $n)->applyFromArray($styleArray, False);
                    header("Pragma: public");
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header( "Content-type:".$attachment['mime']);
                    header( 'Content-Disposition: attachment; filename="'.$attachment['filename'].'"' );
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $readerType);
					ob_end_clean();
                    $objWriter->save('php://output');            	
                    //$objWriter->save($config->tmp_path.'/tmp_'.$attachment['code'].$attachment['filename']);
                    //return $config->tmp_path.'/tmp_'.$attachment['code'].$attachment['filename'];           
	        }
	    }
	
	
	}
}