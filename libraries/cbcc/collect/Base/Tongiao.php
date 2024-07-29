<?php
class Base_Collect_Tongiao{
	public static function collect($where=null)
	{
		$db = JFactory::getDbo();
		$class = 'JDatabaseQuery' . ucfirst($db->name);
		//$query = "SELECT code as value, name as text FROM base_loaihinh";
		//var_dump($where instanceof $class);
		if ($where instanceof $class) {
			$query = $where;			
		}else{			
			$query = $db->getQuery(true);
			$query->select(array('id','name AS text'))
				 ->from('rel_code');
			$where[] = 'status = 1';
			if ($where != null && (is_array($where) || is_string($where))) {
				$query->where($where);
			}
		}
		$db->setQuery($query);				
		return $db->loadAssocList();
	}

	/**
	 *
	 * @static
	 * @param int $id
	 * @return string
	 */
	public static function getName($id)
	{
		$db = JFactory::getDbo();
		$class = 'JDatabaseQuery' . ucfirst($db->name);
		//$query = "SELECT code as value, name as text FROM base_loaihinh";
		if ($id instanceof $class) {
			$query = $id;
		}else{
			$where = array();
			$where[] = 'id = '.$db->quote($id);
			$query = $db->getQuery(true);
			$query->select('name')
				->from('rel_code')
				->where($where);
		}	
		$db->setQuery($query);
		return $db->loadResult();
	}
}