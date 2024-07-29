<?php
defined('_JEXEC') or die('Restricted access');
class Tochuc_Model_Qltochuc{
	function getHosoByDonvi($donvi_id, $hoten=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('lft, rgt, level')
		->from('ins_dept')
		->where('id = '.$db->quote($donvi_id));
		$db->setQuery($query);
		$rs = $db->loadAssoc();
		$lft = $rs['lft'];
		$rgt = $rs['rgt'];

		$query = $db->getQuery(true);
		$query->select('id')
		->from('ins_dept')
		// ->where('level >= '.$db->quote($level1))
		// ->where('level <= '.$db->quote($level2))
		->where('lft >= '.$db->quote($lft))
		->where('rgt <= '.$db->quote($rgt));
		$db->setQuery($query);
		$rs_donvi = $db->loadColumn();
		$donvi_arr = implode(',', $rs_donvi);

		$query = $db->getQuery(true);
		$query->select('hsht.hosochinh_id, hsht.hoten, hsht.ngaysinh, hsc.mobile as sodienthoai, hsht.email_tinhthanh as email, hsht.congtac_chucvu, hsht.congtac_donvi,  hsht.congtac_phong')
		->from('hosochinh_quatrinhhientai hsht')
		->join('inner','hosochinh hsc ON hsc.id = hsht.hosochinh_id')
		->where('hsht.congtac_donvi_id IN('.$donvi_arr.')')
		->where('hsht.hoso_trangthai = "00"');
		if($hoten!=null) $query->where('hsht.hoten LIKE "%'.strtolower($hoten).'%"');
		$exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, 'com_tochuc', 'tochuc', 'tree_ins_dept');
		if($exceptionUnits) $query->where('hsht.congtac_donvi_id NOT IN('.$exceptionUnits.')');
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function getInfo($user_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('hosochinh_id, hoten, ngaysinh, sodienthoai, email')
		->from('core_user_quanlytochuc')
		->where('user_id = '.$db->quote($user_id));
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	function getQltochuc($donvi_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('lft, rgt, level')
		->from('ins_dept')
		->where('id = '.$db->quote($donvi_id));
		$db->setQuery($query);
		$rs = $db->loadAssoc();
		$lft = $rs['lft'];
		$rgt = $rs['rgt'];
		// $level1 = $rs['level'];
		// $level2 = $rs['level']+1;

		$query = $db->getQuery(true);
		$query->select('id, name')
		->from('ins_dept')
		// ->where('level >= '.$db->quote($level1))
		// ->where('level <= '.$db->quote($level2))
		->where('lft >= '.$db->quote($lft))
		->where('rgt <= '.$db->quote($rgt));
		$db->setQuery($query);
		$rs_donvi = $db->loadAssocList('id');

		$donvi_arr = implode(',', array_keys($rs_donvi));
		$nhomnguoidung = Core::config('core/system/IdGroupManager');
		$nguoidung = $this->userGroup($nhomnguoidung);
		$query = $db->getQuery(true);
		$query->select('hosochinh_id, hoten, ngaysinh, sodienthoai, email, donvi_id, user_id')
		->from('core_user_quanlytochuc')
		->where('donvi_id IN (0'.$donvi_arr.')')
		->where('user_id IN (0'.implode(',', $nguoidung).')')
		->order('donvi_id ASC');
		$db->setQuery($query);
		$rs_qltochuc = $db->loadAssocList();
		$info['donvi'] = $rs_donvi;
		$info['qltochuc'] = $rs_qltochuc;
		return $info;
	}
	function getUserDisable(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')
		->from('jos_users')
		->where('block = 1');
		$db->setQuery($query);
		return $db->loadColumn();
	}
	function userGroup($group=0){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('user_id')
		->from('jos_user_usergroup_map')
		->where('group_id in ('.$db->quote($group).')');
		$db->setQuery($query);
		return $db->loadColumn();
	}
	function xoaqltochuc(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$conditions = array(
			    $db->quoteName('user_id') . ' = ' . $db->quote(JFactory::getUser()->id)
			);
			$query->delete($db->quoteName('core_user_quanlytochuc'));
			$query->where($conditions);
			$db->setQuery($query);
			return $db->query();
	}
	function luuqltochuc($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
		    $db->quoteName('hosochinh_id') . ' = ' . $db->quote($formData['hosochinh_id']),
		    $db->quoteName('hoten') . ' = ' . $db->quote($formData['hoten']),
		    $db->quoteName('donvi_id') . ' = ' . $db->quote($formData['donvi_id']),
		    $db->quoteName('user_id') . ' = ' . $db->quote(JFactory::getUser()->id),
		    $db->quoteName('ngaysinh') . ' = ' . $db->quote($this->strDateVntoMySql($formData['ngaysinh'])),
		    $db->quoteName('sodienthoai') . ' = ' . $db->quote($formData['sodienthoai']),
		    $db->quoteName('email') . ' = ' . $db->quote($formData['email']),
		);
		$query->insert($db->quoteName('core_user_quanlytochuc'));
		$query->set($fields);
		$db->setQuery($query);
		return $db->query();
	}
	static public function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
	static public function strDateMySqltoVN($dateMysql){
		if (empty($dateMysql) || $dateMysql == '0000-00-00') {
			return '';
		}
		$dateMysql = explode('-', $dateMysql);
		return $dateMysql[2].'/'.$dateMysql[1].'/'.$dateMysql[0];
	}
}