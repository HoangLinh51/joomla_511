<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseModel;

defined('_JEXEC') or die('Restricted Access');
class Danhmuchethong_Model_Party_pos extends BaseModel
{
	function findparty_posbyname($tk_party_pos)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('code,name,level,status,daxoa');
		$query->from('party_pos_code');
		$query->where('name' . " LIKE '%$tk_party_pos%'");
		$query->where('daxoa!=1');
		$query->order('code asc');
		// echo $query;die;
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function addparty_pos($form)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$columns = ('name,level,status,daxoa');
		$values = array($db->quote($form['name']), $db->quote($form['level']), $db->quote($form['status']), 0);
		$query->insert('party_pos_code')->columns($columns)->values(implode(',', $values));
		$db->setQuery($query);
		return $db->execute();
	}
	function xoaparty_pos($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$condition = 'code=' . $id['id'];
		$query->update('party_pos_code');
		$query->set('daxoa=1');
		$query->where($condition);
		// echo $query;die;
		$db->setQuery($query);
		return $db->execute();
	}
	function findparty_pos($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$condition = 'code=' . $id;
		$query->select('code,name,level,status,daxoa');
		$query->from('party_pos_code');
		$query->where($condition);
		$query->where('daxoa!=1');
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	function updateparty_pos($form)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$field = array(
			$db->quotename('name') . '=' . $db->quote($form['name']),
			$db->quotename('level') . '=' . $db->quote($form['level']),
			$db->quotename('status') . '=' . $db->quote($form['status'])
		);
		$condition = $db->quotename('code') . '=' . $db->quote($form['id']);
		$query->update('party_pos_code')->set($field)->where($condition);
		$db->setQuery($query);
		return $db->execute();
	}
	function xoanhieuparty_pos($id)
	{
		$db = Factory::getDbo();
		for ($i = 0; $i < count($id); $i++) {
			$query = $db->getQuery(true);
			$query->update('party_pos_code');
			$query->set('daxoa=1');
			$query->where('code=' . $id[$i]);
			$db->setQuery($query);
			$result = $db->execute();
		}
		return $result;
	}

	function updateStatus($id, $state)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->update('party_pos_code');
		$query->set('status=' . $state);
		$query->where('code=' . $id);
		$db->setQuery($query);
		$result = $db->execute();

		return $result;
	}
	// function xuat_excel(){
	// 	require 'components/com_danhmuc/classes/PHPExcel.php';        
	//     $PHPExcel = new PHPExcel();
	//     $PHPExcel->setActiveSheetIndex(0);
	//     $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	//     $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách Chức vụ Đảng');
	//     $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	//     $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	//     $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	//     $PHPExcel->getActiveSheet()->setCellValue('C3','Tên Chức vụ Đảng');
	//     $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	//     $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	//     $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	//     $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	//     $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	//     $timkiem_party_pos = JRequest::getVar('ten');
	//     $model = Core::model('Danhmuchethong/Party_pos');
	//     $ds_party_pos = $model->findparty_posbyname($timkiem_party_pos);

	//     $rowNumber = 4;
	//     foreach($ds_party_pos as $index=>$item){  
	//         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	//         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
	//         $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['status']);
	//         $rowNumber++;
	//     }
	//     $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->applyFromArray(array(
	//         'borders' => array(
	//             'allborders' => array(
	//                 'style' => PHPExcel_Style_Border::BORDER_THIN,
	//                 // 'color' => array('rgb' => 'DDDDDD')
	//             )
	//         )
	//     ));
	//     $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//     $PHPExcel->getActiveSheet()->getStyle('B3:D'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	//     $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
	//     $objWriter->save('php://output'); 
	// }
}
