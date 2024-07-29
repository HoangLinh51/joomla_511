<?php
class Tochuc_Table_Adgoibienche extends JTable{
	// Your properties and methods go here.
	var $id = null;
	var $name = null;
	var $active = null;	
	function __construct(&$db)
	{
		parent::__construct( 'bc_goibienche', 'id', $db );
	}
	
}