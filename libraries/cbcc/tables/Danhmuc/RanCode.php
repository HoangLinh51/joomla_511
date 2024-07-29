<?php
class Danhmuc_Table_RanCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'ran_code', 'id', $db );
	}

}
