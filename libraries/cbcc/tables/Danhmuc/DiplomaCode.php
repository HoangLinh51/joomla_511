<?php
class Danhmuc_Table_DiplomaCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'diploma_code', 'id', $db );
	}

}
