<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Noicap
{
	public function getDanhsach()
	{
		$array['flt_ten'] = JRequest::getVar('flt_ten', null);
		$array['flt_trangthai'] = JRequest::getVar('flt_trangthai', null);
		$db = JFactory::getDbo();
		$db->sql("SET character_set_client=utf8");
		$db->sql("SET character_set_connection=utf8");
		$db->sql("SET character_set_results=utf8");
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		$columns = array(
			array('db' => 'a.id',					'dt' => 0),
			array('db' => 'a.name',					'dt' => 1),
			array('db' => 'a.cap',						'dt' => 2),
			array('db' => 'a.type',						'dt' => 3),
			array('db' => (($i4223==1 && in_array('danhmuc_noicap', $t4223))?'a.code_bnv':'a.id'), 'alias' => 'code_bnv','dt' => 4),
			array('db' => 'a.status',						'dt' => 5),
			array('db' => 'a.id', 'alias' => 'aa',					'dt' => 6),
		);
		$table = 'danhmuc_noicap AS a';
		$primaryKey = 'a.id';
		$join = '';
		if (isset($array['flt_ten']) && $array['flt_ten'] != null)
			$where[] = 'a.name like "%' . $array['flt_ten'] . '%"';
		$flt_trangthai = self::stringToArrDb($array['flt_trangthai']);
		if ($flt_trangthai != null && count($flt_trangthai) > 0 && is_array($flt_trangthai))
			$where[] = 'a.status IN (' . implode(',', $flt_trangthai) . ')';
		$flt_type = self::stringToArrDb($array['flt_type']);
		if ($flt_type != null && count($flt_type) > 0 && is_array($flt_type))
			$where[] = 'a.type IN (' . implode(',', $flt_type) . ')';

		$where = implode(' AND ', $where);
		$datatables = Core::model('Core/Datatables');
		return $datatables->simple($_POST, $table, $primaryKey, $columns, $join, $where);
	}
	public function save($formData)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('name') . ' = ' . $db->quote($formData['name']),
			$db->quoteName('status') . ' = ' . $db->quote($formData['status']),
			$db->quoteName('ma') . ' = ' . $db->quote($formData['ma']),
			$db->quoteName('cap') . ' = ' . $db->quote($formData['cap']),
			$db->quoteName('type') . ' = ' . $db->quote($formData['type']),
		);
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		if($i4223==1 && in_array('danhmuc_noicap', $t4223)){
			array_push($fields, $db->quoteName('code_bnv') . ' = ' . $db->quote($formData['code_bnv']));
		}
		if (isset($formData['id']) && $formData['id']>0) {
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('danhmuc_noicap'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			return $formData['id'];
		} else {
			$query->insert($db->quoteName('danhmuc_noicap'));
			$query->set($fields);
			$db->setQuery($query);
			$db->execute();
			return $db->insertid();
		}
	}
	function xoa($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if ($id != null && count($id) > 0 && is_array($id))
			$conditions = array(
				$db->quoteName('id') . ' IN (' . implode(',', $db->quote($id)) . ')'
			);
		else return false;

		// Dùng cái này nếu xóa hẳn row
		$query->delete('danhmuc_noicap');
		$query->where($conditions);

		// Dùng cái này nếu có daxoa
		// $fields = array(
		// 	$db->quoteName('daxoa') . ' = 1',
		// );
		// $query->update($db->quoteName('danhmuc_noicap'))->set($fields)->where($conditions);

		$db->setQuery($query);
		return $db->execute();
	}
	function get($id){
		$db = JFactory::getDbo();
		return Core::loadAssoc('danhmuc_noicap','*', 'id='.$db->quote($id));
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
