<?php
class Danhmuc_Table_WhoisManager extends JTable
{
    var $id  	= null;
    var $name   = null; 
    var $status = null;      
    
    
	function __construct($db)
	{
		parent::__construct( 'whois_manager', 'id', $db );
	}
}

