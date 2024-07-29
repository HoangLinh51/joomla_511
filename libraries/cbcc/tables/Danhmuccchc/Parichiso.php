<?php
class Danhmuccchc_Table_Parichiso extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $donvitao_id = null;
	var $parent_id = null;
	var $ten = null;
	var $diemchuan = null;
	var $is_main = null;
	var $is_diemtru = null;
	var $is_active = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $alias = null;
	var $path = null;


	function __construct($db)
	{
		parent::__construct( 'cchc_dgxh_chiso', 'id', $db );
	}
}