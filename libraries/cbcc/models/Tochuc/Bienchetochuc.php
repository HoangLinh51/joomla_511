<?php 
	class Tochuc_Model_Bienchetochuc extends JModelLegacy{
		public function findhinhthucbyloaihinhid($loaihinh_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('bc_hinhthuc');
			$query->where('loaihinh_id='.$db->quote($loaihinh_id))
			->where('status=1')->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function finddonvibyloaihinhid($loaihinh_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('ins_dept');
			$query->where('(type=1 OR type=3)');
			if($loaihinh_id!=null){
				$query->where('ins_loaihinh='.$db->quote($loaihinh_id));
			}
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function findslbienchebynam($nam,$dept_id,$hinhthuc_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('sum(b.bienche) as soluongbienche');
			$query->from('ins_dept_quatrinh_bienche a');
			$query->where('a.nam='.$db->quote($nam));
			$query->where('a.dept_id ='.$db->quote($dept_id));
			$query->where('b.hinhthuc_id='.$db->quote($hinhthuc_id));
			$query->join('INNER','ins_dept_quatrinh_bienche_chitiet b ON b.quatrinh_id=a.id');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function findinsloaihinhfrominsdept($donvi_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('ins_loaihinh');
			$query->from('ins_dept');
			$query->where('id='.$db->quote($donvi_id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function xuat_excel($loaihinh_id,$nam){
			require 'components/com_danhmuc/classes/PHPExcel.php';
			$PHPExcel = new PHPExcel();
			$ds_hinhthuc = $this->findhinhthucbyloaihinhid($loaihinh_id);
			$ds_donvi = $this->finddonvibyloaihinhid($loaihinh_id);       
	       	$PHPExcel->setActiveSheetIndex(0);
	       	$width = array(5, 30,20, 20, 35, 30, 15, 23, 40, 15, 15, 12, 12, 12, 23, 23, 23);   
	        $PHPExcel->getActiveSheet()->setCellValue('A5','STT');
	        $PHPExcel->getActiveSheet()->setCellValue('B5','Tên đơn vị');
	        $PHPExcel->getActiveSheet()->setCellValue('C5','Mã đơn vị');
	        $PHPExcel->getActiveSheet()->getColumnDimensionByColumn(0,5)->setWidth($width[0]);
	        $PHPExcel->getActiveSheet()->getColumnDimensionByColumn(1,5)->setWidth($width[1]);
	        $PHPExcel->getActiveSheet()->getColumnDimensionByColumn(2,5)->setWidth($width[2]);
	        $count =3;
	        for($i=0;$i<count($ds_hinhthuc);$i++){	        	
	        	$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($count,5,$ds_hinhthuc[$i]['name']);
	        	$PHPExcel->getActiveSheet()->getColumnDimensionByColumn($count,5)->setWidth($width[$count]);
	        	$count++;
	        }	        
	        // $PHPExcel->getActiveSheet()->getColumnDimension($PHPExcel->getActiveSheet()->getHighestColumn())->setAutoSize(TRUE);
			// for ($i = 'A'; $i != $PHPExcel->getActiveSheet()->getHighestColumn(); $i++){ 
			// 	$PHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE); 
			// } 
	        $PHPExcel->getActiveSheet()->getStyle("A5:".$PHPExcel->getActiveSheet()->getHighestColumn().'5')->getFont()->setBold(true);
	        $rowNumber = 6;

	        foreach($ds_donvi as $index=>$item){  
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowNumber,($index+1));
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNumber,$item['name']);
	            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNumber,$item['id']);
	            for($i=0;$i<count($ds_hinhthuc);$i++){
	            	$slbienche = $this->findslbienchebynam($nam,$item['id'],$ds_hinhthuc[$i]['id']);
	            	$column = $i+3;
	            	$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column,$rowNumber,$slbienche['soluongbienche']);	
	            }	
	            $rowNumber++;
	        }
	        // $PHPExcel->getActiveSheet()->mergeCells('A5:'.$PHPExcel->getActiveSheet()->getHighestColumn().'5');
	        // $PHPExcel->getActiveSheet()->setCellValue('A5','Danh sách đơn vị');	        
	        // $PHPExcel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true)->setSize(20);
	        // $PHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $PHPExcel->getActiveSheet()->getStyle('A5:'.$PHPExcel->getActiveSheet()->getHighestColumn().$PHPExcel->getActiveSheet()->getHighestRow())->applyFromArray(array(
	        		'borders' => array(
	                'allborders' => array(
	                    'style' => PHPExcel_Style_Border::BORDER_THIN,
	                    // 'color' => array('rgb' => 'DDDDDD')
	                )
	            )
	        	)
	    	);
	        $PHPExcel->getActiveSheet()->getStyle('A5:'.$PHPExcel->getActiveSheet()->getHighestColumn().'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        // $PHPExcel->getActiveSheet()->getStyle('A5:'.$PHPExcel->getActiveSheet()->getHighestColumn().$PHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="ds_donvi.xls"'); 
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5'); 
	        $objWriter->save('php://output');
		}
		public function importdatafromexcel($form){
			if(!empty($_FILES['data_file'])){
				$file_array = explode(".", $_FILES['data_file']["name"]);
				if($file_array[1]=='xls'||$file_array[1]=='xlsx'){				
					include "components/com_danhmuc/classes/PHPExcel/IOFactory.php";				
					$bc_hinhthuc_name=array();
					$result = [];
					$object = PHPExcel_IOFactory::load($_FILES["data_file"]["tmp_name"]);
					$sheetCount = $object->getSheetCount();
					// echo $sheetCount;die;
					$ngaytao = date('Y-m-d H:i:s');
					for($i=0;$i<$sheetCount;$i++){
						$object->setActiveSheetIndex($i);
						$activeSheet = $object->getActiveSheet();
						$sheetname = $object->getSheetNames();
						$sheetname1 = $sheetname[$i];
						$highestRow = $activeSheet->getHighestRow();
						$highestColumn = $activeSheet->getHighestColumn();
						for($column='D';$column!=$highestColumn;$column++){
							if($activeSheet->getCell($column.'5')->getValue()==null){
								break;
							}
							$bc_hinhthuc_name[$i][] = $activeSheet->getCell($column.'5')->getValue();
						}
						for($row=6;$row<=$highestRow;$row++){
							$row1 = $row+1;
							if($this->checkText($activeSheet->getCellByColumnAndRow(2, $row)->getValue())==false
								&& $this->checkText($activeSheet->getCellByColumnAndRow(1,$row)->getValue())==false){
								$donvi_id = $activeSheet->getCellByColumnAndRow(2, $row)->getValue();
								$donvi_name = $activeSheet->getCellByColumnAndRow(1,$row)->getValue();
								$bienche_ins_dept_import_id = $this->addbienche_ins_dept_import($form,$donvi_id,$donvi_name,$ngaytao,$sheetname1);
								for($column1=0;$column1<count($bc_hinhthuc_name[$i]);$column1++){
									$column2 = $column1+3;
									$soluongbienche = (int)$activeSheet->getCellByColumnAndRow($column2,$row)->getValue();
									$bc_hinhthuc_name1 = $activeSheet->getCellByColumnAndRow($column2,5)->getValue();
									$result[] = $this->InsertBC_Ins_dept_Import_Fk($bc_hinhthuc_name1,$bienche_ins_dept_import_id,$soluongbienche,$ngaytao);
								}
							}
							else{
								$result[] = 'Hàng '.$row;
							}							
							if($this->checkText($activeSheet->getCellByColumnAndRow(2, $row)->getValue())==true
								&& $this->checkText($activeSheet->getCellByColumnAndRow(1,$row)->getValue())==true
								&& $this->checkText($activeSheet->getCellByColumnAndRow(2, $row1)->getValue())==true
								&& $this->checkText($activeSheet->getCellByColumnAndRow(1,$row1)->getValue())==true){
									break;	
							}
						}
					}
					return $result;
				}
				else{
					return $result;
				}
			}
			else{
				return $result;
			}
		}
		public function checkText($text){
			if($text=='' || $text==null){
				return true;
			}
			else{
				return false;
			}
		}
		public function addbienche_ins_dept_import($form,$donvi_id,$donvi_name,$ngaytao,$sheetname){
			$db = JFactory::getDbo();
			$ngayquyetdinh = $this->convertDate($form['ngayquyetdinh']);
			$user = JFactory::getUser();
			$user_id = $user->id;
			$id = 0;
			if($donvi_id!=null&&$donvi_name!=null){
				$query = $db->getQuery(true);
				$ins_loaihinh = $this->findinsloaihinhfrominsdept($donvi_id);
				$fields = array($db->quotename('donvi_id').'='.$db->quote($donvi_id),
							$db->quotename('donvi_ten').'='.$db->quote($donvi_name),
							$db->quotename('ngaytao').'='.$db->quote($ngaytao),
							$db->quotename('nguoitao').'='.$db->quote($user_id),
							$db->quotename('soquyetdinh').'='.$db->quote($form['soquyetdinh']),
							$db->quotename('ngayquyetdinh').'='.$db->quote($ngayquyetdinh),
							$db->quotename('coquanquyetdinh').'='.$db->quote($form['coquanquyetdinh']),
							$db->quotename('ins_loaihinh').'='.$db->quote($ins_loaihinh['ins_loaihinh']),
							$db->quotename('tensheet').'='.$db->quote($sheetname),
							$db->quotename('trangthai').'= 2',
							$db->quotename('nam').'='.$db->quote($form['nam']));
				$query->insert('bienche_ins_dept_import');
				$query->set($fields);
				$db->setQuery($query);
				$db->query();
				$id = $db->insertid();
			}
			return $id;
		}
		public function findhinhthucbydonvi($hinhthuc_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('bc_hinhthuc');
			$query->where('name='.$db->quote($hinhthuc_name));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function InsertBC_Ins_dept_Import_Fk($bc_hinhthuc_name1,$bienche_ins_dept_import_id,$soluongbienche,$ngaytao){
			$db = JFactory::getDbo();
			
			$query = $db->getQuery(true);
			$hinhthuc_id = $this->findhinhthucbydonvi($bc_hinhthuc_name1);
			if((int)$hinhthuc_id==0 || $bienche_ins_dept_import_id==0){
				$result = 'Cột '.$bc_hinhthuc_name1.'';
				// echo 'aaa1';die;
			}
			else{
				$values = array(
						$db->quote($bienche_ins_dept_import_id),
						$db->quote($hinhthuc_id['id']),
						$db->quote($soluongbienche),
						$db->quote($ngaytao));
				$query->insert('bienche_ins_dept_import_fk');
				$query->columns('
						bienche_ins_dept_import_id,
						bc_hinhthuc_id,
						soluongbienche,
						ngaytao');
				$query->values(implode(',',$values));
				// echo $query;die;
				$db->setQuery($query);
				$kq = $db->query();
				if($kq==false){
					$result = 'Lỗi không thêm được hình thức biên chế';
				}
			}	
			return $result;
		}
		public function getallbienche_insdeptimport($date,$time){
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$user_id = $user->id;
			$query = $db->getQuery(true);
			$date = $this->convertDate($date);
			$ngaytao = $date.' '.$time;
			$query->select('id,donvi_id,donvi_ten,soquyetdinh,ngayquyetdinh,coquanquyetdinh,nam,ngaytao,tensheet');
			$query->from('bienche_ins_dept_import');
			$query->where('ngaytao='.$db->quote($ngaytao));
			$query->where('nguoitao='.$db->quote($user_id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getallsheet_insdeptimport($date,$time){
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$user_id = $user->id;
			$query = $db->getQuery(true);
			$date = $this->convertDate($date);
			$ngaytao = $date.' '.$time;
			$query->select('tensheet');
			$query->from('bienche_ins_dept_import');
			$query->where('ngaytao='.$db->quote($ngaytao));
			$query->where('nguoitao='.$db->quote($user_id));
			$query->group('tensheet');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getallbctcimport(){
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$user_id = $user->id;
			$query = $db->getQuery(true);
			$name = array('ngaytao,nguoitao,soquyetdinh,ngayquyetdinh,coquanquyetdinh,trangthai','count(id) AS soluongdonvi');
			$query->select($name);
			$query->from('bienche_ins_dept_import');
			$query->where('nguoitao='.$db->quote($user_id));
			$query->group('ngaytao');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function deleteimportbctc($ngaytao){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bienche_ins_dept_import');
			$query->where('ngaytao='.$db->quote($ngaytao));
			$db->setQuery($query);
			return $db->query();
		}
		public function deleteimportbctc_fk($ngaytao){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bienche_ins_dept_import_fk');
			$query->where('ngaytao='.$db->quote($ngaytao));
			$db->setQuery($query);
			return $db->query();
		}
		public function findbc_hinhthucnamebyimportbctc_id($tensheet){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('b.name');
			$query->from('bienche_ins_dept_import_fk a');
			$query->where('c.tensheet='.$db->quote($tensheet));
			$query->join('INNER','bienche_ins_dept_import c ON (a.bienche_ins_dept_import_id=c.id)');
			$query->join('INNER','bc_hinhthuc b ON (a.bc_hinhthuc_id=b.id)');
			$query->group('b.name')->order('bc_hinhthuc_id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function findsoluongbienchebyimportbctc_id($bienche_ins_dept_import_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('bc_hinhthuc_id,soluongbienche');
			$query->from('bienche_ins_dept_import_fk');
			$query->where('bienche_ins_dept_import_id='.$db->quote($bienche_ins_dept_import_id))->order('bc_hinhthuc_id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		// public function insertimportbctc($ds_biencheimport){
		// 	$db = JFactory::getDbo();
		// 	for($i=0;$i<count($ds_biencheimport);$i++){

		// 	}
		// }
		public function convertDate($date){
			$year = substr($date,6,4);
			$month = substr($date,3,2);
			$day = substr($date,0,2);
			return $year.'-'.$month.'-'.$day;
		}
		public function convertDate1($date){
			$year = substr($date,0,4);
			$month = substr($date,5,2);
			$day = substr($date,8,2);
			return $day.'/'.$month.'/'.$year;
		}
		public function importbctc_main($date){
			$date1 = substr($date,0,10);
			$date1 = $this->convertDate1($date1);
			$time = substr($date,11,8);
			$ds_biencheimport = $this->getallbienche_insdeptimport($date1,$time);
			// var_dump($ds_biencheimport);die;
			$count = 0;		
			for($i=0;$i<count($ds_biencheimport);$i++){
				$result = $this->addquatrinhbienche($ds_biencheimport[$i]);				
				if($result>0){
					$result1 = $this->addchitietquatrinhbienche($ds_biencheimport[$i]['id'],$result);
					$count1 = 0;
					for($j=0;$j<count($result1);$j++){
						if($result1[$j]==true){
							$count1++;
						}
					}
					if($count1==count($result1)){
						$result2 =$this->updatetrangthai_biencheimport($ds_biencheimport[$i]['id']);
						if($result2==true){
							$count++;
						}					
					}
				}
			}
			if($count==count($ds_biencheimport)){
				return true;
			}
			else{
				return false;
			}
		}
		public function addquatrinhbienche($ds_biencheimport){
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$user_id = $user->id;
			$query = $db->getQuery(true);
			$ngayquyetdinh = $this->convertDate1($ds_biencheimport['ngayquyetdinh']);
			$field = array($db->quotename('quyetdinh_so').'='.$db->quote($ds_biencheimport['soquyetdinh']),
				$db->quotename('quyetdinh_ngay').'='.$db->quote($ngayquyetdinh),
				$db->quotename('user_id').'='.$db->quote($user_id),
				$db->quotename('dept_id').'='.$db->quote($ds_biencheimport['donvi_id']),
				$db->quotename('nghiepvu_id').'='.$db->quote(1),
				$db->quotename('ngay_tao').'='.$db->quote($ds_biencheimport['ngaytao']),
				$db->quotename('ordering').'='.$db->quote(99),
				$db->quotename('nam').'='.$db->quote($ds_biencheimport['nam']));
			$query->insert('ins_dept_quatrinh_bienche');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function addchitietquatrinhbienche($bienche_import_id,$quatrinh_id){
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$user_id = $user->id;
			$ds_soluongbienche = $this->findsoluongbienchebyimportbctc_id($bienche_import_id);
			// var_dump($ds_soluongbienche);die;
			for($i=0;$i<count($ds_soluongbienche);$i++){
				$query = $db->getQuery(true);
				$field = array($db->quotename('quatrinh_id').'='.$db->quote($quatrinh_id),
						$db->quotename('hinhthuc_id').'='.$db->quote($ds_soluongbienche[$i]['bc_hinhthuc_id']),
						$db->quotename('bienche').'='.$db->quote($ds_soluongbienche[$i]['soluongbienche']));
				$query->insert('ins_dept_quatrinh_bienche_chitiet');
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function updatetrangthai_biencheimport($bienche_import_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('bienche_ins_dept_import');
			$query->set('trangthai=1');
			$query->where('id='.$db->quote($bienche_import_id));
			$db->setQuery($query);
			return $db->query();
		}	
	}
?>