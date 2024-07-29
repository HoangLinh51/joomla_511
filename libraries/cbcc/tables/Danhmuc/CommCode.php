<?php
class Danhmuc_Table_CommCode extends JTable
{
	var $dc_code   		= null;
	var $dc_cadc_code   = null;
	var $code  			= null;
	var $name   		= null;
	var $type 			= null;
	var $status 		= null;
	
	function __construct($db)
	{
		parent::__construct( 'comm_code', 'code', $db );
	}

}
