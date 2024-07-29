<?php
class Danhmuc_Table_RelativeCode extends JTable
{
	var $id   	= null;
	var $name   = null;
	var $status = null;
	var $type   = null;
	var $orders = null;
	
	function __construct($db)
	{
		parent::__construct( 'relative_code', 'id', $db );
	}

}
