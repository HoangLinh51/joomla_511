<?php 
	defined('_JEXEC') or die('Restricted Access');
	class Danhmuchethong_Model_Linhvuc extends JModelLegacy{
		public function findlinhvucbyname($tk_tenlinhvuc){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,daxoa');
			$query->from($db->quotename('function_code'));
			$query->where('name LIKE '.$db->quote('%'.$tk_tenlinhvuc.'%'));
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addlinhvuc($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns= ('name,status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert($db->quotename('function_code'));
			$query->columns($columns);
			$query->values(implode(',',$values));
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function findlinhvuc($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,daxoa');
			$query->from($db->quotename('function_code'));
			$query->where('id='.$db->quote($id));
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatelinhvuc($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update($db->quotename('function_code'));
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoalinhvuc($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = $db->quotename('id').'='.$db->quote($id['id']);
			$query->update($db->quotename('function_code'));
			$query->set('daxoa=1');
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieulinhvuc($id){
			$db = JFactory::getDbo();
			// var_dump($id);
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update($db->quotename('function_code'));
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));

				$db->setQuery($query);
				$result= $db->query();
			}
			return $result;
		}
		public function xuat_excellinhvuc(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách lĩnh vực');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên lĩnh vực');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_linhvuc = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Linhvuc');
	        $ds_linhvuc = $model->findlinhvucbyname($timkiem_linhvuc);

	        $rowNumber = 4;
	        foreach($ds_linhvuc as $index=>$item){ 
	        	if($item['status']==1){
	        		$status = 'Đang hoạt động';
	        	} 
	        	else{
	        		$status = 'Không hoạt động';
	        	}  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$status);
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