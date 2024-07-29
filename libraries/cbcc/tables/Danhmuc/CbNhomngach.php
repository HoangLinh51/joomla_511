<?php
class Danhmuc_Table_CbNhomngach extends JTable
{
	var $id   		= null;
	var $name   	= null;
	var $idbangluong   	= null;
	var $cap   		= null;
	var $bacdau   	= null;
	var $hesodau   	= null;
	var $baccuoi   	= null;
	var $hesocuoi   = null;
	var $sonamluong = null;
	var $parentid   = null;
	var $code   	= null;
	var $status   	= null;
	var $htcn_code  = null;
	
	function __construct($db)
	{
		parent::__construct( 'cb_nhomngach', 'id', $db );
	}

}
