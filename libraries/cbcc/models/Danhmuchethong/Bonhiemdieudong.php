<?php 
	class Danhmuchethong_Model_Bonhiemdieudong extends JModelLegacy{
		public function timkiembonhiemdieudong($tk_bonhiemdieudong){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,type,status,is_dieudong');
			$query->from('whois_pos_mgr');
			if($tk_bonhiemdieudong!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_bonhiemdieudong.'%'));
			}
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addbonhiemdieudong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			// var_dump($form);die;
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			if($form['is_dieudong']==''){
				$is_dieudong = 0;
			}
			else{
				$is_dieudong = $form['is_dieudong'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('type').'='.$db->quote($form['type']),
						$db->quotename('status').'='.$db->quote($status),
						$db->quotename('is_dieudong').'='.$db->quote($is_dieudong));
			$query->insert('whois_pos_mgr');
			$query->set($field);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function findbonhiemdieudong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,type,status,is_dieudong');
			$query->from('whois_pos_mgr');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatebonhiemdieudong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			if($form['is_dieudong']==''){
				$is_dieudong = 0;
			}
			else{
				$is_dieudong = $form['is_dieudong'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('type').'='.$db->quote($form['type']),
							$db->quotename('status').'='.$db->quote($status),
							$db->quotename('is_dieudong').'='.$db->quote($is_dieudong));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('whois_pos_mgr');
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoa_bonhiemdieudong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('whois_pos_mgr');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieubonhiemdieudong($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$id1 = $id[$i];
				$result[] = $this->xoa_bonhiemdieudong($id1);
			}
			return $result;
		}
		public function xuat_excelbonhiemdieudong(){
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
	        $timkiem_bonhiemdieudong = JRequest::getVar('ten');
	        $timkiem_bonhiemdieudong2 = JRequest::getVar('ten2');
	        $timkiem_bonhiemdieudong3 = JRequest::getVar('ten3');
	        $model = Core::model('Danhmuchethong/Quanlybonhiemdieudong');
	        $ds_bonhiemdieudong = $model->findbonhiemdieudongbyname($timkiem_bonhiemdieudong,$timkiem_bonhiemdieudong2,$timkiem_bonhiemdieudong3);

	        $rowNumber = 4;
	        foreach($ds_bonhiemdieudong as $index=>$item){
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