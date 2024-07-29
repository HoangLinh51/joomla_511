<?php  
	class Danhmuchethong_Model_Capbonhiembanhanh extends JModelLegacy{
		function findcbnbhbyname($tk_tencapbonhiembanhanh){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,sapxep,trangthai,daxoa');
			$query->from($db->quotename('danhmuc_capbanhanh'));
			$query->where('ten'." LIKE ".$db->quote('%'.$tk_tencapbonhiembanhanh.'%'));
			$query->where('daxoa!=1');
			$query->order('sapxep asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		function addcapbonhiembanhanh($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = ('ten,sapxep,trangthai,daxoa');
			$values = array($db->quote($form['ten']),0,$db->quote($form['trangthai']),0);
			$query->insert($db->quotename('danhmuc_capbanhanh'));
			$query->columns($columns);
			$query->values(implode(',',$values)); 
			$db->setQuery($query);
			return $db->query();
		}
		function xoacapbonhiembanhanh($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$condition = ('id='.$db->quote($id['id']));
			$query->update($db->quotename('danhmuc_capbanhanh'));
			$query->set('daxoa=1');
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		function findcapbonhiembanhanh($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,sapxep,trangthai,daxoa');
			$query->from($db->quotename('danhmuc_capbanhanh'));
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		function updatecapbonhiembanhanh($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('ten').'='.$db->quote($form['ten']),
							$db->quotename('trangthai').'='.$db->quote($form['trangthai']));
			$condition = ($db->quotename('id').'='.$db->quote($form['id']));
			$query->update($db->quotename('danhmuc_capbanhanh'));
			$query->set($field);
			$query->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		function xoanhieucapbonhiembanhanh($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id['id']);$i++){
				$id1 = $id['id'][$i];
				$query = $db->getQuery(true);
				$query->update($db->quotename('danhmuc_capbanhanh'));
				$query->set('daxoa=1');
				$query->where('id='.$db->quote($id1));
				$db->setQuery($query);
				$result = $db->execute();
			}
			return $result;
		}
		function xuat_excel(){   
	        require 'components/com_danhmuc/classes/PHPExcel.php';        
	        $PHPExcel = new PHPExcel();
	        $PHPExcel->setActiveSheetIndex(0);
	        $PHPExcel->getActiveSheet()->mergeCells('C1:D1');
	        $PHPExcel->getActiveSheet()->setCellValue('C1','Danh sách cấp bổ nhiệm / ban hành');
	        $PHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('B3','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('C3','Tên cấp bổ nhiệm / ban hành');
	        $PHPExcel->getActiveSheet()->setCellValue('D3','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getStyle("B3:D3")->getFont()->setBold(true);
	        $timkiem_capbonhiembanhanh = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Capbonhiembanhanh');
	        $ds_capbonhiembanhanh = $model->findcbnbhbyname($timkiem_capbonhiembanhanh);

	        $rowNumber = 4;
	        foreach($ds_capbonhiembanhanh as $index=>$item){  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['ten']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNumber,$item['trangthai']);
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