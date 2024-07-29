<?php
class Capmathe_Table_HosoLog extends JTable{
	var $id = null;
	var $hoso_id = null;
	var $trangthai = null;
	var $noidung = null;
	var $ngaygui = null;
	var $nguoigui = null;
	var $code_ccvc = null;
	var $code_card = null;
	var $mangach = null;
	var $htbienche = null;	
	function __construct(&$db)
	{
		parent::__construct( 'hoso_capmathe_log', 'id', $db );
	}
	public function getAllHosoLogByHosoId($hoso_id){
		// Initialise the query.
		$query = $this->_db->getQuery(true)
		->select("a.id,a.hoso_id,a.trangthai,a.noidung,a.mangach,a.code_ccvc,a.code_card,a.htbienche,DATE_FORMAT(a.ngaygui, '%d/%m/%Y %H:%i') AS ngaygui,a.nguoigui,a.code_ccvc,a.code_card,b.name AS ten_trangthai,c.name AS ten_nguoigui,e.e_name AS ten_hoso")
		->from($this->_tbl.' a')
		->join('INNER', 'status_capmathe b ON a.trangthai = b.id')
		->join('INNER', 'hosochinh e ON e.id = a.hoso_id')
		->join('INNER', '#__users c ON a.nguoigui = c.id');
		// Add the search tuple to the query.
		$query->where('a.hoso_id = ' . $this->_db->quote($hoso_id));
		$query->order('a.ngaygui ASC');
		$this->_db->setQuery($query);
		$row =  $this->_db->loadAssocList();
		if(empty($row)){
			return array();
		}
		return $row;
	}
}