<?php
class Base_Collect_Donvitungcongtac{
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
			$query->select('DISTINCT INST_NAME_CT AS id,INST_NAME_CT AS name')
			->from('quatrinhcongtac');
			$where[] = 'inst_code_ct > 0 ';
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
			$query->select('inst_name_ct')
			->from('quatrinhcongtac')
			->where($where);
		}
		$db->setQuery($query);
		return $db->loadResult();
	}
}