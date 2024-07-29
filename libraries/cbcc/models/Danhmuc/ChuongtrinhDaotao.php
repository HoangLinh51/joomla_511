<?php
class Danhmuc_Model_ChuongtrinhDaotao extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
		$src['id'] = $formData['id'];
		$src['name'] = $formData['name'];
		$src['status'] = $formData['status'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
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
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
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
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id AS id','name AS value'))
				->from($table->getTableName());
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
		$table = Core::table('Danhmuc/ChuongtrinhDaotao');
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
		return $db->loadObjectList();
	
	}
	
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/ChuongtrinhDaotao');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
	function getTotalChuongtrinh($id=null)
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
			$orderby = " ORDER BY id";
			$query='select * from danhmuc_chuongtrinhdaotao'
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
			$this->_pagination = new JPagination( $this->getTotalChuongtrinh('danhmuc_chuongtrinhdaotao',$id), $this->getState('limitstart'), $this->getState('limit') );
		}
	
		return $this->_pagination;
	}
}