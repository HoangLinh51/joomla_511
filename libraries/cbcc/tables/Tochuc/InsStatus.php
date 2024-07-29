<?php
class Tochuc_Table_InsStatus extends JTable{
	var $id = null;
	var $name = null;
	function __construct(&$db){
		parent::__construct( 'ins_status', 'id', $db );
	}
	public function findAll(){
		$query = $this->_db->getQuery(true);
		$query->select(array('id','name'))->from($this->_tbl);
		$this->_db->setQuery($query);
		return $this->_db->loadAssocList();
	}
}