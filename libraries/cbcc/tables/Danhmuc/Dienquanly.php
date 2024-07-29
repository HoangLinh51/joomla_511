<?php
class Danhmuc_Table_Dienquanly extends JTable
{
	var $id  		= null;
	var $name   	= null;
	var $mota 		= null;
	var $trangthai   	= null;
	var $sapxep   	= null;
	var $tt 		= null;

	function __construct($db)
	{
		parent::__construct( 'danhmuc_dienquanly', 'id', $db );
	}

}
