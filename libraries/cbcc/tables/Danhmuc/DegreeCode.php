<?php
class Danhmuc_Table_DegreeCode extends JTable
{
	var $id   		= null;
	var $name   	= null;
	var $status   	= null;
	var $orders		= null;

	function __construct($db)
	{
		parent::__construct( 'degree_code', 'id', $db );
	}

}
