<?php
class Xeploaidonvi_Table_Tieuchuan extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $chimuc = null;
	var $tieuchi = null;
	var $quydinh = null;
	var $diemquydinh = null;
	var $botieuchuanid = null;
	var $is_tieuchi = null;
	var $dotbaocaoid = null;
	var $trangthai = null;
	// var $path = null;
	// var $alias = null;
	// var $level = null;
	// var $lft = null;
	// var $rgt = null;
	
	function __construct(&$db)
	{
		parent::__construct( 'cchc_xldv_tieuchuan', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO cchc_xldv_tieuchuan (id,parent_id,lft,rgt,level,tieuchi) VALUES (1,0,0,1,0,'root')";		
		$db->setQuery ( $sql );
		$db->query ();		
		return $db->insertid ();
	}
}