<?php
class Danhmuc_Model_PlaceTraining extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/PlaceTraining');
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		$src['parent'] = $formData['parent'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/PlaceTraining');
		$src['code'] = $formData['code'];
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		$src['parent'] = $formData['parent'];
		return $table->save($src);
	}
	public function read($code){
		$table = Core::table('Danhmuc/PlaceTraining');
		if (!$table->load($code)) {
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
		$table = Core::table('Danhmuc/PlaceTraining');
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
		$table = Core::table('Danhmuc/PlaceTraining');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('code AS id','name AS value'))
				->from($table->getTableName());
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
		$table = Core::table('Danhmuc/PlaceTraining');
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
			$table = Core::table('Danhmuc/PlaceTraining');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
	function getTruongDaoTao(){
		$query = 'SELECT dm.name AS text, dm.code AS id, dm.parent as parentid,dm.status as status'
				. ' FROM place_training AS dm where dm.parent is null '
						. ' ORDER BY dm.code';
		//echo 'truy van'.$query;
		$this->_db->setQuery( $query );
		return $this->_db->loadObjectList();
	}
	public function getNameByParent($id = null){
		// Load the data
		$db = JFactory::getDBO();
		$where = array();
		if((int)$id != 0){
			$where[] = "a.parent =".$id;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby = " ORDER BY a.code";
		$query='select a.*, b.`name` as parent_name from place_training as a
						LEFT JOIN place_training as b on a.parent = b.`code`'
									.$where
									.$orderby
									;
									//   $db->setQuery( $query );
									$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
									// echo $query;
									return $this->_data;
	}
	function getTotalPlace($id=null)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$db = JFactory::getDBO();
			$where = array();
			if((int)$id != 0){
				$where[] = "parent =".$id;
			}
			$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
			$orderby = " ORDER BY code";
			$query='select * from place_training'
			.$where
			.$orderby
			;
			// echo $query;
			$this->_total = $this->_getListCount($query);
			//var_dump($this->_total);
		}
		return $this->_total;
	}
	function getPaginationPlace($id=null)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotalPlace('place_training',$id), $this->getState('limitstart'), $this->getState('limit') );
		}
	
		return $this->_pagination;
	}
}