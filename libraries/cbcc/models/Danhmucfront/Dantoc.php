<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Dantoc
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
		$i=0;
		$columns = array(
			array('db' => 'a.id',					'dt' => $i++),
			array('db' => 'a.name',					'dt' => $i++),
			array('db' => (($i4223==1 && in_array('nat_code', $t4223))?'a.code_bnv':'a.id'), 'alias' => 'code_bnv','dt' => $i++),
			array('db' => 'a.status',						'dt' => $i++),
			array('db' => 'a.id', 'alias' => 'aa',					'dt' => $i++),
		);
		$table = 'nat_code AS a';
		$primaryKey = 'a.id';
		$join = '';
		$where[] = 'a.daxoa=0';
		if (isset($array['flt_ten']) && $array['flt_ten'] != null)
			$where[] = 'a.name like "%' . $array['flt_ten'] . '%"';
		$flt_trangthai = self::stringToArrDb($array['flt_trangthai']);
		if ($flt_trangthai != null && count($flt_trangthai) > 0 && is_array($flt_trangthai))
			$where[] = 'a.status IN (' . implode(',', $flt_trangthai) . ')';

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
			$db->quoteName('parent') . ' = ' . $db->quote($formData['parent']),
		);
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		if($i4223==1 && in_array('nat_code', $t4223)){
			array_push($fields, $db->quoteName('code_bnv') . ' = ' . $db->quote($formData['code_bnv']));
		}
		if (isset($formData['id']) && $formData['id']>0) {
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('nat_code'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			return $formData['id'];
		} else {
			array_push($fields, $db->quoteName('daxoa') . ' = 0');
			$query->insert($db->quoteName('nat_code'));
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
		// $query->delete('nat_code');
		// $query->where($conditions);

		// Dùng cái này nếu có daxoa
		$fields = array(
			$db->quoteName('daxoa') . ' = 1',
			$db->quoteName('status') . ' = 0',
		);
		$query->update($db->quoteName('nat_code'))->set($fields)->where($conditions);

		$db->setQuery($query);
		return $db->execute();
	}
	function get($id){
		$db = JFactory::getDbo();
		return Core::loadAssoc('nat_code','*', 'id='.$db->quote($id));
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
