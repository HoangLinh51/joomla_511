<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Baucuxuatbieumau
{

	function getMau30_donvibaucu($dotbaucu_id, $capbaucu_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(
			'count(dvbc.id) as donvibaucu_tongso,
			(
				select sum(if((100*bbbc2.socutribophieu/bbbc2.tongsocutri)<50,1,0))
				from baucu_bienbanbaucu bbbc2
				inner join baucu_donvibaucu dvbc2 on dvbc2.id = bbbc2.donvibaucu_id
				where 	bbbc2.dotbaucu_id = '.(int)$dotbaucu_id.' AND bbbc2.capbaucu_id = '.(int)$capbaucu_id.' AND bbbc2.daxoa = 0 
			) as donvibaucu_duoi50,
			count(if( ( SELECT count( tobaucu_id ) FROM baucu_donvibaucu2tobaucu WHERE donvibaucu_id = dvbc.id )=1,1,null)) AS donvibaucu_1dvbp 
			'
		)
		->from('baucu_donvibaucu dvbc')
		->where('dvbc.dotbaucu_id = '.(int)$dotbaucu_id.' AND dvbc.capbaucu_id = '.(int)$capbaucu_id.' AND dvbc.daxoa = 0');
		$db->setQuery($query);
		// echo $query;
		return $db->loadAssoc();
	}
	/**
	 * Chuyển string sang array, bắt SQL-injection, các filter string/int đều phải bọc
	 * input: string
	 * output: array
	 */
	static function stringToArrDb($string)
	{
		$db = JFactory::getDbo();
		if ($string != null && $string != 'null' && $string != '' && $string != 'undefined')
			$arr = explode(',', $string);
		$rs = [];
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$rs[] = $db->quote($v);
			}
		}
		return $rs;
	}
}
