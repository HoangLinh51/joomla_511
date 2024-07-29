<?php
class Danhmuc_Table_CbNhomngachHeso extends JTable
{
	var $id   		= null;
	var $idbac   	= null;
	var $heso   	= null;
	var $sta_code  	= null;
	
	function __construct($db)
	{
		parent::__construct( 'cb_nhomngach_heso', 'id', $db );
	}

}
