

<?php

/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-06-20 11:06:53
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-08-06 14:33:54
 * @ Description:
 */

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Utilities\ArrayHelper;

class Danhmuc_Model_CommCode extends ListModel
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/CommCode');
		$src['dc_code'] 		= $formData['dc_code'];
		$src['dc_cadc_code']	= $formData['dc_cadc_code'];
		$src['name'] 			= $formData['name'];
		$src['type'] 			= $formData['type'];
		$src['status'] 			= $formData['status'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/CommCode');
		$src['code'] 			= $formData['code'];
		$src['dc_code'] 		= $formData['dc_code'];
		$src['dc_cadc_code']	= $formData['dc_cadc_code'];
		$src['name'] 			= $formData['name'];
		$src['type'] 			= $formData['type'];
		$src['status'] 			= $formData['status'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/CommCode');
		if (!$table->load($id)) {
			return null;
		}
		$fields = array_keys($table->getFields());
		$data = array();
		$count = count($fields);
		for ($i = 0; $i < $count ; $i++) {
			$tmp = $fields[$i];
			$data[$fields[$i]] = $table->$tmp;
		}
		return $data;
	}
	public function delete($cid){
		$table = Core::table('Danhmuc/CommCode');
		if(!is_array($cid)||count($cid)==0){
			$flag	=	false;
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		return $flag;
	}
	
	public function getTinhThanh(){
		$db = Factory::getDbo();
		$query = 'select code,name from city_code order by name';
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function getQuanHuyen($dc_code = null){
		$db = Factory::getDbo();
		$query = 'select code,name from dist_code';
		if(!empty($dc_code)){
			$query .= ' WHERE cadc_code = '.$dc_code;
		}
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function listQuanHuyen($code_tinhthanh){
		$db = Factory::getDbo();
		$query = "SELECT code,name
    				FROM dist_code
    				WHERE cadc_code = ".$db->quote($code_tinhthanh);
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			ArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/CommCode');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['code']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
	function __construct(){
		parent::__construct();
	
		$array = Factory::getApplication()->input->getVar('cid',  0, '', 'array');
		global $mainframe, $option;
		$mainframe = &Factory::getApplication();
	
		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	function _buildQuery($tb=null,$order=null){
		$db = &Factory::getDbo();
		$post = Factory::getApplication()->get('post');
	
		$query = 'SELECT * FROM '.$tb;
		if(!empty($post['name_search'])){
			$where []= 'name LIKE '.$db->quote ('%' . $db->escape($post['name_search'],true) . '%', false);
		}
		if(!empty($post['cadc_code'])){
			$where []= 'cadc_code =' .$post['cadc_code'];
		}
		if(!empty($post['dc_cadc_code'])){
			$where []= 'dc_cadc_code =' .$post['dc_cadc_code'];
		}
		if(!empty($post['dc_code'])){
			$where []= 'dc_code =' .$post['dc_code'];
		}
		$where = (count($where))?implode(' AND ',$where):'';
		if(!empty($where)){
			$query .=' WHERE '.$where;
		}
		if(!empty($order)){
			$query .=' ORDER BY '.$order;
		}
	
		return $query;
	}
	function getData($tb=null,$order=null)
	{
		// Load the data
		$db = &Factory::getDbo();
		if (empty( $this->_data )) {
			$query = $this->_buildQuery($tb,$order);
			$this->_data =  $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}
	function getTotal($tb=null,$order=null)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery($tb,$order);
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	function getPagination($tb=null,$order=null)
	{
	
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new Pagination( $this->getTotal($tb,$order), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	public function collect($params = null,$order = null,$offset = null,$limit = null){
	    $table = Core::table('Danhmuc/CommCode');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);
	    $query->select(array('code','name'))
	    ->from($table->getTableName());
	    $query->where('status = 1');
	    if (isset($params['name']) && !empty($params['name'])) {
	        $query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
	    }
	    if (isset($params['tinhthanh_id']) && !empty($params['tinhthanh_id'])) {
	        $query->where('dc_cadc_code = '.$db->quote($params['tinhthanh_id']));
	    }
	    if (isset($params['quanhuyen_id']) && !empty($params['quanhuyen_id'])) {
	        $query->where('dc_code = '.$db->quote($params['quanhuyen_id']));
	    }
	    if ($order == null) {
	        $query->order('name');
	    }else{
	        $query->order($order);
	    }
	    if($offset != null && $limit != null){
	        $db->setQuery($query,$offset,$limit);
	    }else{
	        $db->setQuery($query);
	    }
	    return $db->loadAssocList();
	}
}