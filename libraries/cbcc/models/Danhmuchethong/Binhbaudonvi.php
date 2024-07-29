<?php 
	defined('_JEXEC') or die('Restricted access');
	class Danhmuchethong_Model_Binhbaudonvi extends JModelLegacy{
		public function findbbdvbyname($tk_tenbinhbaudonvi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = array('name LIKE '.$db->quote('%'.$tk_tenbinhbaudonvi.'%'),'daxoa!=1');
			$query->select('id,name,status,daxoa');
			$query->from('ins_assets');
			$query->where($condition);
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addbbdv($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('name,status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert('ins_assets');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findbbdv($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = array('id='.$db->quote($id),'daxoa!=1');
			$query->select('id,name,status,daxoa');
			$query->from('ins_assets');
			$query->where($condition);
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatebbdv($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('ins_assets')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function deletebbdv($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('ins_assets');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletemanybbdv($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('ins_assets');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result = $db->query();
			}
			return $result;
		}
		public function xuat_excelbbdv(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách bình bầu đơn vị');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên bình bầu đơn vị');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_bbdv = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Binhbaudonvi');
	        $ds_bbdv = $model->findbbdvbyname($timkiem_bbdv);

	        $rowNumber = 4;
	        foreach($ds_bbdv as $index=>$item){ 
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