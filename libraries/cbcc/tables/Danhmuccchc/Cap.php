<?php
class Danhmuccchc_Table_Cap extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = null;
	var $name = null;
	var $status = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $is_danhgia = null;
	var $alias = null;
	var $path = null;

	function __construct($db)
	{
		parent::__construct( 'cchc_tochuc_loai', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO cchc_tochuc_loai (id,parent_id,name,status,level,lft,rgt,is_danhgia,alias,path) VALUES (1,0,'root',1,0,0,1,0,'','')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}
