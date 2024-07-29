<?php
class Danhmuc_Table_HeadCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'hea_code', 'id', $db );
	}

}
