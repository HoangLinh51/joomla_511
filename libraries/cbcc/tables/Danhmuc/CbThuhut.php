<?php
class Danhmuc_Table_CbThuhut extends JTable
{
    var $id   = null;
    var $name   = null; 
    var $status   = null;     
    
    
	function __construct($db)
	{
		parent::__construct( 'cb_thuhut', 'id', $db );
	}
}
