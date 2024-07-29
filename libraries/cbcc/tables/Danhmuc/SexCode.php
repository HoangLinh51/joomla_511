<?php
class Danhmuc_Table_SexCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'sex_code', 'id', $db );
	}

}
