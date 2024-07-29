<?php
class Danhmuc_Table_ElecTime extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'elec_time', 'id', $db );
	}

}
