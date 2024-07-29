<?php 
	defined('_JEXEC') or die('Restricted access');
	class Danhmuchethong_Model_Nhomtieuchi extends JModelLegacy{
		public function findnhomtieuchibyname($tk_tennhomtieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,published');
			$query->from('dgcbcc_tieuchi_nhom');
			$query->where('daxoa!=1');
			$query->where('name LIKE '.$db->quote('%'.$tk_tennhomtieuchi.'%'));
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addnhomtieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array($db->quotename('name'),'code,orders,published,daxoa');
			$values = array($db->quote($form['name']),$db->quote($form['code']),0,$db->quote($form['published']),0);
			$query->insert('dgcbcc_tieuchi_nhom');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findnhomtieuchibyid($tk_idnhomtieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,published');
			$query->from('dgcbcc_tieuchi_nhom');
			$query->where('id='.$db->quote($tk_idnhomtieuchi));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatenhomtieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('code').'='.$db->quote($form['code']),
							$db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('published').'='.$db->quote($form['published']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('dgcbcc_tieuchi_nhom')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function deletenhomtieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('dgcbcc_tieuchi_nhom');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletenhieunhomtieuchi($id){
			$db = JFactory::getDbo();
			// var_dump($id);
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('dgcbcc_tieuchi_nhom');
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id['id'][$i]));
				// echo $query;die;
				$db->setQuery($query);
				$result[]= $db->query();
			}
			return $result;
		}
		public function xuat_excel(){   
	        require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('A1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('A1','Danh sách nhóm tiêu chí');
	        $PHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('A2','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('B2','Mã nhóm tiêu chí');
	        $PHPExcel->getActiveSheet()->setCellValue('C2','Tên nhớm tiêu chí');
	        $PHPExcel->getActiveSheet()->setCellValue('D2','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("A2:D2")->getFont()->setBold(true);
	        $tk_tennhomtieuchi = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Nhomtieuchi');
	        $ds_nhomtieuchi = $model->findnhomtieuchibyname($tk_tennhomtieuchi);

	        $rowNumber = 3;
	        foreach($ds_nhomtieuchi as $index=>$item){ 
	        	if($item['published']==1){
	        		$published = 'Đang sử dụng';
	        	} 
	        	else{
	        		$published = 'Không sử dụng';
	        	}
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,$item['code']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['name']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$published);
	            $rowNumber++;
	        }
	        $PHPExcel->getActiveSheet()->getStyle('A2:D'.($rowNumber-1))->applyFromArray(array(
	            'borders' => array(
	                'allborders' => array(
	                    'style' => PHPExcel_Style_Border::BORDER_THIN,
	                    // 'color' => array('rgb' => 'DDDDDD')
	                )
	            )
	        ));
	        $PHPExcel->getActiveSheet()->getStyle('A2:D'.($rowNumber-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $PHPExcel->getActiveSheet()->getStyle('A2:D'.($rowNumber-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
	        $objWriter->save('php://output'); 
	    }
	}
?>