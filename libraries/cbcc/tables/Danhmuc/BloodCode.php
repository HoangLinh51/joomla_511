<?php
class Danhmuc_Table_BloodCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'blood_code', 'id', $db );
	}

}
