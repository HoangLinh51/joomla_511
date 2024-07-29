<?php 
	defined('_JEXEC') or die('Restricted Access');
	class Danhmuchethong_Model_Cyu extends JModelLegacy{
		function findcyubyname($tk_cyu){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,level,status,daxoa');
			$query->from('cyu_code');
			$query->where('name'." LIKE".$db->quote('%'.$tk_cyu.'%'));
			$query->where('daxoa!=1');
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		function addcyu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('name,level,status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['level']),$db->quote($form['status']),0);
			$query->insert('cyu_code')->columns($columns)->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		function xoacyu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id['id']);
			$query->update('cyu_code');
			$query->set('daxoa=1');
			$query->where($condition);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		function findcyu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id);
			$query->select('id,name,level,status,daxoa');
			$query->from('cyu_code');
			$query->where($condition);
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		function updatecyu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('level').'='.$db->quote($form['level']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('cyu_code')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		function xoanhieucyu($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('cyu_code');
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
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách chức vụ Đoàn');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên chức vụ Đoàn');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_cyu = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Cyu');
	        $ds_cyu = $model->findcyubyname($timkiem_cyu);

	        $rowNumber = 4;
	        foreach($ds_cyu as $index=>$item){  
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