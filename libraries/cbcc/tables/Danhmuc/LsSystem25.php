<?php
class Danhmuc_Table_LsSystem25 extends JTable
{
	var $id   		= null;
	var $name   	= null;
	var $status   	= null;
	var $httc_code	=	null;

	function __construct($db)
	{
		parent::__construct( 'ls_system25', 'id', $db );
	}

}
