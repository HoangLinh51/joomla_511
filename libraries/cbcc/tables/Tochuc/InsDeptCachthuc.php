<?php
class Tochuc_Table_InsDeptCachthuc extends JTable{
	var $id = null;
	var $name = null;
	function __construct(&$db){
		parent::__construct( 'ins_dept_cachthuc', 'id', $db );
	}
	public function findAll(){
		$query = $this->_db->getQuery(true);
		$query->select(array('id','name'))->from($this->_tbl);
		$this->_db->setQuery($query);
		return $this->_db->loadAssocList();
	}
	public function findAllCachThucThanhLap(){
		$query = $this->_db->getQuery(true);
		$query->select(array('id','name'))->from($this->_tbl)->where('id IN (1,2,3,4)');
		$this->_db->setQuery($query);
		return $this->_db->loadAssocList();
	}
}