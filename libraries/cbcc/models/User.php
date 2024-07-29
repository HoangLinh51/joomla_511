<?php
class User{
	public function getInfo($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$cols = array('id','name','username','email','\'avatar.png\' AS avatar','lastvisitDate');
		$query->select($cols)->from('#__users');
		if (is_array($id)) {			
			$query->where($id);
		}else {
			//$db->quoteName('InstrumentFamily').'='.$db->quote('debt')
			$query->where($db->quoteName('id').' = '.$db->quote($id));
		}		
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	public function getCount($where = null){
		$db = JFactory::getDbo();
		$class = 'JDatabaseQuery' . ucfirst($db->name);
		//$query = "SELECT code as value, name as text FROM base_loaihinh";
		//var_dump($where instanceof $class);
		if ($where instanceof $class) {
			$query = $where;
		}else{			
			$query = $db->getQuery(true);
			$query->select('COUNT(id)')
				->from('#__users')			
			;
			if ($where != null && (is_array($where) || is_string($where))) {
				$query->where($where);
			}
		}
		//echo 	$query->__toString();	
		$db->setQuery($query);		
		return $db->loadResult();
	}
	public function getAll($limit,$page,$where = null){
		$db = JFactory::getDbo();
		$class = 'JDatabaseQuery' . ucfirst($db->name);
		//$query = "SELECT code as value, name as text FROM base_loaihinh";
		//var_dump($where instanceof $class);
		if ($where instanceof $class) {
			$query = $where;
		}else{
			$cols = array('id','name','username','email','\'avatar.png\' AS avatar','lastvisitDate');
			$query = $db->getQuery(true);
			$query->select($cols)
				  ->from('#__users')
				  ->order('username')
			;			
			if ($where != null && (is_array($where) || is_string($where))) {
				$query->where($where);
			}
		}
		if ($limit == 0) {
			$db->setQuery($query);
		}else{
			$db->setQuery($query,(--$page*$limit),$limit);
		}		
		return $db->loadAssocList();
	}
}