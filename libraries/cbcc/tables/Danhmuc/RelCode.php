<?php
class Danhmuc_Table_RelCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'rel_code', 'id', $db );
	}

}
