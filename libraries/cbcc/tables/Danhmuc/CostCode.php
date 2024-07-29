<?php
class Danhmuc_Table_CostCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'cost_code', 'id', $db );
	}

}
