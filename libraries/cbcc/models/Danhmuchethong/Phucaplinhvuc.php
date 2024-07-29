<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Phucaplinhvuc extends JModelLegacy {

    function findPhucaplinhvucbyname($timkiem_tenPhucaplinhvuc) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('id,tenlinhvuc,loaiphucap_id,sonamtangphucap,muctangphucap,status,daxoa');
        $query->select($name);
        $query->from($db->quoteName('danhmuc_phucaplinhvuc'));
        if($timkiem_tenPhucaplinhvuc!=null){
            $query->where('tenlinhvuc'." LIKE ".$db->quote('%'.$timkiem_tenPhucaplinhvuc.'%'));
            //echo $query;die;
        }

        $query->where('daxoa != 1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function getallloaiphucap() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tenloaiphucap');
        $query->from($db->quoteName('danhmuc_loaiphucap'));
        $query->where('daxoa != 1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function addPhucaplinhvuc($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $columns = array('tenlinhvuc,loaiphucap_id,sonamtangphucap,muctangphucap,status,daxoa');
        $values = array($db->quote($form['tenlinhvuc']),$db->quote($form['loaiphucap_id']),$db->quote($form['sonamtangphucap']),
                        $db->quote($form['muctangphucap']),$db->quote($form['status']),0);
        $query->insert($db->quotename('danhmuc_phucaplinhvuc'))->columns($columns)->values(implode(',', $values));
        $db->setQuery($query);
        //echo $query;die;
        return($db->query());
    }

    function deletePhucaplinhvuc($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('danhmuc_phucaplinhvuc'));
        $query->set('daxoa=1');
        $query->where($db->quotename('id') . "=".$db->quote($id['id']));
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyPhucaplinhvuc($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('danhmuc_phucaplinhvuc'));
            $query->set('daxoa=1');
            $query->where($db->quotename('id') . "=".$db->quote($id1));
            $db->setQuery($query);
            $result = $db->execute();
        }
        return $result;
    }
    function findphucaplinhvuc($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('id,tenlinhvuc,loaiphucap_id,sonamtangphucap,muctangphucap,status,daxoa');
        $condition = array($db->quotename('id') . "=".$db->quote($id));
        $query->select($name)->from($db->quotename('danhmuc_phucaplinhvuc'))->where($condition);
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function updatePhucaplinhvuc($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('tenlinhvuc') . '=' . $db->quote($form['tenlinhvuc']),
                        $db->quotename('loaiphucap_id') . '=' . $db->quote($form['loaiphucap_id']),
                        $db->quotename('sonamtangphucap') . '=' . $db->quote($form['sonamtangphucap']),
                        $db->quotename('muctangphucap') . '=' . $db->quote($form['muctangphucap']),
                        $db->quotename('status') . '=' . $db->quote($form['status']),);
        $condition = $db->quotename('id') . '=' . $db->quote($form['id']);
        $query->update($db->quotename('danhmuc_phucaplinhvuc'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }   
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->mergeCells('D1:E1');
        $PHPExcel->getActiveSheet()->setCellValue('D1','Danh sách phụ cấp lĩnh vực');
        $PHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setBold(true)->setSize(20);
        $PHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên lĩnh vực');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Tên loại phụ cấp');
        $PHPExcel->getActiveSheet()->setCellValue('E3','Số năm tăng phụ cấp');
        $PHPExcel->getActiveSheet()->setCellValue('F3','Mức tăng phụ cấp');
        $PHPExcel->getActiveSheet()->setCellValue('G3','Trạng thái');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $PHPExcel->getActiveSheet()->getStyle("B3:G3")->getFont()->setBold(true);
        $timkiem_tenPhucaplinhvuc = JRequest::getVar('ten');
        $model = JModelLegacy::getInstance('Phucaplinhvuc', 'DanhmucModel');
        $ds_luongcoso = $model->findPhucaplinhvucbyname($timkiem_tenPhucaplinhvuc);
        $ds_loaiphucap= $model->getallloaiphucap();
        $rowNumber = 4;
        foreach($ds_luongcoso as $index=>$item){  
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['tenlinhvuc']);
            for($i=0;$i<count($ds_loaiphucap);$i++){
                if($ds_loaiphucap[$i]['id']==$item['loaiphucap_id']){
                    $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$ds_loaiphucap[$i]['tenloaiphucap']);
                }
            }
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$item['sonamtangphucap']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNumber,$item['muctangphucap']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNumber,$item['status']);
            $rowNumber++;
        }
        $PHPExcel->getActiveSheet()->getStyle('B3:G'.($rowNumber-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'DDDDDD')
                )
            )
        ));
        $PHPExcel->getActiveSheet()->getStyle('B3:G'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('B3:G'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
}