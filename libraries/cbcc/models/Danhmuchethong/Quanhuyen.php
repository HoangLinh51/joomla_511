<?php
class Danhmuchethong_Model_Quanhuyen extends JModelLegacy {
 	function findquanhuyenbynameorcode($tk_tenquanhuyen,$timkiem_codetp){
 		$db = JFactory::getDbo();
 		$query= $db->getQuery(true);
 		$name= array($db->quotename('cadc_code'),$db->quotename('code'),$db->quotename('name'),$db->quotename('status'),$db->quotename('muctuongduong'));
 		$condition = array($db->quotename('name').'LIKE'.$db->quote('%'.$tk_tenquanhuyen.'%'),
                            $db->quotename('cadc_code').'LIKE'.$db->quote('%'.$timkiem_codetp.'%'),
                            'daxoa!=1');
 		$query->select($name)->from($db->quotename('dist_code'))->where($condition)->order('code ASC');
 		$db->setQuery($query);
 		return $db->loadAssocList();
 	}
 	function addquanhuyen($form){
 		$db = JFactory::getDbo();
 		$query = $db->getQuery(true);
 		$columns= array($db->quotename('cadc_code'),$db->quotename('name'),$db->quotename('type'),$db->quotename('status'),$db->quotename('muctuongduong'),$db->quotename('daxoa'));
 		$values= array($db->quote($form['cadc_code']),$db->quote($form['name']),$db->quote($form['type']),$db->quote($form['muctuongduong']),$db->quote($form['status']),0);
 		$query->insert($db->quotename('dist_code'))->columns($columns)->values(implode(',',$values));
 		$db->setQuery($query);

 		return $db->execute();
 	}
 	function xoaquanhuyen($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('dist_code'));
        $query->set('daxoa=1');
        $query->where($db->quotename('code') . "=".$db->quote($id));
        $db->setQuery($query);
        return $db->execute();
    }
    function findquanhuyen($id){
    	$db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('cadc_code','code','name','status','muctuongduong');
        $query->select($name)->from('dist_code')->where($db->quotename('code')."=".$db->quote($id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    function updatequanhuyen($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('cadc_code').'='.$db->quote($form['cadc_code']),
                        $db->quotename('name') . '=' . $db->quote($form['name']),
                        $db->quotename('status') . '=' . $db->quote($form['status']),
                        $db->quotename('muctuongduong'). '=' . $db->quote($form['muctuongduong']));
        $condition = $db->quotename('code') . '=' . $db->quote($form['code']);
        $query->update($db->quotename('dist_code'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyquanhuyen($id){
    	$db = JFactory::getDbo();
    	for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('dist_code'));
            $query->set('daxoa=1');
            $query->where($db->quotename('code') . "=".$db->quote($id1));
            $db->setQuery($query);
            $result = $db->execute();
        }
        return $result;
    }
    function getallthanhpho(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('code','name','status');
        $query->select($name)->from('city_code')->where($db->quotename('status')."=1");
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên quận huyện');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
        $PHPExcel->getActiveSheet()->setCellValue('E3','Mức tương đương');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        // $PHPExcel->getActiveSheet()->getStyle('B3:F3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $PHPExcel->getActiveSheet()->getStyle("B3:E3")->getFont()->setBold(true);
        $timkiem_name = JRequest::getVar('ten');
        $timkiem_code = JRequest::getVar('ma');
        $model = Core::model('Danhmuckieubao/Quanhuyen');
        $ds_kv = $model->findquanhuyenbynameorcode($timkiem_code, $timkiem_name);
        $rowNumber = 4;
        foreach($ds_kv as $index=>$item){  
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['status']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$item['muctuongduong']);
            $rowNumber++;
        }
        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'DDDDDD')
                )
            )
        ));
        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
}