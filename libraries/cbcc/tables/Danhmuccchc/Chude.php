<?php
class Danhmuccchc_Table_Chude extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $tieude  = null;
	var $trangthai = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $access = null;
	var $params = null;

	function __construct(&$db)
	{
		parent::__construct( 'cchc_tailieu_chude', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO cchc_tailieu_chude (id,parent_id,tieude,trangthai,level,lft,rgt,access,params) VALUES (1,0,'Chưa xác định',0,0,1,10,1,'')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}