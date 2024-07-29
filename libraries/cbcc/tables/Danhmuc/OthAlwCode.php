<?php
class Danhmuc_Table_OthAlwCode extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;
	var $insu_req = null;

	function __construct($db)
	{
		parent::__construct( 'oth_alw_code', 'id', $db );
	}

}
