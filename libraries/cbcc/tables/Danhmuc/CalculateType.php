<?php
class Danhmuc_Table_CalculateType extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'calculate_type', 'id', $db );
	}

}
