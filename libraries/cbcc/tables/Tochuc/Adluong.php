<?php
class Tochuc_Table_Adluong extends JTable{
	// Your properties and methods go here.
	var $ID = null;
	var $NAME = null;
	var $STATUS = null;
	var $PARENTID = null;
	
	function __construct(&$db)
	{
		parent::__construct( 'cb_goiluong', 'ID', $db );
	}
}