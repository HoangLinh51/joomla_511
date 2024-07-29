<?php
class Core_Table_BlockIp extends JTable
{
	var $id   = null;
	var $ip   = null;
	var $status   = null;
	var $ghichu   = null;
	var $date_block   = null;
	function __construct($db)
	{
		parent::__construct( 'core_block_ip', 'id', $db );
	}
	/**
	 * Lay thong tin 1 row
	 * @param int $id
	 * @return multitype:|Ambigous <mixed, NULL>
	 */
	public function getRowById($id){
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
	 * Lay thong tin 1 row
	 * @param string $ip
	 * @return multitype:|Ambigous <mixed, NULL>
	 */
	public function getRowByIp($ip){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
		->select('*')
		->from($this->_tbl);
		//$fields = array_keys($this->getProperties());
		// Add the search tuple to the query.
		$query->where($this->_db->quoteName('ip') . ' = ' . $this->_db->quote($ip));
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
	public function deleteByIp($ip){
		$query = $this->_db->getQuery(true);
		$query->delete($this->_tbl)->where($this->_db->quoteName('ip') . ' = ' . $this->_db->quote($ip));
		$this->_db->setQuery($query);
		return $this->_db->execute();
	}
}
