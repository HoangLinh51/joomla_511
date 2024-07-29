<?php 
	defined('_JEXEC') or die('Restricted access');
	class Danhmuchethong_Model_Binhbauphanloaicbcc extends JModelLegacy{
		public function findbinhbauphanloaicbccbyname($tk_tenbinhbauphanloaicbcc){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,daxoa');
			$query->from('quality_level');
			$query->where('daxoa!=1');
			$query->where('name LIKE '.$db->quote('%'.$tk_tenbinhbauphanloaicbcc.'%'));
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addbinhbauphanloaicbcc($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns= ('name,status,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['status']),0);
			$query->insert('quality_level');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findbinhbauphanloaicbcc($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id);
			$query->select('id,name,status,daxoa');
			$query->from('quality_level');
			$query->where($condition);
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatebinhbauphanloaicbcc($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('status').'='.$db->quote($form['status']));
			$condition = 'id='.$db->quote($form['id']);
			$query->update('quality_level')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoabinhbauphanloaicbcc($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = 'id='.$db->quote($id['id']);
			$query->update('quality_level')->set('daxoa=1')->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieubinhbauphanloaicbcc($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('quality_level')->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				$db->setQuery($query);
				$result = $db->query();
			}
			return $result;
		}
		public function xuat_excelbinhbauphanloaicbcc(){
			require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('B1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('B1','Danh sách bình bầu phân loại cbcc');
	        $PHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên bình bầu phân loại cbcc');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_binhbauphanloaicbcc = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Binhbauphanloaicbcc');
	        $ds_binhbauphanloaicbcc = $model->findbinhbauphanloaicbccbyname($timkiem_binhbauphanloaicbcc);

	        $rowNumber = 4;
	        foreach($ds_binhbauphanloaicbcc as $index=>$item){  
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