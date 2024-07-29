<?php
class Danhmuc_Table_InvCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'inv_code', 'id', $db );
	}

}
