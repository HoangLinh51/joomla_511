<?php
class Danhmuchethong_Model_Phuongxa extends JModelLegacy {
 	function findphuongxabynameorcode($tk_tenphuongxa,$matp,$maqh){
 		$db = JFactory::getDbo();
 		$query= $db->getQuery(true);
 		$name= array($db->quotename('dc_cadc_code'),$db->quotename('dc_code'),$db->quotename('code'),$db->quotename('name'),$db->quotename('status'),$db->quotename('muctuongduong'));
 		$condition = array($db->quotename('name').'LIKE'.$db->quote('%'.$tk_tenphuongxa.'%'),
                            $db->quotename('dc_code').'LIKE'.$db->quote('%'.$maqh.'%'),
                            $db->quotename('dc_cadc_code').'LIKE'.$db->quote('%'.$matp.'%'),
                            'daxoa!=1');
 		$query->select($name)->from($db->quotename('comm_code'))->where($condition)->order('code ASC');
 		$db->setQuery($query);
 		return $db->loadAssocList();
 	}
 	function addphuongxa($form){
 		$db = JFactory::getDbo();
 		$query = $db->getQuery(true);
 		$columns= array($db->quotename('dc_cadc_code'),$db->quotename('dc_code'),$db->quotename('name'),$db->quotename('type'),$db->quotename('status'),$db->quotename('muctuongduong'),$db->quotename('daxoa'));
 		$values= array($db->quote($form['dc_cadc_code']),$db->quote($form['dc_code']),$db->quote($form['name']),$db->quote($form['type']),$db->quote($form['muctuongduong']),$db->quote($form['status']),0);
 		$query->insert($db->quotename('comm_code'))->columns($columns)->values(implode(',',$values));
 		$db->setQuery($query);

 		return $db->execute();
 	}
 	function xoaphuongxa($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('comm_code'));
        $query->set('daxoa=1');
        $query->where($db->quotename('code') . "=".$db->quote($id));
        $db->setQuery($query);
        return $db->execute();
    }
    function findphuongxa($id){
    	$db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('dc_cadc_code','dc_code','code','name','status','muctuongduong');
        $query->select($name)->from('comm_code')->where($db->quotename('code')."=".$db->quote($id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    function updatephuongxa($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('dc_cadc_code').'='.$db->quote($form['dc_cadc_code']),
                        $db->quotename('dc_code').'='.$db->quote($form['dc_code']),
                        $db->quotename('name') . '=' . $db->quote($form['name']),
                        $db->quotename('status') . '=' . $db->quote($form['status']),
                        $db->quotename('muctuongduong'). '=' . $db->quote($form['muctuongduong']));
        $condition = $db->quotename('code') . '=' . $db->quote($form['code']);
        $query->update($db->quotename('comm_code'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyphuongxa($id){
    	$db = JFactory::getDbo();
    	for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('comm_code'));
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
    function getallquanhuyen(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('cadc_code','code','name','status');
        $query->select($name)->from('dist_code')->where($db->quotename('status')."=1");
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    function findquanhuyenbythanhpho($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('cadc_code','code','name');
        $query->select($name)->from('dist_code')->where($db->quotename('cadc_code')."=".$db->quote($id['id']),$db->quotename('daxoa')."!=1");
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    function findquanhuyenbythanhpho1($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('cadc_code','code','name');
        $query->select($name)->from('dist_code')->where($db->quotename('cadc_code')."=".$db->quote($id),$db->quotename('daxoa')."!=1");
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên phường xã');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
        $PHPExcel->getActiveSheet()->setCellValue('E3','Mức tương đương');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        // $PHPExcel->getActiveSheet()->getStyle('B3:F3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $PHPExcel->getActiveSheet()->getStyle("B3:E3")->getFont()->setBold(true);
        $timkiem_name = JRequest::getVar('ten');
        $matp = JRequest::getVar('matp');
        $maqh = JRequest::getVar('maqh'); 
        $model = Core::model('Danhmuckieubao/Phuongxa');
        $ds_kv = $model->findphuongxabynameorcode($timkiem_name,$matp,$maqh);
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