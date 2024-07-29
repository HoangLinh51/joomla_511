<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Luongcoso extends JModelLegacy {

    function findluongcosobyname($timkiem_luong) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,mucluong,thoidiemapdung,thoidiemhetapdung,ngaytao,nguoitao,ngaysua,nguoisua');
        $query->from($db->quoteName('tl_dmluongcoso'));
        if($timkiem_luong!=null){
            $query->where('mucluong'." LIKE ".$db->quote('%'.$timkiem_luong.'%'));
            //echo $query;die;
        }

        $query->where('daxoa!=1');
        $query->order('thoidiemapdung asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function getallluongcoso(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,mucluong,thoidiemapdung,thoidiemhetapdung,ngaytao,nguoitao,ngaysua,nguoisua');
        $query->from($db->quoteName('tl_dmluongcoso'));
        $query->where('daxoa!=1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function addluongcoso($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        // $thoidiemapdung = $form['thoidiemapdung']+$form['thoidiemapdung_time'];
        // echo $thoidiemapdung;die;
        $columns = array('mucluong','thoidiemapdung','thoidiemhetapdung','ngaytao','nguoitao','ngaysua','nguoisua','daxoa');
        $values = array($db->quote($form['mucluong']), $db->quote($form['thoidiemapdung'].' '.$form['thoidiemapdung_time']), 
                        $db->quote($form['thoidiemhetapdung'].' '.$form['thoidiemhetapdung_time']),
                        $db->quote($form['ngaytao'].' '.$form['ngaytao_time']),$db->quote($form['nguoitao']),
                        $db->quote($form['ngaysua'].' '.$form['ngaysua_time']),$db->quote($form['nguoisua']),0);
        $query->insert($db->quotename('tl_dmluongcoso'))->columns($columns)->values(implode(',', $values));
        $db->setQuery($query);
        //echo $query;die;
        return($db->query());
    }

    function deleteluongcoso($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('tl_dmluongcoso'));
        $query->set('daxoa=1');
        $query->where($db->quotename('id') . "=".$db->quote($id['id']));
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyluongcoso($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('tl_dmluongcoso'));
            $query->set('daxoa=1');
            $query->where($db->quotename('id') . "=".$db->quote($id1));
            $db->setQuery($query);
            $result = $db->execute();
        }
        return $result;
    }
    function findluongcoso($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array($db->quotename('id'), $db->quotename('mucluong'), $db->quotename('thoidiemapdung'), $db->quotename('thoidiemhetapdung'),$db->quotename('ngaytao'),$db->quotename('nguoitao'),$db->quotename('ngaysua'),$db->quotename('nguoisua'), $db->quotename('daxoa'));
        $condition = array($db->quotename('id') . "=".$db->quote($id));
        $query->select($name)->from($db->quotename('tl_dmluongcoso'))->where($condition);
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function updateluongcoso($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('mucluong') . '=' . $db->quote($form['mucluong']), 
                    $db->quotename('thoidiemapdung') . '=' . $db->quote($form['thoidiemapdung'].' '.$form['thoidiemapdung_time']),
                    $db->quotename('thoidiemhetapdung') . '=' . $db->quote($form['thoidiemhetapdung'].' '.$form['thoidiemhetapdung_time']),
                    $db->quotename('ngaytao').'='.$db->quote($form['ngaytao'].' '.$form['ngaytao_time']),
                    $db->quotename('nguoitao') . '=' . $db->quote($form['nguoitao']),
                    $db->quotename('ngaysua').'='.$db->quote($form['ngaysua'].' '.$form['ngaysua_time']),
                    $db->quotename('nguoisua') . '=' . $db->quote($form['nguoisua']));
        $condition = $db->quotename('id') . '=' . $db->quote($form['id']);
        $query->update($db->quotename('tl_dmluongcoso'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }   
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->mergeCells('E1:F1');
        $PHPExcel->getActiveSheet()->setCellValue('E1','Danh sách lương cơ sở');
        $PHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true)->setSize(20);
        $PHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Mức lương');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Thời điểm áp dụng');
        $PHPExcel->getActiveSheet()->setCellValue('E3','Thời điểm hết áp dụng');
        $PHPExcel->getActiveSheet()->setCellValue('F3','Ngày tạo');
        $PHPExcel->getActiveSheet()->setCellValue('G3','Người tạo');
        $PHPExcel->getActiveSheet()->setCellValue('H3','Ngày sửa');
        $PHPExcel->getActiveSheet()->setCellValue('I3','Người sửa');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $PHPExcel->getActiveSheet()->getStyle("B3:I3")->getFont()->setBold(true);
        $timkiem_luong = JRequest::getVar('ten');
        $model = JModelLegacy::getInstance('Luongcoso', 'DanhmucModel');
        $ds_luongcoso = $model->findluongcosobyname($timkiem_luong);

        $rowNumber = 4;
        foreach($ds_luongcoso as $index=>$item){  
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['mucluong']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['thoidiemapdung']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$item['thoidiemhetapdung']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNumber,$item['ngaytao']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNumber,$item['nguoitao']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNumber,$item['ngaysua']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowNumber,$item['nguoisua']);
            $rowNumber++;
        }
        $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'DDDDDD')
                )
            )
        ));
        $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
    function updateenddate($tomorrow,$id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = $db->quotename('thoidiemhetapdung')."='$tomorrow'";
        $condition = $db->quotename('id') . "='$id'";
        $query->update($db->quotename('tl_dmluongcoso'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result; 
    }
}