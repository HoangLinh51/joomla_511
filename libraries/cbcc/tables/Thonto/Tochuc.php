<?php
class Thonto_Table_Tochuc extends JTableNested
{
	var $id = null;
	var $parent_id = 0;
	var $ten = null;
	var $tenviettat = null;
	var $soquyetdinhthanhlap = null;
	var $ngayquyetdinhthanhlap = null;
	var $donvi_id = 0;
	var $tongsodan = null;
	var $tongsoho = null;
	var $dientichtunhien = null;
	var $chibo_id = null;
	var $kieu = null;
	var $ghichu = null;
	var $trangthai_id = 1;

	function __construct(&$db)
	{
		parent::__construct( 'thonto_tochuc', 'id', $db );
	}
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO thonto_tochuc (id,parent_id,lft,rgt,level,ten) VALUES (1,0,0,1,0,'Hệ thống Tổ dân phố thôn')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}