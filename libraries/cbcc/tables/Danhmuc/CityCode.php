<?php
class Danhmuc_Table_CityCode extends JTable
{
	var $code  		= null;
	var $name   	= null;
	var $type 		= null;
	var $status   	= null;
	var $code_fk   	= null;
	var $tt 		= null;

	function __construct($db)
	{
		parent::__construct( 'city_code', 'code', $db );
	}

}
