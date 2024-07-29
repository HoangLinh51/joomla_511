<?php 
	defined('_JEXEC') or die('Restricted Access');
	class Danhmuchethong_Model_Country extends JModelLegacy{
		function findcountrybyname($tk_country){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name,daxoa');
			$query->from('country_code');
			$query->where('name'." LIKE ".$db->quote('%'.$tk_country.'%'));
			$query->where('daxoa!=1');
			$query->order('code asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		function addcountry($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('name,daxoa');
			$values = array($db->quote($form['name']),0);
			$query->insert('country_code')->columns($columns)->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		function xoacountry($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'code='.$db->quote($id['id']);
			$query->update('country_code');
			$query->set('daxoa=1');
			$query->where($condition);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		function findcountry($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'code='.$db->quote($id);
			$query->select('code,name,daxoa');
			$query->from('country_code');
			$query->where($condition);
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		function updatecountry($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']));
			$condition = $db->quotename('code').'='.$db->quote($form['id']);
			$query->update('country_code')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		function xoanhieucountry($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('country_code');
				$query->set('daxoa=1');
				$query->where('code='.$db->quote($id['id'][$i]));
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
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách quốc gia');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên quốc gia');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_country = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Country');
	        $ds_country = $model->findcountrybyname($timkiem_country);

	        $rowNumber = 4;
	        foreach($ds_country as $index=>$item){  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
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