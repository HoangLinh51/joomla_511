<?php
class Danhmuc_Table_InsSalType extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'ins_sal_type', 'id', $db );
	}

}
