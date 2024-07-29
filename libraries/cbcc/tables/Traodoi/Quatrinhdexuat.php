<?php
class Traodoi_Table_Quatrinhdexuat extends JTable{
	var $id_dexuat = null;
	var $id_user = null;
	var $emp_id = null;
	var $dexuat = null;
	var $date_dexuat = null;
	var $is_xuly = null;
	var $date_xuly = null;
	var $type_id = null;
	
	function __construct(&$db)
	{
		parent::__construct( 'quatrinhdexuat', 'id_dexuat', $db );
	}
	public function getRowById($id){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
		->select('*')
		->from($this->_tbl);
		$fields = array_keys($this->getProperties());
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