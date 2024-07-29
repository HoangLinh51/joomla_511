<?php 
	class Danhmuchethong_Model_Thuocdienquanly extends JModelLegacy{
		public function findthuocdienquanlybyname($ten_tkthuocdienquanly){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = array($db->quotename('name'),'id,trangthai,daxoa');
			$query->select($name);
			$query->from('danhmuc_dienquanly');
			$query->where('daxoa!=1');
			$query->where($db->quotename('name').' LIKE '.$db->quote('%'.$ten_tkthuocdienquanly.'%'));
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addthuocdienquanly($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array($db->quotename('name'),'trangthai,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['trangthai']),0);
			$query->insert('danhmuc_dienquanly');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findthuocdienquanly($id){
			// var_dump($id);die;
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,trangthai,daxoa');
			$query->from('danhmuc_dienquanly');
			$query->where('daxoa!=1 AND id='.$db->quote($id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatethuocdienquanly($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('trangthai').'='.$db->quote($form['trangthai']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('danhmuc_dienquanly');
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoathuocdienquanly($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('danhmuc_dienquanly');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieuthuocdienquanly($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('danhmuc_dienquanly');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result =  $db->query();
			}
			return $result;
		}
		public function xuat_excelthuocdienquanly(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách thuộc diện quản lý');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên thuộc diện quản lý');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_thuocdienquanly = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Thuocdienquanly');
	        $ds_thuocdienquanly = $model->findthuocdienquanlybyname($timkiem_thuocdienquanly);

	        $rowNumber = 4;
	        foreach($ds_thuocdienquanly as $index=>$item){  
	        	if($item['trangthai']==1){
	        		$trangthai = 'Đang hoạt động';
	        	}
	        	else{
	        		$trangthai = 'Không hoạt động';
	        	}
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$trangthai);
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