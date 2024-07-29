<?php
class Core_Table_Logs extends JTable{
	var $id = null;
	var $user_ip = null;
	var $user_id = null;
	var $fullname = null;
	var $component = null;
	var $controller = null;
	var $task = null;
	var $link = null;
	var $error = null;
	var $date_log = null;
	var $message = null;
	function __construct(&$db){
		parent::__construct( 'core_logs', 'id', $db );
	}
	/**
	 * Lay thong tin 1 row
	 * @param int $id
	 * @return multitype:|Ambigous <mixed, NULL>
	 */
	public function getLogById($id){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
		->select('*')
		->from($this->_tbl);
		//$fields = array_keys($this->getProperties());
		// Add the search tuple to the query.
		$query->where($this->_db->quoteName('id') . ' = ' . $this->_db->quote($id));
		$this->_db->setQuery($query);
		return $this->_db->loadAssoc();
	}
	/**
	 * Xoa tat ca cac row
	 * @return mixed
	 */
	public function truncate(){
		$query = "TRUNCATE TABLE ".$this->getTableName();
		$this->_db->setQuery($query);
		return $this->_db->execute();
	} 
}