<?php
class Tochuc_Table_Adcbgoihinhthuchuongluong extends JTable{
	// Your properties and methods go here.
	var $id = null;
	var $name = null;
	var $status = null;	
	function __construct(&$db)
	{
		parent::__construct( 'cb_goihinhthuchuongluong', 'id', $db );
	}
	
}