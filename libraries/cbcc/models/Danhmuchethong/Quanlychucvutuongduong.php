<?php 
	class Danhmuchethong_Model_Quanlychucvutuongduong extends JModelLegacy{
		public function findcvtdbyname($tk_cvtd,$tk_cvtd2,$tk_cvtd3){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = array('daxoa!=1','position LIKE '.$db->quote('%'.$tk_cvtd.'%'),
								'position2 LIKE '.$db->quote('%'.$tk_cvtd2.'%'),
								'position3 LIKE '.$db->quote('%'.$tk_cvtd3.'%'));
			$query->select('id,level,position,type_org,active,position2,position3,daxoa');
			$query->from('pos_level');
			$query->where($condition);
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addchucvutuongduong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('level,position,type_org,active,position2,position3,daxoa');
			$values = array($db->quote($form['level']),$db->quote($form['position']),
							$db->quote($form['type_org']),$db->quote($form['active']),
							$db->quote($form['position2']),$db->quote($form['position3']),0);
			$query->insert('pos_level')->columns($columns)->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findcvtd($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,level,position,type_org,active,position2,position3,daxoa');
			$query->from('pos_level');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatechucvutuongduong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('level').'='.$db->quote($form['level']),
							$db->quotename('position').'='.$db->quote($form['position']),
							$db->quotename('type_org').'='.$db->quote($form['type_org']),
							$db->quotename('active').'='.$db->quote($form['active']),
							$db->quotename('position2').'='.$db->quote($form['position2']),
							$db->quotename('position3').'='.$db->quote($form['position3']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('pos_level')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoachucvutuongduong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('pos_level');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieuchucvutuongduong($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('pos_level');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result = $db->query();
			}
			return $result;
		}
		public function xuat_excelchucvutuongduong(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:H1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách chức vụ tương đương');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên chức vụ tương đương');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Tên chức vụ tương đương 2');
	        $PHPExcel->getActiveSheet()->setCellValue('E3','Tên chức vụ tương đương 3');
	        $PHPExcel->getActiveSheet()->setCellValue('F3','Phân loại');
	        $PHPExcel->getActiveSheet()->setCellValue('G3','Mức tương đương');
	        $PHPExcel->getActiveSheet()->setCellValue('H3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
	        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
	        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("B3:H3")->getFont()->setBold(true);
	        $timkiem_cvtd = JRequest::getVar('ten');
	        $timkiem_cvtd2 = JRequest::getVar('ten2');
	        $timkiem_cvtd3 = JRequest::getVar('ten3');
	        $model = Core::model('Danhmuchethong/Quanlychucvutuongduong');
	        $ds_cvtd = $model->findcvtdbyname($timkiem_cvtd,$timkiem_cvtd2,$timkiem_cvtd3);

	        $rowNumber = 4;
	        foreach($ds_cvtd as $index=>$item){
	        	if($item['type_org']==1){
	        		$type = 'Sở ban ngành';
	        	} 
	        	else if($item['type_org']==2){
	        		$type = 'Quận huyện';
	        	}
	        	else{
	        		$type = 'Phường xã';
	        	} 
	        	if($item['active']==1){
	        		$active = 'Đang hoạt động';
	        	} 
	        	else{
	        		$active = 'Không hoạt động';
	        	} 
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['position']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['position2']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$item['position3']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNumber,$type);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNumber,$item['level']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNumber,$active);
	            $rowNumber++;
	        }
	        $PHPExcel->getActiveSheet()->getStyle('B3:H'.($rowNumber-1))->applyFromArray(array(
	            'borders' => array(
	                'allborders' => array(
	                    'style' => PHPExcel_Style_Border::BORDER_THIN,
	                    // 'color' => array('rgb' => 'DDDDDD')
	                )
	            )
	        ));
	        $PHPExcel->getActiveSheet()->getStyle('B3:H'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $PHPExcel->getActiveSheet()->getStyle('B3:H'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
	        $objWriter->save('php://output'); 
		}
	}
?>