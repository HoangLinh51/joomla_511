<?php
class Danhmuc_Table_OusCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'ous_code', 'id', $db );
	}

}
