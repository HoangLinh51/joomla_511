<?php
class Dtdb_Table_Doituong extends JTable{
	var $id = null;
	var $name = null;
	var $s_name = null;	
	var $orders = null;
	var $status = null;
	

	function __construct(&$db)
	{
		parent::__construct( 'dtdb_doituong', 'id', $db );
	}

}