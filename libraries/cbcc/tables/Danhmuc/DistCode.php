<?php
class Danhmuc_Table_DistCode extends JTable
{
	var $code		= null;
	var $cadc_code	= null;
	var $type   	= null;
	var $name   	= null;
	var $status   	= null;

	function __construct($db)
	{
		parent::__construct( 'dist_code', 'code', $db );
	}

}
