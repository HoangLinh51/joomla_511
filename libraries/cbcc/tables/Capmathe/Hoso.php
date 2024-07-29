<?php
class Capmathe_Table_Hoso extends JTable{
	var $id = null;
	var $hoso_id = null;
	var $status = null;
	var $user_send = null;
	var $user_created = null;
	var $code_ccvc = null;
	var $num = null;
	var $code_card = null;
	var $code_card_created = null;
	var $ghichu = null;
	var $date_send = null;
	function __construct(&$db)
	{
		parent::__construct( 'hoso_capmathe', 'id', $db );
	}
	public function getHosoCapmatheByHosoId($hoso_id){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
			->select('*')
			->from($this->_tbl);
		$fields = array_keys($this->getProperties());
			// Add the search tuple to the query.
		$query->where($this->_db->quoteName('hoso_id') . ' = ' . $this->_db->quote($hoso_id));
		$this->_db->setQuery($query);
		$row = $this->_db->loadAssoc();
		if(empty($row)){
			return array();
		}
		return $row;
	}
	public function getHosoCapmatheById($id){
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