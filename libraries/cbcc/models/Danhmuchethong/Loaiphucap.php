<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Loaiphucap extends JModelLegacy {

    function findloaiphucapbyname($timkiem_tenloaiphucap) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('id,tenloaiphucap,donvitinh,cachtinh,giatrimacdinh,colinhvuc,congaynangtieptheo,theochucvu,trangthaisudung',$db->quotename('key'),'sonamtangphucap,muctangphucap');
        $query->select($name);
        $query->from($db->quoteName('danhmuc_loaiphucap'));
        if($timkiem_tenloaiphucap!=null){
            $query->where('tenloaiphucap'." LIKE ".$db->quote('%'.$timkiem_tenloaiphucap.'%'));
            //echo $query;die;
        }
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function getalldonvitinh() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten');
        $query->from($db->quoteName('danhmuc_donvitinhphucap'));
        // $query->where('daxoa != 1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function getallcachtinh() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten');
        $query->from($db->quoteName('danhmuc_cachtinhphucap'));
        // $query->where('daxoa != 1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function addloaiphucap($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $columns = array('tenloaiphucap,donvitinh,cachtinh,giatrimacdinh,colinhvuc,congaynangtieptheo,theochucvu,trangthaisudung',$db->quotename('key'),'sonamtangphucap,muctangphucap');
        $values = array($db->quote($form['tenloaiphucap']),$db->quote($form['donvitinh']),$db->quote($form['cachtinh']),
                        $db->quote($form['giatrimacdinh']),$db->quote($form['colinhvuc']),$db->quote($form['congaynangtieptheo']),
                        $db->quote($form['theochucvu']),$db->quote($form['trangthaisudung']),$db->quote($form['key']),
                        $db->quote($form['sonamtangphucap']),$db->quote($form['muctangphucap']));
        $query->insert($db->quotename('danhmuc_loaiphucap'))->columns($columns)->values(implode(',', $values));
        $db->setQuery($query);
        //echo $query;die;
        return($db->query());
    }

    function deleteLoaiphucap($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quotename('danhmuc_loaiphucap'));
        $query->set('daxoa=1');
        $query->where($db->quotename('id') . "=".$db->quote($id['id']));
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }
    function deletemanyLoaiphucap($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id['id']);$i++){
            $id1 = $id['id'][$i];
            $query = $db->getQuery(true);
            $query->update($db->quotename('danhmuc_loaiphucap'));
            $query->set('daxoa=1');
            $query->where($db->quotename('id') . "=".$db->quote($id1));
            $db->setQuery($query);
            $result = $db->execute();
        }
        return $result;
    }
    function findloaiphucap($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = array('id,tenloaiphucap,donvitinh,cachtinh,giatrimacdinh,colinhvuc,congaynangtieptheo,theochucvu,trangthaisudung',$db->quotename('key'),'sonamtangphucap,muctangphucap,daxoa');
        $condition = array($db->quotename('id') . "=".$db->quote($id));
        $query->select($name)->from($db->quotename('danhmuc_loaiphucap'))->where($condition);
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function updateLoaiphucap($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $field = array($db->quotename('tenloaiphucap') . '=' . $db->quote($form['tenloaiphucap']),
                        $db->quotename('donvitinh') . '=' . $db->quote($form['donvitinh']),
                        $db->quotename('cachtinh') . '=' . $db->quote($form['cachtinh']),
                        $db->quotename('giatrimacdinh') . '=' . $db->quote($form['giatrimacdinh']),
                        $db->quotename('colinhvuc') . '=' . $db->quote($form['colinhvuc']),
                        $db->quotename('congaynangtieptheo') . '=' . $db->quote($form['congaynangtieptheo']),
                        $db->quotename('theochucvu') . '=' . $db->quote($form['theochucvu']), 
                        $db->quotename('trangthaisudung') . '=' . $db->quote($form['trangthaisudung']),
                        $db->quotename('key') . '=' . $db->quote($form['key']),
                        $db->quotename('sonamtangphucap') . '=' . $db->quote($form['sonamtangphucap']),
                        $db->quotename('muctangphucap') . '=' . $db->quote($form['muctangphucap']));
        $condition = $db->quotename('id') . '=' . $db->quote($form['id']);
        $query->update($db->quotename('danhmuc_loaiphucap'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }   
    function export_excel(){   
        require 'components/com_danhmuc/classes/PHPExcel.php';        
        $PHPExcel = new PHPExcel();
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->mergeCells('E1:G1');
        $PHPExcel->getActiveSheet()->setCellValue('E1','Danh sách loại phụ cấp');
        $PHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true)->setSize(20);
        $PHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên loại phụ cấp');
        $PHPExcel->getActiveSheet()->setCellValue('D3','Đơn vị tính');
        $PHPExcel->getActiveSheet()->setCellValue('E3','Cách tính');
        $PHPExcel->getActiveSheet()->setCellValue('F3','Giá trị mặc định');
        $PHPExcel->getActiveSheet()->setCellValue('G3','Có lĩnh vực');
        $PHPExcel->getActiveSheet()->setCellValue('H3','Có ngày nâng tiếp theo');
        $PHPExcel->getActiveSheet()->setCellValue('I3','Theo chức vụ');
        $PHPExcel->getActiveSheet()->setCellValue('J3','Trạng thái sử dụng');
        $PHPExcel->getActiveSheet()->setCellValue('K3','Key');
        $PHPExcel->getActiveSheet()->setCellValue('L3','Số năm tăng phụ cấp');
        $PHPExcel->getActiveSheet()->setCellValue('M3','Mức tăng phụ cấp');
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
        $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $PHPExcel->getActiveSheet()->getStyle("B3:M3")->getFont()->setBold(true);
        $timkiem_tenloaiphucap = JRequest::getVar('ten');
        $model = JModelLegacy::getInstance('Loaiphucap', 'DanhmucModel');
        $ds_luongcoso = $model->findloaiphucapbyname($timkiem_tenloaiphucap);
        $ds_donvitinh = $model->getalldonvitinh();
        $ds_cachtinh = $model->getallcachtinh();
        $rowNumber = 4;
        foreach($ds_luongcoso as $index=>$item){  
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['tenloaiphucap']);
            for($i=0;$i<count($ds_donvitinh);$i++){
                if($ds_donvitinh[$i]['id']==$item['donvitinh']){
                    $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$ds_donvitinh[$i]['ten']);
                }
            }
            for($i=0;$i<count($ds_cachtinh);$i++){
                if($ds_cachtinh[$i]['id']==$item['cachtinh']){
                    $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$ds_cachtinh[$i]['ten']);
                }
            }
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNumber,$item['giatrimacdinh']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNumber,$item['colinhvuc']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNumber,$item['congaynangtieptheo']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowNumber,$item['theochucvu']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowNumber,$item['trangthaisudung']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowNumber,$item['key']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowNumber,$item['sonamtangphucap']);
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowNumber,$item['muctangphucap']);
            $rowNumber++;
        }
        $PHPExcel->getActiveSheet()->getStyle('B3:M'.($rowNumber-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'DDDDDD')
                )
            )
        ));
        $PHPExcel->getActiveSheet()->getStyle('B3:M'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('B3:M'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
}