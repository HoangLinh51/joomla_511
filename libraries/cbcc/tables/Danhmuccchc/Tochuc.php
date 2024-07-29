<?php
class Danhmuccchc_Table_Tochuc extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = null;
	var $ten = null;
	var $tenrutgon = null;
	var $ins_cap = null;
	var $active = null;
	var $type = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $donvixuly_id = null;
	var $iscchc = null;
	var $base_coquan_id = null;
	var $loaihinh_id = null;
	var $alias = null;
	var $path = null;


	function __construct($db)
	{
		parent::__construct( 'cchc_tochuc', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = "INSERT INTO cchc_tochuc (id,parent_id,ten,active,level,lft,rgt,access,params) VALUES (1,0,'Chưa xác định',0,0,1,10,1,'')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}