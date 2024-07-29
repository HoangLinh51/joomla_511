<?php
class Tochuc_Table_Adchucvu extends JTableNested{
	// Your properties and methods go here.
	var $id = null;
	var $name = null;
	var $parent_id = null;
	var $status = null;
	var $ins_level_id = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $path = null;
	var $alias = null;
	
	function __construct($db)
	{
		parent::__construct( 'cb_captochuc', 'id', $db );
	}
}