<?php
class Base_Collect_Chucvutungcongtac{
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
			$query->select("a.pos_system_id AS id, CONCAT(a.name,' (',b.name,')') AS name")
				->from('cb_goichucvu_chucvu a')				
				->join('INNER', 'cb_goichucvu b ON b.id = a.goichucvu_id');
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
			$where[] = 'mangach = '.$db->quote($id);
			$query = $db->getQuery(true);
			$query->select('tencap')
			->from('cb_captochuc_chucvu')
			->where($where);
		}
		$db->setQuery($query);
		return $db->loadResult();
	}
}