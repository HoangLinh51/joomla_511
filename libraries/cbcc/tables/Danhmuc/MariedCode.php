<?php
class Danhmuc_Table_MariedCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'maried_code', 'id', $db );
	}

}
