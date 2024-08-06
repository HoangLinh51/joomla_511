<?php
/**
* @file: CityCode.php
* @author: huenn.dnict@gmaill.com
* @date: 04-08-2024
* @company : http://dnict.vn
* 
**/
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Utilities\ArrayHelper;

class Danhmuc_Model_CityCode extends ListModel
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/CityCode');
		$src['name'] 	= $formData['name'];
		$src['type'] 	= $formData['type'];
		$src['code_fk'] = $formData['id'];
		$src['tt']		= $formData['tt'];
		$src['status'] 	= $formData['status'];
		return $table->save($src);
	}	
	/**
	 * update
	 *
	 * @param  mixed $formData
	 * @return void
	 */
	public function update($formData){
		$table = Core::table('Danhmuc/CityCode');
		$src['code']	= $formData['code'];
		$src['name'] 	= $formData['name'];
		$src['type'] 	= $formData['type'];
		$src['code_fk'] = $formData['id'];
		$src['tt']		= $formData['tt'];
		$src['status'] 	= $formData['status'];
		return $table->save($src);
	}	
	/**
	 * read
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function read($id){
		$table = Core::table('Danhmuc/CityCode');
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
	/**
	 * delete
	 *
	 * @param  mixed $cid
	 * @return void
	 */
	public function delete($cid){
		$table = Core::table('Danhmuc/CityCode');
		if(!is_array($cid)||count($cid)==0){
			$flag	=	false;
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		return $flag;
	}
	
		
	/**
	 * publish
	 *
	 * @param  mixed $cid
	 * @param  mixed $publish
	 * @return void
	 */
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			ArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/CityCode');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['code']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}	
	/**
	 * __construct
	 *
	 * @return void
	 */
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
		
	/**
	 * _buildQuery
	 *
	 * @param  mixed $tb
	 * @param  mixed $order
	 * @return void
	 */
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
	/**
	 * getData
	 *
	 * @param  mixed $tb
	 * @param  mixed $order
	 * @return void
	 */
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
	/**
	 * getTotal
	 *
	 * @param  mixed $tb
	 * @param  mixed $order
	 * @return void
	 */
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
	/**
	 * getPagination
	 *
	 * @param  mixed $tb
	 * @param  mixed $order
	 * @return void
	 */
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
	/**
	 * collect
	 *
	 * @param  mixed $params
	 * @param  mixed $order
	 * @param  mixed $offset
	 * @param  mixed $limit
	 * @return void
	 */
	public function collect($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/CityCode');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('code','name'))
				->from($table->getTableName());
		$query->where('status = 1');
		if (isset($params['name']) && !empty($params['name'])) {
			$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
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