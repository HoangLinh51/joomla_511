<?php 
	defined('_JEXEC') or die('Restricted Access');
	class Danhmuchethong_Model_Nhiemvuduocgiao extends JModelLegacy{
		public function findnhiemvuduocgiaobyname($tk_tennhiemvuduocgiao){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,mota,trangthai,daxoa');
			$query->from($db->quotename('danhmuc_nhiemvuduocgiao'));
			$query->where('ten LIKE '.$db->quote('%'.$tk_tennhiemvuduocgiao.'%'));
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addnhiemvuduocgiao($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns= ('ten,mota,trangthai,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['mota']),$db->quote($form['status']),0);
			$query->insert($db->quotename('danhmuc_nhiemvuduocgiao'));
			$query->columns($columns);
			$query->values(implode(',',$values));
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function findnhiemvuduocgiao($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,mota,trangthai,daxoa');
			$query->from($db->quotename('danhmuc_nhiemvuduocgiao'));
			$query->where('id='.$db->quote($id));
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatenhiemvuduocgiao($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('ten').'='.$db->quote($form['name']),
							$db->quotename('mota').'='.$db->quote($form['mota']),
							$db->quotename('trangthai').'='.$db->quote($form['status']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update($db->quotename('danhmuc_nhiemvuduocgiao'));
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhiemvuduocgiao($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = $db->quotename('id').'='.$db->quote($id['id']);
			$query->update($db->quotename('danhmuc_nhiemvuduocgiao'));
			$query->set('daxoa=1');
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieunhiemvuduocgiao($id){
			$db = JFactory::getDbo();
			// var_dump($id);
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update($db->quotename('danhmuc_nhiemvuduocgiao'));
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));

				$db->setQuery($query);
				$result= $db->query();
			}
			return $result;
		}
		public function xuat_excelnhiemvuduocgiao(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:E1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách nhiệm vụ được giao');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên nhiệm vụ được giao');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Mô tả');
	        $PHPExcel->getActiveSheet()->setCellValue('E3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:E3")->getFont()->setBold(true);
	        $timkiem_nhiemvuduocgiao = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Nhiemvuduocgiao');
	        $ds_nhiemvuduocgiao = $model->findnhiemvuduocgiaobyname($timkiem_nhiemvuduocgiao);

	        $rowNumber = 4;
	        foreach($ds_nhiemvuduocgiao as $index=>$item){
	        	if($item['trangthai']==1){
	        		$trangthai = 'Đang hoạt động';
	        	} 
	        	else{
	        		$trangthai = 'Không hoạt động';
	        	}  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['ten']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['mota']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNumber,$trangthai);
	            $rowNumber++;
	        }
	        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->applyFromArray(array(
	            'borders' => array(
	                'allborders' => array(
	                    'style' => PHPExcel_Style_Border::BORDER_THIN,
	                    // 'color' => array('rgb' => 'DDDDDD')
	                )
	            )
	        ));
	        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $PHPExcel->getActiveSheet()->getStyle('B3:E'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
	        $objWriter->save('php://output'); 
		}
	}
?>