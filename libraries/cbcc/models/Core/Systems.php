<?php
use GCore\Libs\Arr;

/**
  *@file:  Systems.php
  *@encoding:UTF-8
  *@auth: nguyennpb@danang.gov.vn
  *@date: Jan 08, 2015
  *@company: http://dnict.vn
 **/
class Core_Model_Systems{
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
						INNER JOIN core_user_hoso AS b ON a.hosochinh_id = b.hoso_id
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
	 * Lấy danh sách các hồ sơ chưa có tài khoản trong hệ thống
	 * @module Quản lý tài khoản
	 * @param Integer $dept_code
	 * @return NULL|Array
	 */
	public function getCreateAccountByDeptCode($dept_code, $option = array()){
		$db = JFactory::getDbo();
		$exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id,'com_hoso','treeview','treeview');
		$exception_condition = ($exceptionUnits)?' AND a.congtac_donvi_id NOT IN ('.$exceptionUnits.') 
													AND a.congtac_phong_id NOT IN ('.$exceptionUnits.')':'';
		$query = 'SELECT 	a.hosochinh_id AS id,a.hoten AS e_name,a.ngaysinh AS birth_date,b.birth_place,
							a.congtac_chucvu AS position,a.congtac_donvi_id AS inst_code,a.congtac_phong_id AS dept_code,b.email
					FROM hosochinh_quatrinhhientai AS a
					INNER JOIN hosochinh AS b ON a.hosochinh_id = b.id
					WHERE (a.hoso_trangthai = "00" OR a.hoso_trangthai = "10") '.$exception_condition.'
						AND (a.congtac_donvi_id = '.$db->quote($dept_code).' OR a.congtac_phong_id = '.$db->quote($dept_code).')
						AND a.hosochinh_id NOT IN ( SELECT DISTINCT hoso_id FROM core_user_hoso )
					ORDER BY a.hoten_sapxep';
//  	echo $query;exit;
		$db->setQuery($query);
		return  $db->loadAssocList();
	}
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
	// Phúc thêm đoạn tạo user_nhiemvu mặc định khi khởi tạo tài khoản lần đầu
	/**
	 * for đợt
	 */
	public function themNhiemVuMacDinh($user_id, $hosochinh_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// tạo all đợt
		$dot = Core::loadAssocList('dgcbcc_dotdanhgia','*',null,'ngaybatdau asc');
		for($i=0; $n=count($dot), $i<$n; $i++){
			$hosochinh = Core::loadAssoc('hosochinh_quatrinhhientai','*','hosochinh_id ='.$db->quote($hosochinh_id));
			$ar = [];
			$ar['user_id'] = $user_id;
			$ar['id_hosochinh'] = $hosochinh_id;
			$ar['e_name'] = $hosochinh['hoten'];
			$ar['birth_date'] = $hosochinh['ngaysinh'];
			$ar['position'] = $hosochinh['congtac_chucvu'];
			$ar['pos_td'] = $hosochinh['congtac_chucvutuongduong'];
			$ar['inst_code'] = $hosochinh['congtac_donvi_id'];
			$ar['dept_code'] = $hosochinh['congtac_phong_id'];
			$ar['id_theonhiemvu'] =0;
			$ar['id_dotdanhgia'] = $dot[$i]['id'];
			$ar['is_lock'] =0;
			$ar['is_tongket'] =0;
			$ar['id_vtvl'] =0;
			$this->luuNhiemVuMacDinh($ar);
		}
	}
	/**
	 * Lưu nhiemvu
	 */
	public function luuNhiemVuMacDinh($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
		    $db->quoteName('user_id') . ' = ' . $db->quote($formData['user_id']),
			$db->quoteName('id_hosochinh') . ' = ' . $db->quote($formData['id_hosochinh']),
			$db->quoteName('e_name') . ' = ' . $db->quote($formData['e_name']),
			$db->quoteName('birth_date') . ' = ' . $db->quote($formData['birth_date']),
			$db->quoteName('position') . ' = ' . $db->quote($formData['position']),
			$db->quoteName('pos_td') . ' = ' . $db->quote($formData['pos_td']),
			$db->quoteName('inst_code') . ' = ' . $db->quote($formData['inst_code']),
			$db->quoteName('dept_code') . ' = ' . $db->quote($formData['dept_code']),
			$db->quoteName('id_theonhiemvu') . ' = ' . $db->quote($formData['id_theonhiemvu']),
			$db->quoteName('id_dotdanhgia') . ' = ' . $db->quote($formData['id_dotdanhgia']),
			$db->quoteName('is_lock') . ' = ' . $db->quote($formData['is_lock']),
			$db->quoteName('is_tongket') . ' = ' . $db->quote($formData['is_tongket']),
			$db->quoteName('id_vtvl') . ' = ' . $db->quote($formData['id_vtvl'])
		);
		$query->insert($db->quoteName('dgcbcc_user_nhiemvu'));
		$query->set($fields);
		$db->setQuery($query);
		return $db->query();
	}
	// end Phúc thêm đoạn tạo user_nhiemvu mặc định khi khởi tạo tài khoản lần đầu

	/**
	 * Tạo tài khoản cho các hồ sơ có trong hệ thống
	 * @module Quản lý tài khoản
	 * @return True|False
	 */
	public function taoTaikhoan(){
		try{
			jimport('joomla.user.helper');
			$cid = JRequest::getVar('cid', array(0), 'post', 'array');
			$e_name = JRequest::getVar('e_name', array(0), 'post', 'array');
			$username = JRequest::getVar('username', array(0), 'post', 'array');
			$donvi_id = JRequest::getVar('donvi_id', array(0), 'post', 'array');
			//------------------Lọc danh sách hồ sơ chưa được ánh xạ thuộc đơn vị được chọn--------------------
			$db = JFactory::getDbo();
			$matkhau = Core::config('Core/System/ResetPass');
			$email = Core::config('Core/System/Email');

			//--------------------Thêm tài khoản ----------------------
			$kieutaikhoan = Core::config('Core/System/Kieutaikhoan');
			for($i = 0, $n = count($cid); $i < $n; $i++){
				$usersParams = &JComponentHelper::getParams('com_users');
				$user[$i] = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
				$post['name'] = $e_name[$i];
				if ($kieutaikhoan == 'email') {
					$post['username'] = $username[$i].$email;
					$post['email'] = $username[$i].$email;
				} else {
					$post['username'] = $username[$i];
					if(strpos($username[$i],'@') !== false){
						$post['email'] = $username[$i];
					}else{
						$post['email'] = $username[$i].$email;
					}
				}
				$post['password'] = $matkhau;
				$post['password2'] = $matkhau;
				//set default group.
				$defaultUserGroup = $usersParams->get('new_usertype', 15);
				//default to defaultUserGroup i.e.,Registered
				$post['groups'] = array('2','15');
				$post['block'] = '0';
				if(!$user[$i]->bind($post)){
					return false;
				}
				if(!$user[$i]->save()){
					return false;
				}
				//----------------------Tạo ánh xạ cho tài khoản --------------------------
				$query = 'INSERT INTO core_user_hoso (hoso_id,user_id) 
								VALUES ('.$db->quote($cid[$i]).','.$db->quote($user[$i]->get('id')).')';
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				$query = 'UPDATE hosochinh 
								SET email = '.$db->quote($username[$i].$email).' 
									WHERE id = '.$db->quote($cid[$i]);
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				$query = 'UPDATE hosochinh_quatrinhhientai 
								SET email_tinhthanh = '.$db->quote($username[$i].$email).' 
									WHERE hosochinh_id = '.$db->quote($cid[$i]);
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				$query = '	INSERT INTO core_user_action_donvi (user_id,action_id,iddonvi,group_id)
								SELECT '.$db->quote($user[$i]->get('id')).' AS user_id,action_id,
										'.$db->quote($donvi_id[$i]).' AS iddonvi,group_id
									FROM core_group_action
									WHERE group_id IN (2,15)';
				$db->setQuery($query);
				if(!$db->query()){
					return false;
				}
				// Phúc thêm đoạn tạo user_nhiemvu mặc định khi khởi tạo tài khoản lần đầu
				if(Core::config('dgcbcc/template/isTaoTaiKhoan')==1){
					$this->themNhiemVuMacDinh($user[$i]->get('id'), $cid[$i]);
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
            $n = count($data);
            if($n > 0){
                for($i = 0; $i < $n; $i++){
                    $row = $data[$i];
                    $values[] = $db->quote($row->maCongDan).',NOW(),'.$db->quote($row->inserted);
                }
                $query->insert('hoso_tichhopdulieucongdan')
                   ->columns('hosochinh_id, thoigianthuchien, ketquathuchien')
                   ->values($values);
                $db->setQuery($query);
                return $db->query();
            }else{
                echo 'Không có dữ liệu công dân được trả về từ hệ thống tích hợp công dân! Vui lòng kiểm tra lại!'; exit;
            }
	}
}