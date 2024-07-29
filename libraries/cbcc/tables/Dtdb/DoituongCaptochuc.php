<?php
class Dtdb_Table_DoituongCaptochuc extends JTable{
	var $doituong_id = null;
	var $captochuc_id = null;

	function __construct(&$db)
	{
		parent::__construct( 'dtdb_doituong_captochuc', array('doituong_id','captochuc_id'), $db );
	}

}