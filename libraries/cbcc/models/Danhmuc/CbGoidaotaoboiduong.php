<?php
class Danhmuc_Model_CbGoidaotaoboiduong extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function save($formData){	
		$flag = false;
		$table = Core::table('Danhmuc/CbGoidaotaoboiduong');
		$tableCbGoidaotaoboiduongLoaitrinhdo = Core::table('Danhmuc/CbGoidaotaoboiduongLoaitrinhdo');
		$src['id'] = $formData['id'];
		$src['name'] = $formData['name'];	
		$src['status'] = $formData['status'];
		$flag = $table->save($src);
		$goidaotaoboiduong_id = $table->id;
		//var_dump($doituong_id);exit;
		//$tableDoituongCaptochuc->set('doituong_id',$doituong_id);
		//$tableDoituongCaptochuc->delete(array('doituong_id'=>$doituong_id));
		$db = $tableCbGoidaotaoboiduongLoaitrinhdo->getDbo();
		//$tableDoituongCaptochuc->getDbo()
		$query = $db->getQuery(true)
				->delete($tableCbGoidaotaoboiduongLoaitrinhdo->getTableName())
				->where('goidaotaoboiduong_id = '.$db->quote($goidaotaoboiduong_id));
		$db->setQuery($query);
		$db->query();
		//exit;
		for ($i = 0; $i < count($formData['type_sca_code_id']); $i++) {
			$tableCbGoidaotaoboiduongLoaitrinhdo->save(array('goidaotaoboiduong_id'=>$goidaotaoboiduong_id,'type_sca_code_id'=>(int)$formData['type_sca_code_id'][$i]));
		}		
		return $flag;
	}

	public function read($id){
		$table = Core::table('Danhmuc/CbGoidaotaoboiduong');
		if (!$table->load($id)) {
			return null;
		}
		$fields = array_keys($table->getFields());
		$data = array();
		$count = count($fields);
		for ($i = 0; $i < $count ; $i++) {
			$tmp = $fields[$i];
			$data[$fields[$i]] = $table->$tmp;
		}
		return $data;
	}
	public function delete($cid){
		$table = Core::table('Danhmuc/CbGoidaotaoboiduong');
		$flag = false;
		if(!is_array($cid)){
			$flag = $table->delete($cid);			
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		if($flag == true){
			$tableCbGoidaotaoboiduongLoaitrinhdo = Core::table('Danhmuc/CbGoidaotaoboiduongLoaitrinhdo');
			$db = $tableCbGoidaotaoboiduongLoaitrinhdo->getDbo();
			//$tableDoituongCaptochuc->getDbo()
			$query = $db->getQuery(true)
					->delete($tableCbGoidaotaoboiduongLoaitrinhdo->getTableName())
					->where('goidaotaoboiduong_id = '.$db->quote($goidaotaoboiduong_id));
			$db->setQuery($query);
			$db->query();
		}
		return $flag;
	}
	public function getLoaiTrinhDoById($id){
		$db = Core::db();
		$sql = 'SELECT * FROM cb_goidaotaoboiduong_loaitrinhdo WHERE goidaotaoboiduong_id = '.$db->quote($id);
		$db->setQuery($sql);
		return $db->loadAssocList();
	}
	
	public function fetchAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/CbGoidaotaoboiduong');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
		->from($table->getTableName())
		;
		if (isset($params['name']) && !empty($params['name'])) {
			$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
		}
		if ($order == null) {
			$query->order('id');
		}else{
			$query->order($order);
		}

		if($offset != null && $limit != null){
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		return $db->loadAssocList();

	}
}