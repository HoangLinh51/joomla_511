<?php 
	defined('_JEXEC') or die('Restricted access');
	class Danhmuchethong_Model_Tieuchi extends JModelLegacy{
		public function findtieuchibyname($tk_tentieuchi,$nhomtieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,published,diemmin,diemmax,code_xeploai');
			$query->from('dgcbcc_tieuchi');
			$query->where('daxoa!=1');
			$query->where('name LIKE '.$db->quote('%'.$tk_tentieuchi.'%'));
			if($nhomtieuchi>0){
				$query->where('id_nhom='.$db->quote($nhomtieuchi));
			}
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_tieuchi_by_nhomtieuchi($id, $id_botieuchi = null){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($id_botieuchi==null){
				$name = 'a.id,a.name';
			}
			else{
				$name = 'a.id,a.name,b.diem_min,b.diem_max,b.code_xeploai,b.id_tieuchi_phanloai,if(b.id_botieuchi IS NOT NULL,1,0) as checked';
			}
			$query->select($name);
			$query->from('dgcbcc_tieuchi a');
			if($id_botieuchi!=null){
				$query->join('LEFT','dgcbcc_fk_botieuchi_tieuchi b ON b.id_tieuchi=a.id AND b.id_botieuchi='.$db->quote($id_botieuchi));
			}			
			$query->where('a.id_nhom='.$db->quote($id));
			if($id_botieuchi!=null){
				$query->order('checked desc');
			}
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function getallnhomtieuchi(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,published');
			$query->from('dgcbcc_tieuchi_nhom');
			$query->where('daxoa!=1');
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addtieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array($db->quotename('name'),'id_nhom,code,orders,published,daxoa,diemmin,diemmax,code_xeploai');
			$values = array($db->quote($form['name']),$db->quote($form['id_nhom']),$db->quote($form['code']),0,$db->quote($form['published']),0,$db->quote($form['diemmin']),$db->quote($form['diemmax']),$db->quote($form['code_xeploai']));
			$query->insert('dgcbcc_tieuchi');
			$query->columns($columns);
			$query->values(implode(',',$values));
			$db->setQuery($query);
			return $db->query();
		}
		public function findtieuchibyid($tk_idtieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,id_nhom,name,code,published,diemmin,diemmax,code_xeploai');
			$query->from('dgcbcc_tieuchi');
			$query->where('id='.$db->quote($tk_idtieuchi));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatetieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('code').'='.$db->quote($form['code']),
							$db->quotename('id_nhom').'='.$db->quote($form['id_nhom']),
							$db->quotename('name').'='.$db->quote($form['name']),
							$db->quotename('published').'='.$db->quote($form['published']),
							$db->quotename('diemmin').'='.$db->quote($form['diemmin']),
							$db->quotename('diemmax').'='.$db->quote($form['diemmax']),
							$db->quotename('code_xeploai').'='.$db->quote($form['code_xeploai']));
			$condition = $db->quotename('id').'='.$db->quote($form['id']);
			$query->update('dgcbcc_tieuchi')->set($field)->where($condition);
			$db->setQuery($query);
			return $db->query();
		}
		public function deletetieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('dgcbcc_tieuchi');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletenhieutieuchi($id){
			$db = JFactory::getDbo();
			// var_dump($id);
			for($i=0;$i<count($id['id']);$i++){
				$query = $db->getQuery(true);
				$query->update('dgcbcc_tieuchi');
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
	        $PHPExcel->getActiveSheet()->setCellValue('A1','Danh sách tiêu chí');
	        $PHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(20);
	        $PHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
	        $PHPExcel->getActiveSheet()->setCellValue('A2','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('B2','Mã tiêu chí');
	        $PHPExcel->getActiveSheet()->setCellValue('C2','Tên tiêu chí');
	        $PHPExcel->getActiveSheet()->setCellValue('D2','Trạng thái');
	        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $PHPExcel->getActiveSheet()->getStyle("A2:D2")->getFont()->setBold(true);
	        $tk_tentieuchi = JRequest::getVar('ten');
	        $model = Core::model('Danhmuchethong/Tieuchi');
	        $ds_tieuchi = $model->findtieuchibyname($tk_tentieuchi);

	        $rowNumber = 3;
	        foreach($ds_tieuchi as $index=>$item){ 
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