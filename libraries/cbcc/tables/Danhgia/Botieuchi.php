<?php
class Danhgia_Table_Botieuchi extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $id_loaicongviec = null;
	var $name = null;
	var $code = null;
	var $is_dexuat = null;
	var $status = null;
	var $published = null;
	var $tk_diemchinh = null;
	var $tk_diemcong = null;
	var $tk_diemtru = null;
	var $group = null;
	
	
	
	function __construct(&$db)
	{
		parent::__construct( 'dgcbcc_botieuchi', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO dgcbcc_botieuchi (id,parent_id,lft,rgt,level,name) VALUES (1,0,0,1,0,'Root')";		
		$db->setQuery ( $sql );
		$db->query ();		
		return $db->insertid ();
	}
}