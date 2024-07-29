<?php
class Danhmuc_Table_AwaCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'awa_code', 'id', $db );
	}

}
