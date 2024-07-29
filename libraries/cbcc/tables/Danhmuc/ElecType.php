<?php
class Danhmuc_Table_ElecType extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'elec_type', 'id', $db );
	}

}
