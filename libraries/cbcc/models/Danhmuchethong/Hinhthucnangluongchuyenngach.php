<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Hinhthucnangluongchuyenngach extends JModelLegacy {

    function timkiem_hinhthucnangluongchuyenngach($ten_hinhthuc_nlcn){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,name,status,is_nangluonglansau,is_nhaptien,is_nhapngaynangluong,phantramsotienhuong');
        $query->from($db->quoteName('whois_sal_mgr'));
        if($ten_hinhthuc_nlcn!=null){
            $query->where('name'." LIKE ".$db->quote('%'.$ten_hinhthuc_nlcn.'%'));
            //echo $query;die;
        }
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();
        return $result;
    }
    function getall_hinhthuc_nlcn(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,mucluong,thoidiemapdung,thoidiemhetapdung,ngaytao,nguoitao,ngaysua,nguoisua');
        $query->from($db->quoteName('tl_dm_hinhthuc_nlcn'));
        $query->where('daxoa!=1');
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    function add_hinhthuc_nlcn($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if($form['status']==''){
            $status = 0;
        }
        else{
            $status = $form['status'];
        }
        $field = array($db->quotename('name').'='.$db->quote($form['name']),
                    $db->quotename('is_nangluonglansau').'='.$db->quote($form['is_nangluonglansau']),
                    $db->quotename('is_nhaptien').'='.$db->quote($form['is_nhaptien']),
                    $db->quotename('is_nhapngaynangluong').'='.$db->quote($form['is_nhapngaynangluong']),
                    $db->quotename('phantramsotienhuong').'='.$db->quote($form['phantramsotienhuong']),
                    $db->quotename('status').'='.$db->quote($status));
        $query->insert('whois_sal_mgr');
        $query->set($field);        
        $db->setQuery($query);
        return $db->query();
    }

    function delete_hinhthuc_nlcn($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->delete('whois_sal_mgr');
        $query->where($db->quotename('id') . "=".$db->quote($id));
        $db->setQuery($query);
        return $db->query();
    }
    function deletemany_hinhthuc_nlcn($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id);$i++){
            $id1 = $id[$i];
            $result[] = $this->delete_hinhthuc_nlcn($id1);
        }
        return $result;
    }
    function find_hinhthuc_nlcn($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,name,status,is_nangluonglansau,is_nhaptien,is_nhapngaynangluong,phantramsotienhuong');
        $query->from($db->quotename('whois_sal_mgr'));
        $query->where('id='.$db->quote($id));
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function update_hinhthuc_nlcn($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if($form['status']==''){
            $status = 0;
        }
        else{
            $status = $form['status'];
        }
        $field = array($db->quotename('name').'='.$db->quote($form['name']),
                    $db->quotename('is_nangluonglansau').'='.$db->quote($form['is_nangluonglansau']),
                    $db->quotename('is_nhaptien').'='.$db->quote($form['is_nhaptien']),
                    $db->quotename('is_nhapngaynangluong').'='.$db->quote($form['is_nhapngaynangluong']),
                    $db->quotename('phantramsotienhuong').'='.$db->quote($form['phantramsotienhuong']),
                    $db->quotename('status').'='.$db->quote($status));
        $query->update('whois_sal_mgr');
        $query->set($field);
        $query->where('id='.$db->quote($form['id']));        
        $db->setQuery($query);
        return $db->query();
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
        $model = JModelLegacy::getInstance('_hinhthuc_nlcn', 'DanhmucModel');
        $ds__hinhthuc_nlcn = $model->find_hinhthuc_nlcnbyname($timkiem_luong);

        $rowNumber = 4;
        foreach($ds__hinhthuc_nlcn as $index=>$item){  
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
        $query->update($db->quotename('tl_dm_hinhthuc_nlcn'))->set($field)->where($condition);
        $db->setQuery($query);
        $result = $db->execute();
        return $result; 
    }
}