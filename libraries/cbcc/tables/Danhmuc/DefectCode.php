<?php
class Danhmuc_Table_DefectCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'defect_code', 'id', $db );
	}

}
