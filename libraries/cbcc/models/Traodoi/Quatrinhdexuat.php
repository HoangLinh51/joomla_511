<?php
class Traodoi_Model_Quatrinhdexuat{
	private $_total_rows = 0;
	
	public function getTotalRows(){
		return $this->_total_rows;
	}
	public function listAll($params = null,$order = null,$offset = null,$limit = null){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
		$query->select("a.hoten AS e_name,b.*,d.name AS fullname")
			->from('quatrinhdexuat b')
			->join("INNER", 'hosochinh_quatrinhhientai a ON b.emp_id = a.hosochinh_id')
			->join("INNER", '#__users d ON d.id = b.id_user')
			//->join("LEFT", 'hoso_capmathe b ON b.hoso_id = a.id')
		;
		$where = array();
		if (isset($params['type_id']) && !empty($params['type_id'])) {
			$where[] = 'b.type_id = '.$db->quote($params['type_id']);
		}
		if (isset($params['is_xuly']) && null != $params['is_xuly']) {
			$where[] = 'b.is_xuly = '.$db->quote($params['is_xuly']);
		}
		if (isset($params['dept_id']) && !empty($params['dept_id'])) {
			$rows = Core::getAllDeptById($params['dept_id']);
			//var_dump($rows);
			if (count($rows) > 0 ) {
				$where[] = '(a.congtac_donvi_id IN ('.implode(',', $rows).') OR a.congtac_phong_id IN ('.implode(',', $rows).'))';
			}
				
		}else{
			$root_id = Core::getManageUnit($user->id,'com_capmathe','capmathe','default');
			$rows = Core::getAllDeptById($root_id);
			if (count($rows) > 0 ) {
				$where[] = '(a.congtac_donvi_id IN ('.implode(',', $rows).') OR a.congtac_phong_id IN ('.implode(',', $rows).'))';
			}
		}
// 		if (isset($params['search']) && !empty($params['search'])) {
// 			$where[] = '(d.name LIKE ('.$db->quote('%'.$params['search'].'%').') OR '
// 					. 'p.name LIKE ('.$db->quote('%'.$params['search'].'%').') OR '
// 						 . 'a.e_name LIKE ('.$db->quote('%'.$params['search'].'%').')) '
// 						 		;
// 		}
		$query->where($where);
		if ($order == null) {
			$query->order('b.date_dexuat');
		}else{
			$query->order($order);
		}
		//var_dump($offset != null);
		if((int)$limit > 0 ){
			//var_dump($offset,$limit);
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		//echo $query->__toString();exit;
		$rows = $db->loadAssocList();
		
		// xu ly total
		$query = $db->getQuery(true);
		$query->select('COUNT(b.id_dexuat)')
			->from('quatrinhdexuat b')
			->join("INNER", 'hosochinh_quatrinhhientai a ON b.emp_id = a.hosochinh_id')
			->join("INNER", '#__users d ON d.id = b.id_user')
		;
		$query->where($where);
		$db->setQuery($query);
		$this->_total_rows = (int)$db->loadResult();
		//
		return $rows;
	}
	public function create($formData, $option = null){
		$table = Core::table('Traodoi/Quytrinhdexuat');		
		$data = array(				
				'id_user'=>$formData['id_user'],
				'emp_id'=>$formData['emp_id'],
				'dexuat'=>$formData['dexuat'],
				'is_xuly'=>0,
				'date_dexuat'=>date('Y-m-d H:i:s'),			
				'type_id'=>$formData['type_id']
				
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table->bind($data);
		return $table->store();	
	}
	public function update($formData, $option = null){
		$table = Core::table('Traodoi/Quytrinhdexuat');
		$data = array(
				'id_dexuat'=>$formData['id_dexuat'],
				'id_user'=>$formData['id_user'],
				'emp_id'=>$formData['emp_id'],
				'dexuat'=>$formData['dexuat'],
				'date_dexuat'=>$formData['date_dexuat'],
				'is_xuly'=>$formData['is_xuly'],
				'date_xuly'=>date('Y-m-d H:i:s'),
				'type_id'=>$formData['type_id']
	
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table->bind($data);
		return $table->store();
	}
	public function read($id_dexuat){
		$table = Core::table('Traodoi/Quytrinhdexuat');		
		return $table->getRowById($id_dexuat);
	}
	public function xuly($id_dexuat,$option = null){
		$table = Core::table('Traodoi/Quytrinhdexuat');
		$data = array(
				'id_dexuat'=>$id_dexuat,			
				'is_xuly'=>1,
				'date_xuly'=>date('Y-m-d H:i:s')
	
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table->bind($data);
		return $table->store();
	}
}