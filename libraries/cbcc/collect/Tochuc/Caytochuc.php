<?php
class Tochuc_Collect_Caytochuc{
	public static function collect($params = array(),$option = array())
	{
		$db = JFactory::getDbo();
		$query = "SELECT id, name FROM tochuc_caytochuc";
		$db->setQuery( $query );
		return $db->loadObjectList();
	}

	/**
	 *
	 * @static
	 * @param int $id
	 * @return string
	 */
	public static function getName($arguments,$option = array())
	{
		$db = JFactory::getDbo();
		if(isset($arguments['code'])){
			$query = "SELECT name FROM tochuc_caytochuc WHERE code = ".$db->quote($arguments['code']);
		}else{
			$query = "SELECT name FROM tochuc_caytochuc WHERE id = ".$db->quote($arguments['id']);
		}
		//echo $query;
		$db->setQuery( $query );
		return $db->loadResult();
	}
}