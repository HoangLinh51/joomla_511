<?php
class Danhmuc_Model_LsCode extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/LsCode');
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		$src['lim_code'] = $formData['lim_code'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/LsCode');
		$src['code'] = $formData['code'];
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		$src['lim_code'] = $formData['lim_code'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/LsCode');
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
		$table = Core::table('Danhmuc/LsCode');
		if(!is_array($cid)||count($cid)==0){
			$flag	=	false;
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		return $flag;
	}
	public function collect($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/LsCode');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('code AS id','name AS value'))
				->from($table->getTableName());
		$query->where('lim_code IN( SELECT chuyennganh_fk from dt_trinhdo_nganh where loaitrinhdo_fk=2)');
		$query->where('status = 1');
		if (isset($params['name']) && !empty($params['name'])) {
			if(strpos($params['name'], 'button-ajax') === false){
				$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
			}
		}
		if ($order == null) {
			$query->order('name');
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
	
	public function findAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/LsCode');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			->from($table->getTableName())
		;
		if (isset($params['name']) && !empty($params['name'])) {
			$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
		}
		if ($order == null) {
			$query->order('code');
		}else{
			$query->order($order);
		}
		
		if($offset != null && $limit != null){
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		return $db->loadObjectList();
	
	}
	
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/LsCode');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['code']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
	//lay du lieu do ra cay thu muc trong bang ls_code
	function getTenNhomNganh(){
		$query = 'SELECT dm.name AS text, dm.code AS id, dm.lim_code as parentid,dm.status as status'
				. ' FROM ls_code AS dm where dm.lim_code is null '
						. ' ORDER BY dm.code';
		//echo 'truy van'.$query;
		$this->_db->setQuery( $query );
			
		return $this->_db->loadObjectList();
	}
	//ham lay name theo lim_code trong bang ls_code
	function getNameByLimCode($id= null){
		$db = JFactory::getDBO();
		$where = array();
		if((int)$id != 0){
			$where[] = "a.lim_code = ".$id;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby = " ORDER BY a.code";
		$query='select a.*, b.`name` as lim_name from ls_code as a
						LEFT JOIN ls_code as b on a.lim_code = b.`code`'
			    		.$where
			    		.$orderby
			    		;
			    		$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
			    		return $this->_data;
	}
	function getTotalLsCode($id=null)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$db = JFactory::getDBO();
			$where = array();
			if((int)$id != 0){
				$where[] = "a.lim_code = ".$id;
			}
			$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
			$orderby = " ORDER BY a.code";
			$query='select a.*, b.`name` as lim_name from ls_code as a
						LEFT JOIN ls_code as b on a.lim_code = b.`code`'
									.$where
									.$orderby
									;
									$this->_total = $this->_getListCount($query);
									//var_dump($this->_total);
		}
		return $this->_total;
	}
	function getPaginationLsCode($id=null)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotalLsCode($id), $this->getState('limitstart'), $this->getState('limit') );
		}
	
		return $this->_pagination;
	}
}