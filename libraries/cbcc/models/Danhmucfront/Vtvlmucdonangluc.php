<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Vtvlmucdonangluc
{
	public function getDanhsach()
	{
		$array['flt_ten'] = JRequest::getVar('flt_ten', null);
		$array['flt_trangthai'] = JRequest::getVar('flt_trangthai', null);
		$db = JFactory::getDbo();
		$db->sql("SET character_set_client=utf8");
		$db->sql("SET character_set_connection=utf8");
		$db->sql("SET character_set_results=utf8");
		$columns = array(
			array('db' => 'a.id',								'dt' => 0),
			array('db' => 'a.name',					'dt' => 1),
			array('db' => 'a.status',						'dt' => 2),
			array('db' => 'a.orders',							'dt' => 3),
			array('db' => 'a.id', 'alias' => 'aa',					'dt' => 4),
		);
		$table = 'vtvl_mucdonangluc AS a';
		$primaryKey = 'a.id';
		$join = '';
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
			$db->quoteName('orders') . ' = ' . $db->quote($formData['orders']),
		);
		if (isset($formData['id']) && $formData['id'] > 0) {
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('vtvl_mucdonangluc'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			return $formData['id'];
		} else {
			$query->insert($db->quoteName('vtvl_mucdonangluc'));
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
				$db->quoteName('id') . ' IN (0' . implode(',', $id) . ')'
			);
		else return false;

		// Dùng cái này nếu xóa hẳn row
		$query->delete('vtvl_mucdonangluc');
		$query->where($conditions);

		// Dùng cái này nếu có daxoa
		// $fields = array(
		// 	$db->quoteName('status') . ' = 0',
		// );
		// $query->update($db->quoteName('vtvl_mucdonangluc'))->set($fields)->where($conditions);
		$db->setQuery($query);
		return $db->execute();
	}
	function get($id){
		return Core::loadAssoc('vtvl_mucdonangluc','*', 'id='.$id);
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
