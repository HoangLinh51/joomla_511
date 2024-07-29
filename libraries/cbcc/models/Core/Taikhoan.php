<?php
use GCore\Libs\Arr;
class Core_Model_Taikhoan{
	/**
	 * Lấy thông tin đơn vị được phân quyền sử dụng cây hồ sơ
	 * 
	 * @param Integer $idRoot	Mã đơn vị được phân quyền
	 * 
	 * @return Trả về thông tin đơn vị được phân quyền sử dụng cây hồ sơ.
	 */
	public function getInfoOfRootTree($idRoot){
		$db = JFactory::getDbo();
		$query = "SELECT a.id AS rootId,a.name AS rootName,a.type AS rootType
					FROM ins_dept AS a
					WHERE a.id = ".$db->quote($idRoot);
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	/**
	 * Lấy thông tin các hồ sơ theo đơn vị
	 * @module Dùng chung tất cả
	 * @param Integer $dept_code,Integer $id_dotdanhgia
	 * @return NULL|Array
	 */
	public function listHosoByDept($dept_code, $option = array()){
		$db = JFactory::getDbo();
		$exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id,'com_hoso','treeview','treeview');
		$exception_condition = ($exceptionUnits)?' AND a.congtac_donvi_id NOT IN ('.$exceptionUnits.') 
													AND a.congtac_phong_id NOT IN ('.$exceptionUnits.')':'';
		$query = '	SELECT 	b.user_id,a.hoten AS e_name,DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS birth_date,
							a.congtac_chucvu AS position,a.congtac_chucvutuongduong AS pos_td
						FROM hosochinh_quatrinhhientai AS a
						left JOIN core_user_hoso AS b ON a.hosochinh_id = b.hoso_id
						WHERE (a.hoso_trangthai = "00" OR a.hoso_trangthai = "10")
							AND (a.congtac_donvi_id = '.$db->quote($dept_code).' OR a.congtac_phong_id = '.$db->quote($dept_code).')'
							.$exception_condition;
		$db->setQuery($query);
		return $db->loadAssocList('user_id');
	}
	/**
	 * Lấy danh sách các hồ sơ đã có tài khoản đánh giá trong hệ thống
	 * @module Quản lý tài khoản đánh giá
	 * @param Array $listUserOfDept
	 * @return NULL|Array
	 */
	public function getListHosoHasAccount($listUserOfDept, $option = array()){
		$db = JFactory::getDbo();
		$query = '	SELECT a.id AS id_user,a.username,a.block,a.email
						FROM jos_users AS a
						WHERE a.id IN ('.implode(',', array_keys($listUserOfDept)).')';
		//echo $query;exit;
		$db->setQuery($query);
		return  $db->loadAssocList();
	}
	/**
	 * Lấy danh sách tài khoản tồn tại trong hệ thống (chưa hoặc đã ánh xạ hồ sơ THEO đơn vị)
	 * @module Quản lý tài khoản đánh giá
	 * @param Array $listUserOfDept
	 * @return NULL|Array
	 */
	public function danhsachtaikhoan($donvi_id){
		$db = JFactory::getDbo();
		$group_user = Core::config('cbcc/template/nhomtaikhoan');
		$query = '	SELECT a.id AS id_user,a.username,a.block,a.email,d.hoso_id, a.name
						FROM jos_users AS a
						INNER JOIN core_user_donvi b on b.id_user = a.id
						INNER join core_user_action_donvi c ON c.user_id = a.id AND c.iddonvi = b.id_donvi
						LEFT JOIN core_user_hoso d ON d.user_id = a.id
						WHERE b.id_donvi IN (0'.$donvi_id.')
						AND c.group_id IN (0'.$group_user.')
						group by a.id' ;
		$db->setQuery($query);
		return  $db->loadAssocList();
	}
	function hosoByDonvi($donvi_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = '	SELECT * from hosochinh_quatrinhhientai
		where congtac_donvi_id = '.$db->quote($donvi_id) ;
		$db->setQuery($query);
		return $db->loadAssocList('hosochinh_id');
	}
	// /**
	//  * Lấy danh sách các hồ sơ chưa có tài khoản trong hệ thống
	//  * @module Quản lý tài khoản
	//  * @param Integer $dept_code
	//  * @return NULL|Array
	//  */
	// public function getCreateAccountByDeptCode($dept_code, $option = array()){
	// 	$db = JFactory::getDbo();
	// 	$exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id,'com_hoso','treeview','treeview');
	// 	$exception_condition = ($exceptionUnits)?' AND a.congtac_donvi_id NOT IN ('.$exceptionUnits.') 
	// 												AND a.congtac_phong_id NOT IN ('.$exceptionUnits.')':'';
	// 	$query = 'SELECT 	a.hosochinh_id AS id,a.hoten AS e_name,a.ngaysinh AS birth_date,b.birth_place,
	// 						a.congtac_chucvu AS position,a.congtac_donvi_id AS inst_code,a.congtac_phong_id AS dept_code,b.email
	// 				FROM hosochinh_quatrinhhientai AS a
	// 				INNER JOIN hosochinh AS b ON a.hosochinh_id = b.id
	// 				WHERE (a.hoso_trangthai = "00" OR a.hoso_trangthai = "10") '.$exception_condition.'
	// 					AND (a.congtac_donvi_id = '.$db->quote($dept_code).' OR a.congtac_phong_id = '.$db->quote($dept_code).')
	// 					AND a.hosochinh_id NOT IN ( SELECT DISTINCT hoso_id FROM core_user_hoso )
	// 				ORDER BY a.hoten_sapxep';
 	// echo $query;die;
	// 	$db->setQuery($query);
	// 	return  $db->loadAssocList();
	// }
	/**
	 * Cấp lại mật khẩu mặc định cho các tài khoản có trong hệ thống
	 * @module Quản lý tài khoản
	 * @param  Integer $id_user
	 * @return True|False
	 */
	public function capMatkhau($id_user){
		jimport('joomla.user.helper');
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword(Core::config('Core/System/ResetPass'), $salt);
		$password	= $crypt.':'.$salt;
		$db = JFactory::getDbo();
		$query = 'UPDATE jos_users SET password = '.$db->quote($password).' WHERE id = '.$db->quote($id_user);
		$db->setQuery($query);
		return $db->query();
	}
	/**
	 * Cấp nhật lại tài khoản và email cho các tài khoản có trong hệ thống
	 * @module Quản lý tài khoản
	 * @param  Integer 	$id_user
	 * @param  String 	$email_capnhat
	 * @return True|False
	 */
	public function capnhatEmail($id_user,$email_capnhat){
		$db = JFactory::getDbo();
		$query = '	UPDATE hosochinh_quatrinhhientai AS a
						INNER JOIN core_user_hoso AS b ON a.hosochinh_id = b.hoso_id
						SET a.email_tinhthanh = '.$db->quote($email_capnhat).'
						WHERE b.user_id = '.$db->quote($id_user);
		$db->setQuery($query);
		if(!$db->query()){
			return false;
		}
		
		$query = '	UPDATE jos_users 
						SET username = '.$db->quote($email_capnhat).',
							email = '.$db->quote($email_capnhat).'
						WHERE id = '.$db->quote($id_user);
		$db->setQuery($query);
		return $db->query();
	}
	/**
	 * Thiết lập trạng thái khóa/mở tài khoản
	 * @module Quản lý tài khoản
	 * @param  Integer $id_user, Integer $block (1 : khóa, 0 : mở)
	 * @return True|False
	 */
	public function setTrangthaiTaikhoan($id_user, $block){
		$db = JFactory::getDbo();
		$query = 'UPDATE jos_users SET block = '.$db->quote($block).' WHERE id = '.$db->quote($id_user);
		$db->setQuery($query);
		return $db->query();
	}
	/**
	 * Tạo tên tài khoản
	 * @module Quản lý tài khoản
	 * @param  String $value
	 * @return True|False
	 */
	public function taoTendangnhap($value){
		$db = JFactory::getDbo();
		$str = explode(' ', $this->locTiengviet($value));
		$total_str = count($str);
		$username = $str[($total_str - 1)];
		for($i = 0; $i < ($total_str-1); $i++){
			$username.= substr($str[$i], 0, 1);
		}
		$query = "SELECT COUNT(*) FROM jos_users WHERE username LIKE '".$username."%'";
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result >0){
			$username.= $result;
		}
		return $username;
	}
	/**
	 * Lọc và khử các dấu tiếng việt
	 * @module Quản lý tài khoản
	 * @param  String $value
	 * @return True|False
	 */
	public function locTiengviet($value){
		/*a à ả ã á ạ ă ằ ẳ ẵ ắ ặ â ầ ẩ ẫ ấ ậ b c d đ e è ẻ ẽ é ẹ ê ề ể ễ ế ệ
		 f g h i ì ỉ ĩ í ị j k l m n o ò ỏ õ ó ọ ô ồ ổ ỗ ố ộ ơ ờ ở ỡ ớ ợ
		p q r s t u ù ủ ũ ú ụ ư ừ ử ữ ứ ự v w x y ỳ ỷ ỹ ý ỵ z*/
	
		$charaterA = '#(à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';
		$repleceCharaterA = 'a';
		$value = preg_replace($charaterA,$repleceCharaterA,$value);
	
		$charaterD = '#(đ)#imsU';
		$replaceCharaterD = 'd';
		$value = preg_replace($charaterD,$replaceCharaterD,$value);
	
		$charaterE = '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';
		$replaceCharaterE = 'e';
		$value = preg_replace($charaterE,$replaceCharaterE,$value);
	
		$charaterI = '#(ì|ỉ|ĩ|í|ị)#imsU';
		$replaceCharaterI = 'i';
		$value = preg_replace($charaterI,$replaceCharaterI,$value);
	
		$charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';
		$replaceCharaterO = 'o';
		$value = preg_replace($charaterO,$replaceCharaterO,$value);
	
		$charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';
		$replaceCharaterU = 'u';
		$value = preg_replace($charaterU,$replaceCharaterU,$value);
	
		$charaterY = '#(ỳ|ỷ|ỹ|ý)#imsU';
		$replaceCharaterY = 'y';
		$value = preg_replace($charaterY,$replaceCharaterY,$value);
	
		return $value;
	}
	/**
	 * Tạo tài khoản cho các hồ sơ có trong hệ thống
	 * @module Quản lý tài khoản
	 * @return True|False
	 */
	public function taoTaikhoan(){
		try{
			jimport('joomla.user.helper');
			$jinput 	= JFactory::getApplication()->input;
			$hosochinh_id 	= $jinput->get('hosochinh_id', null, 'int');
			$e_name 	= $jinput->get('e_name', null, 'string');
			$username 	= $jinput->get('username', null, 'string');
			$email 		= $jinput->get('username', null, 'string');
			$donvi_id 	= $jinput->get('donvi_id', 0, 'int');
			$matkhau 	= $jinput->get('matkhau', null, 'string');
			//------------------Các thông tin cấu hình--------------------
			$db = JFactory::getDbo();
			$group_user = Core::config('cbcc/template/nhomtaikhoan');

			//--------------------Thêm tài khoản ----------------------
				$usersParams = JComponentHelper::getParams('com_users');
				$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
				$post['name'] = $e_name;
				$post['username'] = $username;
				$post['email'] = $email;
				$post['password'] = $matkhau;
				$post['password2'] = $matkhau;
				//set default group.
				$defaultUserGroup = $usersParams->get('new_usertype', $group_user);
				//default to defaultUserGroup i.e.,Registered
				$post['groups'] = array('2', $group_user);
				$post['block'] = '0';
				if(!$user->bind($post)){
					return false;
				}
				if(!$user->save()){
					return false;
				}
				//----------------------Tạo ánh xạ đơn vị cho tài khoản --------------------------
				$query = 'INSERT INTO core_user_donvi (id_user, id_donvi, iddonvi_quanly) 
								VALUES ('.$db->quote($user->get('id')).', '.$db->quote($donvi_id).', null)';
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				$query = '	INSERT INTO core_user_action_donvi (user_id,action_id,iddonvi,group_id)
								SELECT '.$db->quote($user->get('id')).' AS user_id,action_id,
										'.$db->quote($donvi_id).' AS iddonvi,group_id
									FROM core_group_action
									WHERE group_id IN (2,0'.$group_user.')';
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				//-------------------------Tạo ánh xạ hồ sơ nếu có------------------------
				if($hosochinh_id>0){
					$query = '	INSERT INTO core_user_hoso (user_id, hoso_id)
									VALUES ('.$db->quote($user->get('id')).', '.$db->quote($hosochinh_id).')';
					$db->setQuery($query);
					if(!$db->query()){
						return false;
					}	
				}
			return true;
		}catch(Exception $e){
			return $e;
		}
	}
	/**
	 * Chức năng kiểm tra xem đã có email trong hệ thống hay chưa
	 * @param string $email
	 * @return boolean
	 */
	public function capNhatTaikhoan(){
		try{
			jimport('joomla.user.helper');
			$jinput 	= JFactory::getApplication()->input;
			$hosochinh_id 	= $jinput->get('hosochinh_id', null, 'int');
			$id_user 	= $jinput->get('id_user', null, 'int');
			$e_name 	= $jinput->get('e_name', null, 'string');
			$username 	= $jinput->get('username', null, 'string');
			$email 		= $jinput->get('username', null, 'string');
			$matkhau 	= $jinput->get('matkhau', null, 'string');
			//------------------Các thông tin cấu hình--------------------
			$db = JFactory::getDbo();
			$object				=	new stdClass();
			$object->id = $id_user;
			$object->name 		=	$e_name;
			$object->username	=	$username;
			$object->email		=	$email;
			if(strlen($matkhau)>0)
			$object->password = md5($matkhau);
			
			$db->updateObject('jos_users', $object,'id');
			//-------------------------Cập nhật ánh xạ hồ sơ ------------------------
			Core::delete('core_user_hoso', array('user_id = '=>(int)$id_user));
			Core::insert('core_user_hoso',  array('user_id'=>(int)$id_user,'hoso_id'=>(int)$hosochinh_id));
			return true;
		}catch(Exception $e){
			return $e;
		}
	}
	public function xoaTaiKhoan(){
		$jinput 	= JFactory::getApplication()->input;
		$id_user 	= $jinput->get('id_user', null, 'int');
		if($id_user>0){
			Core::delete('jos_users', array('id = '=>(int)$id_user));
			Core::delete('core_user_hoso', array('user_id = '=>(int)$id_user));
			return true;
		}else return false;
	}
	/**
	 * Chức năng kiểm tra xem đã có email trong hệ thống hay chưa
	 * @param string $email
	 * @return boolean
	 */
	public function kiemtraEmailTontai($email){
		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(*) FROM jos_users WHERE email = '.$db->quote($email);
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result > 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Chức năng kiểm tra xem đã có thông tin quản lý tổ chức chưa
	 * @param integer $user_id
	 * @param integer $config
	 * @return boolean
	 */
	public function kiemtraTaikhoanQuanlyTochuc($user_id, $config){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(a.user_id)')
		  ->from($db->quoteName('core_user_quanlytochuc','a'))
		  ->join('INNER', 'jos_user_usergroup_map AS b ON a.user_id = b.user_id 
		                      AND b.user_id = '.$db->quote($user_id).' 
		                      AND b.group_id = '.$db->quote($config));
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result > 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Chức năng kiểm tra LDAP xem đã có email hay chưa, chức năng nay hoạt động tốt khi plugin ldap của joomla được kích hoạt
	 * @param string $email
	 * @return boolean
	 */
	public function hasEmail($email){
		$credentials ['username'] = $email;
		$success = false;
		// JLoader::register('JPluginHelper', JPATH_LIBRARIES . '/cms/plugin/helper.php');
		$plugin = JPluginHelper::getPlugin ( 'authentication', 'ldap' );
		$params = new JRegistry ( $plugin->params );
		// Load plugin params info
		$ldap_email = $params->get ( 'ldap_email' );
		$ldap_fullname = $params->get ( 'ldap_fullname' );
		$ldap_uid = $params->get ( 'ldap_uid' );
		$auth_method = $params->get ( 'auth_method' );
		// var_dump($params);exit;
		$ldap = new JClientLdap ( $params );
		// $ldap->close();
		// var_dump($ldap->connect());exit;
		if (! $ldap->connect ()) {
			return false;
		}
		if (strlen ( $params->get ( 'username' ) )) {
			$bindtest = $ldap->bind ();
		} else {
			$bindtest = $ldap->anonymous_bind ();
		}		
		if ($bindtest) {
			// Search for users DN
			$binddata = $ldap->simple_search ( str_replace ( "[search]", $credentials ['username'], $params->get ( 'search_string' ) ) );
			if (isset($binddata[0]) && isset($binddata[0]['dn']))
			{
				// Verify Users Credentials
				//$success = $ldap->bind($binddata[0]['dn'], $credentials['password'], 1);		
				$success = true;
			}else{
				$success = false;
			}
			// var_dump($binddata);
			
		} else {
			$success = false;
		}		
		$ldap->close ();	
		return $success;
	}
	public function capnhatTichhopDLCD($data = array()){
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    for($i = 0, $n = count($data); $i < $n; $i++){
	        $row = $data[$i];
	        $values[] = $db->quote($row->maCongDan).',NOW(),'.$db->quote($row->inserted);
	    }
	    $query->insert('hoso_tichhopdulieucongdan')
	       ->columns('hosochinh_id, thoigianthuchien, ketquathuchien')
	       ->values($values);
	    $db->setQuery($query);
	    return $db->query();
	}
	public function getCboHoso($donvi_id, $hoten=null) {
        $db = JFactory::getDbo();
        $dates = date_create(null, timezone_open("Asia/Ho_Chi_Minh"));
        $date = date_format($dates, "Y-m-d");
        $query = $db->getQuery(true);
        $query->select(' b.hosochinh_id as hosochinh_id, b.hoten as hoten, b.gioitinh, b.ngaysinh as ngaysinh, b.congtac_chucvu as congtac_chucvu, (select name from cla_sca_code where code = b.chuyenmon_trinhdo_code and tosc_code = 2) as chuyenmon_trinhdo_code, b.congtac_donvi,  b.congtac_phong, a.email as email ')
				->from('hosochinh_quatrinhhientai b')
				->join('inner','hosochinh a ON a.id = b.hosochinh_id')
				->where('b.hosochinh_id NOT IN (select aa.hoso_id from core_user_hoso aa inner join jos_users bb on bb.id = aa.user_id)')
                ->where('b.hoso_trangthai !="15"')
                ->where('(b.congtac_donvi_id = ' . $db->quote($donvi_id) . ' or b.hosochinh_id in (
						SELECT
							emp_id_knbp
						FROM
							ct_kiemnhiembietphai
						WHERE
							(	start_date_knbp <=' . $db->quote($date) . ' 
								and (end_date_knbp IS NULL OR end_date_knbp >= ' . $db->quote($date) . ') 
							)
							AND inst_code_knbp = ' . $db->quote($donvi_id) . '
							) )')
				->order('SUBSTRING_INDEX(hoten, " ", -1) ASC');
        if($hoten!=null) $query->where('b.hoten LIKE '.$db->quote('%'.$hoten.'%'));
        $db->setQuery($query);
        $a = $db->loadAssocList();
        return $a;
    }
}