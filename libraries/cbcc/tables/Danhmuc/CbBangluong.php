<?php
class Danhmuc_Table_CbBangluong extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;
	var $level   = null;

	function __construct($db)
	{
		parent::__construct( 'cb_bangluong', 'id', $db );
	}

}
