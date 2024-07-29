<?php
class Core_Model_BlockIp{
	private $_total_rows = 0;

	public function getTotalRows(){
		return $this->_total_rows;
	}
	/**
	 * Tao mới log
	 * @param array $formData
	 * @return boolean
	 */
	public function save($formData){
		$data = array(
				'id'=>$formData['id'],
				'ip'=>$formData['ip'],
				'status'=>(int)$formData['status'],
				'date_block'=>$formData['date_block'],
				'ghichu'=>$formData['ghichu']
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table = Core::table('Core/BlockIp');
		return $table->save($data);
	}
	/**
	 * Lấy log
	 * @param int $id
	 * @return array
	 */
	public function getRowById($id){
		$table = Core::table('Core/BlockIp');
		return $table->getRowById($id);
	}
	/**
	 * Xóa log
	 * @param array|int $ids
	 */
	public function delete($ids){
		$table = Core::table('Core/BlockIp');
		if (is_array($ids)) {
			for ($i = 0,$n=count($ids); $i < $n; $i++) {
				$table->delete($ids[$i]);
			}
		}else{
			$table->delete($ids);
		}
	}

	public function findAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Core/BlockIp');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
		->from($table->getTableName())
		;
		if (isset($params['ip']) && !empty($params['ip'])) {
			$query->where('ip LIKE ('.$db->quote($params['ip'].'%').')');
		}
		if ($order === null) {
			$query->order('id');
		}else{
			$query->order($order);
		}
		//var_dump($offset !== null && $limit !== null);
		if($offset !== null && $limit !== null){
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		//echo $query->__toString();
		$rows = $db->loadAssocList();
		// xu ly total
		$query->clear('select')->clear('order')->clear('limit');
		$query->select('COUNT(*)');
		$db->setQuery($query);
		//echo $query->__toString();
		$this->_total_rows = $db->loadResult();
		return $rows;
		//return $table->delete($id);
	}
	/**
	 * Xoa tat ca cac row
	 * @return mixed
	 */
	public function truncate(){
		$table = Core::table('Core/BlockIp');
		return $table->truncate();
	}

	public function block($ip,$ghichu){
		$this->deleteByIp($ip);
		$formData = array('ip'=>$ip,'date_block'=>date('Y-m-d H:i:s'),'ghichu'=>$ghichu,'status'=>1);
		return $this->save($formData);
	}
	public function deleteByIp($ip){
		$table = Core::table('Core/BlockIp');
		$db = $table->getDbo();
		$query = $db->getQuery(true);		
		$query->delete($table->getTableName())->where($db->quoteName('ip') . ' = ' . $db->quote($ip));
		$db->setQuery($query);
		return $db->execute();
	}
	/**
	 * Kiem tra xem ip co nam trong block list không
	 * @param string $ip
	 * @return boolean
	 */
	public function checkIps(){
		$ip = $this->getIP();
		$table = Core::table('Core/BlockIp');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)')->from($table->getTableName())->where('ip = '.$db->quote($ip));
		$db->setQuery($query);
		$cnt = $db->loadResult();
		if ($cnt > 0 ) {
			return true;
		}	
		return false;
	}
	/**
	 * lay ip người dùng
	 * @return string
	 */
	public function getIP() {
		if (getenv("HTTP_CLIENT_IP")) return getenv("HTTP_CLIENT_IP");
		if (getenv("HTTP_X_FORWARDED_FOR")) return getenv("HTTP_X_FORWARDED_FOR");
		if (getenv("REMOTE_ADDR")) return getenv("REMOTE_ADDR");
		return "UNKNOWN";
	}
}