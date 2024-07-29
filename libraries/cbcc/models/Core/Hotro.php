<?php
/**
  *@file:  Hotro.php
  *@encoding:UTF-8
  *@auth: nguyennpb@danang.gov.vn
  *@date: Dec 10, 2015
  *@company: http://dnict.vn
 **/
class Core_Model_Hotro{
	public function danhsachTaikhoanQuanly(){
		$db = JFactory::getDbo();
		$query = '	SELECT a.id,a.name,a.username,a.email,a.block
						FROM jos_users AS a
						INNER JOIN jos_user_usergroup_map AS b ON a.id = b.user_id
						INNER JOIN jos_usergroups AS c ON b.group_id = c.id AND c.id > 10
							AND c.title NOT LIKE "%Đánh giá kết quả làm việc%"
							AND c.title NOT LIKE "%Cá nhân CBCCVC%"
						WHERE a.id NOT IN (SELECT user_id FROM core_ignore_user)
							AND a.id NOT IN (SELECT user_id FROM core_user_hoso)
							AND a.username NOT LIKE "%dnict%"
							AND a.username NOT LIKE "%admin%"
							AND a.username NOT LIKE "%nhomhotro%"
							AND a.username NOT LIKE "%test%"
						GROUP BY a.id';
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function danhsachTaikhoanThua(){
		$db = JFactory::getDbo();
		$query = '	SELECT a.id,a.name,a.username,a.email,a.block
						FROM jos_users AS a
						WHERE a.id NOT IN (SELECT user_id FROM core_user_hoso)
							AND a.id NOT IN (SELECT user_id FROM jos_user_usergroup_map WHERE group_id <> 2)
							AND username LIKE "%'.Core::config('Core/System/Email').'%"';
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function capMatkhau($id_user, $matkhau){
		jimport('joomla.user.helper');
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($matkhau, $salt);
		$password	= $crypt.':'.$salt;
		$db = JFactory::getDbo();
		$query = 'UPDATE jos_users SET password = '.$db->quote($password).' WHERE id = '.$db->quote($id_user);
		$db->setQuery($query);
		return $db->query();
	}
	public function xoaTaikhoan($id_user){
		$db = JFactory::getDbo();
		$query = '	DELETE FROM jos_users WHERE id = '.$db->quote($id_user);
		$db->setQuery($query);
		return $db->query();
	}
	/**
	 * Chức năng chạy hàm trong MySQL
	 * @param String $hamchay
	 * @param integer $donvi_id
	 * @param integer $hosochinh_id
	 * @return boolean
	 */
	public function runFunctionSQL($hamchay, $donvi_id = 0, $hosochinh_id = 0){
		$db = JFactory::getDbo();
		$str_params = 0;
		if($donvi_id > 0){
		    $str_params = $donvi_id;
		}else if($hosochinh_id > 0){
		    $str_params = $hosochinh_id;
		}else{
		    $str_params = 0;
		}
		if($hamchay == 'index_all' || $hamchay == 'xacthuc_tatca_hoso'){
		    $query = 'CALL '.$hamchay.';';
		}else{
		  $query = 'CALL '.$hamchay.'('.$str_params.');';
		}
		$db->setQuery($query);
		if(!$db->execute()){
		    return false;
		}else{
		    return true;
		}
	}
}