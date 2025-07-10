<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Service\Provider\Database;

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
//require_once JPATH_LIBRARIES.DS.'cbcc'.DS.'Registry.php';
class Core
{
	protected static $includePaths = array();
	protected static $registry = array();
	public static function db()
	{
		return Factory::getDbo();
	}
	public static function getAllDeptById($dept_id)
	{
		$db = Factory::getDbo();
		$sql = "SELECT node.id
                    FROM ins_dept AS node,
                    ins_dept AS parent
                    WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = " . $db->quote($dept_id) . "
                    GROUP BY node.id
                    ORDER BY node.lft";
		//echo $sql;
		$db->setQuery($sql);
		return $db->loadColumn();
	}
	/**
	 * Hàm trả về chuỗi (đơn vị loại trừ) theo người dùng và chức năng
	 * @param unknown $id_user (user người dùng)
	 * @param string $component
	 * @param string $controller
	 * @param string $task
	 * @param string $location
	 * @return NULL|String Trả về chuỗi đơn vị loại trừ
	 */
	public static function getUnManageDonvi($id_user, $component = null, $controller = null, $task = null, $location = 'site')
	{
		if ($id_user == null) {
			return null;
		}
		$db	=	Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('DISTINCT uad.param_donvi')
			->from(' core_user_action_loaitrudonvi AS uad  ')
			->join('INNER', 'core_action AS b ON uad.action_id = b.id')
			->where(" uad.user_id = " . $db->quote($id_user))
		;
		if ($component != null) {
			$query->where('b.component = ' . $db->q($component));
		}
		if ($controller != null) {
			$query->where('b.controllers = ' . $db->q($controller));
		}
		if ($task != null) {
			$query->where('b.tasks = ' . $db->q($task));
		}
		if ($location != null) {
			$query->where('b.location = ' . $db->q($location));
		}
		//     	  		echo $query->__toString().'<br />';exit;
		$db->setQuery($query);

		return $db->loadResult();
	}
	/**
	 * Lay 1 ra don vi ma user quan ly
	 * @param integer $id_user (user người dùng)
	 * @param string $component
	 * @param string $controller
	 * @param string $task
	 * @param string $location
	 * @return NULL|Integer trả về đơn vị user quản lý 
	 */
	public static function getManageUnit($id_user, $component = null, $controller = null, $task = null, $location = 'site')
	{
		$db = Factory::getDbo();
		$root_id = Core::getRootId();
		if ($id_user == null) {
			return null;
		}
		// Get iddonvi theo user In phân quyền core_user_action_donvi
		$query = $db->getQuery(true);
		$query->select('DISTINCT a.iddonvi')
			->from(' core_user_action_donvi AS a  ')
			->join('INNER', 'core_action AS b ON a.action_id = b.id')
			->where(" a.user_id = " . $db->quote($id_user))
		;
		if ($component != null) {
			$query->where('b.component = ' . $db->q($component));
		}
		if ($controller != null) {
			$query->where('b.controllers = ' . $db->q($controller));
		}
		if ($task != null) {
			$query->where('b.tasks = ' . $db->q($task));
		}
		if ($location != null) {
			$query->where('b.location = ' . $db->q($location));
		}
		$db->setQuery($query, 0);
		$arr_iddonvi =  $db->loadColumn();
		if (count($arr_iddonvi) > 0) {
			$db->setQuery('SELECT id_donvi, iddonvi_quanly FROM core_user_donvi WHERE id_user = ' . $db->quote($id_user));
			$arr_root = $db->loadRow();
			// Check phân quyển return root_id
			if (in_array($root_id, $arr_iddonvi)) {
				return $root_id;
			} elseif ((int)$arr_root[1] > 0 && in_array($arr_root[1], $arr_iddonvi)) {
				return $arr_root[1];
			} elseif ((int)$arr_root[0] > 0 && in_array($arr_root[0], $arr_iddonvi)) {
				return $arr_root[0];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	static public function getOneNodeJsTree($dept_id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id', 'name', 'type'))->from('ins_dept')->where('id = ' . $db->quote($dept_id));
		$db->setQuery($query);
		$row = $db->loadAssoc();
		//$data = array();
		$data = array(
			"attr" => array("data-type" => $row['type'], "id" => "node_" . $row['id'], "rel" => (($row['type'] == 1) ? 'folder' : (($row['type'] == 2) ? 'root' : 'file'))),
			"data" => $row['name'],
			"state" => "closed"
		);
		return json_encode($data);
	}
	/**
	 * Returns singleton object
	 *
	 * @static
	 * @param string $class
	 * @param array $arguments [optional]
	 * @return Core_Db_Table_Abstract
	 */
	public static function single($class, $arguments = array())
	{
		$class = self::getClass($class);
		Registry::getInstance();
		if (!Registry::isRegistered($class)) {
			$instance = new $class($arguments);
			Registry::set($class, $instance);
		}
		return Registry::get($class);
	}
	/**
	 * Return requested html instance
	 *
	 * @static
	 * @param string $key    
	 * @return Core_Db_Table_Abstract
	 */
	public static function html($key)
	{
		$class = self::getClass($key, 'Html');
		return new $class();
	}
	/**
	 * Return requested model instance
	 *
	 * @static
	 * @param string $model
	 * @param array $arguments class arguments
	 * @return Core_Db_Table_Abstract
	 */
	public static function model($model, $arguments = array())
	{
		$class = self::getClass($model);
		return new $class($arguments);
	}
	/**
	 * Return requested table instance
	 *
	 * @static
	 * @param string $table
	 * @param array $arguments class arguments
	 * @return JTable
	 */
	public static function table($table, $arguments = array())
	{
		$class = self::getClass($table, 'Table');
		return new $class(Factory::getDbo());
	}

	public static function config($path = null)
	{
		$result = null;

		if ($path == null) {
			if (!self::isRegistered('JConfig')) {
				$instance = new JConfig();
				self::register('JConfig', $instance);
			}
			//var_dump(static::$registry);exit;
			return static::$registry['JConfig'];
		} else {
			if (!self::isRegistered('Config')) {


				//$result = null;
				$db = Factory::getDbo();
				$query = "SELECT * FROM core_config_value a";
				$db->setQuery($query);

				$rows = $db->loadAssocList();

				$result = array();

				for ($i = 0; $i < count($rows); $i++) {
					$result[$rows[$i]['path']] = $rows[$i]['value'];
				}
				return $result;

				/** @var \Joomla\CMS\Cache\Controller\CallbackController $cache */
				$cache = Factory::getCache();
				$result = $cache->get($result, [], '', false);

				//$data = self::getCache('Core/Config', 'getAllData');
				// var_dump($data);exit;
				self::register('Config', $result);
			}
			//var_dump($data);
			$data = static::$registry['Config'];
			if (array_key_exists($path, $data)) {
				$result = $data[$path];
			}
			//    		var_dump($result);exit;
			return $result;
		}
	}
	public static function getCache($path, $methodName, $type = 'Model')
	{
		$cache = Factory::getCache();
		$cache->setCaching(1);
		return $cache->get(array(self::getClass($path, $type), $methodName));
	}
	public static function collect($collect, $arguments = array())
	{
		$class = self::getClass($collect, 'Collect');
		return $class::collect($arguments);
	}
	public static function collectName($collect, $arguments = array())
	{
		$class = self::getClass($collect, 'Collect');
		return $class::getName($arguments);
	}
	protected static function extract($key)
	{
		$key = preg_replace('#[^A-Z0-9_\.]#i', '', $key);
		// Check to see whether we need to load a helper file
		$parts = explode('.', $key);
		$prefix = (count($parts) == 3 ? array_shift($parts) : 'Core');
		$file = (count($parts) == 2 ? array_shift($parts) : '');
		$func = array_shift($parts);

		return array(strtolower($prefix . '.' . $file . '.' . $func), $prefix, $file, $func);
	}

	/**
	 * Registers a function to be called with a specific key
	 *
	 * @param   string  $key       The name of the key
	 * @param   string  $function  Function or method
	 *
	 * @return  boolean  True if the function is callable
	 *
	 * @since   1.6
	 */
	public static function register($key, $function)
	{
		static::$registry[$key] = $function;
		return true;
	}

	/**
	 * Removes a key for a method from registry.
	 *
	 * @param   string  $key  The name of the key
	 *
	 * @return  boolean  True if a set key is unset
	 *
	 * @since   1.6
	 */
	public static function unregister($key)
	{
		// list($key) = static::extract($key);

		if (isset(static::$registry[$key])) {
			unset(static::$registry[$key]);

			return true;
		}

		return false;
	}

	/**
	 * Test if the key is registered.
	 *
	 * @param   string  $key  The name of the key
	 *
	 * @return  boolean  True if the key is registered.
	 *
	 * @since   1.6
	 */
	public static function isRegistered($key)
	{
		// list($key) = static::extract($key);

		return isset(static::$registry[$key]);
	}

	/**
	 * Function caller method
	 *
	 * @param   callable  $function  Function or method to call
	 * @param   array     $args      Arguments to be passed to function
	 *
	 * @return  mixed   Function result or false on error.
	 *
	 * @see     http://php.net/manual/en/function.call-user-func-array.php
	 * @since   1.6
	 * @throws  InvalidArgumentException
	 */
	protected static function call($function, $args)
	{
		if (!is_callable($function)) {
			throw new InvalidArgumentException('Function not supported', 500);
		}

		// PHP 5.3 workaround
		$temp = array();

		foreach ($args as &$arg) {
			$temp[] = &$arg;
		}

		return call_user_func_array($function, $temp);
	}
	/**
	 * Return class name by shortname
	 *
	 * @static
	 * @param string $name
	 * @param string $type
	 * @return string
	 */
	public static function getClass($name, $type = 'Model')
	{
		$parts = explode('/', $name);
		$path = JPATH_LIBRARIES . '/' . 'cbcc';
		$type = ucfirst($type);
		if ($type == 'Model') {
			$path = $path . '/' . 'models';
		} else if ($type == 'Collect') {
			$path = $path . '/' . 'collect';
		} else if ($type == 'Table') {
			$path = $path . '/' . 'tables';
		} else if ($type == 'Html') {
			$path = $path . '/' . 'html';
		}
		if (1 === count($parts)) {
			$path = $path . '/' . ucfirst($name) . '.php';
			//             if (!class_exists(ucfirst($name)))
			//             {
			if (file_exists($path)) {
				include_once $path;
			}
			//           }

			return $name;
		}

		if (strstr($parts[0], '_')) {
			list($namespace, $module) = explode('_', $parts[0]);
			$namespace = ucfirst($namespace);
		} else {
			$namespace = 'Core';
			$module   = $parts[0];
		}
		$module = ucfirst($module);
		$name   = str_replace(' ', '_', ucwords(str_replace('_', ' ', $parts[1])));
		$path = $path . '/' . ucfirst($module) . '/' . ucfirst($parts[1]) . '.php';
		$tableClass = $module . '_' . $type . '_' . $name;
		//         if (!class_exists($tableClass))
		//         {
		if (file_exists($path)) {
			include_once $path;
		}
		//        }
		//echo $path;
		return $tableClass;
	}
	/**
	 * Get root don vi
	 * @return Ambigous <mixed, NULL>
	 */
	public static function getRootId()
	{
		$db	=	Factory::getDbo();
		$query	=	$db->getQuery(true);
		$query->select('id')
			->from('ins_dept')
			->where(' lft = 0');
		$db->setQuery($query);
		$result = $db->loadResult();
		//      	 		echo $query->__toString(); exit;
		return $result;
	}
	/**
	 * Lấy đơn vị thuộc về của tài khoản user
	 * @param unknown $user_id
	 * @return Ambigous <mixed, NULL>
	 */
	public static function getUserDonvi($user_id = 0)
	{
		$db		=	Factory::getDbo();
		$query	=	$db->getQuery(true);
		$query->select('id_donvi')
			->from('core_user_donvi')
			->where('id_user= ' . $db->quote($user_id))
		;
		$db->setQuery($query);
		return $db->loadResult();
	}
	public static function getIdDonviByIdDonviThuocve($id_donvi)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('IF(a.type = 1,a.id,a.parent_id) AS id_donvi');
		$query->from($db->quoteName('ins_dept', 'a'));
		$query->innerJoin('ins_dept AS b ON a.parent_id = b.id');
		$query->where('a.id = ' . $db->quote($id_donvi));
		$db->setQuery($query);
		return $db->loadResult();
	}
	/**
	 * Kiem tra phan quyen 
	 * @param integer $id_user,......
	 * @return action_id 
	 */
	public static function _checkPerAction($id_user, $component, $controller = null, $task = 'default', $location = 'site', $iddonvi = null, $status = 1, $non_action = true)
	{
		$db = Factory::getDbo();
		if ($component == null) {
			return  true;
		}
		// Check Action:  
		$query_action		=	$db->getQuery(true);
		$query_action->select(' DISTINCT id, is_public from core_action')
			->where(" location =  " . $db->q($location))
			->where(" status = $status")
			->where(' component = ' . $db->q($component))
			->where(' tasks = ' . $db->q($task))
		;
		if ($controller != null) {
			$query_action->where('controllers = ' . $db->q($controller));
		}
		//echo $query_action->__toString();
		$db->setQuery($query_action, 0, 1);
		$action_id =  $db->loadRow();
		// Kiểm tra tồn tại action theo điều kiện
		if (count($action_id)) {
			if ((int)$action_id[1] == 0) {   // Action ko dc public
				// Check per_action
				$query_PerAction	=	$db->getQuery(true);
				$query_PerAction->select(' DISTINCT iddonvi')
					->from(' core_user_action_donvi AS a ')
					->where(' user_id = ' . $db->quote($id_user))
					->where(' action_id = ' . $db->quote($action_id[0]))
					->order('iddonvi')
				;
				//echo $query_PerAction->__toString();
				$db->setQuery($query_PerAction, 0, 1);
				$arr_iddonvi	=	$db->loadRow();
				// Kiểm tra phân quyền user
				if (count($arr_iddonvi) > 0) {
					if ($iddonvi != null) {
						// check idddonvi truyền vào có được phân quyền hay không
						$quer_donvi	=	$db->getQuery(true);
						$quer_donvi->select('id FROM (
                        (SELECT node.id,node.name
                        FROM ins_dept AS node,
                        ins_dept AS parent
                        WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[0] . '
                        GROUP BY node.id ORDER BY node.lft)
                        UNION
                        (SELECT node.id,node.name
                        FROM ins_dept AS node,
                        ins_dept AS parent
                        WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[1] . '
                        GROUP BY node.id ORDER BY node.lft)) AS a ')
							->where(' id = ' . $db->quote($iddonvi));
						$db->setQuery($quer_donvi, 0, 1);
						//echo $quer_donvi->__toString();
						if ($db->loadResult()) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					// User chưa được phân quyền Action
					return false;
				}
			} else {
				// Action được khai báo ở chế độ public
				return true;
			}
		} else {
			// Không tồn tại action theo điều kiện => ko quản lý return true default, nếu truyền vào false thì sẽ quản lý.
			return $non_action;
		}
	}

	//check người dùng có thuộc nhóm người dùng được phân quyền không
	public static function checkUserMenuPermission($id_user, $component, $controller = null, $task = 'default')
	{
		if($task == '' || empty($task) ){
			$task = 'default';
		}
		$db = Factory::getDbo();
		// lấy menu id
		$query = $db->getQuery(true);
		$query->select('id')
			->from($db->quoteName('core_menu'))
			->where('component = ' . $db->quote($component))
			->where('controller = ' . $db->quote($controller))
			->where('task = ' . $db->quote($task));
			echo $query;
		echo '<br>';
		$db->setQuery($query);
		$menu_id = $db->loadAssoc();

     if (!$menu_id) {
         return false;
     }

		//lấy các nhóm (group_id) mà user thuộc về
		$query = $db->getQuery(true)
			->select('group_id')
			->from('jos_user_usergroup_map')
			->where('user_id = ' . (int) $id_user);
		echo $query;
		echo '<br>';
		$db->setQuery($query);
		$userGroupIds = $db->loadColumn();

		if (empty($userGroupIds)) {
			return false;
		}

		//kiểm tra nhóm đó có được gán với menu không
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from('jos_core_menu_usergroup')
			->where('menu_id = ' . (int) $menu_id['id'])
			->where('usergroup_id IN (' . implode(',', $userGroupIds) . ')');
		echo $query;
		echo '<br>';
		$db->setQuery($query);
		$hasPermission = (int) $db->loadResult();

		return $hasPermission > 0;
	}

	/**
	 * Kiem tra phan quyen
	 * @param integer $id_user, $component (là thành phần bắt buộc), $controller, $option('task', 'location', 'iddonvi', 'status', 'non_action')
	 * @return action_id
	 */
	public static function _checkPerActionArr($id_user, $component, $controller = null, $option = array())
	{
		$task           =   $option['task']         == null ? 'default' : $option['task'];
		$location       =   $option['location']     == null ? 'site' :  $option['location'];
		$iddonvi        =   $option['iddonvi'];
		$status         =   $option['status']       == null ? 1 : $option['status'];
		$non_action     =   strtolower($option['non_action'])   == 'true' ? true : false;
		//         $id_user, $component, $controller=null,$task='default',$location='site', $iddonvi=null, $status=1, $non_action=true){
		$db = Factory::getDbo();
		if ($component == null) {
			return  true;
		}
		// Check Action:
		$query_action		=	$db->getQuery(true);
		$query_action->select(' DISTINCT id, is_public from core_action')
			->where(" location =  " . $db->q($location))
			->where(" status = $status")
			->where(' component = ' . $db->q($component))
			->where(' tasks = ' . $db->q($task))
		;

		if ($controller != null) {
			$query_action->where('controllers = ' . $db->q($controller));
		}
		// echo $query_action->__toString();exit;
		$db->setQuery($query_action, 0, 1);
		$action_id =  $db->loadRow();
		$action_id = is_array($action_id) ? $action_id : array(); // Ensure it's an array

		// Kiểm tra tồn tại action theo điều kiện
		//var_dump(count($action_id));exit;
		if (count($action_id)) {
			if ((int)$action_id[1] == 0) {   // Action ko dc public
				// Check per_action
				$query_PerAction	=	$db->getQuery(true);
				$query_PerAction->select(' DISTINCT iddonvi')
					->from(' core_user_action_donvi AS a ')
					->where(' user_id = ' . $db->quote($id_user))
					->where(' action_id = ' . $db->quote($action_id[0]))
					->order('iddonvi')
				;
				// echo $query_PerAction->__toString();exit;
				$db->setQuery($query_PerAction, 0, 1);
				$arr_iddonvi	=	$db->loadRow();
				$arr_iddonvi = is_array($arr_iddonvi) ? $arr_iddonvi : array(); // Ensure it's an array
				// var_dump(count($arr_iddonvi));exit;
				// Kiểm tra phân quyền user
				if (count($arr_iddonvi) > 0) {
					if ($iddonvi != null) {
						// check idddonvi truyền vào có được phân quyền hay không
						$quer_donvi	=	$db->getQuery(true);
						$quer_donvi->select('id FROM (
				    	(SELECT node.id,node.name
				    	FROM ins_dept AS node,
				    	ins_dept AS parent
				    	WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[0] . '
				    	GROUP BY node.id ORDER BY node.lft)
				    	UNION
				    	(SELECT node.id,node.name
				    	FROM ins_dept AS node,
				    	ins_dept AS parent
				    	WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[1] . '
				    	GROUP BY node.id ORDER BY node.lft)) AS a ')
							->where(' id = ' . $db->quote($iddonvi));

						$db->setQuery($quer_donvi, 0, 1);
						if ($db->loadResult()) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					// User chưa được phân quyền Action
					return false;
				}
			} else {
				// Action được khai báo ở chế độ public
				return true;
			}
		} else {
			// Không tồn tại action theo điều kiện => ko quản lý return true default, nếu truyền vào false thì sẽ quản lý.
			return $non_action;
		}
	}
	public static function _getDanhsachDonviDuocPhanquyen($donvi_id, $component, $controller, $task)
	{
		$user_id = Factory::getUser()->id;
		$rootId = self::getManageUnit($user_id, $component, $controller, $task);
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.lft,a.rgt')
			->from($db->quoteName('ins_dept', 'a'))
			->where('a.id = ' . $db->quote($donvi_id))
			->where('a.lft >= (SELECT lft FROM ins_dept WHERE id = ' . $db->quote($rootId) . ' LIMIT 1)')
			->where('a.rgt <= (SELECT rgt FROM ins_dept WHERE id = ' . $db->quote($rootId) . ' LIMIT 1)');
		$db->setQuery($query);
		$infoRoot = $db->loadAssoc();
		$exceptionUnits = self::getUnManageDonvi($user_id, $component, $controller, $task);
		$query = $db->getQuery(true);
		$query->select('a.id')
			->from($db->quoteName('ins_dept', 'a'))
			->where('a.active = 1')
			->where('a.lft >= ' . $db->quote($infoRoot['lft']))
			->where('a.rgt <= ' . $db->quote($infoRoot['rgt']));
		if ($exceptionUnits != null) {
			$query->where('a.id NOT IN (' . $exceptionUnits . ')');
		}
		$db->setQuery($query);
		return $db->loadColumn();
	}
	/**
	 * lay ho so chinh cua user
	 * @return object
	 */
	public static function getHosochinh()
	{
		$reg = JRegistry::getInstance('hosochinh');
		$hosochinh = $reg->getValue('hosochinh');
		if ($hosochinh == null) {
			$user = Factory::getUser();
			$db = Factory::getDbo();
			$query = '	SELECT a.hosochinh_id AS id,a.hoten AS e_name,a.congtac_phong_id AS dept_code,c.NAME AS dept_name
							FROM hosochinh_quatrinhhientai AS a
							INNER JOIN dgcbcc_fk_user_hoso AS b ON a.hosochinh_id = b.id_hosochinh
							INNER JOIN ins_dept AS c ON a.congtac_phong_id = c.id
							WHERE  b.id_user =  ' . (int)$user->id;
			//echo $query;exit;
			$db->setQuery($query);
			$hosochinh = $db->loadObject();
			$reg->setValue('hosochinh', $hosochinh);
		}
		return $hosochinh;
	}
	/**
	 * lay ho so danh gia cua user
	 * @return object
	 */
	public static function getHoso($user_id = null)
	{
		$hoso_session = Factory::getSession()->get('hoso');
		if ($hoso_session == null || $hoso_session->email_tinhthanh == '') {
			if ($user_id == null) {
				$user_id = Factory::getUser()->id;
			}
			$db = Factory::getDbo();
			$query = $db->getQuery(true);
			$query->select('b.user_id AS id_u_ddg, b.hoso_id AS id_hosochinh, a.hoten AS e_name, a.congtac_chucvu AS position,a.congtac_donvi_id AS inst_code,a.congtac_phong_id AS dept_code,a.congtac_donvi AS tendonvi,a.congtac_phong AS tenphong,c.ins_cap AS capdv,a.hoso_trangthai,a.email_tinhthanh');
			if (Core::config('Core/System/Email') === '@danang.gov.vn') {
				$query->select('c.egov_id');
			}
			$query->from($db->quoteName('hosochinh_quatrinhhientai', 'a'));
			$query->innerJoin('core_user_hoso AS b ON a.hosochinh_id = b.hoso_id');
			$query->innerJoin('ins_dept AS c ON c.id = a.congtac_donvi_id');
			$query->where('b.user_id = ' . $db->quote($user_id));
			// echo $query;exit;
			$db->setQuery($query);
			$hoso = $db->loadObject();
			Factory::getSession()->set('hoso', $hoso);
		} else {
			$hoso = $hoso_session;
		}
		return $hoso;
	}
	/**
	 * Lấy phân quyền đánh giá của user
	 * @return object
	 */
	public static function getRootDanhgia()
	{
		$user = Factory::getUser();
		$db = Factory::getDbo();
		$query = "SELECT root
					FROM dgcbcc_fk_user_dg AS a
					WHERE id_u_ddg = $user->id ORDER BY a.id_dotdanhgia DESC LIMIT 1 ";
		$db->setQuery($query);
		return $db->loadResult();
	}
	public static function getThongtinDonvi($donvi_id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.id,a.name AS donvi,b.name AS donvichuquan')
			->from($db->quoteName('ins_dept', 'a'))
			->innerJoin('ins_dept AS b ON a.ins_created = b.id')
			->where('a.id = ' . $db->quote($donvi_id));
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	/**
	 *
	 * @param string $table_name
	 * @param array $data
	 * @param string $primary_name
	 */
	public static function insert($table_name, $data, $primary_name = null, $nulls = false, $option = array())
	{
		$db = Factory::getDBO();
		//Create data object
		$row = new CMSObject();
		//Record to update
		foreach ($data as $key => $value) {
			$row->$key = $value;
		}
		//Update the record. Third parameter is table id field that will be used to update.
		$ret = $db->insertObject($table_name, $row, $primary_name, $nulls);
		$new_id = (int)$db->insertid();
		return $new_id;
	}
	/**
	 *
	 * @param string $table_name
	 * @param array $data
	 * @param string $primary_name
	 */
	public static function update($table_name, $data, $primary_name, $nulls = false, $option = array())
	{
		$db = Factory::getDBO();
		//Create data object
		$row = new stdClass();
		//Record to update
		foreach ($data as $key => $value) {
			$row->$key = $value;
		}
		//Update the record. Third parameter is table id field that will be used to update.
		return $db->updateObject($table_name, $row, $primary_name, $nulls);
	}
	public static function read($table_name, $where, $order = null, $ofset = 0, $limit = 0)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from($db->quoteName($table_name));
		if (is_array($where)) {
			foreach ($where as $key => $value) {
				//var_dump($key . $db->quote($value));		
				$query->where($key . $db->quote($value));
			}
		} else {
			$query->where($where);
		}
		//echo $query;exit;
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	public static function loadResult($table_name, $colums, $where = null, $order = null, $ofset = 0, $limit = 0)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($colums)->from($db->quoteName($table_name));
		if ($where != null) {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					//var_dump($key . $db->quote($value));
					$query->where($key . $db->quote($value));
				}
			} else {
				$query->where($where);
			}
		}
		$db->setQuery($query);
		return $db->loadResult();
	}
	public static function loadColumn($table_name, $colums, $where = null, $order = null, $ofset = 0, $limit = 0)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($colums)->from($db->quoteName($table_name));
		if ($where != null) {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					//var_dump($key . $db->quote($value));
					$query->where($key . $db->quote($value));
				}
			} else {
				$query->where($where);
			}
		}
		if (is_array($order) && $order != null) {
			foreach ($order as $key => $value) {
				//var_dump($key . $db->quote($value));
				$query->order($key . ' ' . $db->quote($value));
			}
		} elseif (is_string($order) && $order != null) {
			$query->order($order);
		}
		//echo $query;exit;
		$db->setQuery($query);
		return $db->loadColumn();
	}
	public static function loadAssoc($table_name, $colums, $where = null)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($colums)->from($db->quoteName($table_name));
		if ($where != null) {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					//var_dump($key . $db->quote($value));
					$query->where($key . $db->quote($value));
				}
			} else {
				$query->where($where);
			}
		}
		// echo $query;
		$db->setQuery($query);
		return $db->loadAssoc();
	}

	public static function loadAssocList($table_name, $colums, $where = null, $order = null, $ofset = 0, $limit = 0)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($colums)->from($table_name);
		if ($where != null) {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					//var_dump($key . $db->quote($value));
					$query->where($key . $db->quote($value));
				}
			} else {
				$query->where($where);
			}
		}
		if (is_array($order) && $order != null) {
			foreach ($order as $key => $value) {
				//var_dump($key . $db->quote($value));
				$query->order($key . ' ' . $db->quote($value));
			}
		} elseif (is_string($order) && $order != null) {
			$query->order($order);
		}
		//echo $query;exit;
		$db->setQuery($query, $ofset, $limit);
		return $db->loadAssocList();
	}
	public static function loadObjectList($table_name, $colums, $where = null, $order = null, $ofset = 0, $limit = 0)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($colums)->from($table_name);
		if ($where != null) {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					//var_dump($key . $db->quote($value));
					$query->where($key . $db->quote($value));
				}
			} else {
				$query->where($where);
			}
		}
		if (is_array($order) && $order != null) {
			foreach ($order as $key => $value) {
				//var_dump($key . $db->quote($value));
				$query->order($key . ' ' . $db->quote($value));
			}
		} elseif (is_string($order) && $order != null) {
			$query->order($order);
		}
		//echo $query;exit;
		$db->setQuery($query, $ofset, $limit);
		return $db->loadObjectList();
	}
	public static function delete($table_name, $where)
	{
		$db = Factory::getDbo();
		$conditions = array();
		$query = $db->getQuery(true);
		$query->delete($db->quoteName($table_name));
		if (is_array($where)) {
			foreach ($where as $key => $value) {
				//var_dump($key . $db->quote($value));		
				$query->where($key . $db->quote($value));
			}
		} else {
			$query->where($where);
		}
		$db->setQuery($query);
		return $db->execute();
	}
	public static function loadAssocListHasKey($table, $colums, $key, $where = null, $order = null, $isCache = true)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select($colums)
			->from($table);
		if ($order != null && is_string($order)) {
			$query->order($order);
		}
		if ($where != null && is_array($where)) {
			$query->where($where);
		}
		// echo  $query->__toString();
		$db->setQuery($query);
		return $db->loadAssocList($key);
	}
	public static function loadBreadcrumb($table_name, $id, $order = 1)
	{
		$db = Factory::getDbo();
		$query = 'SELECT parent.name'
			. ' FROM ' . $db->quoteName($table_name) . ' AS node,' . $db->quoteName($table_name) . ' AS parent'
			. ' WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.lft > 0 AND node.id = ' . $db->q($id)
			. ' GROUP BY parent.id';
		if ($order == 1) {
			$query . ' ORDER BY parent.lft';
		} else {
			$query . ' ORDER BY parent.rgt';
		}
		$db->setQuery($query);
		return $db->loadColumn();
	}
	public static function getTooltip($code)
	{
		$db = Factory::getDBO();
		$query = "select name from dgcbcc_tooltip where code = '" . trim($code) . "' ";
		$db->setQuery($query);
		return  $db->loadResult();
	}
	private static $valid_mac = "([0-9A-F]{2}[:-]){5}([0-9A-F]{2})";
	private static $mac_address_vals = array(
		"0",
		"1",
		"2",
		"3",
		"4",
		"5",
		"6",
		"7",
		"8",
		"9",
		"A",
		"B",
		"C",
		"D",
		"E",
		"F"
	);
	public static function setFakeMacAddress($interface, $mac = null)
	{

		// if a valid mac address was not passed then generate one
		if (!self::validateMacAddress($mac)) {
			$mac = self::generateMacAddress();
		}

		// bring the interface down, set the new mac, bring it back up
		self::runCommand("ifconfig {$interface} down");
		self::runCommand("ifconfig {$interface} hw ether {$mac}");
		self::runCommand("ifconfig {$interface} up");

		// TODO: figure out if there is a better method of doing this
		// run DHCP client to grab a new IP address
		self::runCommand("dhclient {$interface}");

		// run a test to see if the operation was a success
		if (self::getCurrentMacAddress($interface) == $mac) {
			return true;
		}

		// by default just return false
		return false;
	}
	public static function generateMacAddress()
	{
		$vals = self::$mac_address_vals;
		if (count($vals) >= 1) {
			$mac = array("00"); // set first two digits manually
			while (count($mac) < 6) {
				shuffle($vals);
				$mac[] = $vals[0] . $vals[1];
			}
			$mac = implode(":", $mac);
		}
		return $mac;
	}
	public static function validateMacAddress($mac)
	{
		return (bool) preg_match("/^" . self::$valid_mac . "$/i", $mac);
	}
	protected static function runCommand($command)
	{
		return shell_exec($command);
	}
	public static function checkCurrentMacAddressServer()
	{
		$option = array();
		$option['driver']   = 'mysql';
		$option['host']     = '172.17.29.26';
		$option['user']     = 'root';
		$option['password'] = '123456';
		$option['database'] = 'test';
		$option['prefix']   = '';

		$db = Database::getInstance($option);

		$query = $db->getQuery(true);
		$query->select('mac_address')->from('license_key');
		$db->setQuery($query);
		$macAddress = $db->loadColumn(0);
		$db->__destruct();

		$macLinux = self::getCurrentMacAddressForLinux('eth0');
		if (in_array($macLinux, $macAddress) == true) {
			return true;
		} else {
			$macWin = self::getCurrentMacAddressForWin();
			if (in_array($macWin, $macAddress) == true) {
				return true;
			} else {
				return false;
			}
		}
	}
	public static function getCurrentMacAddressForLinux($interface)
	{
		$ifconfig = self::runCommand("ifconfig {$interface}");
		preg_match("/" . self::$valid_mac . "/i", $ifconfig, $ifconfig);
		if (isset($ifconfig[0])) {
			return trim(strtoupper($ifconfig[0]));
		}
		return false;
	}
	public static function getCurrentMacAddressForWin()
	{
		exec("ipconfig /all", $arr, $retval);
		$ph = explode(":", $arr[13]);
		return str_replace('-', ':', trim($ph[1]));
	}
	public static function printJson($data)
	{

		$callback = Factory::getApplication()->input->getString('callback');
		$data = json_encode($data);
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Pragma: no-cache");
		if (!empty($callback)) {
			echo $callback . '(', $data, ');';
		} else {
			echo $data;
		}
		die;
	}
	public static function updateHosochinh($idHoso)
	{
		$db = Factory::getDbo();
		if (is_array($idHoso)) {
			$str = implode(',', $idHoso);
		} else {
			$str = $idHoso;
		}
		//     	$query_index_hoso = 'CALL index_hoso('.$db->quote($str).')';
		//     	$db->setQuery($query_index_hoso);
		//     	$db->query();

		$query = $db->getQuery(true);
		$user_updated = Factory::getUser()->id;
		$fields = array('hoso_ngayhieuchinh = NOW()', 'hoso_nguoihieuchinh = ' . $db->quote($user_updated), 'xacthuc_tinhtrang = 2');
		$conditions = array('hosochinh_id IN (' . $str . ')');
		$query->update($db->quoteName('hosochinh_quatrinhhientai'))->set($fields)->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
	public static function getDonviQuanlyOfUser($id_user, $component, $controller, $task)
	{
		$db = Factory::getDbo();
		$id_donviquanly = self::getManageUnit($id_user, $component, $controller, $task);
		$query = 'SELECT level,lft,rgt FROM ins_dept WHERE id = ' . $db->quote($id_donviquanly);
		$db->setQuery($query);
		$idRoot = $db->loadAssoc();

		$query = 'SELECT id, name
					FROM ins_dept
					WHERE type = 1
						AND lft >= ' . $db->quote($idRoot['lft']) . '
						AND rgt <= ' . $db->quote($idRoot['rgt']);
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public static function getDotdanhgiaByDonvi($id_donvi)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*')
			->from($db->quoteName('dgcbcc_dotdanhgia_thang', 'a'))
			->where('a.inst_code = ' . $db->quote($id_donvi))
			->order('a.date_dot DESC');
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public static function getContentById($content_id)
	{
		if (empty($content_id)) {
			return array();
		}
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.id', 'a.title', 'a.fulltext', 'a.introtext'))
			->from('jos_content AS a')
			->where('a.id = ' . $db->quote($content_id))
		;
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	public static function inputAttachment_new($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
		<script type="text/javascript">
		jQuery(function($){
			jQuery("#' . $iddiv . '").load("index.php?option=com_core&view=attachment&format=raw&task=attachment&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '",function(){
				$("#' . $iddiv . ' input:checkbox").attr("checked","cheched");
			});
		});
		</script>
		';
	}
	public static function inputAttachment($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
		<script type="text/javascript">
		jQuery(function($){
			jQuery("#' . $iddiv . '").load("index.php?option=com_core&view=attachment&format=raw&task=input&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '",function(){
				$("#' . $iddiv . ' input:checkbox").attr("checked","cheched");
			});
		});
		</script>
		';
	}
	public static function dinhKemNhieuFile($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
		<script type="text/javascript">
		jQuery(function($){
			jQuery("#' . $iddiv . '").load("index.php?option=com_core&controller=attachment&format=raw&task=dinhKemNhieuFile&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '",function(){
				$("#' . $iddiv . ' input:checkbox").attr("checked","cheched");
			});
		});
		</script>
		';
	}
	public static function inputAttachmentOneFile($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
		<script type="text/javascript">
		jQuery(function($){
			jQuery("#' . $iddiv . '").load("index.php?option=com_core&view=attachment&format=raw&task=attachmentonefile&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '",function(){
			
			});
		});
		</script>
		';
	}
	public static function inputImage($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
			<script type="text/javascript">
					jQuery(function($){
							jQuery("#' . $iddiv . '").load("index.php?option=com_core&view=attachment&format=raw&task=uploadAvatar&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '", function(){
							});
					});
			</script>
		';
	}

	public static function uploadImages($iddiv, $idObject, $is_new, $year, $type, $isreadonly = 0, $is_nogetcontent = 0, $pdf = 0)
	{
		return '
		<div id="' . $iddiv . '"></div>
			<script type="text/javascript">
					jQuery(function($){
							jQuery("#' . $iddiv . '").load("index.php?option=com_core&view=attachment&format=raw&task=uploadImages&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . '&pdf=' . $pdf . '", function(){
							});
					});
			</script>
		';
	}
	/**
	 * Hàm chuyển đổi từ ngày/tháng/năm => năm-tháng-ngày
	 * @param unknown $date
	 * @return unknown|string
	 */
	public static function convertToEnDateFromVNdate($date)
	{
		if ($date == NULL || $date == "" || trim($date) == "")
			return $date;

		$date = explode('/', $date);
		return $date[2] . "-" . $date[1] . "-" . $date[0];
	}

	// Quản lý thôn tổ
	/**
	 * Kiem tra phan quyen
	 * @param integer $id_user,......
	 * @return action_id
	 */
	public static function _checkPerActionThonTo($id_user, $component, $controller = null, $task = 'default', $location = 'site', $iddonvi = null, $status = 1)
	{
		$db = Factory::getDbo();
		if ($component == null) {
			return  true;
		}
		// Check Action:
		$query_action		=	$db->getQuery(true);
		$query_action->select(' DISTINCT id, is_public from thonto_action')
			->where(" location =  " . $db->q($location))
			->where(" status = $status")
			->where(' component = ' . $db->q($component))
			->where(' tasks = ' . $db->q($task))
		;

		if ($controller != null) {
			$query_action->where('controllers = ' . $db->q($controller));
		}

		//echo $query_action->__toString();
		$db->setQuery($query_action, 0, 1);
		$action_id =  $db->loadRow();
		// Kiểm tra tồn tại action theo điều kiện
		if (count($action_id)) {
			if ((int)$action_id[1] == 0) {   // Action ko dc public
				// Check per_action
				$query_PerAction	=	$db->getQuery(true);
				$query_PerAction->select(' DISTINCT tochuc_id')
					->from(' thonto_user_action_tochuc AS a ')
					->where(' user_id = ' . $db->quote($id_user))
					->where(' action_id = ' . $db->quote($action_id[0]))
					->order('tochuc_id')
				;
				//echo $query_PerAction->__toString();
				$db->setQuery($query_PerAction, 0, 1);
				$arr_iddonvi	=	$db->loadRow();
				// Kiểm tra phân quyền user
				if (count($arr_iddonvi) > 0) {
					if ($iddonvi != null) {
						// check idddonvi truyền vào có được phân quyền hay không
						$quer_donvi	=	$db->getQuery(true);
						$quer_donvi->select('id FROM (
				    	(SELECT node.id,node.ten as name
				    	FROM thonto_tochuc AS node,
				    	thonto_tochuc AS parent
				    	WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[0] . '
				    	GROUP BY node.id ORDER BY node.lft)
				    	UNION
				    	(SELECT node.id,node.ten as name
				    	FROM thonto_tochuc AS node,
				    	thonto_tochuc AS parent
				    	WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = ' . (int)$arr_iddonvi[1] . '
				    	GROUP BY node.id ORDER BY node.lft)) AS a ')
							->where(' id = ' . $db->quote($iddonvi));

						$db->setQuery($quer_donvi, 0, 1);
						//     					echo $quer_donvi->__toString();
						if ($db->loadResult()) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					// User chưa được phân quyền Action
					return false;
				}
			} else {
				// Action được khai báo ở chế độ public
				return true;
			}
		} else {
			// Không tồn tại action theo điều kiện => ko quản lý return true
			return true;
		}
	}
	/**
	 * Lay 1 ra don vi ma user quan ly
	 * @param integer $id_user (user người dùng)
	 * @param string $component
	 * @param string $controller
	 * @param string $task
	 * @param string $location
	 * @return NULL|Integer trả về đơn vị user quản lý
	 */
	public static function getManageUnitThonTo($id_user, $component = null, $controller = null, $task = null, $location = 'site')
	{
		$db = Factory::getDbo();
		$root_id = Core::getRootId();
		if ($id_user == null) {
			return null;
		}
		// Get iddonvi theo user In phân quyền core_user_action_donvi
		$query = $db->getQuery(true);
		$query->select('DISTINCT a.tochuc_id')
			->from(' thonto_user_action_tochuc AS a  ')
			->join('INNER', 'thonto_action AS b ON a.action_id = b.id')
			->where(" a.user_id = " . $db->quote($id_user))
		;

		if ($component != null) {
			$query->where('b.component = ' . $db->q($component));
		}
		if ($controller != null) {
			$query->where('b.controllers = ' . $db->q($controller));
		}
		if ($task != null) {
			$query->where('b.tasks = ' . $db->q($task));
		}
		if ($location != null) {
			$query->where('b.location = ' . $db->q($location));
		}
		//   		echo $query->__toString().'<br />';exit;
		$db->setQuery($query, 0);
		$arr_iddonvi =  $db->loadColumn();
		// 		var_dump($arr_iddonvi); echo '<br />';
		if (count($arr_iddonvi) > 0) {
			// get id_donvi, iddonvi_quanly In core_user_donvi
			$db->setQuery('SELECT tochuc_id, idtochuc_quanly FROM thonto_user_tochuc WHERE id_user = ' . $db->quote($id_user));
			$arr_root = $db->loadRow();
			// Check phân quyển return root_id
			if (in_array($root_id, $arr_iddonvi)) {
				return $root_id;
			} elseif ((int)$arr_root[1] > 0 && in_array($arr_root[1], $arr_iddonvi)) {
				return $arr_root[1];
			} elseif ((int)$arr_root[0] > 0 && in_array($arr_root[0], $arr_iddonvi)) {
				return $arr_root[0];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	// End quản lý thôn tổ
	/**
	 * Nhan tin den 1 so dien thoai bat ky và lưu tin nhắn vào bảng sms_log
	 * @param integer $phone
	 * @param string $content noi dung tin nhắn
	 * @param string $component Tên component gửi tin nhắn
	 * @param string $id ID của đối tượng mà tin nhắn hướng đến
	 * @return NULL
	 */
	public static function sms($phone, $content, $component, $id)
	{
		$db = Factory::getDbo();
		$userid = Factory::getUser()->id;
		ini_set('soap.wsdl_cache_enabled', 0);
		ini_set('soap.wsdl_cache_ttl', 900);
		ini_set('default_socket_timeout', 15);
		//Làm sạch số điện thoại
		if (substr($phone, 0, 1) == 0) {
			$phone = ltrim($phone, '0');
		}
		$phone_arr = array(" ", ".", ",", "-");
		$phone = "84" . str_replace($phone_arr, "", $phone);
		$config = json_decode(self::config('core/system/sms'));
		$params = new stdClass();
		$params->userID = $config->userID;
		$params->password = $config->password;
		$params->phoneNo = $phone;
		$params->content = $content;
		$wsdl = $config->wsdl;
		$options = array(
			// 'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
			// 'style'=>SOAP_RPC,
			// 'use'=>SOAP_ENCODED,
			// 'soap_version'=>SOAP_1_1,
			// 'cache_wsdl'=>WSDL_CACHE_NONE,
			// 'connection_timeout'=>15,
			// 'trace'=>true,
			// 'encoding'=>'UTF-8',
			// 'exceptions'=>true,
		);
		try {
			$soap = new SoapClient($wsdl, $options);
			$data = $soap->sendSMS($params);
			$query = "INSERT INTO sms_log (phone,content,component,userid,id_component,time)
    		VALUES ('$phone','$content','$component','$userid',$id,now()) ";
			$db->setQuery($query);
			$db->query();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	/*
     * Mã hóa code, loại bỏ edit trực tiếp trên URL
     */
	public static function buildCode($code, $option = 'Dnict')
	{
		if ($code != '' || $code != null) {
			$output =  md5($option . $code . date('d-m-Y'));
		} else {
			$output =  '';
		}
		return $output;
	}
	/*
     * Convert date EN to VI
     */
	public static function convertDateViToEn($date)
	{
		$date = explode(" ", $date);
		$date = explode("/", $date[0]);
		$date = $date[2] . "-" . $date[1] . "-" . $date[0];
		return $date;
	}
	public static function convertDateEnToVi($date)
	{
		$date = explode(" ", $date);
		$date = explode("-", $date[0]);
		$date = $date[2] . "/" . $date[1] . "/" . $date[0];
		return $date;
	}
}
