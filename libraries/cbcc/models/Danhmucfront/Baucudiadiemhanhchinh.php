<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Baucudiadiemhanhchinh
{
	public function getDanhsach()
	{
		$jinput = JFactory::getApplication()->input;
        $array['flt_ten'] = $jinput->get('flt_ten', 0, 'string');
        $array['flt_trangthai'] = $jinput->get('flt_trangthai', null, 'array');
        $array['flt_cap'] = $jinput->get('flt_cap', null, 'array');
		$db = JFactory::getDbo();
		$db->sql("SET character_set_client=utf8");
		$db->sql("SET character_set_connection=utf8");
		$db->sql("SET character_set_results=utf8");
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		$i=0;
		$columns = array(
			array('db' => 'a.id',					'dt' => $i++),
			array('db' => 'a.ten',					'dt' => $i++),
			array('db' => 'a.cap',					'dt' => $i++),
			array('db' => (($i4223==1 && in_array('baucu_diadiemhanhchinh', $t4223))?'a.code_bnv':'a.id'), 'alias' => 'code_bnv','dt' => $i++),
			array('db' => 'a.trangthai',						'dt' => $i++),
			array('db' => 'a.id', 'alias' => 'aa',					'dt' => $i++),
		);
		$table = 'baucu_diadiemhanhchinh AS a';
		$primaryKey = 'a.id';
		$join = '';
		$where[] = 'a.daxoa=0';
		if (isset($array['flt_ten']) && $array['flt_ten'] != null)
			$where[] = 'a.ten like "%' . $array['flt_ten'] . '%"';
		$flt_trangthai = self::stringToArrDb($array['flt_trangthai']);
		if ($flt_trangthai != null && count($flt_trangthai) > 0 && is_array($flt_trangthai))
			$where[] = 'a.trangthai IN (' . implode(',', $flt_trangthai) . ')';
		$flt_cap = self::stringToArrDb($array['flt_cap']);
		if ($flt_cap != null && count($flt_cap) > 0 && is_array($flt_cap))
			$where[] = 'a.cap IN (' . implode(',', $flt_cap) . ')';

		$where = implode(' AND ', $where);
		$datatables = Core::model('Core/Datatables');
		return $datatables->simple($_POST, $table, $primaryKey, $columns, $join, $where.' order by cap asc, ten asc');
	}
	public function save($formData)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('ten') . ' = ' . $db->quote($formData['ten']),
			$db->quoteName('trangthai') . ' = ' . $db->quote($formData['trangthai']),
			$db->quoteName('tenrutgon') . ' = ' . $db->quote($formData['tenrutgon']),
			$db->quoteName('parent_id') . ' = ' . $db->quote($formData['parent_id']),
			$db->quoteName('cap') . ' = ' . $db->quote($formData['cap']),
		);
		$i4223 = Core::config('sync4223/is_use');
		$t4223 = explode(',' ,Core::config('sync4223/tbl'));
		if($i4223==1 && in_array('baucu_diadiemhanhchinh', $t4223)){
			array_push($fields, $db->quoteName('code_bnv') . ' = ' . $db->quote($formData['code_bnv']));
		}
		if (isset($formData['id']) && $formData['id']>0) {
			array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
			array_push($fields, $db->quoteName('nguoihieuchinh_id') . ' = '.JFactory::getUser()->id);
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('baucu_diadiemhanhchinh'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->query();
			return $formData['id'];
		} else {
			array_push($fields, $db->quoteName('daxoa') . ' = 0');
			array_push($fields, $db->quoteName('ngaytao') . ' = now()');
			array_push($fields, $db->quoteName('nguoitao_id') . ' = '.JFactory::getUser()->id);
			$query->insert($db->quoteName('baucu_diadiemhanhchinh'));
			$query->set($fields);
			$db->setQuery($query);
			$db->query();
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
		// $query->delete('baucu_diadiemhanhchinh');
		// $query->where($conditions);

		// Dùng cái này nếu có daxoa
		$fields = array(
			$db->quoteName('daxoa') . ' = 1',
			$db->quoteName('trangthai') . ' = 0',
		);
		$query->update($db->quoteName('baucu_diadiemhanhchinh'))->set($fields)->where($conditions);

		$db->setQuery($query);
		return $db->query();
	}
	function get($id){
		$db = JFactory::getDbo();
		return Core::loadAssoc('baucu_diadiemhanhchinh','*', 'id='.$db->quote($id));
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
