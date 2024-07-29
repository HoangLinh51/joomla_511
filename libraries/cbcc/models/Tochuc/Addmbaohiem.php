<?php
defined('_JEXEC') or die('Restricted access');
class Tochuc_Model_Addmbaohiem extends JModelLegacy{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	public function __construct(){
		parent::__construct();
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
		
		$limit = $this->mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $this->mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $this->mainframe->getUserStateFromRequest( $this->option.'.limitstart', 'limitstart', 0, 'int' );
		
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	public function getTotal($table){
		if (empty($this->_total)){
			$query = $this->_buildQuery($table);
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	public function getPagination($table){
		if (empty($this->_pagination)){
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal($table), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	public function _buildQuery($table){
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
			
		$query = 'SELECT * FROM '.$table
					.$where
					.$orderby
					;
		//echo $query;exit;
		return $query;
	}
	
	public function _buildContentWhere(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
			
		$status = $this->mainframe->getUserStateFromRequest( $this->option.'status','status', '', 'string' );
		$filter_order = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order', 'filter_order', 'name', 'cmd' );
		$filter_order_Dir = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$search	= $this->mainframe->getUserStateFromRequest( $this->option.'search', 'search', '', 'string');
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		$location = JString::strtolower($location);
	
		$where = array();

		if ($search) {
			$where[] = 'LOWER(name) LIKE '.$this->_db->Quote( '%'.$search.'%');
		}
		if($status != ''){
			$where[] = 'trangthai = '.(int) $status;
		}
	
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
	
		return $where;
	}
	
	public function _buildContentOrderBy(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
		$filter_order		= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order','filter_order','','name','cmd' );
		$filter_order_Dir	= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir','filter_order_Dir',	'',	'word' );
		if (!in_array($filter_order, array('id', 'ma'))){
			$filter_order = 'ma';
		}
	
		if (!in_array(strtoupper($filter_order_Dir), array('ASC', 'DESC'))) {
			$filter_order_Dir = '';
		}
	
		if ($filter_order != 'ma'){
			$orderby 	= ' ORDER BY  ma '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.',ma ';
		}
	
		return $orderby;
	}
	
	public function listDanhsach($table){
		if (empty($this->_data)){
			$query = $this->_buildQuery($table);//echo $query;exit;
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}
	
	public function getEditItem($table, $id){
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM '.$table.' WHERE id ='.$id;
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	
	public function storeData(){
		$flag = true;
		$data = JRequest::get('post');
		$db= JFactory::getDbo();
		$object = new stdClass();
		$object->ma = $data['ma'];
		$object->sapxep = $data['sapxep'];
		
		$object->trangthai = $data['trangthai'];
		if((int)$data['id'] == 0){
			$flag = $flag&&$db->insertObject($data['dbtable'], $object);
		}
		else{
			$object->id = (int)$data['id'];
			$flag = $flag&&$db->updateObject($data['dbtable'], $object,'id');
		}
		return $flag;
	}
	
	public function remove($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="DELETE FROM ".$table." WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	
// 	public function cboModule(){
// 		$db = JFactory::getDBO();
// 		$query = "SELECT id,name FROM core_module WHERE status = 1 order by name";
// 		// 		echo $query;exit;
// 		$db->setQuery($query);
// 		return $db->loadAssocList();
// 	}
// 	public function cboExtension(){
// 		$db = JFactory::getDBO();
// 		$query = "SELECT element , name FROM jos_extensions 
// 		WHERE type = 'component' and enabled = 1 and extension_id > 10000
// 		order by name";
// 		// 		echo $query;exit;
// 		$db->setQuery($query);
// 		return $db->loadAssocList();
// 	}
	public function publish($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET trangthai = 1 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	
	public function unpublish($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET trangthai = 0 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	/*public function is_public($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET is_public = 1 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	
	public function unis_public($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET is_public = 0 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}*/
}