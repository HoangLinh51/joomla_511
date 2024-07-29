<?php
class Danhmuc_Table_OrgSystem25 extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'org_system25', 'id', $db );
	}

}
