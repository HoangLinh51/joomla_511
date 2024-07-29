<?php
class Core_Model_Logs{	
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
			'user_ip'=>$formData['user_ip'],
			'user_id'=>$formData['user_id'],
			'fullname'=>$formData['fullname'],
			'component'=>$formData['component'],
			'controller'=>$formData['controller'],
			'task'=>$formData['task'],
			'link'=>$formData['link'],
			'error'=>$formData['error'],
			'date_log'=>$formData['date_log'],
			'message'=>$formData['message']				
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table = Core::table('Core/Logs');
		return $table->save($data);	
	}
	/**
	 * Lấy log
	 * @param int $id
	 * @return array
	 */
	public function getLogById($id){
		$table = Core::table('Core/Logs');
		return $table->getLogById($id);
	}
	/**
	 * Xóa log
	 * @param array|int $ids
	 */
	public function delete($ids){
		$table = Core::table('Core/Logs');
		if (is_array($ids)) {
			for ($i = 0,$n=count($ids); $i < $n; $i++) {
				$table->delete($ids[$i]);
			}
		}else{
			$table->delete($ids);
		}
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
	public function getAction($component,$controller,$task,$location='site'){
		$table = Core::table('Core/Action');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			->from($table->getTableName())
			->where('component = '.$db->quote($component))
			->where('controllers = '.$db->quote($controller))
			->where('tasks = '.$db->quote($task))
			->where('location = '.$db->quote($location))
		;	
		$db->setQuery($query);		
		return $db->loadAssoc();
	}
	public function findAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Core/Logs');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('l.*','d.name','sess.userid AS user_online'))
		      ->from($table->getTableName().' l')
		      ->join('LEFT', '(SELECT cu.*,dept.name FROM core_user_donvi cu INNER JOIN ins_dept dept ON dept.id = cu.id_donvi) d ON d.id_user = l.user_id')
		      ->join('LEFT', '(SELECT userid FROM jos_session GROUP BY userid) sess ON sess.userid = l.user_id')
		;
		//var_dump($params);
		if (isset($params['ip']) && !empty($params['ip'])) {
			$query->where('l.user_ip LIKE ('.$db->quote('%'.$params['ip'].'%').')','OR');
		}
		if (isset($params['fullname']) && !empty($params['fullname'])) {
			$query->where('l.fullname LIKE ('.$db->quote('%'.$params['fullname'].'%').')','OR');
		}
		if (!empty($params['date_begin']) && !empty($params['date_end'])) {
			$query->where("(DATE_FORMAT(l.date_log, '%d/%m/%Y') BETWEEN ".$db->quote($params['date_begin'])." AND ".$db->quote($params['date_end']).")");
		}
		if ($order === null) {
			$query->order('l.id');
		}else{
			$query->order($order);
		}
		//var_dump($offset !== null && $limit !== null);
		if($offset !== null && $limit !== null){
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		///echo $query->__toString();
		//exit;
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
		$table = Core::table('Core/Logs');		
		return $table->truncate();
	}
	/**
	 * Block user
	 * @return mixed
	 */
	public function block($user_id){
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__users')->set(array('block = 1'))->where('id = '.$db->quote($user_id));
		$db->setQuery($query);
		if($db->execute()){
			$options = array(
					'clientid' => 0
			);
			$app->logout($table->id, $options);
		}
	}
	/**
	 * Logout  user
	 * @return mixed
	 */
	public function logout($user_id){
	    $app = JFactory::getApplication();
        $options = array(
	            'clientid' => 0
	        );
	    return $app->logout($user_id, $options);	    
	}
}