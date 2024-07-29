<?php 
	class Danhmuchethong_Model_Cacloaiquyetdinh extends JModelLegacy{
		public function findcacloaiquyetdinhbyname($tk_tencacloaiquyetdinh){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = array('id',$db->quotename('name'),'status,daxoa');
			$query->select($name);
			$query->from('approv_type');
			$query->where('daxoa!=1');
			$query->where($db->quotename('name').' LIKE '.$db->quote('%'.$tk_tencacloaiquyetdinh.'%'));
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addcacloaiquyetdinh($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array($db->quotename('name'),'status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert('approv_type')->columns($columns)->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findcacloaiquyetdinh($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = array($db->quotename('name'),'id,status,daxoa');
			$condition = array('daxoa!=1','id='.$db->quote($id));
			$query->select($name)->from('approv_type')->where($condition);
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatecacloaiquyetdinh($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = 'id='.$db->quote($form['id']);
			$query->update('approv_type')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoacacloaiquyetdinh($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('approv_type');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieucacloaiquyetdinh($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('approv_type');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result = $db->query();
			}
			return $result;
		}
		public function xuat_excelcacloaiquyetdinh(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách các loại quyết định');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên các loại quyết định');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_cacloaiquyetdinh = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Cacloaiquyetdinh');
	        $ds_cacloaiquyetdinh = $model->findcacloaiquyetdinhbyname($timkiem_cacloaiquyetdinh);

	        $rowNumber = 4;
	        foreach($ds_cacloaiquyetdinh as $index=>$item){  
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