<?php
class Core_Table_Action extends JTable{
	var $id = null;
	var $id_module = null;
	var $name = null;
	var $component = null;
	var $controllers = null;
	var $tasks = null;
	var $location = null;
	var $status = null;
	var $is_public = null;
	var $is_module = null;
	
	function __construct(&$db){
		parent::__construct( 'core_action', 'id', $db );
	}
	public function getActionById($id){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
		->select('*')
		->from($this->_tbl);
		//$fields = array_keys($this->getProperties());
		// Add the search tuple to the query.
		$query->where($this->_db->quoteName('id') . ' = ' . $this->_db->quote($id));
		$this->_db->setQuery($query);
		$row =  $this->_db->loadAssoc();
		if(empty($row)){
			return array();
		}
		return $row;
	}
}