<?php
/**
* @file: Danhmucchung.php
* @author: npbnguyen@gmaill.com
* @date: 08/07/2014
* @company : http://dnict.vn
**/
class Base_Model_Danhmucchung extends JModelLegacy{
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
	public function getTotal($table, $where, $orders){
		if (empty($this->_total)){
			$query = $this->_buildQuery($table, $where, $orders);
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	public function getPagination($table, $where, $orders){
		if (empty($this->_pagination)){
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal($table, $where, $orders), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	public function _buildQuery($table, $where = array(), $orders = array()){
		if($where != null){
			$str_where = $this->_buildContentWhere($where);
		}
		if($orders != null){
			$str_order = $this->_buildContentOrderBy($orders);
		}
			
		$query = "SELECT * FROM ".$table
					.$str_where
					.$str_order
					;
		return $query;
	}
	public function _buildContentWhere($where = array()){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');

		$filter_order = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order', 'filter_order', 'orders', 'cmd' );
		$filter_order_Dir = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$str_where = array();
		
		if(count($where) > 0){
			foreach ($where AS $key => $val){
				$data[$key] = $this->mainframe->getUserStateFromRequest( $this->option.$key, $key, '', 'string' );
				if($key == 'search'){
					if(strpos($val, '"') !== false){
						$data[$key] = str_replace(array('=', '<'), '', $data[$key]);
					}
					$data[$key] = JString::strtolower($data[$key]);
					if ($data[$key]) {
						$str_where[] = 'LOWER(name) LIKE '.$this->_db->quote('%'.$data[$key].'%');
					}
				}else{
					if($data[$key] != ''){
						$str_where[] = $key.' = '.$this->_db->quote($data[$key]);
					}
				}
			}
		}
	
		$str_where 		= ( count( $str_where ) ? ' WHERE '. implode( ' AND ', $str_where ) : '' );
	
		return $str_where;
	}
	
	public function _buildContentOrderBy($orders = array()){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
	
		$filter_order		= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order', 'filter_order', $orders[0], 'cmd' );
		$filter_order_Dir	= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir', 'filter_order_Dir', '', 'word');
	
		if (!in_array($filter_order, $orders)){
			$filter_order = $orders[0];
		}
		if (!in_array(strtoupper($filter_order_Dir), array('ASC', 'DESC'))) {
			$filter_order_Dir = '';
		}
		if ($filter_order == $orders[0]){
			$orderby 	= ' ORDER BY '.$orders[0].' '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.', '.$orders[0].' ';
		}
	
		return $orderby;
	}
	public function listItems($table, $where = array(), $orders = array()){
		if (empty($this->_data)){
			$query = $this->_buildQuery($table, $where, $orders);
			$this->_db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
			$this->_data = $this->_db->loadAssocList();
		}
		return $this->_data;
	}
	public function getInfoItem($table, $id){
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM '.$table.' WHERE id ='.$id;
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	public function storeData(){
		$flag = true;
		$data = JRequest::get('post');
		$table = $data['dbtable'];
		$primary_key = $data['primary_key'];
		$id = $data[$primary_key];
		
		$db = JFactory::getDbo();
		$object = new stdClass();
		foreach($data AS $key => $val){
			if($key != 'option' && $key != 'controller' && $key != 'view' && $key != 'dbtable' && $key != 'task' && $key != 'primary_key' && $key != $primary_key){
				$object->$key = $data[$key];
			}
		}
		if($id == '' || $id == null){
			$flag = $flag&&$db->insertObject($table, $object);
		}else{
			$object->$primary_key = $id;
			$flag = $flag&&$db->updateObject($table, $object,$primary_key);
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
	public function saveOrders(){
		$flag = true;
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');
		$orders = JRequest::getVar('orders', array(0), 'post', 'array');
		$table = JRequest::getVar('dbtable','');
		$db = JFactory::getDbo();
		for($i = 0, $n = count($cid); $i < $n; $i++){
			$object = new stdClass();
			$object->orders = $orders[$i];
			$object->id = (int)$cid[$i];
			$flag = $flag&&$db->updateObject($table, $object,'id');
		}
		return $flag;
	}
	public function publish($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET status = 1 WHERE id IN ($ids)";
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
		$sql="UPDATE ".$table." SET status = 0 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
}