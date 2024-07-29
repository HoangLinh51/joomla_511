<?php
class Danhmuc_Table_WhoisSalMgr extends JTable
{
	var $id   		= null;
	var $name  		= null;
	var $status   	= null;
	var $is_nangluonglansau  	 = null;
	var $is_nhaptien  			 = null;
	var $is_nhapngaynangluong 	 = null;
	var $phantramsotienhuong	 = null;

	function __construct($db)
	{
		parent::__construct( 'whois_sal_mgr', 'id', $db );
	}

}
