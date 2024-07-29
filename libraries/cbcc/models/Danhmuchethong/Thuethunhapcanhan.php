<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Danhmuchethong_Model_Thuethunhapcanhan extends JModelLegacy {

    function getall_thuetncn(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,bac,tinhthuenam_tu,tinhthuenam_den,tinhthuethang_tu,tinhthue_thang_den,phantramthue,ghichu,trangthai');
        $query->from($db->quotename('danhmuc_thuetncn'));
        $query->order('id asc');
        // echo $query;die;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function check_sql_injection($string){
        $filter = JFilterInput::getInstance();
        return $filter->clean($string,'string');
    }
    function add_thuetncn($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if($form['trangthai']==''){
            $status = 0;
        }
        else{
            $status = $form['trangthai'];
        }
        // $con=mysqli_connect("localhost","root","","test_cbcc");
        // if(mysqli_connect_errno()){
        //     return false;
        // }

        // $ghichu = mysqli_real_escape_string($con,$form['ghichu']);
        $filter = JFilterInput::getInstance();
        $ghichu = $filter->clean($form['ghichu'],'string');
        // echo $ghichu;die;
        // $ghichu = $jinput->getString('ghichu','');
        // jinput filter string sql injection joomla -> string filtered -> db
        // echo $ghichu;die;
        $field = array($db->quotename('bac').'='.$db->quote($form['bac']),
                    $db->quotename('tinhthuenam_tu').'='.$db->quote($form['tinhthuenam_tu']),
                    $db->quotename('tinhthuenam_den').'='.$db->quote($form['tinhthuenam_den']),
                    $db->quotename('tinhthuethang_tu').'='.$db->quote($form['tinhthuethang_tu']),
                    $db->quotename('tinhthue_thang_den').'='.$db->quote($form['tinhthue_thang_den']),
                    $db->quotename('phantramthue').'='.$db->quote($form['phantramthue']),
                    $db->quotename('ghichu').'='.$db->quote($ghichu),
                    $db->quotename('trangthai').'='.$db->quote($status));
        $query->insert('danhmuc_thuetncn');
        $query->set($field);
        // echo $query;die;   
        $db->setQuery($query);
        return $db->query();
    }

    function delete_thuetncn($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->delete('danhmuc_thuetncn');
        $query->where($db->quotename('id') . "=".$db->quote($id));
        $db->setQuery($query);
        return $db->query();
    }
    function deletemany_thuetncn($id){
        $db = JFactory::getDbo(); 
        for($i=0;$i<count($id);$i++){
            $id1 = $id[$i];
            $result[] = $this->delete_thuetncn($id1);
        }
        return $result;
    }
    function find_thuetncn($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,bac,tinhthuenam_tu,tinhthuenam_den,tinhthuethang_tu,tinhthue_thang_den,phantramthue,ghichu,trangthai');
        $query->from($db->quotename('danhmuc_thuetncn'));
        $query->where('id='.$db->quote($id));
        //echo $query;die;
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function update_thuetncn($form) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if($form['trangthai']==''){
            $status = 0;
        }
        else{
            $status = $form['trangthai'];
        }
        $con=mysqli_connect("localhost","root","","test_cbcc");
        if(mysqli_connect_errno()){
            return false;
        }
        $ghichu = mysqli_real_escape_string($con,$form['ghichu']);
        $field = array($db->quotename('bac').'='.$db->quote($form['bac']),
                    $db->quotename('tinhthuenam_tu').'='.$db->quote($form['tinhthuenam_tu']),
                    $db->quotename('tinhthuenam_den').'='.$db->quote($form['tinhthuenam_den']),
                    $db->quotename('tinhthuethang_tu').'='.$db->quote($form['tinhthuethang_tu']),
                    $db->quotename('tinhthue_thang_den').'='.$db->quote($form['tinhthue_thang_den']),
                    $db->quotename('phantramthue').'='.$db->quote($form['phantramthue']),
                    $db->quotename('ghichu').'='.$db->quote($ghichu),
                    $db->quotename('trangthai').'='.$db->quote($status));
        $query->update('danhmuc_thuetncn');
        $query->set($field);
        $query->where('id='.$db->quote($form['id']));        
        $db->setQuery($query);
        return $db->query();
    }   
    // function export_excel(){   
    //     require 'components/com_danhmuc/classes/PHPExcel.php';        
    //     $PHPExcel = new PHPExcel();
    //     $PHPExcel->setActiveSheetIndex(0);
    //     $PHPExcel->getActiveSheet()->mergeCells('E1:F1');
    //     $PHPExcel->getActiveSheet()->setCellValue('E1','Danh sách lương cơ sở');
    //     $PHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true)->setSize(20);
    //     $PHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
    //     $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
    //     $PHPExcel->getActiveSheet()->setCellValue('C3','Mức lương');
    //     $PHPExcel->getActiveSheet()->setCellValue('D3','Thời điểm áp dụng');
    //     $PHPExcel->getActiveSheet()->setCellValue('E3','Thời điểm hết áp dụng');
    //     $PHPExcel->getActiveSheet()->setCellValue('F3','Ngày tạo');
    //     $PHPExcel->getActiveSheet()->setCellValue('G3','Người tạo');
    //     $PHPExcel->getActiveSheet()->setCellValue('H3','Ngày sửa');
    //     $PHPExcel->getActiveSheet()->setCellValue('I3','Người sửa');
    //     $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    //     $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    //     $PHPExcel->getActiveSheet()->getStyle("B3:I3")->getFont()->setBold(true);
    //     $timkiem_luong = JRequest::getVar('ten');
    //     $model = JModelLegacy::getInstance('_thuetncn', 'DanhmucModel');
    //     $ds__thuetncn = $model->find_thuetncnbyname($timkiem_luong);

    //     $rowNumber = 4;
    //     foreach($ds__thuetncn as $index=>$item){  
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['mucluong']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['thoidiemapdung']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$item['thoidiemhetapdung']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNumber,$item['ngaytao']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNumber,$item['nguoitao']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNumber,$item['ngaysua']);
    //         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowNumber,$item['nguoisua']);
    //         $rowNumber++;
    //     }
    //     $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->applyFromArray(array(
    //         'borders' => array(
    //             'allborders' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
    //                 // 'color' => array('rgb' => 'DDDDDD')
    //             )
    //         )
    //     ));
    //     $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //     $PHPExcel->getActiveSheet()->getStyle('B3:I'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    //     $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
    //     $objWriter->save('php://output'); 
    // }
    // function updateenddate($tomorrow,$id){
    //     $db = JFactory::getDbo();
    //     $query = $db->getQuery(true);
    //     $field = $db->quotename('thoidiemhetapdung')."='$tomorrow'";
    //     $condition = $db->quotename('id') . "='$id'";
    //     $query->update($db->quotename('tl_dm_thuetncn'))->set($field)->where($condition);
    //     $db->setQuery($query);
    //     $result = $db->execute();
    //     return $result; 
    // }
}