<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Sso{
	// SSO Đắk Lắk
	// 1. Tại CBCC, bấm đăng nhập bằng Hệ thống đăng nhập tập trung Đăk Lắk, href sang url authori như ví dụ anh gửi ở trên. Cán bộ đăng nhập bt theo tài khoản tỉnh.
	// $domain_sso = Core::config('core/sso/domain_sso');
	// https://xacthuc.sdtech.vn/oauth2/authorize?response_type=code&state=fd28d491e6e86c2111f&client_id=Y9f5lIKIFvPrQfwSVu2hmKpVYJwa&redirect_uri=http://49.156.54.92:8084
	// client_id: Y9f5lIKIFvPrQfwSVu2hmKpVYJwa
	// client_secret: 8dKhKrRI1mpJxfNf6QRclpfogN0a
	// 2. Nếu đăng nhập ok thì Hệ thống xacthuc sẽ chuyển tiếp đến &redirect_uri kèm với param code, state và session_state
	// http://49.156.54.92:8084/?code=1719a913-18de-389f-a045-a006bf607f64&state=fd28d491e6e86c2111f&session_state=f7d3c1d04619929be8a3918a5141919bbe5f12cb779ab935cfe2fb56ac1fa631.wnIuuSpmP-_9WB7ZvRjq7A
	// 3. Từ code, lấy token theo API get access token
	// 4. Phía CBCC sẽ dựa vào token này, gọi lên API get user info để lấy thông tin tài khoản người dùng. Rồi thực hiện việc kiểm tra tài khoản/đăng nhập bên phía CBCC
	// nguyetntm@kbnn.vn
		// 12345
		// CREATE TABLE `sso_token` (
		// 	`id` int(11) NOT NULL AUTO_INCREMENT,
		// 	`user_id` int(11) DEFAULT NULL,
		// 	`id_token` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		// 	`token` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		// 	PRIMARY KEY (`id`)
		//   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

	function sso(){
		$db = JFactory::getDbo();
		$jinput = JFactory::getApplication()->input;
		$code = $jinput->get('code', null, 'string');
		$state = $jinput->get('state', null, 'string');
		$session_state = $jinput->get('session_state', null, 'string');
		if(strlen($code)>0 && strlen($state)>0 && strlen($session_state)>0){
			$access_token = (array)json_decode($this->apiToken($code));
			if(strlen($access_token['access_token'])>0){
				$token = $access_token['access_token'];
				$id_token = $access_token['id_token'];// lưu để gọi api log out
				$sso_user = $this->apiGetUserInfo($token);
				$sso_user = (array)json_decode($sso_user);
				if(strlen($sso_user['mail'])>0){
					// lưu bảng id_token để sau này logout
					// kiểm tra xem có tồn tại trong db ko, nếu có thì cho đăng nhập
					$user = Core::loadAssoc('jos_users','*','email='.$db->quote($sso_user['mail']).' OR username = '.$db->quote($sso_user['mail']));
					if(strlen($user['username'])>0){
						$username = $user['username'];
						$form = array();
						$form['user_id'] = $user['id'];
						$form['id_token'] = $id_token;
						$form['token'] = $token;
						$this->updateSsoToken($form);
					}else{
						// khởi tạo user với mail và username = mail_sso
						$form = array();
						$form['name'] = $sso_user['lastName'].' '.$sso_user['middleName'].' '.$sso_user['firstName'];
						$form['username'] = $sso_user['mail'];
						$form['email'] = $sso_user['mail'];
						$form['group_id'] = 15;
						$form['type'] = 1;
						$this->saveTk($form);
						$this->updatetk();
						$user = Core::loadAssoc('jos_users','*','email='.$db->quote($sso_user['mail']).' OR username = '.$db->quote($sso_user['mail']));
						$form = array();
						$form['user_id'] = $user['id'];
						$form['id_token'] = $id_token;
						$form['token'] = $token;
						$this->updateSsoToken($form);
					}
					$app = JFactory::getApplication('site');
					// $user = JUser::getInstance(62);

					echo 'Joomla! Authentication was successful!' . '<br>';
					echo 'Joomla! Token is:' . JHTML::_( 'form.token' );

					//perform the login action
					// $credentials['username'] = 'dnictsp';
					// $credentials['password'] = 'alakayam';
					// $error = $app->login($credentials);
					// $logged_user = JFactory::getUser();


					JPluginHelper::importPlugin('user');
					$options = array();
					$options['action'] = 'core.login.site';
					$response = array(); 
					$response['language'] = ""; 
					$response['username'] = $username; 
					$result = $app->triggerEvent('onUserLogin', array((array)$response, $options));
					$app->redirect('index.php');
				}
			}else return false;
		}
		else return false;
	}
	function logout(){
		$user_id = JFactory::getUser()->id;
		$token = Core::loadAssoc('sso_token','*','user_id='.$user_id);
		$form = array();
		$form['user_id'] = $user_id;
		$form['id_token'] = '';
		$form['token'] = '';
		$this->updateSsoToken($form);
		// nếu còn id_token trong db thì mới call link logout
		if(strlen($token['id_token'])>0){
			$app = JFactory::getApplication();
			$app->logout($user_id);
			$domain_sso = Core::config('core/sso/domain_sso');
			$app->redirect($domain_sso.'/oidc/logout?id_token_hint='.$token['id_token'].'&post_logout_redirect_uri='.urlencode(Core::config('core/sso/redirect_uri')));
		}
	}
	function saveTk($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
		    $db->quoteName('name') . ' = ' . $db->quote($formData['name']),
		    $db->quoteName('username') . ' = ' . $db->quote($formData['username']),
		    $db->quoteName('email') . ' = ' . $db->quote($formData['email']),
		    $db->quoteName('group_id') . ' = ' . $db->quote($formData['group_id']),
		    $db->quoteName('type') . ' = ' . $db->quote($formData['type']),
		);
		if (isset($formData['id']) && $formData['id']>0){
			$conditions = array(
					$db->quoteName('id').'='.$db->quote($formData['id'])
			);
			$query->update($db->quoteName('core_update_tk'))->set($fields)->where($conditions);
		}
		else{
			$query->insert($db->quoteName('core_update_tk'));
			$query->set($fields);
		}
		$db->setQuery($query);
		return $db->query();
	}
	function updateSsoToken($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
		    $db->quoteName('user_id') . ' = ' . $db->quote($formData['user_id']),
		    $db->quoteName('token') . ' = ' . $db->quote($formData['token']),
		    $db->quoteName('id_token') . ' = ' . $db->quote($formData['id_token']),
		);
		if (Core::loadResult('sso_token','user_id','user_id='.$db->quote($formData['user_id']))>0){
			$conditions = array(
					$db->quoteName('user_id').'='.$db->quote($formData['user_id'])
			);
			$query->update($db->quoteName('sso_token'))->set($fields)->where($conditions);
		}
		else{
			$query->insert($db->quoteName('sso_token'));
			$query->set($fields);
		}
		$db->setQuery($query);
		return $db->query();
	}

	function checkLoginSso(){
	}
	function apiToken($code){
		$url = urlencode(Core::config('core/sso/redirect_uri'));
		$client_secret = Core::config('core/sso/client_secret');
		$client_id = Core::config('core/sso/client_id');
		$domain_sso = Core::config('core/sso/domain_sso');
        $curl = curl_init();
		$onoffssl = Core::config('core/sso/onoffssl');
		if($onoffssl==1){
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt_array($curl, array(
		CURLOPT_URL => $domain_sso."/oauth2/token",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS =>"grant_type=authorization_code&code=".$code."&redirect_uri=".$url."&client_secret=".$client_secret."&client_id=".$client_id,
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/x-www-form-urlencoded"
		),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
	function apiGetUserInfo($token){
		$curl = curl_init();
		$domain_sso = Core::config('core/sso/domain_sso');
		$onoffssl = Core::config('core/sso/onoffssl');
		if($onoffssl==1){
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $domain_sso."/oauth2/userinfo",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$token,
		  ),
		));
		
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
		
	}
	function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
	/**
	 * Cập nhật tài khoản từ core_update_tk vào phân quyền người dùng
	 */
	function updatetk(){
	    $flag		=	true;
// 	    $data		=	JRequest::get('post');
	    $db			=	JFactory::getDbo();
	    $query     =   'SELECT * FROM core_update_tk WHERE active IS NULL';
	    $db->setQuery($query);
	    $data_all  =   $db->loadAssocList();
	    if (count($data_all)) {
	        $grname            =   array();
	        for ($i = 0; $i < count($data_all); $i++) {
	            $data  =   $data_all[$i];
	            
	            $check =   $this->check_username($data['username']);
	            if ((int)$check == 0 ) {
	                $object				=	new stdClass();
	                $object->name 		=	$data['name'];
	                $object->username	=	$data['username'];
	                $object->email		=	$data['email'];
	                
	                unset($grname);
	                $grname[]          =   $data['group_id']; //jos_user_usergroup_map
	                $grname[]          =   2; // Nhóm register;
	                $id_donvi          =   (int)$data['iddonvi'];
	                if ((int)$data['iddonvi_quanly'] > 0) {
	                    $iddonvi_quanly		=	(int)$data['iddonvi_quanly'];
	                }else {
	                    $iddonvi_quanly		=	$id_donvi;
	                }
	                // Lấy đơn vị theo type trong group
	                $ar_id_donvi[0]	=	$this->getChirl_Donvi($id_donvi, 0 , $iddonvi_quanly);
	                $ar_id_donvi[1]	=	$this->getChirl_Donvi($id_donvi, 1, $iddonvi_quanly);
	                $ar_id_donvi[2]	=	$this->getChirl_Donvi($id_donvi, 2, $iddonvi_quanly);
	                // 		var_dump($ar_id_donvi); exit;
	                $arname		=	$this->getAction_Group($grname);
	                // thêm mới user
	                $object->registerDate	=	date('Y-m-d H:I:s');
	                $object->password		=	md5($data['password']);
	                $flag = $flag&&$db->insertObject('jos_users', $object, 'id');
	                if ($flag) {
	                    if ($grname != null) {
	                        for($j = 0; $j < count ($grname); $j ++) {
	                            $object_user_usergroup_map = new stdClass();
	                            $object_user_usergroup_map->group_id	=	$grname[$j];
	                            $object_user_usergroup_map->user_id		=	$object->id;
	                            $flag_g	=	$db->insertObject('jos_user_usergroup_map', $object_user_usergroup_map);
	                            if ($flag_g) {
	                                //echo '123'; exit;
	                                foreach ($arname as $value) { // array action theo group
	                                    if ((int)$value['group_id'] == (int)$grname[$j]) {
	                                        // Lấy đơn vị theo phân quyền group 0 1 2 lưu 'user_id, action_id, iddonvi' vào bảng core_user_action_donvi
	                                        $type	=	(int)$value['type'];
	                                        //for ($k = 0; $k < count($ar_id_donvi[$type]); $k++) {
	                                        //echo $ar_id_donvi[$type][$k];
	                                        $object_user_action_donvi	= new stdClass();
	                                        $object_user_action_donvi->user_id		=	$object->id;
	                                        $object_user_action_donvi->action_id	=	$value['action_id'];
	                                        $object_user_action_donvi->iddonvi		=	(int)$ar_id_donvi[$type];//[$k];
	                                        $object_user_action_donvi->group_id		=	$value['group_id'];
	                                        $db->insertObject('core_user_action_donvi', $object_user_action_donvi);
	                                        //}
	                                    }
	                                }
	                            }
	                        }
	                    }
	                    if ((int)$id_donvi > 0 || (int)$iddonvi_quanly > 0) {
	                        $object_core_user_donvi = new stdClass();
	                        $object_core_user_donvi->id_donvi	=	$id_donvi;
	                        $object_core_user_donvi->id_user	=	$object->id;
	                        $object_core_user_donvi->iddonvi_quanly	=	$iddonvi_quanly;
	                        $db->insertObject('core_user_donvi', $object_core_user_donvi);
	                    }
	                }
	                $this->update_tk($data['id']);
	            }
	        }
	    }
	    return $flag;
	}
	function update_tk($id){
	    $db= JFactory::getDBO();
	    $sql_fk = 'UPDATE core_update_tk SET active = 1  WHERE id = ('.$id.')';
	    $db->setQuery($sql_fk);
	    return 	$db->query();
	}
	public function getChirl_Donvi($id, $type = 0, $iddonvi_quanly){
		
		$result = null;
		if ((int)$id > 0) {
			if ((int)$type == 0) {
				$result	=	$id;
// 					WHERE lft >= (SELECT lft FROM ins_dept WHERE id = '.$id.') 
// 					AND rgt <= (SELECT rgt FROM ins_dept WHERE id = '.$id.') 
// 					AND type in (1,2)'
				;
			}elseif ((int)$type == 1) {
				/* if ($id == 150000) {
					$result	=	150000;
				}else {
					$db		=	JFactory::getDbo();
					$query	=	'SELECT id FROM ins_dept WHERE lft = (SELECT MIN(a.lft) FROM ins_dept a 
						WHERE lft >= (SELECT lft FROM ins_dept WHERE id = 
						(SELECT parent_id FROM ins_dept WHERE ID ='.$id.'))
						AND rgt <= (SELECT rgt FROM ins_dept WHERE id = 
						(SELECT parent_id FROM ins_dept WHERE ID ='.$id.'))
						AND type in (1,2))'
						;
					$db->setQuery($query);
					$result	=	$db->loadResult();
				} */
				$result = $iddonvi_quanly;
			}elseif ((int)$type == 2){
				$db		=	JFactory::getDbo();
				$query	=	'SELECT id FROM ins_dept where lft = 0';
				$db->setQuery($query);
				$result	=	$db->loadResult();
// 				$root_id = Core::getRootId();
// 				$result	= $root_id;//	(int)core::getRootId(); 
			}
		}
		
		return (int)$result;
	}
	/**
	 * Kiểm tra username
	 * @param string $username
	 * @return Ambigous <string, mixed, NULL>
	 */
	public function check_username($username = ''){
		$result = '';
		if ($username != '') {
			$result = Core::loadResult('jos_users', 'id', array('LOWER(username) = '=>trim(strtolower($username))));
		}
		return $result;
	}
	/**
	 * 
	 * @param unknown $ar_group_id
	 * @return Ambigous <mixed, NULL, multitype:unknown Ambigous <unknown, mixed> >
	 */
	public function getAction_Group($ar_group_id ){
		//		$result		=	array();
				$db			=	JFactory::getDbo();
				if (is_array($ar_group_id)) {
					if (count($ar_group_id) > 0) {
						$group_id = implode(', ', $ar_group_id);
						$query	= 'SELECT group_id,action_id, type
								FROM core_group_action
								WHERE group_id  in ( '.$group_id.' )' ;
					}
				}
				
				$db->setQuery($query);
				$row		=	$db->loadAssocList();
				return $row;
			}
}
