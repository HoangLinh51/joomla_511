<?php
class Baocaothongtu_Table_Cauhinhtieuchi extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $maso = 0;
	var $parent_id = 0;
	var $level = null;

	function __construct($db)
	{
		parent::__construct( 'baocaott03_cauhinh_tieuchibaocao', 'id', $db );
	}
}