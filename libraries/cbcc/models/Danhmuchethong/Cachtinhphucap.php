<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Cachtinhphucap extends JModelLegacy {

    function findctpcbyname($timkiem_tenctpc) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten,sapxep,trangthai,daxoa');
        $query->from($db->quoteName('danhmuc_cachtinhphucap'));
        if($timkiem_tenctpc!=null){
            $query->where('ten'." LIKE ".$db->quote('%'.$timkiem_tenctpc.'%'));
            //echo $query;die;
        }

        $query->where('daxoa!=1');
        $query->order('sapxep asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function addctpc($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $columns = array('ten','trangthai','daxoa');
        $values = array($db->quote($form['ten']),$db->quote($form['trangthai']),0);
        $query->insert($db->quotename('danhmuc_cachtinhphucap'))->columns($columns)->values(implode(',', $values));
        $db->setQuery($query);
        //echo $query;die;
        return($db->query());
    }

    function deleteCachtinhphucap($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('danhmuc_cachtinhphucap'));
        $query->set('daxoa=1');
        $query->where($db->quotename('id') . "=".$db->quote($id['id']));
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyCachtinhphucap($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('danhmuc_cachtinhphucap'));
            $query->set('daxoa=1');
            $query->where($db->quotename('id') . "=".$db->quote($id1));
            $db->setQuery($query);
            $result = $db->execute();
        }
        return $result;
    }
    function findctpc($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array($db->quotename('id'), $db->quotename('ten'), $db->quotename('trangthai'));
        $condition = array($db->quotename('id') . "=".$db->quote($id));
        $query->select($name)->from($db->quotename('danhmuc_cachtinhphucap'))->where($condition);
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function updateCachtinhphucap($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('ten') . '=' . $db->quote($form['ten']), 
                    $db->quotename('trangthai') . '=' . $db->quote($form['trangthai']));
        $condition = $db->quotename('id') . '=' . $db->quote($form['id']);
        $query->update($db->quotename('danhmuc_cachtinhphucap'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }   
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách cách tính phụ cấp');
        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
        $timkiem_tenctpc = JRequest::getVar('ten');
        $model = JModelLegacy::getInstance('Cachtinhphucap', 'DanhmucModel');
        $ds_luongcoso = $model->findctpcbyname($timkiem_tenctpc);

        $rowNumber = 4;
        foreach($ds_luongcoso as $index=>$item){  
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['ten']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['trangthai']);
            $rowNumber++;
        }
        $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'DDDDDD')
                )
            )
        ));
        $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
}