<?php
class Tochuc_Table_Adbiencheloaihinh extends JTable{
	// Your properties and methods go here.	
	var $id = null;
	var $name = null;
	var $status = null;
	var $s_name = null;

	function __construct(&$db)
	{
		parent::__construct( 'bc_loaihinh', 'id', $db );
	}
}