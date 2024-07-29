<?php 
	defined('_JEXEC') or die('Restricted Access');
	class Danhmuchethong_Model_Sex extends JModelLegacy{
		function findsexbyname($tk_sex){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,daxoa');
			$query->from('sex_code');
			$query->where('name'." LIKE ".$db->quote('%'.$tk_sex.'%'));
			$query->where('daxoa!=1');
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		function addsex($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('id,name,status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert('sex_code')->columns($columns)->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		function xoasex($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id['id']);
			$query->update('sex_code');
			$query->set('daxoa=1');
			$query->where($condition);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		function findsex($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id);
			$query->select('id,name,status,daxoa');
			$query->from('sex_code');
			$query->where($condition);
			$query->where('daxoa!=1');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		function updatesex($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('sex_code')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		function xoanhieusex($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('sex_code');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result = $db->query();
			}
			return $result;
		}
		function xuat_excel(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách giới tính');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên giới tính');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_sex = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Sex');
	        $ds_sex = $model->findsexbyname($timkiem_sex);
	        $rowNumber = 4;
	        foreach($ds_sex as $index=>$item){  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['status']);
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
?>