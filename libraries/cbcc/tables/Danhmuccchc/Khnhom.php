<?php
class Danhmuccchc_Table_Khnhom extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $ten  = null;
	var $trangthai = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $access = null;
	var $params = null;
        var $alias = null;
        var $path = null;


	function __construct(&$db)
	{
		parent::__construct( 'cchc_kh_nhomkehoach', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO cchc_kh_nhomkehoach (id,parent_id,ten,trangthai,level,lft,rgt,access,params) VALUES (1,0,'root',0,0,1,2,1,'')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}