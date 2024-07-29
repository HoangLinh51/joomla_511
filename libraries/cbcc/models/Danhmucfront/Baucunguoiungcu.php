<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Baucunguoiungcu
{
	function upload_nguoiungcu(){
		require_once JPATH_LIBRARIES.'/phpexcel/Classes/PHPExcel/IOFactory.php';
                
		$arr = array();
		$user_import = jFactory::getUser()->id;
		$md5 = md5(rand(0,999));
		$hash = substr($md5, 15, 10);
		$filename	= 	$hash.date('mdY').''.($this->regexFileUpload($_FILES['file']['name'], true));
		move_uploaded_file($_FILES['file']['tmp_name'], 'tmp/'.$filename); // tải file lên server
		$objPHPExcel = PHPExcel_IOFactory::load ('tmp/'.$filename);
		$objPHPExcel->setActiveSheetIndex(0); // lấy sheet đầu tiên
		//  	$objPHPExcel->setActiveSheetIndexByName('DSCBCC'); // lấy sheet với tên DSCBCC
		$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn(); // số cột lớn nhất
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn ); // số cột lớn nhất
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); // số hàng lớn nhất
		// lấy cột a2 và cột ax2
		// echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow ( 'A', '2' )->getValue ();
		$a2 = $objPHPExcel->getActiveSheet()->getCell ( 'A2' )->getValue();
		$ay1 = $objPHPExcel->getActiveSheet()->getCell ( 'AY1' )->getValue();
			for($row = 4; $row <= $highestRow ; ++ $row) {
				for($col = 0; $col < $highestColumnIndex; ++ $col) {
					$cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow ( $col, $row );
					$val = $cell->getValue();
					if ($row == 1)
						echo $val;
					else{
						$arr[$row][$col]= $val;
					}
				}
			}
			unlink('tmp/'.$filename); // xóa file khỏi hệ thống
			// lưu dữ liệu vào db
			// var_dump($arr);die;
			foreach ($arr as $key => $val) {
				$formData = array();
				$formData['hoten']= $val[1];
				$formData['gioitinh']= strtoupper($val[3])=="NAM"?"1":"2";
				$formData['quequan']= $val[7];
				if($val[2]<9999) {
					
					$formData['namsinh'] =  $val[2];
					$formData['is_chiconamsinh'] = 1;
				}
				else {
					$formData['ngaysinh'] = PHPExcel_Style_NumberFormat::toFormattedString($val[2], 'DD/MM/YYYY');
					$formData['is_chiconamsinh'] = 0;
				}
				$formData['quoctich']= $val[4];
				$formData['dantoc']= $val[5];
				$formData['tongiao']= $val[6];
				$formData['noiohiennay']= $val[8];
				$formData['trinhdo_gdpt']= $val[9];
				$formData['trinhdo_chuyenmon']= $val[10];
				$formData['trinhdo_hocham']= $val[11];
				$formData['trinhdo_lltt']= $val[12];
				$formData['trinhdo_ngoaingu']= $val[13];
				$formData['nghenghiep']= $val[14];
				$formData['noicongtac']= $val[15];
				$formData['ngayvaodang']= PHPExcel_Style_NumberFormat::toFormattedString($val[16], 'DD/MM/YYYY');
				$formData['daibieuqh']= strtoupper($val[17])=='X'?1:0;
				$formData['daibieuhdnd']= strtoupper($val[18])=='X'?1:0;
				$formData['nguoiimport']= JFactory::getUser()->id;
				$formData['trangthai']= 1;
				$formData['ghichu']= $val[19];
				$this->save($formData);
			}
			return true;
	}
	public function getDanhsach()
	{
		$array['flt_ten'] = JRequest::getVar('flt_ten', null);
		$array['flt_trangthai'] = JRequest::getVar('flt_trangthai', null);
		$db = JFactory::getDbo();
		$db->sql("SET character_set_client=utf8");
		$db->sql("SET character_set_connection=utf8");
		$db->sql("SET character_set_results=utf8");	
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		$i=0;
		$columns = array(
			array('db' => 'a.id',					'dt' => $i++),
			array('db' => 'a.hoten',					'dt' => $i++),
			array('db' => 'if(a.is_chiconamsinh=0, DATE_FORMAT(a.ngaysinh, "%d/%m/%Y"), DATE_FORMAT(a.ngaysinh, "%Y"))','alias'=>'asdvhgd',					'dt' => $i++),
			array('db' => 'a.gioitinh',					'dt' => $i++),
			array('db' => 'a.trinhdo_chuyenmon',					'dt' => $i++),
			array('db' => 'a.nghenghiep',					'dt' => $i++),
			array('db' => 'a.noicongtac',					'dt' => $i++),
			array('db' => (($i4223==1 && in_array('baucu_nguoiungcu', $t4223))?'a.code_bnv':'a.id'), 'alias' => 'code_bnv','dt' => $i++),
			array('db' => 'a.trangthai',						'dt' => $i++),
			array('db' => 'a.id', 'alias' => 'aa',					'dt' => $i++),
		);
		$table = 'baucu_nguoiungcu AS a';
		$primaryKey = 'a.id';
		$join = '';
		$where[] = 'a.daxoa=0';
		if (isset($array['flt_ten']) && $array['flt_ten'] != null)
			$where[] = 'a.hoten like "%' . $array['flt_ten'] . '%"';
		$flt_trangthai = self::stringToArrDb($array['flt_trangthai']);
		if ($flt_trangthai != null && count($flt_trangthai) > 0 && is_array($flt_trangthai))
			$where[] = 'a.trangthai IN (' . implode(',', $flt_trangthai) . ')';

		$where = implode(' AND ', $where);
		$datatables = Core::model('Core/Datatables');
		return $datatables->simple($_POST, $table, $primaryKey, $columns, $join, $where);
	}
	public function save($formData)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if($formData['is_chiconamsinh']==1) $ngaysinh =  Core::convertToEnDateFromVNdate('01/01/'.$formData['namsinh']);
		else $ngaysinh = Core::convertToEnDateFromVNdate($formData['ngaysinh']);
		$ngayvaodang = Core::convertToEnDateFromVNdate($formData['ngayvaodang']);
		$fields = array(
			$db->quoteName('hoten') . ' = ' . $db->quote($formData['hoten']),
			$db->quoteName('gioitinh') . ' = ' . $db->quote($formData['gioitinh']),
			$db->quoteName('quequan') . ' = ' . $db->quote($formData['quequan']),
			$db->quoteName('ngaysinh') . ' = ' . $db->quote($ngaysinh),
			$db->quoteName('ngayvaodang') . ' = ' . $db->quote($ngayvaodang),
			// $db->quoteName('donvibaucu_id') . ' = ' . $db->quote($formData['donvibaucu_id']),
			$db->quoteName('quoctich') . ' = ' . $db->quote($formData['quoctich']),
			$db->quoteName('dantoc') . ' = ' . $db->quote($formData['dantoc']),
			$db->quoteName('tongiao') . ' = ' . $db->quote($formData['tongiao']),
			$db->quoteName('noiohiennay') . ' = ' . $db->quote($formData['noiohiennay']),
			$db->quoteName('trinhdo_gdpt') . ' = ' . $db->quote($formData['trinhdo_gdpt']),
			$db->quoteName('trinhdo_chuyenmon') . ' = ' . $db->quote($formData['trinhdo_chuyenmon']),
			$db->quoteName('trinhdo_hocham') . ' = ' . $db->quote($formData['trinhdo_hocham']),
			$db->quoteName('trinhdo_lltt') . ' = ' . $db->quote($formData['trinhdo_lltt']),
			$db->quoteName('trinhdo_ngoaingu') . ' = ' . $db->quote($formData['trinhdo_ngoaingu']),
			$db->quoteName('nghenghiep') . ' = ' . $db->quote($formData['nghenghiep']),
			$db->quoteName('noicongtac') . ' = ' . $db->quote($formData['noicongtac']),
			$db->quoteName('daibieuqh') . ' = ' . $db->quote($formData['daibieuqh']),
			$db->quoteName('daibieuhdnd') . ' = ' . $db->quote($formData['daibieuhdnd']),
			$db->quoteName('ghichu') . ' = ' . $db->quote($formData['ghichu']),
			// $db->quoteName('donvibaucu_text') . ' = ' . $db->quote(Core::loadResult('baucu_donvibaucu','ten','id='.(int)$formData['donvibaucu_id'])),
			// $db->quoteName('capbaucu_id') . ' = ' . $db->quote($formData['capbaucu_id']),
			// $db->quoteName('capbaucu_text') . ' = ' . $db->quote(Core::loadResult('baucu_capbaucu','ten','id='.(int)$formData['capbaucu_id'])),
			// $db->quoteName('diaphuongbaucu_id') . ' = ' . $db->quote($formData['diaphuongbaucu_id']),
			// $db->quoteName('diaphuongbaucu_text') . ' = ' . $db->quote(Core::loadResult('baucu_diadiemhanhchinh','ten','id='.(int)$formData['diaphuongbaucu_id'])),
			$db->quoteName('is_chiconamsinh') . ' = ' . $db->quote((int)$formData['is_chiconamsinh']),
			$db->quoteName('trangthai') . ' = ' . $db->quote($formData['trangthai']),
		);
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		if($i4223==1 && in_array('baucu_nguoiungcu', $t4223)){
			array_push($fields, $db->quoteName('code_bnv') . ' = ' . $db->quote($formData['code_bnv']));
		}
		if($formData['nguoiimport']>0){
			array_push($fields, $db->quoteName('nguoiimport') . ' = ' . $db->quote($formData['nguoiimport']));
			array_push($fields, $db->quoteName('ngayimport') . ' = now()');
		}
		if (isset($formData['id']) && $formData['id']>0) {
			array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
			array_push($fields, $db->quoteName('nguoihieuchinh_id') . ' = '.JFactory::getUser()->id);
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('baucu_nguoiungcu'))->set($fields)->where($conditions);
			$db->setQuery($query);
			// echo $query;
			// die;
			$db->execute();
			return $formData['id'];
		} else {
			array_push($fields, $db->quoteName('daxoa') . ' = 0');
			array_push($fields, $db->quoteName('ngaytao') . ' = now()');
			array_push($fields, $db->quoteName('nguoitao_id') . ' = '.JFactory::getUser()->id);
			$query->insert($db->quoteName('baucu_nguoiungcu'));
			$query->set($fields);
			$db->setQuery($query);
			// echo $query;
			// die;
			$db->execute();
			return $db->insertid();
		}
	}
	function xoa($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if ($id != null && count($id) > 0 && is_array($id))
			$conditions = array(
				$db->quoteName('id') . ' IN (' . implode(',', $db->quote($id)) . ')'
			);
		else return false;

		// Dùng cái này nếu xóa hẳn row
		// $query->delete('baucu_nguoiungcu');
		// $query->where($conditions);

		// Dùng cái này nếu có daxoa
		$fields = array(
			$db->quoteName('daxoa') . ' = 1',
			$db->quoteName('trangthai') . ' = 0',
		);
		$query->update($db->quoteName('baucu_nguoiungcu'))->set($fields)->where($conditions);

		$db->setQuery($query);
		return $db->execute();
	}
	function get($id){
		$db = JFactory::getDbo();
		return Core::loadAssoc('baucu_nguoiungcu','*', 'id='.$db->quote($id));
	}
	/**
	 * Chuyển string sang array, bắt SQL-injection, các filter string/int đều phải bọc
	 * input: string
	 * output: array
	 */
	static function stringToArrDb($string)
	{
		$db = JFactory::getDbo();
		if ($string != null && $string != 'null' && $string != '' && $string != 'undefined')
			$arr = explode(',', $string);
		$rs = [];
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$rs[] = $db->quote($v);
			}
		}
		return $rs;
	}
	function regexFileUpload($cs, $tolower = false)
	{
		/*Mảng chứa tất cả ký tự có dấu trong Tiếng Việt*/
		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
				"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề",
				"ế","ệ","ể","ễ",
				"ì","í","ị","ỉ","ĩ",
				"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ",
				"ờ","ớ","ợ","ở","ỡ",
				"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
				"ỳ","ý","ỵ","ỷ","ỹ",
				"đ",
				"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
				"Ằ","Ắ","Ặ","Ẳ","Ẵ",
				"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
				"Ì","Í","Ị","Ỉ","Ĩ",
				"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
				"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
				"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
				"Đ"," ");
	
		/*Mảng chứa tất cả ký tự không dấu tương ứng với mảng $marTViet bên trên*/
		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a",
				"a","a","a","a","a","a",
				"e","e","e","e","e","e","e","e","e","e","e",
				"i","i","i","i","i",
				"o","o","o","o","o","o","o","o","o","o","o","o",
				"o","o","o","o","o",
				"u","u","u","u","u","u","u","u","u","u","u",
				"y","y","y","y","y",
				"d",
				"a","a","a","a","a","a","a","a","a","a","a","a",
				"a","a","a","a","a",
				"e","e","e","e","e","e","e","e","e","e","e",
				"i","i","i","i","i",
				"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
				"u","u","u","u","u","u","u","u","u","u","u",
				"y","y","y","y","y",
				"d","_");
		if ($tolower) {
			return strtolower(str_replace($marTViet,$marKoDau,$cs));
		}
		return str_replace($marTViet,$marKoDau,$cs);
	}
}
