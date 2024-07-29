<?php
class Danhmuc_Table_TypeOrg extends JTable
{
    var $id   = null;
    var $name   = null; 
    var $status   = null;     
    
    
	function __construct($db)
	{
		parent::__construct( 'type_org', 'id', $db );
	}
}


