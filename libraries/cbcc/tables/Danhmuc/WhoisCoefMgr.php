<?php
class Danhmuc_Table_WhoisCoefMgr extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'whois_coef_mgr', 'id', $db );
	}

}
