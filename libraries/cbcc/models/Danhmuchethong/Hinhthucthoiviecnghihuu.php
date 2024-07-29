<?php 
	class Danhmuchethong_Model_Hinhthucthoiviecnghihuu extends JModelLegacy{
		public function findhinhthucthoiviecnghihuubyname($ten_tkhinhthucthoiviecnghihuu){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = array($db->quotename('name'),'id,status,daxoa');
			$query->select($name);
			$query->from('depend_status');
			$query->where('daxoa!=1');
			$query->where($db->quotename('name').' LIKE '.$db->quote('%'.$ten_tkhinhthucthoiviecnghihuu.'%'));
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addhinhthucthoiviecnghihuu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array($db->quotename('name'),'status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert('depend_status');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findhinhthucthoiviecnghihuu($id){
			// var_dump($id);die;
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,daxoa');
			$query->from('depend_status');
			$query->where('daxoa!=1 AND id='.$db->quote($id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatehinhthucthoiviecnghihuu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('depend_status');
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoahinhthucthoiviecnghihuu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('depend_status');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieuhinhthucthoiviecnghihuu($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('depend_status');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result =  $db->query();
			}
			return $result;
		}
		public function xuat_excelhinhthucthoiviecnghihuu(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách hình thức thôi việc nghỉ hưu');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên hình thức thôi việc nghỉ hưu');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_hinhthucthoiviecnghihuu = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Hinhthucthoiviecnghihuu');
	        $ds_hinhthucthoiviecnghihuu = $model->findhinhthucthoiviecnghihuubyname($timkiem_hinhthucthoiviecnghihuu);

	        $rowNumber = 4;
	        foreach($ds_hinhthucthoiviecnghihuu as $index=>$item){  
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