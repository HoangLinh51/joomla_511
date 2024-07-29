<?php
defined('_JEXEC') or die( 'Restricted access' );
class Tochuc_Model_Solieubienche extends JModelLegacy{
	/**
	 * Lấy thông tin từ bảng, kết hợp join
	 * @param unknown $field
	 * @param unknown $table
	 * @param string $arrJoin
	 * @param string $where
	 * @param string $order
	 * @return Ambigous <mixed, NULL, multitype:unknown mixed >
	 */
	function getThongtin($field, $table, $arrJoin=null, $where=null, $order=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($field)
		->from($table);
		if (count($arrJoin)>0)
			foreach ($arrJoin as $key=>$val){
				$query->join($key, $val);
			}
		for($i=0;$i<count($where);$i++)
			if ($where[$i]!='')
				$query->where($where);
		if($order!=null)$query->order($order);
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	/**
	 * Lưu số lượng biên chế
	 * @param unknown $formData
	 * @return boolean
	 */
	function savebienche($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
				$db->quoteName('bchanhchinh').'='.$db->quote($formData['bchanhchinh']),
				$db->quoteName('bcsunghiep_nhanuocgiao').'='.$db->quote($formData['bcsunghiep_nhanuocgiao']),
				$db->quoteName('bcsunghiep_tudambao').'='.$db->quote($formData['bcsunghiep_tudambao']),
				$db->quoteName('hopdong68').'='.$db->quote($formData['hopdong68']),
				$db->quoteName('tuhopdong').'='.$db->quote($formData['tuhopdong']),
				$db->quoteName('banchuyentrach').'='.$db->quote($formData['banchuyentrach']),
				$db->quoteName('id_donvi').'='.$db->quote($formData['id_donvi'])
		);
		$query->insert($db->quoteName('ins_soluongbchd'));
		$query->set($fields);
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Xóa biên chế
	 * @param unknown $id_donvi
	 * @return boolean
	 */
	public function removebienche($id_donvi){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('id_donvi').' IN ('.$db->quote($id_donvi).')'
		);
		$query->delete($db->quoteName('ins_soluongbchd'));
		$query->where($conditions);
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
}